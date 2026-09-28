{{-- Halaman ubah syarat layanan (pakai layout admin) --}}
@extends('layouts.admin')

{{-- Judul tab + judul bar atas --}}
@section('title', 'Ubah Syarat - Desa Kalimanah')

{{-- CSS + JS khusus halaman ini dimuat via stack layout --}}
@push('styles')
    @vite(['resources/css/admin/syarat-layanan/edit.css'])
@endpush

@section('content')
    {{-- Form ubah syarat terisi data lama --}}
    <section class="page-container-kecil" aria-labelledby="syarat-judul">
        <h1 id="syarat-judul">Ubah Syarat</h1>
        <p class="page-sub">Perbarui syarat {{ $syarat->nama }}.</p>

        {{-- Kirim perubahan ke update syarat --}}
        <form class="form-card" method="POST" action="{{ route('admin.syarat-layanan.update', $syarat) }}">
            @csrf
            @method('PUT')
            {{-- Layanan pemilik tetap (tersembunyi agar validasi lolos) --}}
            <input type="hidden" name="layanan_id" value="{{ $syarat->layanan_id }}">
            <div class="field">
                <label for="nama">Nama Syarat</label>
                <input id="nama" type="text" name="nama" value="{{ old('nama', $syarat->nama) }}" required autocomplete="off">
                @foreach ((array) $errors->get('nama') as $msg)
                    <p class="field-error" role="alert">{{ $msg }}</p>
                @endforeach
            </div>
            <div class="field">
                <label for="tipe">Tipe Jawaban</label>
                <select id="tipe" name="tipe" required>
                    <option value="file" @selected(old('tipe', $syarat->tipe) === 'file')>File</option>
                    <option value="text" @selected(old('tipe', $syarat->tipe) === 'text')>Teks</option>
                </select>
                @foreach ((array) $errors->get('tipe') as $msg)
                    <p class="field-error" role="alert">{{ $msg }}</p>
                @endforeach
            </div>
            {{-- Centang = wajib diisi warga --}}
            <div class="field-check">
                <label for="wajib"><input id="wajib" type="checkbox" name="wajib" value="1" @checked(old('wajib', $syarat->wajib))> Wajib diisi</label>
            </div>
            {{-- Baris tombol simpan + batal --}}
            <div class="aksi-baris">
                <button type="submit" class="btn-simpan">Simpan Perubahan</button>
                <a class="btn-sekunder" href="{{ route('admin.syarat-layanan.index', ['layanan' => $syarat->layanan_id]) }}">Batal</a>
            </div>
        </form>
    </section>
@endsection

{{-- JS khusus halaman ini dimuat via stack layout --}}
@push('scripts')
    @vite(['resources/js/admin/syarat-layanan/edit.js'])
@endpush
