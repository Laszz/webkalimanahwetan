{{-- Dashboard WARGA - ringkasan + seksi publik (pakai layout warga, butuh login) --}}
@extends('layouts.warga')

{{-- Judul tab + judul bar --}}
@section('title', 'Dashboard Warga - Desa Kalimanah')

{{-- CSS dashboard + CSS seksi publik (aduan, berita, agenda, peta) dimuat di <head> layout --}}
@push('styles')
    @vite(['resources/css/warga/dashboard.css', 'resources/css/welcome.css'])
@endpush

@section('content')
    {{-- Sapaan + ringkasan akun --}}
    <section class="page-container dash" aria-labelledby="dash-judul">
        <h1 id="dash-judul">Halo, {{ Auth::user()->name }}</h1>
        <p class="dash-sub">Pantau status pengajuan surat dan kelola data diri dari sini.</p>

        {{-- Kondisi kosong: belum ada pengajuan; tampilkan cara mengisi, bukan angka palsu --}}
        <div class="empty-state" role="status">
            <h2>Belum ada pengajuan surat</h2>
            <p>Setelah mengajukan surat lewat halaman layanan, statusnya tampil di sini.</p>
            <a class="btn-dash" href="{{ url('/') }}">Kembali ke Beranda</a>
        </div>
        {{-- TODO: ganti empty-state di atas dengan daftar riwayat pengajuan dari database --}}
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

{{-- JS khusus dashboard warga dimuat sebelum </body> layout --}}
@push('scripts')
    @vite(['resources/js/warga/dashboard.js'])
@endpush
