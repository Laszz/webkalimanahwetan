{{-- Halaman ubah perangkat desa (pakai layout admin) --}}
@extends('layouts.admin')

{{-- Judul tab + judul bar atas --}}
@section('title', 'Ubah Perangkat - Desa Kalimanah')

{{-- CSS + JS khusus halaman ini dimuat via stack layout --}}
@push('styles')
    @vite(['resources/css/admin/perangkat-desa/edit.css'])
@endpush

@section('content')
    {{-- Form ubah terisi data lama --}}
    <section class="page-container-kecil" aria-labelledby="perangkat-judul">
        <h1 id="perangkat-judul">Ubah Perangkat</h1>
        <p class="page-sub">Perbarui data pamong desa.</p>

        {{-- Kirim perubahan ke update perangkat desa --}}
        <form class="form-card" method="POST" action="{{ route('admin.perangkat-desa.update', $perangkat) }}" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            {{-- Nama lengkap --}}
            <div class="field">
                <label for="nama">Nama</label>
                <input id="nama" type="text" name="nama" value="{{ old('nama', $perangkat->nama) }}" required autocomplete="name">
                @foreach ((array) $errors->get('nama') as $msg)
                    <p class="field-error" role="alert">{{ $msg }}</p>
                @endforeach
            </div>
            {{-- Jabatan --}}
            <div class="field">
                <label for="jabatan">Jabatan</label>
                <input id="jabatan" type="text" name="jabatan" value="{{ old('jabatan', $perangkat->jabatan) }}" required autocomplete="off">
                @foreach ((array) $errors->get('jabatan') as $msg)
                    <p class="field-error" role="alert">{{ $msg }}</p>
                @endforeach
            </div>
            {{-- Foto profil (kosongkan untuk pakai lama) --}}
            <div class="field">
                <label for="foto">Foto</label>
                <input id="foto" type="file" name="foto" accept="image/jpeg,image/png">
                @foreach ((array) $errors->get('foto') as $msg)
                    <p class="field-error" role="alert">{{ $msg }}</p>
                @endforeach
            </div>
            {{-- Telepon --}}
            <div class="field">
                <label for="telepon">Telepon</label>
                <input id="telepon" type="text" name="telepon" value="{{ old('telepon', $perangkat->telepon) }}" inputmode="tel" maxlength="20" autocomplete="tel">
                @foreach ((array) $errors->get('telepon') as $msg)
                    <p class="field-error" role="alert">{{ $msg }}</p>
                @endforeach
            </div>
            {{-- Nomor urut tampil --}}
            <div class="field">
                <label for="urutan">Urutan Tampil</label>
                <input id="urutan" type="number" name="urutan" value="{{ old('urutan', $perangkat->urutan) }}" min="0">
                @foreach ((array) $errors->get('urutan') as $msg)
                    <p class="field-error" role="alert">{{ $msg }}</p>
                @endforeach
            </div>
            {{-- Centang = tampil di halaman perangkat --}}
            <div class="field-check">
                <label for="aktif"><input id="aktif" type="checkbox" name="aktif" value="1" @checked(old('aktif', $perangkat->aktif))> Aktif</label>
            </div>
            {{-- Baris tombol simpan + batal --}}
            <div class="aksi-baris">
                <button type="submit" class="btn-simpan">Simpan Perubahan</button>
                <a class="btn-sekunder" href="{{ route('admin.perangkat-desa.index') }}">Batal</a>
            </div>
        </form>
    </section>
@endsection

{{-- JS khusus halaman ini dimuat via stack layout --}}
@push('scripts')
    @vite(['resources/js/admin/perangkat-desa/edit.js'])
@endpush
