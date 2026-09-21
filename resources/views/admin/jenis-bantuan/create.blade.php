{{-- Halaman tambah jenis bantuan (pakai layout admin) --}}
@extends('layouts.admin')

{{-- Judul tab + judul bar atas --}}
@section('title', 'Tambah Jenis Bantuan - Desa Kalimanah')

{{-- CSS + JS khusus halaman ini dimuat via stack layout --}}
@push('styles')
    @vite(['resources/css/admin/jenis-bantuan/create.css'])
@endpush

@section('content')
    {{-- Form tambah jenis bantuan --}}
    <section class="page-container-kecil" aria-labelledby="bantuan-judul">
        <h1 id="bantuan-judul">Tambah Jenis Bantuan</h1>
        <p class="page-sub">Daftarkan program bantuan sosial baru.</p>

        {{-- Kirim ke store jenis bantuan --}}
        <form class="form-card" method="POST" action="{{ route('admin.jenis-bantuan.store') }}">
            @csrf
            {{-- Nama program bantuan --}}
            <div class="field">
                <label for="nama">Nama Bantuan</label>
                <input id="nama" type="text" name="nama" value="{{ old('nama') }}" required autocomplete="off">
                @foreach ((array) $errors->get('nama') as $msg)
                    <p class="field-error" role="alert">{{ $msg }}</p>
                @endforeach
            </div>
            {{-- Penjelasan program --}}
            <div class="field">
                <label for="deskripsi">Deskripsi</label>
                <textarea id="deskripsi" name="deskripsi" rows="4">{{ old('deskripsi') }}</textarea>
                @foreach ((array) $errors->get('deskripsi') as $msg)
                    <p class="field-error" role="alert">{{ $msg }}</p>
                @endforeach
            </div>
            {{-- Baris tombol simpan + batal --}}
            <div class="aksi-baris">
                <button type="submit" class="btn-simpan">Simpan</button>
                <a class="btn-sekunder" href="{{ route('admin.jenis-bantuan.index') }}">Batal</a>
            </div>
        </form>
    </section>
@endsection

{{-- JS khusus halaman ini dimuat via stack layout --}}
@push('scripts')
    @vite(['resources/js/admin/jenis-bantuan/create.js'])
@endpush
