{{-- Halaman ubah foto galeri (pakai layout admin) --}}
@extends('layouts.admin')

{{-- Judul tab + judul bar atas --}}
@section('title', 'Ubah Foto - Desa Kalimanah')

{{-- CSS + JS khusus halaman ini dimuat via stack layout --}}
@push('styles')
    @vite(['resources/css/admin/galeri/edit.css'])
@endpush

@section('content')
    {{-- Form ubah terisi data lama --}}
    <section class="page-container-kecil" aria-labelledby="galeri-judul">
        <h1 id="galeri-judul">Ubah Foto</h1>
        <p class="page-sub">Perbarui dokumentasi kegiatan desa.</p>

        {{-- Kirim perubahan ke update galeri --}}
        <form class="form-card" method="POST" action="{{ route('admin.galeri.update', $galeri) }}" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            {{-- Judul foto --}}
            <div class="field">
                <label for="judul">Judul Foto</label>
                <input id="judul" type="text" name="judul" value="{{ old('judul', $galeri->judul) }}" required autocomplete="off">
                @foreach ((array) $errors->get('judul') as $msg)
                    <p class="field-error" role="alert">{{ $msg }}</p>
                @endforeach
            </div>
            {{-- Keterangan foto --}}
            <div class="field">
                <label for="deskripsi">Keterangan</label>
                <textarea id="deskripsi" name="deskripsi" rows="3">{{ old('deskripsi', $galeri->deskripsi) }}</textarea>
                @foreach ((array) $errors->get('deskripsi') as $msg)
                    <p class="field-error" role="alert">{{ $msg }}</p>
                @endforeach
            </div>
            {{-- Berkas foto (kosongkan untuk pakai lama) --}}
            <div class="field">
                <label for="gambar">Foto</label>
                <input id="gambar" type="file" name="gambar" accept="image/jpeg,image/png">
                @foreach ((array) $errors->get('gambar') as $msg)
                    <p class="field-error" role="alert">{{ $msg }}</p>
                @endforeach
            </div>
            {{-- Waktu terbit, kosong = draf --}}
            <div class="field">
                <label for="published_at">Terbit Tanggal (kosongkan untuk draf)</label>
                <input id="published_at" type="datetime-local" name="published_at" value="{{ old('published_at', $galeri->published_at?->format('Y-m-d\TH:i')) }}">
                @foreach ((array) $errors->get('published_at') as $msg)
                    <p class="field-error" role="alert">{{ $msg }}</p>
                @endforeach
            </div>
            {{-- Baris tombol simpan + batal --}}
            <div class="aksi-baris">
                <button type="submit" class="btn-simpan">Simpan Perubahan</button>
                <a class="btn-sekunder" href="{{ route('admin.galeri.index') }}">Batal</a>
            </div>
        </form>
    </section>
@endsection

{{-- JS khusus halaman ini dimuat via stack layout --}}
@push('scripts')
    @vite(['resources/js/admin/galeri/edit.js'])
@endpush
