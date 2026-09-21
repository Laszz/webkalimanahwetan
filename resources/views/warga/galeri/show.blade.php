{{-- Halaman detail foto galeri (pakai layout warga) --}}
@extends('layouts.warga')

{{-- Judul tab browser --}}
@section('title', 'Foto Galeri - Desa Kalimanah')

{{-- CSS + JS khusus halaman ini dimuat via stack layout --}}
@push('styles')
    @vite(['resources/css/warga/galeri/show.css'])
@endpush

@section('content')
    {{-- Foto + keterangan --}}
    <section class="page-container detail" aria-labelledby="galeri-judul">
        <h1 id="galeri-judul">{{ $galeri->judul }}</h1>
        {{-- Tanggal terbit --}}
        <p class="detail-meta">{{ $galeri->published_at?->format('d M Y') }}</p>

        {{-- Foto ukuran penuh --}}
        <figure class="detail-foto">
            <img src="{{ asset('storage/' . $galeri->gambar) }}" alt="{{ $galeri->judul }}">
        </figure>

        @if ($galeri->deskripsi)
            <p class="detail-sub">{{ $galeri->deskripsi }}</p>
        @endif

        {{-- Tombol kembali ke daftar --}}
        <a class="btn-kembali" href="{{ route('warga.galeri.index') }}">Kembali</a>
    </section>
@endsection

{{-- JS khusus halaman ini dimuat via stack layout --}}
@push('scripts')
    @vite(['resources/js/warga/galeri/show.js'])
@endpush
