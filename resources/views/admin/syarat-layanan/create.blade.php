{{-- Halaman tambah syarat layanan (pakai layout admin) --}}
@extends('layouts.admin')

{{-- Judul tab + judul bar atas --}}
@section('title', 'Tambah Syarat - Desa Kalimanah')

{{-- CSS + JS khusus halaman ini dimuat via stack layout --}}
@push('styles')
    @vite(['resources/css/admin/syarat-layanan/create.css'])
@endpush

@section('content')
    {{-- Form tambah syarat untuk layanan terpilih --}}
    <section class="page-container-kecil" aria-labelledby="syarat-judul">
        <h1 id="syarat-judul">Tambah Syarat</h1>
        <p class="page-sub">Syarat baru untuk layanan {{ $layanan->nama }}.</p>

        {{-- Kirim ke store syarat --}}
        <form class="form-card" method="POST" action="{{ route('admin.syarat-layanan.store') }}">
            @csrf
            {{-- Layanan pemilik (tersembunyi, dari halaman tambah) --}}
            <input type="hidden" name="layanan_id" value="{{ $layanan->id }}">
            <div class="field">
                <label for="nama">Nama Syarat</label>
                <input id="nama" type="text" name="nama" value="{{ old('nama') }}" required autocomplete="off">
                @foreach ((array) $errors->get('nama') as $msg)
                    <p class="field-error" role="alert">{{ $msg }}</p>
                @endforeach
            </div>
            <div class="field">
                <label for="tipe">Tipe Jawaban</label>
                <select id="tipe" name="tipe" required>
                    <option value="file" @selected(old('tipe') === 'file')>File</option>
                    <option value="text" @selected(old('tipe') === 'text')>Teks</option>
                </select>
                @foreach ((array) $errors->get('tipe') as $msg)
                    <p class="field-error" role="alert">{{ $msg }}</p>
                @endforeach
            </div>
            {{-- Centang = wajib diisi warga --}}
            <div class="field-check">
                <label for="wajib"><input id="wajib" type="checkbox" name="wajib" value="1" @checked(old('wajib', true))> Wajib diisi</label>
            </div>
            {{-- Baris tombol simpan + batal --}}
            <div class="aksi-baris">
                <button type="submit" class="btn-simpan">Simpan</button>
                <a class="btn-sekunder" href="{{ route('admin.syarat-layanan.index', ['layanan' => $layanan->id]) }}">Batal</a>
            </div>
        </form>
    </section>
@endsection

{{-- JS khusus halaman ini dimuat via stack layout --}}
@push('scripts')
    @vite(['resources/js/admin/syarat-layanan/create.js'])
@endpush
