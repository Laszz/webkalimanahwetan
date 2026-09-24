<!DOCTYPE html>

<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    {{-- Agar layout menyesuaikan lebar HP/tablet/desktop --}}
    <meta name="viewport" content="width=device-width, initial-scale=1">
    {{-- Deskripsi singkat untuk hasil pencarian --}}
    <meta name="description" content="Website resmi Pemerintah Desa Kalimanah: layanan surat online, berita desa, dan info pelayanan.">
    {{-- Pratinjau tautan saat dibagikan ke media sosial --}}
    <meta property="og:title" content="Desa Kalimanah">
    <meta property="og:description" content="Urus surat, pantau pengumuman, dan kenal layanan Desa Kalimanah.">
    <meta property="og:type" content="website">
    {{-- Token keamanan Laravel untuk request JS (fetch/AJAX) --}}
    <meta name="csrf-token" content="{{ csrf_token() }}">
    {{-- Judul tab browser; tiap halaman bisa kirim @section('title', ...) --}}
    <title>@yield('title', config('app.name', 'Desa Kalimanah'))</title>
    {{-- Percepat koneksi ke server font --}}
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet" />
    {{-- Ikon Phosphor (satu keluarga ikon untuk seluruh situs) --}}
    <link rel="stylesheet" href="https://unpkg.com/@phosphor-icons/web@2.1.1/src/regular/style.css">
    {{-- Terapkan tema tersimpan sebelum render agar tidak kedip --}}
    <script>try{if(localStorage.getItem('desa-theme')==='dark')document.documentElement.dataset.theme='dark';}catch(e){}</script>
    {{-- CSS kerangka + CSS tiap partial, lalu JS-nya (urutan: layout dulu agar variabel tersedia) --}}
    @vite(['resources/css/layouts/warga.css', 'resources/css/partials/navbar.css', 'resources/css/partials/footer.css', 'resources/css/warga/tema.css', 'resources/js/layouts/warga.js', 'resources/js/partials/navbar.js'])
    {{-- Slot CSS khusus halaman (mis. welcome.css, dashboard.css) via @push('styles') --}}
    @stack('styles')
</head>
<body>
    {{-- Link lompat ke konten (aksesibilitas keyboard/screen reader) --}}
    <a class="skip-link" href="#konten">Lewati ke konten utama</a>

    {{-- Kepala halaman: berisi navigasi (partials.navbar) --}}
    <header class="site-header">
        @include('partials.navbar')
    </header>

    {{-- Konten utama tiap halaman masuk lewat @section('content') --}}
    <main id="konten" class="site-main">
        @yield('content')
    </main>

    {{-- Kaki halaman (partials.footer) --}}
    <footer class="site-footer">
        @include('partials.footer')
    </footer>

    {{-- Slot JS khusus halaman via @push('scripts') --}}
    @stack('scripts')
</body>
</html>
