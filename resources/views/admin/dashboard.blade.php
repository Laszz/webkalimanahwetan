{{-- Dashboard ADMIN - ringkasan kelola desa (pakai layout admin, butuh login) --}}
@extends('layouts.admin')

{{-- Judul tab + judul bar atas --}}
@section('title', 'Dashboard Admin - Desa Kalimanah')

{{-- CSS khusus dashboard admin dimuat di <head> layout --}}
@push('styles')
    @vite(['resources/css/admin/dashboard.css'])
@endpush

@section('content')
    {{-- Sapaan + ringkasan kerja admin --}}
    <section class="dash" aria-labelledby="dash-judul">
        <h1 id="dash-judul">Halo, {{ Auth::user()->name }}</h1>
        <p class="dash-sub">Kelola pengajuan surat, data warga, dan konten desa dari sini.</p>

        {{-- Kondisi kosong: belum ada data; tampilkan cara mengisi, bukan angka palsu --}}
        <div class="empty-state" role="status">
            <h2>Belum ada data</h2>
            <p>Sambungkan halaman ini ke database pengajuan agar ringkasan tampil di sini.</p>
        </div>
        {{-- TODO: ganti empty-state di atas dengan ringkasan data asli (antrean, warga, surat terbit) --}}
    </section>
@endsection

{{-- JS khusus dashboard admin dimuat sebelum </body> layout --}}
@push('scripts')
    @vite(['resources/js/admin/dashboard.js'])
@endpush
