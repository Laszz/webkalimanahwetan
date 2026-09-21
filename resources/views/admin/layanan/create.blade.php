{{-- Halaman tambah layanan + syarat bawaan (pakai layout admin) --}}
@extends('layouts.admin')

{{-- Judul tab + judul bar atas --}}
@section('title', 'Tambah Layanan - Desa Kalimanah')

{{-- CSS + JS khusus halaman ini dimuat via stack layout --}}
@push('styles')
    @vite(['resources/css/admin/layanan/create.css'])
@endpush

@section('content')
    {{-- Form tambah layanan --}}
    <section class="page-container-kecil" aria-labelledby="layanan-judul">
        <h1 id="layanan-judul">Tambah Layanan</h1>
        <p class="page-sub">Daftarkan jenis surat beserta syarat awalnya.</p>

        {{-- Kirim ke store layanan --}}
        <form class="form-card" method="POST" action="{{ route('admin.layanan.store') }}">
            @csrf
            {{-- Nama layanan --}}
            <div class="field">
                <label for="nama">Nama Layanan</label>
                <input id="nama" type="text" name="nama" value="{{ old('nama') }}" required autocomplete="off">
                @foreach ((array) $errors->get('nama') as $msg)
                    <p class="field-error" role="alert">{{ $msg }}</p>
                @endforeach
            </div>
            {{-- Penjelasan layanan --}}
            <div class="field">
                <label for="deskripsi">Deskripsi</label>
                <textarea id="deskripsi" name="deskripsi" rows="3">{{ old('deskripsi') }}</textarea>
                @foreach ((array) $errors->get('deskripsi') as $msg)
                    <p class="field-error" role="alert">{{ $msg }}</p>
                @endforeach
            </div>
            {{-- Estimasi selesai hari kerja --}}
            <div class="field">
                <label for="estimasi_hari">Estimasi Selesai (hari)</label>
                <input id="estimasi_hari" type="number" name="estimasi_hari" value="{{ old('estimasi_hari') }}" min="1">
                @foreach ((array) $errors->get('estimasi_hari') as $msg)
                    <p class="field-error" role="alert">{{ $msg }}</p>
                @endforeach
            </div>

            {{-- Baris tombol simpan + batal --}}
            <div class="aksi-baris">
                <button type="submit" class="btn-simpan">Simpan</button>
                <a class="btn-sekunder" href="{{ route('admin.layanan.index') }}">Batal</a>
            </div>
        </form>
    </section>
@endsection

{{-- JS khusus halaman ini dimuat via stack layout --}}
@push('scripts')
    @vite(['resources/js/admin/layanan/create.js'])
@endpush
