{{-- Halaman baca berita lengkap (pakai layout warga) --}}
@extends('layouts.warga')

{{-- Judul tab browser --}}
@section('title', 'Baca Berita - Desa Kalimanah')

{{-- CSS + JS khusus halaman ini dimuat via stack layout --}}
@push('styles')
    @vite(['resources/css/warga/berita/show.css'])
@endpush

@section('content')
    {{-- Isi berita lengkap --}}
    <section class="page-container baca" aria-labelledby="berita-judul">
        <h1 id="berita-judul">{{ $berita->judul }}</h1>
        {{-- Penulis + tanggal terbit --}}
        <p class="baca-meta">{{ $berita->user->name ?? '-' }} · {{ $berita->published_at?->format('d M Y') }}</p>

        {{-- Gambar sampul jika ada --}}
        @if ($berita->gambar)
            <figure class="baca-foto">
                <img src="{{ asset('storage/' . $berita->gambar) }}" alt="{{ $berita->judul }}">
            </figure>
        @endif

        {{-- Isi lengkap --}}
        <div class="baca-isi">{!! nl2br(e($berita->konten)) !!}</div>

        {{-- Tombol kembali ke daftar --}}
        <a class="btn-kembali" href="{{ route('warga.berita.index') }}">Kembali</a>
    </section>
@endsection

{{-- JS khusus halaman ini dimuat via stack layout --}}
@push('scripts')
    @vite(['resources/js/warga/berita/show.js'])
@endpush
