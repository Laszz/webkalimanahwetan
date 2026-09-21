{{-- Halaman tambah berita (pakai layout admin) --}}
@extends('layouts.admin')

{{-- Judul tab + judul bar atas --}}
@section('title', 'Tambah Berita - Desa Kalimanah')

{{-- CSS + JS khusus halaman ini dimuat via stack layout --}}
@push('styles')
    @vite(['resources/css/admin/berita/create.css'])
@endpush

@section('content')
    {{-- Form tambah berita --}}
    <section class="page-container-kecil" aria-labelledby="berita-judul">
        <h1 id="berita-judul">Tambah Berita</h1>
        <p class="page-sub">Tulis kabar atau pengumuman desa.</p>

        {{-- Kirim ke store berita --}}
        <form class="form-card" method="POST" action="{{ route('admin.berita.store') }}" enctype="multipart/form-data">
            @csrf
            {{-- Judul berita --}}
            <div class="field">
                <label for="judul">Judul</label>
                <input id="judul" type="text" name="judul" value="{{ old('judul') }}" required autocomplete="off">
                @foreach ((array) $errors->get('judul') as $msg)
                    <p class="field-error" role="alert">{{ $msg }}</p>
                @endforeach
            </div>
            {{-- Ringkasan tampil di daftar --}}
            <div class="field">
                <label for="ringkasan">Ringkasan</label>
                <textarea id="ringkasan" name="ringkasan" rows="2">{{ old('ringkasan') }}</textarea>
                @foreach ((array) $errors->get('ringkasan') as $msg)
                    <p class="field-error" role="alert">{{ $msg }}</p>
                @endforeach
            </div>
            {{-- Isi lengkap --}}
            <div class="field">
                <label for="konten">Isi Berita</label>
                <textarea id="konten" name="konten" rows="6" required>{{ old('konten') }}</textarea>
                @foreach ((array) $errors->get('konten') as $msg)
                    <p class="field-error" role="alert">{{ $msg }}</p>
                @endforeach
            </div>
            {{-- Gambar sampul opsional --}}
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
                <input id="published_at" type="datetime-local" name="published_at" value="{{ old('published_at') }}">
                @foreach ((array) $errors->get('published_at') as $msg)
                    <p class="field-error" role="alert">{{ $msg }}</p>
                @endforeach
            </div>
            {{-- Baris tombol simpan + batal --}}
            <div class="aksi-baris">
                <button type="submit" class="btn-simpan">Simpan</button>
                <a class="btn-sekunder" href="{{ route('admin.berita.index') }}">Batal</a>
            </div>
        </form>
    </section>
@endsection

{{-- JS khusus halaman ini dimuat via stack layout --}}
@push('scripts')
    @vite(['resources/js/admin/berita/create.js'])
@endpush
