{{-- Halaman galeri - dokumentasi foto kegiatan (pakai layout warga) --}}
@extends('layouts.warga')

{{-- Judul tab browser --}}
@section('title', 'Galeri - Desa Kalimanah')

{{-- CSS + JS khusus halaman ini dimuat via stack layout --}}
@push('styles')
    @vite(['resources/css/warga/galeri/index.css'])
@endpush

@section('content')
    {{-- Kisi dokumentasi foto --}}
    <section class="page-container galeri" aria-labelledby="galeri-judul">
        <h1 id="galeri-judul">Galeri Desa</h1>
        <p class="galeri-sub">Dokumentasi foto kegiatan desa.</p>

        {{-- Kisi foto 3 kolom --}}
        <ul class="galeri-grid">
            @forelse ($galeris as $galeri)
                <li>
                    {{-- Foto + tanggal + judul, klik ke detail --}}
                    <a href="{{ route('warga.galeri.show', $galeri) }}">
                        <img src="{{ asset('storage/' . $galeri->gambar) }}" loading="lazy" alt="{{ $galeri->judul }}">
                        <span class="galeri-tanggal">{{ $galeri->published_at?->format('d M Y') }}</span>
                        <span>{{ $galeri->judul }}</span>
                    </a>
                </li>
            @empty
                {{-- Belum ada foto terbit --}}
                <li class="kosong">Belum ada foto.</li>
            @endforelse
        </ul>

        {{-- Navigasi halaman --}}
        {{ $galeris->links() }}
    </section>
@endsection

{{-- JS khusus halaman ini dimuat via stack layout --}}
@push('scripts')
    @vite(['resources/js/warga/galeri/index.js'])
@endpush
