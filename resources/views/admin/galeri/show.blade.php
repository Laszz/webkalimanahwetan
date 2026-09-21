{{-- Halaman detail foto galeri (pakai layout admin) --}}
@extends('layouts.admin')

{{-- Judul tab + judul bar atas --}}
@section('title', 'Detail Foto - Desa Kalimanah')

{{-- CSS + JS khusus halaman ini dimuat via stack layout --}}
@push('styles')
    @vite(['resources/css/admin/galeri/show.css'])
@endpush

@section('content')
    {{-- Foto + keterangan --}}
    <section class="detail" aria-labelledby="galeri-judul">
        <h1 id="galeri-judul">{{ $galeri->judul }}</h1>
        {{-- Baris tanggal + status --}}
        <p class="detail-meta">
            @if ($galeri->published_at)
                <span>Terbit {{ $galeri->published_at->format('d M Y H.i') }}</span>
            @else
                <span class="status status-draf">Draf</span>
            @endif
        </p>

        {{-- Foto ukuran penuh --}}
        <figure class="detail-foto">
            <img src="{{ asset('storage/' . $galeri->gambar) }}" alt="{{ $galeri->judul }}">
        </figure>

        @if ($galeri->deskripsi)
            <p class="detail-sub">{{ $galeri->deskripsi }}</p>
        @endif

        {{-- Baris tombol ubah + kembali --}}
        <div class="aksi-baris">
            <a class="btn-ubah" href="{{ route('admin.galeri.edit', $galeri) }}">Ubah</a>
            <a class="btn-sekunder" href="{{ route('admin.galeri.index') }}">Kembali</a>
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
    @vite(['resources/js/admin/galeri/show.js'])
@endpush
