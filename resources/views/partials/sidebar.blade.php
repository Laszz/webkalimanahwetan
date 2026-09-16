{{-- Menu samping admin — dipakai layout admin (di dalam <aside>) --}}
{{-- Logo/nama desa di atas, klik kembali ke beranda publik --}}
<a class="sidebar-brand" href="{{ url('/') }}">Desa Kalimanah</a>
{{-- Tautan navigasi bertumpuk; href="#" = ganti dengan route asli saat halamannya tersedia --}}
<ul class="sidebar-menu">
    <li><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
    <li><a href="#">Pengajuan Surat</a></li>
    <li><a href="#">Data Warga</a></li>
    <li><a href="#">Layanan</a></li>
    <li><a href="#">Berita</a></li>
    <li><a href="#">Pengaturan</a></li>
</ul>
{{-- Bagian akun di bawah: info pengguna + tombol keluar --}}
<div class="sidebar-user">
    @auth
        {{-- Inisial nama sebagai avatar + nama pengguna --}}
        <span class="sidebar-avatar" aria-hidden="true">{{ strtoupper(substr(Auth::user()->name, 0, 1)) }}</span>
        <span class="sidebar-name">{{ Auth::user()->name }}</span>
    @endauth
    {{-- Tombol keluar (POST agar aman CSRF) --}}
    <form class="sidebar-logout" method="POST" action="{{ route('logout') }}">
        @csrf
        <button type="submit">Keluar</button>
    </form>
</div>
