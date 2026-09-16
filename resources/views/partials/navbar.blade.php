{{-- Navigasi atas publik - dipakai welcome + dashboard warga (di dalam <header> layout warga) --}}
<nav class="navbar" aria-label="Navigasi utama">
    {{-- Logo/nama desa di kiri, klik kembali ke beranda --}}
    <a class="nav-brand" href="{{ url('/') }}">Desa Kalimanah</a>
    {{-- Tombol hamburger khusus HP (buka/tutup menu oleh partials/navbar.js) --}}
    <button type="button" class="nav-toggle" aria-label="Buka tutup menu" aria-expanded="false">
        <i class="ph ph-list" aria-hidden="true"></i>
    </button>
    {{-- Tautan navigasi di tengah/kanan + tombol ajakan utama di paling kanan --}}
    <ul class="nav-links">
        <li><a href="{{ url('/') }}">Beranda</a></li>
        {{-- Link jangkar (#) pakai url('/') agar tetap ke beranda meski dibuka dari halaman lain --}}
        <li><a href="{{ url('/#berita') }}">Berita</a></li>
        @guest
            {{-- Pengunjung belum masuk: Masuk + Daftar, dua-duanya tombol CTA pil --}}
            <li><a class="btn-nav" href="{{ route('login') }}">Masuk</a></li>
            <li><a class="btn-nav" href="{{ route('register') }}">Daftar</a></li>
        @else
            {{-- Sudah masuk: Dashboard sebagai tombol CTA --}}
            <li><a class="btn-nav" href="{{ route('warga.dashboard') }}">Dashboard</a></li>
        @endguest
    </ul>
</nav>
