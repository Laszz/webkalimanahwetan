{{-- Halaman detail layanan + daftar syaratnya (pakai layout admin) --}}
@extends('layouts.admin')

{{-- Judul tab + judul bar atas --}}
@section('title', 'Detail Layanan - Desa Kalimanah')

{{-- CSS + JS khusus halaman ini dimuat via stack layout --}}
@push('styles')
    @vite(['resources/css/admin/layanan/show.css'])
@endpush

@section('content')
    {{-- Info layanan --}}
    <section class="detail" aria-labelledby="layanan-judul">
        <h1 id="layanan-judul">{{ $layanan->nama }}</h1>
        {{-- Baris status + estimasi --}}
        <p class="detail-meta">
            <span class="status {{ $layanan->aktif ? 'status-buka' : 'status-tutup' }}">{{ $layanan->aktif ? 'Buka' : 'Tutup' }}</span>
            <span>{{ $layanan->kategori ?? '-' }}</span>
            @if ($layanan->estimasi_hari)
                <span>Estimasi {{ $layanan->estimasi_hari }} hari</span>
            @endif
        </p>
        @if ($layanan->deskripsi)
            <p class="detail-sub">{{ $layanan->deskripsi }}</p>
        @endif

        {{-- Daftar syarat layanan --}}
        <h2 class="kartu-judul">Syarat Layanan</h2>
        <ul class="syarat-list">
            @forelse ($layanan->syaratLayanan as $syarat)
                <li>
                    {{-- Nama + tipe + wajib --}}
                    <strong>{{ $syarat->nama }}</strong>
                    <span>{{ $syarat->tipe === 'file' ? 'File' : 'Teks' }}{{ $syarat->wajib ? ' · Wajib' : '' }}</span>
                </li>
            @empty
                {{-- Belum ada syarat --}}
                <li class="kosong">Belum ada syarat.</li>
            @endforelse
        </ul>

        {{-- Baris tombol ubah + kembali di bawah daftar syarat --}}
        <div class="aksi-baris">
            <a class="btn-ubah" href="{{ route('admin.layanan.edit', $layanan) }}">Ubah</a>
            <a class="btn-sekunder" href="{{ route('admin.layanan.index') }}">Kembali</a>
        </div>
    </section>

    {{-- Popup hasil aksi (tampil jika ada pesan sesi) --}}
    @if (session('success'))
        <div class="popup" id="popup" role="alertdialog" aria-modal="true" aria-label="Hasil aksi">
            <div class="popup-kartu">
                <i class="ph ph-check-circle popup-ok" aria-hidden="true"></i>
                <p>{{ session('success') }}</p>
                <button type="button" class="btn-kecil btn-setuju" data-tutup>Tutup</button>
            </div>
        </div>
    @endif
@endsection

{{-- JS khusus halaman ini dimuat via stack layout --}}
@push('scripts')
    @vite(['resources/js/admin/layanan/show.js'])
@endpush
