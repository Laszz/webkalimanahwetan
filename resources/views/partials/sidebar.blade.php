{{-- Menu samping admin - dipakai layout admin (di dalam <aside>) --}}
{{-- Nama desa sebagai teks biasa (tanpa link) --}}
<p class="sidebar-brand">Desa Kalimanah</p>
{{-- Tautan dikelompokkan dropdown lipat agar ringkas --}}
<ul class="sidebar-menu">
    {{-- Tautan utama selalu terlihat --}}
    <li><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
    {{-- Kelompok pelayanan ke warga --}}
    <li>
        <details class="sidebar-dropdown">
            <summary>Pelayanan<i class="ph ph-caret-down" aria-hidden="true"></i></summary>
            <ul>
                <li><a href="{{ route('admin.pengajuan.index') }}">Pengajuan Layanan</a></li>
                <li><a href="{{ route('admin.aduan.index') }}">Aduan Warga</a></li>
                <li><a href="{{ route('admin.survey.index') }}">Survey</a></li>
            </ul>
        </details>
    </li>
    {{-- Kelompok data warga --}}
    <li>
        <details class="sidebar-dropdown">
            <summary>Warga<i class="ph ph-caret-down" aria-hidden="true"></i></summary>
            <ul>
                <li><a href="{{ route('admin.warga.index') }}">Data Warga</a></li>
                <li><a href="{{ route('admin.pengguna.index') }}">Verifikasi Akun</a></li>
                <li><a href="{{ route('admin.jenis-bantuan.index') }}">Jenis Bantuan</a></li>
                <li><a href="{{ route('admin.penerima-bantuan.index') }}">Penerima Bantuan</a></li>
            </ul>
        </details>
    </li>
    {{-- Kelompok konten publik --}}
    <li>
        <details class="sidebar-dropdown">
            <summary>Konten<i class="ph ph-caret-down" aria-hidden="true"></i></summary>
            <ul>
                <li><a href="{{ route('admin.berita.index') }}">Berita</a></li>
                <li><a href="{{ route('admin.galeri.index') }}">Galeri</a></li>
                <li><a href="{{ route('admin.agenda.index') }}">Agenda</a></li>
            </ul>
        </details>
    </li>
    {{-- Kelompok tata kelola desa --}}
    <li>
        <details class="sidebar-dropdown">
            <summary>Desa<i class="ph ph-caret-down" aria-hidden="true"></i></summary>
            <ul>
                <li><a href="{{ route('admin.layanan.index') }}">Layanan</a></li>
                <li><a href="{{ route('admin.template.index') }}">Template Hasil</a></li>
                <li><a href="{{ route('admin.apbdes.index') }}">APBDes</a></li>
                <li><a href="{{ route('admin.perangkat-desa.index') }}">Perangkat Desa</a></li>
                <li><a href="{{ route('admin.profil-desa.edit') }}">Profil Desa</a></li>
            </ul>
        </details>
    </li>
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
