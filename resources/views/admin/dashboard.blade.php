{{-- Dashboard ADMIN - ringkasan angka kelola desa (pakai layout admin, butuh login) --}}
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

        {{-- Kartu angka asli dari controller (bukan contoh); sekartu bisa diklik --}}
        <ul class="stat-grid">
            {{-- Total warga terdaftar --}}
            <li class="stat-card">
                <p class="stat-ikon" aria-hidden="true"><i class="ph ph-users"></i></p>
                <strong>{{ $statistik['warga'] }}</strong><span>Total Warga</span>
                <a href="{{ route('admin.warga.index') }}">Lihat data</a>
            </li>
            {{-- Akun menunggu verifikasi --}}
            <li class="stat-card stat-warn">
                <p class="stat-ikon" aria-hidden="true"><i class="ph ph-user-plus"></i></p>
                <strong>{{ $statistik['akunMenunggu'] }}</strong><span>Akun Menunggu</span>
                <a href="{{ route('admin.pengguna.index', ['status' => 'menunggu']) }}">Verifikasi</a>
            </li>
            {{-- Pengajuan menunggu diproses --}}
            <li class="stat-card stat-warn">
                <p class="stat-ikon" aria-hidden="true"><i class="ph ph-envelope"></i></p>
                <strong>{{ $statistik['pengajuanMenunggu'] }}</strong><span>Pengajuan Menunggu</span>
                <a href="{{ route('admin.pengajuan.index', ['status' => 'menunggu']) }}">Proses</a>
            </li>
            {{-- Pengajuan sedang diproses --}}
            <li class="stat-card">
                <p class="stat-ikon" aria-hidden="true"><i class="ph ph-gear"></i></p>
                <strong>{{ $statistik['pengajuanDiproses'] }}</strong><span>Pengajuan Diproses</span>
                <a href="{{ route('admin.pengajuan.index', ['status' => 'diproses']) }}">Lihat</a>
            </li>
            {{-- Aduan menunggu tindak lanjut --}}
            <li class="stat-card stat-warn">
                <p class="stat-ikon" aria-hidden="true"><i class="ph ph-warning"></i></p>
                <strong>{{ $statistik['aduanMenunggu'] }}</strong><span>Aduan Menunggu</span>
                <a href="{{ route('admin.aduan.index', ['status' => 'menunggu']) }}">Tindaklanjuti</a>
            </li>
            {{-- Aduan sedang diproses --}}
            <li class="stat-card">
                <p class="stat-ikon" aria-hidden="true"><i class="ph ph-clock"></i></p>
                <strong>{{ $statistik['aduanDiproses'] }}</strong><span>Aduan Diproses</span>
                <a href="{{ route('admin.aduan.index', ['status' => 'diproses']) }}">Lihat</a>
            </li>
            {{-- Total berita tersimpan --}}
            <li class="stat-card">
                <p class="stat-ikon" aria-hidden="true"><i class="ph ph-newspaper"></i></p>
                <strong>{{ $statistik['berita'] }}</strong><span>Total Berita</span>
                <a href="{{ route('admin.berita.index') }}">Kelola</a>
            </li>
        </ul>
    </section>
@endsection

{{-- JS khusus dashboard admin dimuat sebelum </body> layout --}}
@push('scripts')
    @vite(['resources/js/admin/dashboard.js'])
@endpush
