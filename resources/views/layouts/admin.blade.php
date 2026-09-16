<!DOCTYPE html>

<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    {{-- Agar layout menyesuaikan lebar HP/tablet/desktop --}}
    <meta name="viewport" content="width=device-width, initial-scale=1">
    {{-- Deskripsi singkat untuk hasil pencarian --}}
    <meta name="description" content="Panel admin Desa Kalimanah: kelola pengajuan surat, data warga, dan konten desa.">
    {{-- Token keamanan Laravel untuk request JS (fetch/AJAX) --}}
    <meta name="csrf-token" content="{{ csrf_token() }}">
    {{-- Judul tab browser; tiap halaman bisa kirim @section('title', ...) --}}
    <title>@yield('title', config('app.name', 'Admin Desa Kalimanah'))</title>
    {{-- Percepat koneksi ke server font --}}
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet" />
    {{-- Ikon Phosphor (satu keluarga ikon untuk seluruh situs) --}}
    <link rel="stylesheet" href="https://unpkg.com/@phosphor-icons/web@2.1.1/src/regular/style.css">
    {{-- CSS kerangka + CSS sidebar, lalu JS-nya (urutan: layout dulu agar variabel tersedia) --}}
    @vite(['resources/css/layouts/admin.css', 'resources/css/partials/sidebar.css', 'resources/js/layouts/admin.js', 'resources/js/partials/sidebar.js'])
    {{-- Slot CSS khusus halaman via @push('styles') --}}
    @stack('styles')
</head>
<body>
    {{-- Link lompat ke konten (aksesibilitas keyboard/screen reader) --}}
    <a class="skip-link" href="#konten">Lewati ke konten utama</a>

    {{-- Kerangka 2 kolom: sidebar kiri + area kanan --}}
    <div class="admin-shell">
        {{-- Kolom kiri: menu navigasi admin (partials.sidebar) --}}
        <aside class="admin-sidebar" aria-label="Navigasi admin">
            @include('partials.sidebar')
        </aside>

        {{-- Kolom kanan: bar atas + konten --}}
        <div class="admin-main">
            {{-- Bar atas: tombol menu HP + judul halaman + nama pengguna --}}
            <header class="admin-topbar">
                {{-- Tombol buka/tutup sidebar khusus HP --}}
                <button type="button" class="sidebar-toggle" aria-label="Buka tutup menu" aria-expanded="false">
                    <i class="ph ph-list" aria-hidden="true"></i>
                </button>
                {{-- Judul halaman aktif (diisi tiap halaman via @section('title')) --}}
                <span class="topbar-title">@yield('title', 'Dashboard')</span>
                {{-- Nama admin yg sedang masuk --}}
                @auth
                    <span class="topbar-user">{{ Auth::user()->name }}</span>
                @endauth
            </header>

            {{-- Konten utama tiap halaman masuk lewat @section('content') --}}
            <main id="konten" class="admin-content">
                @yield('content')
            </main>
        </div>
    </div>

    {{-- Slot JS khusus halaman via @push('scripts') --}}
    @stack('scripts')
</body>
</html>
