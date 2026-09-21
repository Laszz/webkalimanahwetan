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

        {{-- Kartu tiap layanan --}}
        <ul class="layanan-grid">
            @forelse ($layanans as $layanan)
                <li>
                    {{-- Nama + estimasi --}}
                    <h2>{{ $layanan->nama }}</h2>
                    <p class="layanan-meta">{{ $layanan->syarat_layanan_count }} syarat{{ $layanan->estimasi_hari ? ' · ' . $layanan->estimasi_hari . ' hari' : '' }}</p>
                    {{-- Tombol ajukan ke form pengajuan layanan ini --}}
                    <a class="btn-ajukan" href="{{ route('warga.pengajuan.create', ['layanan' => $layanan->id]) }}">Ajukan</a>
                </li>
            @empty
                {{-- Belum ada layanan dibuka --}}
                <li><p><strong>Belum ada layanan dibuka.</strong></p></li>
            @endforelse
        </ul>

        {{-- Navigasi halaman --}}
        {{ $layanans->links() }}
    </section>
@endsection

{{-- JS khusus halaman ini dimuat via stack layout --}}
@push('scripts')
    @vite(['resources/js/warga/layanan/index.js'])
@endpush
