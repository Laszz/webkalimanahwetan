{{-- Halaman layanan - daftar surat yang bisa diajukan (pakai layout warga) --}}
@extends('layouts.warga')

{{-- Judul tab browser --}}
@section('title', 'Layanan - Desa Kalimanah')

{{-- CSS + JS khusus halaman ini dimuat via stack layout --}}
@push('styles')
    @vite(['resources/css/warga/layanan/index.css'])
@endpush

@section('content')
    {{-- Daftar layanan aktif --}}
    <section class="page-container layanan" aria-labelledby="layanan-judul">
        <h1 id="layanan-judul">Layanan Desa</h1>
        <p class="layanan-sub">Pilih layanan yang dibutuhkan, lalu ajukan online.</p>

        {{-- Kolom pencarian nama/deskripsi --}}
        <form class="cari-bar" method="GET" action="{{ route('warga.layanan.index') }}" role="search">
            {{-- Saringan kategori ikut dibawa saat mencari --}}
            @if ($kategori !== '')
                <input type="hidden" name="kategori" value="{{ $kategori }}">
            @endif
            <div class="cari-field">
                <label class="sr-only" for="q">Cari layanan</label>
                <input id="q" type="search" name="q" value="{{ $cari }}" placeholder="Cari layanan..." autocomplete="off">
            </div>
            <button type="submit" class="btn-cari">Cari</button>
            @if ($cari !== '' || $kategori !== '')
                <a class="btn-reset" href="{{ route('warga.layanan.index') }}">Reset</a>
            @endif
        </form>

        {{-- Saringan 3 kategori administrasi --}}
        <nav class="filter-nav" aria-label="Saring kategori layanan">
            <a href="{{ route('warga.layanan.index', ['q' => $cari]) }}" class="{{ $kategori === '' ? 'aktif' : '' }}">Semua</a>
            @foreach ($kategoris as $opsi)
                <a href="{{ route('warga.layanan.index', ['q' => $cari, 'kategori' => $opsi]) }}" class="{{ $kategori === $opsi ? 'aktif' : '' }}">{{ $opsi }}</a>
            @endforeach
        </nav>

        {{-- Kartu tiap layanan --}}
        <ul class="layanan-grid">
            @forelse ($layanans as $layanan)
                <li>
                    {{-- Kategori + nama + estimasi --}}
                    <p class="layanan-kategori">{{ $layanan->kategori ?? '-' }}</p>
                    <h2>{{ $layanan->nama }}</h2>
                    <p class="layanan-meta">{{ $layanan->syarat_layanan_count }} syarat{{ $layanan->estimasi_hari ? ' · ' . $layanan->estimasi_hari . ' hari' : '' }}</p>
                    {{-- Tombol ajukan ke form pengajuan layanan ini --}}
                    <a class="btn-ajukan" href="{{ route('warga.pengajuan.create', ['layanan' => $layanan->id]) }}">Ajukan</a>
                </li>
            @empty
                {{-- Tidak cocok saringan / belum ada layanan dibuka --}}
                <li class="kosong"><p><strong>Tidak ada layanan yang cocok.</strong></p></li>
            @endforelse
        </ul>

        {{-- Navigasi halaman (bawa kata kunci + kategori) --}}
        {{ $layanans->links() }}
    </section>
@endsection

{{-- JS khusus halaman ini dimuat via stack layout --}}
@push('scripts')
    @vite(['resources/js/warga/layanan/index.js'])
@endpush
