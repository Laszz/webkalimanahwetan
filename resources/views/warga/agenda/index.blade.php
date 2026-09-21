{{-- Halaman agenda - jadwal kegiatan mendatang (pakai layout warga) --}}
@extends('layouts.warga')

{{-- Judul tab browser --}}
@section('title', 'Agenda - Desa Kalimanah')

{{-- CSS + JS khusus halaman ini dimuat via stack layout --}}
@push('styles')
    @vite(['resources/css/warga/agenda/index.css'])
@endpush

@section('content')
    {{-- Daftar agenda mendatang --}}
    <section class="page-container agenda" aria-labelledby="agenda-judul">
        <h1 id="agenda-judul">Agenda Kegiatan</h1>
        <p class="agenda-sub">Jadwal terdekat yang bisa diikuti warga.</p>

        <ul class="agenda-list">
            @forelse ($agendas as $agenda)
                {{-- Label hitung mundur dari hari ini --}}
                @php
                    $sisaHari = now()->startOfDay()->diffInDays($agenda->mulai->copy()->startOfDay(), false);
                    $labelHari = $sisaHari <= 0 ? 'Hari ini' : ($sisaHari === 1 ? 'Besok' : $sisaHari . ' hari lagi');
                @endphp
                <li>
                    {{-- Kotak tanggal --}}
                    <p class="agenda-tanggal"><strong>{{ $agenda->mulai->format('d') }}</strong><span>{{ $agenda->mulai->format('M Y') }}</span></p>
                    <div>
                        {{-- Judul + lencana hitung mundur --}}
                        <h2>{{ $agenda->judul }} <span class="agenda-sisa">{{ $labelHari }}</span></h2>
                        {{-- Tempat + waktu dengan ikon --}}
                        <p class="agenda-meta"><i class="ph ph-map-pin" aria-hidden="true"></i>{{ $agenda->tempat }}</p>
                        <p class="agenda-meta"><i class="ph ph-clock" aria-hidden="true"></i>{{ $agenda->mulai->format('d M Y, H.i') }}{{ $agenda->selesai ? ' - ' . $agenda->selesai->format('H.i') : '' }}</p>
                        @if ($agenda->deskripsi)
                            <p class="agenda-deskripsi">{{ $agenda->deskripsi }}</p>
                        @endif
                    </div>
                </li>
            @empty
                {{-- Belum ada agenda --}}
                <li><p><strong>Belum ada agenda terdekat.</strong></p></li>
            @endforelse
        </ul>

        {{-- Navigasi halaman --}}
        {{ $agendas->links() }}
    </section>
@endsection

{{-- JS khusus halaman ini dimuat via stack layout --}}
@push('scripts')
    @vite(['resources/js/warga/agenda/index.js'])
@endpush
