{{-- Halaman ubah berita (pakai layout admin) --}}
@extends('layouts.admin')

{{-- Judul tab + judul bar atas --}}
@section('title', 'Ubah Berita - Desa Kalimanah')

{{-- CSS + JS khusus halaman ini dimuat via stack layout --}}
@push('styles')
    @vite(['resources/css/admin/berita/edit.css'])
@endpush

@section('content')
    {{-- Form ubah terisi data lama --}}
    <section class="page-container-kecil" aria-labelledby="berita-judul">
        <h1 id="berita-judul">Ubah Berita</h1>
        <p class="page-sub">Perbarui kabar atau pengumuman desa.</p>

        {{-- Kirim perubahan ke update berita --}}
        <form class="form-card" method="POST" action="{{ route('admin.berita.update', $berita) }}" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            {{-- Judul berita --}}
            <div class="field">
                <label for="judul">Judul</label>
                <input id="judul" type="text" name="judul" value="{{ old('judul', $berita->judul) }}" required autocomplete="off">
                @foreach ((array) $errors->get('judul') as $msg)
                    <p class="field-error" role="alert">{{ $msg }}</p>
                @endforeach
            </div>
            {{-- Ringkasan tampil di daftar --}}
            <div class="field">
                <label for="ringkasan">Ringkasan</label>
                <textarea id="ringkasan" name="ringkasan" rows="2">{{ old('ringkasan', $berita->ringkasan) }}</textarea>
                @foreach ((array) $errors->get('ringkasan') as $msg)
                    <p class="field-error" role="alert">{{ $msg }}</p>
                @endforeach
            </div>
            {{-- Isi lengkap --}}
            <div class="field">
                <label for="konten">Isi Berita</label>
                <textarea id="konten" name="konten" rows="6" required>{{ old('konten', $berita->konten) }}</textarea>
                @foreach ((array) $errors->get('konten') as $msg)
                    <p class="field-error" role="alert">{{ $msg }}</p>
                @endforeach
            </div>
            {{-- Gambar sampul (kosongkan untuk pakai lama) --}}
            <div class="field">
                <label for="gambar">Gambar Sampul</label>
                <input id="gambar" type="file" name="gambar" accept="image/jpeg,image/png">
                @foreach ((array) $errors->get('gambar') as $msg)
                    <p class="field-error" role="alert">{{ $msg }}</p>
                @endforeach
            </div>
            {{-- Waktu terbit, kosong = draf --}}
            <div class="field">
                <label for="published_at">Terbit Tanggal (kosongkan untuk draf)</label>
                <input id="published_at" type="datetime-local" name="published_at" value="{{ old('published_at', $berita->published_at?->format('Y-m-d\TH:i')) }}">
                @foreach ((array) $errors->get('published_at') as $msg)
                    <p class="field-error" role="alert">{{ $msg }}</p>
                @endforeach
            </div>
            {{-- Baris tombol simpan + batal --}}
            <div class="aksi-baris">
                <button type="submit" class="btn-simpan">Simpan Perubahan</button>
                <a class="btn-sekunder" href="{{ route('admin.berita.index') }}">Batal</a>
            </div>
        </form>
    </section>
@endsection

{{-- JS khusus halaman ini dimuat via stack layout --}}
@push('scripts')
    @vite(['resources/js/admin/berita/edit.js'])
@endpush
