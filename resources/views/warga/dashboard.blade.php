{{-- Dashboard WARGA - ringkasan milik sendiri + seksi publik (pakai layout warga, butuh login) --}}
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

        {{-- 5 riwayat pengajuan terakhir milik sendiri --}}
        <h2 class="judul-seksi">Pengajuan Terakhir Saya</h2>
        <ul class="aduan-list">
            @forelse ($riwayat as $pengajuan)
                {{-- Tiap baris: nama layanan + tanggal + status asli --}}
                <li>
                    <div><strong>{{ $pengajuan->layanan->nama }}</strong><span>{{ $pengajuan->created_at->format('d M Y') }}</span></div>
                    <span class="status status-{{ $pengajuan->status }}">{{ ucfirst($pengajuan->status) }}</span>
                </li>
            @empty
                {{-- Belum pernah mengajukan; arahkan ke beranda --}}
                <li><div><strong>Belum ada pengajuan</strong><span>Ajukan surat pertama dari beranda</span></div></li>
            @endforelse
        </ul>
    </section>

{{-- JS khusus dashboard warga dimuat sebelum </body> layout --}}
@push('scripts')
    @vite(['resources/js/warga/dashboard.js'])
@endpush
