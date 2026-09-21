{{-- Navigasi atas publik - dipakai welcome + dashboard warga (di dalam <header> layout warga) --}}
<nav class="navbar" aria-label="Navigasi utama">
    {{-- Logo/nama desa di kiri, klik kembali ke beranda --}}
    <a class="nav-brand" href="{{ url('/') }}">Desa Kalimanah</a>
    {{-- Tautan navigasi di tengah/kanan + tombol ajakan utama di paling kanan --}}
    <ul class="nav-links">
        @auth
            {{-- Sudah masuk: Beranda menuju dashboard warga --}}
            <li><a href="{{ route('warga.dashboard') }}">Beranda</a></li>
        @else
            {{-- Belum masuk: Beranda menuju halaman depan publik --}}
            <li><a href="{{ url('/') }}">Beranda</a></li>
        @endauth
        {{-- Menu publik + sub halaman informasi desa (klik teks untuk buka) --}}
        <li class="nav-drop">
            <button type="button" class="nav-drop-btn" aria-expanded="false">
                Menu Publik <i class="ph ph-caret-down" aria-hidden="true"></i>
            </button>
            <ul class="nav-sub">
                <li><a href="{{ route('warga.agenda.index') }}">Agenda</a></li>
                <li><a href="{{ route('warga.berita.index') }}">Berita</a></li>
                <li><a href="{{ route('warga.galeri.index') }}">Galeri</a></li>
                <li><a href="{{ route('warga.apbdes.index') }}">APBDes</a></li>
                <li><a href="{{ route('warga.penerimabantuan.index') }}">Penerima Bantuan</a></li>
                <li><a href="{{ route('warga.aduan.index') }}">Aduan</a></li>
                <li><a href="{{ route('warga.survey.index') }}">Survey</a></li>
            </ul>
        </li>
        {{-- Profil desa + sub perangkat desa (klik teks untuk buka) --}}
        <li class="nav-drop">
            <button type="button" class="nav-drop-btn" aria-expanded="false">
                Profil Desa <i class="ph ph-caret-down" aria-hidden="true"></i>
            </button>
            <ul class="nav-sub">
                <li><a href="{{ route('warga.profil-desa.index') }}">Profil Desa</a></li>
                <li><a href="{{ route('warga.perangkat-desa.index') }}">Perangkat Desa</a></li>
            </ul>
        </li>
        {{-- Menu layanan + sub riwayat pengajuan (klik teks untuk buka) --}}
        <li class="nav-drop">
            <button type="button" class="nav-drop-btn" aria-expanded="false">
                Layanan Penduduk <i class="ph ph-caret-down" aria-hidden="true"></i>
            </button>
            <ul class="nav-sub">
                <li><a href="{{ route('warga.layanan.index') }}">Semua Layanan</a></li>
                <li><a href="{{ route('warga.pengajuan.index') }}">Riwayat layanan</a></li>
            </ul>
        </li>
        @guest
            {{-- Pengunjung belum masuk: Masuk + Daftar, dua-duanya tombol CTA pil --}}
            <li><a class="btn-nav" href="{{ route('login') }}">Masuk</a></li>
            <li><a class="btn-nav" href="{{ route('register') }}">Daftar</a></li>
        @else
            {{-- Sudah masuk: tombol profil + tombol keluar --}}
            <li><a class="btn-nav" href="{{ route('warga.profil.show') }}">Profil</a></li>
            <li>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="btn-nav">Keluar</button>
                </form>
            </li>
        @endguest
    </ul>
    {{-- Grup kanan selalu terlihat: lonceng + hamburger --}}
    <div class="nav-kanan">
        @auth
            {{-- Lonceng notifikasi: hanya tampil setelah login dan tidak di halaman depan publik --}}
            @unless (request()->is('/'))
                {{-- 5 terbaru apa pun status bacanya; yang lama kegeser jika lebih dari 5 --}}
                @php($notif5 = auth()->user()->notifications()->latest()->take(5)->get())
                {{-- Kotak notifikasi buka/tutup bawaan browser (tanpa JS) --}}
                <details class="nav-bel-wrap">
                    {{-- Lonceng sebagai ringkasan pembuka kotak --}}
                    <summary class="nav-bel-btn" aria-label="Notifikasi">
                        <i class="ph ph-bell" aria-hidden="true"></i>
                        @php($belum = auth()->user()->unreadNotifications()->count())
                        @if ($belum)
                            <span class="nav-badge">{{ $belum > 9 ? '9+' : $belum }}</span>
                        @endif
                    </summary>
                    {{-- Kotak 5 notifikasi terbaru + tautan semua --}}
                    <div class="notif-drop">
                        <div class="notif-judul">
                            <p>Notifikasi</p>
                            {{-- Tong sampah hapus semua notifikasi --}}
                            <form method="POST" action="{{ route('warga.notifikasi.destroyAll') }}" class="notif-buang-semua">
                                @csrf
                                @method('DELETE')
                                <button type="submit" aria-label="Hapus semua notifikasi"><i class="ph ph-trash" aria-hidden="true"></i></button>
                            </form>
                        </div>
                        <ul>
                            @forelse ($notif5 as $notif)
                                <li>
                                    {{-- Lewat show agar sekalian ditandai dibaca --}}
                                    <a href="{{ route('warga.notifikasi.show', $notif->id) }}">{{ $notif->data['judul'] ?? 'Pemberitahuan' }}</a>
                                </li>
                            @empty
                                <li class="notif-kosong">Belum ada notifikasi.</li>
                            @endforelse
                        </ul>
                        <a class="notif-semua" href="{{ route('warga.notifikasi.index') }}">Lihat semua notifikasi</a>
                    </div>
                </details>
            @endunless
        @endauth
        {{-- Tombol hamburger khusus HP (buka/tutup menu oleh partials/navbar.js) --}}
        <button type="button" class="nav-toggle" aria-label="Buka tutup menu" aria-expanded="false">
            <i class="ph ph-list" aria-hidden="true"></i>
        </button>
    </div>
</nav>
