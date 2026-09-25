{{-- Halaman detail aduan + tanggapan admin (pakai layout warga) --}}
@extends('layouts.warga')

{{-- Judul tab browser --}}
@section('title', 'Detail Aduan - Desa Kalimanah')

{{-- CSS + JS khusus halaman ini dimuat via stack layout --}}
@push('styles')
    @vite(['resources/css/warga/aduan/show.css'])
@endpush

@section('content')
    {{-- Isi aduan milik sendiri --}}
    <section class="page-container detail" aria-labelledby="aduan-judul">
        <h1 id="aduan-judul">{{ $aduan->judul }}</h1>
        {{-- Status + tanggal lapor --}}
        <p class="detail-meta">
            <span class="status status-{{ $aduan->status }}">{{ ucfirst($aduan->status) }}</span>
            <span>{{ $aduan->created_at->format('d M Y') }}</span>
        </p>

        {{-- Foto bukti jika ada --}}
        @if ($aduan->gambar)
            <figure class="detail-foto">
                <img src="{{ asset('storage/' . $aduan->gambar) }}" alt="Foto bukti aduan">
            </figure>
        @endif

        {{-- Isi laporan lengkap tanpa kartu --}}
        <div class="detail-teks">{{ $aduan->isi }}</div>

        {{-- Tanggapan admin tanpa kartu --}}
        <h2 class="kartu-judul">Tanggapan Perangkat Desa</h2>
        <ul class="tanggapan-list">
            @forelse ($aduan->tanggapanAduan as $tanggapan)
                <li>
                    {{-- Isi + penanggap + waktu --}}
                    <p>{{ $tanggapan->isi }}</p>
                    <span>{{ $tanggapan->user->name ?? '-' }} · {{ $tanggapan->created_at->format('d M Y') }}</span>
                </li>
            @empty
                {{-- Belum ada tanggapan --}}
                <li class="kosong">Belum ada tanggapan.</li>
            @endforelse
        </ul>

        {{-- Tombol kembali ke daftar --}}
        <a class="btn-kembali" href="{{ route('warga.aduan.index') }}">Kembali</a>
    </section>
@endsection

{{-- JS khusus halaman ini dimuat via stack layout --}}
@push('scripts')
    @vite(['resources/js/warga/aduan/show.js'])
@endpush
