{{-- Dashboard publik Desa Kalimanah - halaman depan pengunjung (pakai layout warga) --}}
@extends('layouts.warga')

{{-- Judul tab browser khusus halaman ini (tanda hubung biasa, tanpa em-dash) --}}
@section('title', 'Beranda - Desa Kalimanah')

{{-- CSS khusus welcome + CSS peta dimuat di <head> layout via @stack('styles') --}}
@push('styles')
    @vite(['resources/css/welcome.css', 'resources/css/partials/peta-desa.css'])
@endpush

{{-- Seluruh konten halaman masuk ke <main> layout via @yield('content') --}}
@section('content')

    {{-- HERO: teks rata tengah tanpa foto --}}
    <section class="hero" aria-labelledby="hero-judul">
        <div class="page-container hero-inner hero-tengah">
            <div class="hero-teks">
                <p class="hero-kicker">Website Resmi Pemerintah Desa</p>
                <h1 id="hero-judul">Selamat Datang di Desa Kalimanah</h1>
                <p class="hero-deskripsi">Urus surat keterangan, pantau pengumuman, dan kenal layanan desa. Semua dari satu tempat, tanpa antre.</p>
            </div>
        </div>
    </section>

    {{-- SAMBUTAN: foto + teks kepala desa --}}
    @include('partials.sambutan')

    {{-- BERITA pola sorotan: 1 utama + daftar mini --}}
    @include('partials.berita-unggulan')

    {{-- AGENDA: jadwal terdekat berupa baris penanda tanggal --}}
    <section class="agenda" id="agenda" aria-labelledby="agenda-judul">
        <div class="page-container">
            <h2 id="agenda-judul" class="judul-seksi">Agenda Kegiatan</h2>
            <p class="sub-seksi">Jadwal terdekat yang bisa diikuti warga.</p>
            <ul class="agenda-list">
                @forelse (($agendas ?? []) as $agenda)
                    {{-- Tiap kartu: kotak tanggal + judul + hitung mundur + tempat dan waktu --}}
                    @php
                        $sisaHari = now()->startOfDay()->diffInDays($agenda->mulai->copy()->startOfDay(), false);
                        $labelHari = $sisaHari <= 0 ? 'Hari ini' : ($sisaHari === 1 ? 'Besok' : $sisaHari . ' hari lagi');
                    @endphp
                    <li>
                        <p class="agenda-tanggal"><strong>{{ $agenda->mulai->format('d') }}</strong><span>{{ $agenda->mulai->format('M Y') }}</span></p>
                        <div>
                            <h3>{{ $agenda->judul }} <span class="agenda-sisa">{{ $labelHari }}</span></h3>
                            <p class="agenda-meta"><i class="ph ph-map-pin" aria-hidden="true"></i>{{ $agenda->tempat }}</p>
                            <p class="agenda-meta"><i class="ph ph-clock" aria-hidden="true"></i>{{ $agenda->mulai->format('d M Y, H.i') }}{{ $agenda->selesai ? ' - ' . $agenda->selesai->format('H.i') : '' }}</p>
                        </div>
                    </li>
                @empty
                    {{-- Belum ada agenda terjadwal --}}
                    <li class="kosong"><div><p><strong>Belum ada agenda terdekat.</strong></p></div></li>
                @endforelse
            </ul>
        </div>
    </section>

    {{-- ADUAN pola sorotan: 1 utama + daftar mini --}}
    @include('partials.aduan-unggulan')

    {{-- PETA: lokasi balai desa (paling bawah) --}}
    @include('partials.peta-desa')
@endsection

{{-- JS khusus welcome dimuat sebelum </body> layout via @stack('scripts') --}}
@push('scripts')
    @vite(['resources/js/welcome.js'])
@endpush
