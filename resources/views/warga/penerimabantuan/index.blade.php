{{-- Halaman bantuan sosial - daftar program + total penerima (pakai layout warga) --}}
@extends('layouts.warga')

{{-- Judul tab browser --}}
@section('title', 'Bantuan Sosial - Desa Kalimanah')

{{-- CSS + JS khusus halaman ini dimuat via stack layout --}}
@push('styles')
    @vite(['resources/css/warga/penerimabantuan/index.css'])
@endpush

@section('content')
    {{-- Daftar program bantuan --}}
    <section class="page-container bantuan" aria-labelledby="bantuan-judul">
        <h1 id="bantuan-judul">Bantuan Sosial</h1>
        <p class="bantuan-sub">Program bantuan desa beserta jumlah penerimanya.</p>

        {{-- Kartu tiap program --}}
        <ul class="bantuan-grid">
            @forelse ($bantuans as $bantuan)
                <li>
                    {{-- Ikon + nama program + total penerima --}}
                    <p class="bantuan-ikon" aria-hidden="true"><i class="ph ph-gift"></i></p>
                    <h2>{{ $bantuan->nama }}</h2>
                    <p class="bantuan-total"><i class="ph ph-users" aria-hidden="true"></i>{{ $bantuan->penerima_bantuan_count }} penerima</p>
                    <p>{{ $bantuan->deskripsi ?? 'Tanpa deskripsi.' }}</p>
                    {{-- Tombol lihat daftar penerima --}}
                    <a class="btn-lihat" href="{{ route('warga.penerimabantuan.show', $bantuan) }}">Lihat Penerima</a>
                </li>
            @empty
                {{-- Belum ada program bantuan --}}
                <li><p><strong>Belum ada program bantuan.</strong></p></li>
            @endforelse
        </ul>

        {{-- Navigasi halaman --}}
        {{ $bantuans->links() }}
    </section>
@endsection

{{-- JS khusus halaman ini dimuat via stack layout --}}
@push('scripts')
    @vite(['resources/js/warga/penerimabantuan/index.js'])
@endpush
