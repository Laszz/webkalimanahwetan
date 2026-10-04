{{-- Dashboard WARGA - sama persis seperti halaman welcome + sapaan (pakai layout warga, butuh login) --}}
@extends('layouts.warga')

{{-- Judul tab + judul bar --}}
@section('title', 'Dashboard Warga - Desa Kalimanah')

{{-- CSS dashboard + CSS seksi publik (aduan, berita, agenda, peta) dimuat di <head> layout --}}
@push('styles')
    @vite(['resources/css/warga/dashboard.css', 'resources/css/welcome.css', 'resources/css/partials/peta-desa.css'])
@endpush

@section('content')
    {{-- Sapaan khusus dashboard (judul disembunyikan, tersisa wadah popup) --}}
    <section class="page-container dash" aria-labelledby="dash-judul">
        <h1 id="dash-judul" class="sr-only">Halo, {{ Auth::user()->name }}</h1>

    </section>

    {{-- Popup info/sukses (mis. pengalihan dari halaman survei yang sudah lunas) --}}
    @if (session('info') || session('success'))
        <div class="popup" id="popup" role="alertdialog" aria-modal="true" aria-label="Info">
            <div class="popup-kartu">
                <i class="ph ph-info popup-info" aria-hidden="true"></i>
                <p>{{ session('info') ?? session('success') }}</p>
                <button type="button" class="btn-dash" data-tutup>Tutup</button>
            </div>
        </div>
    @endif

    {{-- Popup biodata belum lengkap: tombol OK mengarah ke isi biodata --}}
    @if (session('lengkapi'))
        <div class="popup" id="popup" role="alertdialog" aria-modal="true" aria-label="Lengkapi data diri">
            <div class="popup-kartu">
                <i class="ph ph-info popup-info" aria-hidden="true"></i>
                <p>{{ session('lengkapi') }}</p>
                <a class="btn-dash" href="{{ route('warga.profil.create') }}">OK</a>
            </div>
        </div>
    @endif

    {{-- HERO: teks rata tengah tanpa foto --}}
    <section class="hero" aria-labelledby="hero-judul">
        <div class="page-container hero-inner hero-tengah">
            <div class="hero-teks">
                <p class="hero-kicker">Website Resmi Pemerintah Desa</p>
                <h1 id="hero-judul">Selamat Datang di Desa Kalimanah</h1>
                <p class="hero-deskripsi">Urus surat keterangan, pantau pengumuman, dan kenal layanan desa. Semua dari satu tempat, tanpa antre.</p>
            </div>
        </div>
    </section>

    {{-- SAMBUTAN: foto + teks kepala desa --}}
    @include('partials.sambutan')

    {{-- Kartu bantuan yang diterima; hanya tampil jika warga tercatat penerima --}}
    @if ($bantuanSaya->isNotEmpty())
        <section class="page-container" aria-labelledby="bantuan-saya-judul">
            <div class="info-card info-bantuan">
                <h2 id="bantuan-saya-judul">Bantuan Diterima</h2>
                <ul>
                    @foreach ($bantuanSaya as $terima)
                        <li>
                            {{-- Ikon + nama + nominal + periode + detail --}}
                            <p class="bantuan-ikon" aria-hidden="true"><i class="ph ph-gift"></i></p>
                            <div>
                                <div><strong>{{ $terima->jenisBantuan->nama ?? '-' }}</strong></div>
                                <div class="info-rinci">
                                    <span class="bantuan-nominal">Rp{{ number_format($terima->nominal, 0, ',', '.') }}</span>
                                    <span class="bantuan-periode">{{ $terima->bulan ? 'Bulan ' . $terima->bulan . ' ' . $terima->tahun : 'Tahun ' . $terima->tahun }}</span>
                                    <a class="info-link btn-detail" href="{{ route('warga.penerimabantuan.detail', $terima) }}">Detail</a>
                                </div>
                            </div>
                        </li>
                    @endforeach
                </ul>
            </div>
        </section>
    @endif

    {{-- BERITA pola sorotan: 1 utama + daftar mini --}}
    @include('partials.berita-unggulan')

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

    {{-- ADUAN pola sorotan: 1 utama + daftar mini --}}
    @include('partials.aduan-unggulan')

    {{-- PETA: lokasi balai desa (paling bawah) --}}
    @include('partials.peta-desa')
@endsection

{{-- JS khusus dashboard warga dimuat sebelum </body> layout --}}
@push('scripts')
    @vite(['resources/js/warga/dashboard.js'])
@endpush
