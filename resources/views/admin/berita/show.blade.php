{{-- Halaman detail berita (pakai layout admin) --}}
@extends('layouts.admin')

{{-- Judul tab + judul bar atas --}}
@section('title', 'Detail Berita - Desa Kalimanah')

{{-- CSS + JS khusus halaman ini dimuat via stack layout --}}
@push('styles')
    @vite(['resources/css/admin/berita/show.css'])
@endpush

@section('content')
    {{-- Isi berita lengkap --}}
    <section class="detail" aria-labelledby="berita-judul">
        <h1 id="berita-judul">{{ $berita->judul }}</h1>
        {{-- Baris penulis + tanggal + status --}}
        <p class="detail-meta">
            <span>{{ $berita->user->name ?? '-' }}</span>
            <span>{{ $berita->published_at ? $berita->published_at->format('d M Y H.i') : 'Draf' }}</span>
        </p>

        {{-- Gambar sampul jika ada --}}
        @if ($berita->gambar)
            <figure class="detail-foto">
                <img src="{{ asset('storage/' . $berita->gambar) }}" alt="{{ $berita->judul }}">
            </figure>
        @endif

        {{-- Ringkasan + isi --}}
        @if ($berita->ringkasan)
            <p class="detail-sub">{{ $berita->ringkasan }}</p>
        @endif
        <div class="detail-isi">{!! nl2br(e($berita->konten)) !!}</div>

        {{-- Baris tombol ubah + kembali --}}
        <div class="aksi-baris">
            <a class="btn-ubah" href="{{ route('admin.berita.edit', $berita) }}">Ubah</a>
            <a class="btn-sekunder" href="{{ route('admin.berita.index') }}">Kembali</a>
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
    @vite(['resources/js/admin/berita/show.js'])
@endpush
