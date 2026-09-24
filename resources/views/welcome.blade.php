{{-- Dashboard publik Desa Kalimanah - halaman depan pengunjung (pakai layout warga) --}}
@extends('layouts.warga')

{{-- Judul tab browser khusus halaman ini (tanda hubung biasa, tanpa em-dash) --}}
@section('title', 'Beranda - Desa Kalimanah')

{{-- CSS khusus welcome + CSS peta dimuat di <head> layout via @stack('styles') --}}
@push('styles')
    @vite(['resources/css/welcome.css', 'resources/css/partials/peta-desa.css'])
@endpush

{{-- Seluruh konten halaman masuk ke <main> layout via @yield('content') --}}
@section('content')

    {{-- HERO: teks kiri + foto asli kanan; maksimal 4 elemen teks (kicker, judul, deskripsi, tombol) --}}
    <section class="hero" aria-labelledby="hero-judul">
        <div class="page-container hero-inner">
            <div class="hero-teks">
                <p class="hero-kicker">Website Resmi Pemerintah Desa</p>
                <h1 id="hero-judul">Selamat Datang di Desa Kalimanah</h1>
                <p class="hero-deskripsi">Urus surat keterangan, pantau pengumuman, dan kenal layanan desa. Semua dari satu tempat, tanpa antre.</p>
            </div>
            {{-- Foto asli balai desa tanpa caption --}}
            <figure class="hero-foto">
                <img src="https://picsum.photos/seed/kalimanah-balai-desa/880/660" width="880" height="660" alt="Suasana balai Desa Kalimanah" fetchpriority="high">
            </figure>
        </div>
    </section>

    {{-- ADUAN: kartu 5 laporan terbaru (data dari WelcomeController, kosong = pesan jujur) --}}
    <section class="aduan" id="aduan" aria-labelledby="aduan-judul">
        <div class="page-container">
            <h2 id="aduan-judul" class="judul-seksi">Aduan Terbaru Warga</h2>
            <p class="sub-seksi">Laporan yang masuk dan sedang ditindaklanjuti perangkat desa.</p>
            <ul class="kartu-grid kartu-grid-5">
                @forelse (($aduans ?? []) as $aduan)
                    {{-- Tiap kartu: foto + judul + ringkasan isi + tanggal dan status --}}
                    <li>
                        <img src="{{ $aduan->gambar ? asset('storage/' . $aduan->gambar) : 'https://picsum.photos/seed/kalimanah-aduan-' . $aduan->id . '/640/360' }}" width="640" height="360" loading="lazy" alt="{{ $aduan->judul }}">
                        <div class="kartu-badan">
                            <h3><a href="{{ route('warga.aduan.show', $aduan) }}">{{ $aduan->judul }}</a></h3>
                            <p>{{ \Illuminate\Support\Str::limit($aduan->isi, 100) }}</p>
                            <p class="kartu-meta"><span>{{ $aduan->created_at->format('d M Y') }}</span><span class="status status-{{ $aduan->status }}">{{ ucfirst($aduan->status) }}</span></p>
                        </div>
                    </li>
                @empty
                    {{-- Belum ada aduan masuk --}}
                    <li class="kosong"><div><strong>Belum ada aduan.</strong><span>Jadilah pelapor pertama.</span></div></li>
                @endforelse
            </ul>
        </div>
    </section>

    {{-- BERITA: 5 berita terbaru berupa kartu foto + teks (sama seperti aduan) --}}
    <section class="berita" id="berita" aria-labelledby="berita-judul">
        <div class="page-container">
            <h2 id="berita-judul" class="judul-seksi">Berita dan Pengumuman</h2>
            <ul class="kartu-grid kartu-grid-5">
                @forelse (($beritas ?? []) as $berita)
                    {{-- Tiap kartu: foto + judul + ringkasan + tanggal --}}
                    <li>
                        <img src="{{ $berita->gambar ? asset('storage/' . $berita->gambar) : 'https://picsum.photos/seed/kalimanah-berita-' . $berita->id . '/640/360' }}" width="640" height="360" loading="lazy" alt="{{ $berita->judul }}">
                        <div class="kartu-badan">
                            <h3><a href="{{ route('warga.berita.show', $berita->slug) }}">{{ $berita->judul }}</a></h3>
                            <p>{{ $berita->ringkasan }}</p>
                            <p class="kartu-meta"><span>{{ $berita->published_at?->format('d M Y') }}</span></p>
                        </div>
                    </li>
                @empty
                    {{-- Belum ada berita terbit --}}
                    <li class="kosong"><div><p><strong>Belum ada berita.</strong></p></div></li>
                @endforelse
            </ul>
        </div>
    </section>

    {{-- AGENDA: jadwal terdekat berupa baris penanda tanggal --}}
    <section class="agenda" id="agenda" aria-labelledby="agenda-judul">
        <div class="page-container">
            <h2 id="agenda-judul" class="judul-seksi">Agenda Kegiatan</h2>
            <p class="sub-seksi">Jadwal terdekat yang bisa diikuti warga.</p>
            <ul class="agenda-list">
                @forelse (($agendas ?? []) as $agenda)
                    {{-- Tiap kartu: kotak tanggal + judul + hitung mundur + tempat dan waktu --}}
                    @php
                        $sisaHari = now()->startOfDay()->diffInDays($agenda->mulai->copy()->startOfDay(), false);
                        $labelHari = $sisaHari <= 0 ? 'Hari ini' : ($sisaHari === 1 ? 'Besok' : $sisaHari . ' hari lagi');
                    @endphp
                    <li>
                        <p class="agenda-tanggal"><strong>{{ $agenda->mulai->format('d') }}</strong><span>{{ $agenda->mulai->format('M Y') }}</span></p>
                        <div>
                            <h3>{{ $agenda->judul }} <span class="agenda-sisa">{{ $labelHari }}</span></h3>
                            <p class="agenda-meta"><i class="ph ph-map-pin" aria-hidden="true"></i>{{ $agenda->tempat }}</p>
                            <p class="agenda-meta"><i class="ph ph-clock" aria-hidden="true"></i>{{ $agenda->mulai->format('d M Y, H.i') }}{{ $agenda->selesai ? ' - ' . $agenda->selesai->format('H.i') : '' }}</p>
                        </div>
                    </li>
                @empty
                    {{-- Belum ada agenda terjadwal --}}
                    <li class="kosong"><div><p><strong>Belum ada agenda terdekat.</strong></p></div></li>
                @endforelse
            </ul>
        </div>
    </section>

    {{-- PETA: lokasi balai desa --}}
    @include('partials.peta-desa')
@endsection

{{-- JS khusus welcome dimuat sebelum </body> layout via @stack('scripts') --}}
@push('scripts')
    @vite(['resources/js/welcome.js'])
@endpush
