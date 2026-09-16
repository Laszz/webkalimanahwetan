{{-- Dashboard publik Desa Kalimanah - halaman depan pengunjung (pakai layout warga) --}}
@extends('layouts.warga')

{{-- Judul tab browser khusus halaman ini (tanda hubung biasa, tanpa em-dash) --}}
@section('title', 'Beranda - Desa Kalimanah')

{{-- CSS khusus welcome dimuat di <head> layout via @stack('styles') --}}
@push('styles')
    @vite(['resources/css/welcome.css'])
@endpush

{{-- Seluruh konten halaman masuk ke <main> layout via @yield('content') --}}
@section('content')

    {{-- HERO: teks kiri + foto asli kanan; maksimal 4 elemen teks (kicker, judul, deskripsi, tombol) --}}
    <section class="hero" aria-labelledby="hero-judul">
        <div class="page-container hero-inner">
            <div class="hero-teks">
                <p class="hero-kicker">Website Resmi Pemerintah Desa</p>
                <h1 id="hero-judul">Selamat Datang di Desa Kalimanah</h1>
                <p class="hero-deskripsi">Urus surat keterangan, pantau pengumuman, dan kenal layanan desa. Semua dari satu tempat, tanpa antre.</p>
                <div class="hero-aksi">
                    {{-- Satu-satunya CTA daftar di halaman ini (label tunggal sesuai aturan satu label satu maksud) --}}
                    <a class="btn btn-utama" href="{{ route('register') }}">Daftar</a>
                    {{-- Aksi kedua: lompat ke daftar layanan di bawah --}}
                    <a class="btn btn-kedua" href="#layanan">Lihat Layanan</a>
                </div>
            </div>
            {{-- Foto asli balai desa; caption fungsional satu baris --}}
            <figure class="hero-foto">
                <img src="https://picsum.photos/seed/kalimanah-balai-desa/880/660" width="880" height="660" alt="Suasana balai Desa Kalimanah" fetchpriority="high">
            </figure>
        </div>
    </section>

    {{-- Kartu 5 aduan terbaru warga --}}
    @include('partials.aduan-terbaru')

    {{-- 5 berita terbaru --}}
    @include('partials.berita-terbaru')

    {{-- Agenda kegiatan desa --}}
    @include('partials.agenda-desa')

    {{-- Peta lokasi balai desa --}}
    @include('partials.peta-desa')

@endsection

{{-- JS khusus welcome dimuat sebelum </body> layout via @stack('scripts') --}}
@push('scripts')
    @vite(['resources/js/welcome.js'])
@endpush
