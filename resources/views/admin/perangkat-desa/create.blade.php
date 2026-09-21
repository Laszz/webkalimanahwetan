{{-- Halaman tambah perangkat desa (pakai layout admin) --}}
@extends('layouts.admin')

{{-- Judul tab + judul bar atas --}}
@section('title', 'Tambah Perangkat - Desa Kalimanah')

{{-- CSS + JS khusus halaman ini dimuat via stack layout --}}
@push('styles')
    @vite(['resources/css/admin/perangkat-desa/create.css'])
@endpush

@section('content')
    {{-- Form tambah perangkat --}}
    <section class="page-container-kecil" aria-labelledby="perangkat-judul">
        <h1 id="perangkat-judul">Tambah Perangkat</h1>
        <p class="page-sub">Daftarkan pamong desa baru.</p>

        {{-- Kirim ke store perangkat desa --}}
        <form class="form-card" method="POST" action="{{ route('admin.perangkat-desa.store') }}" enctype="multipart/form-data">
            @csrf
            {{-- Nama lengkap --}}
            <div class="field">
                <label for="nama">Nama</label>
                <input id="nama" type="text" name="nama" value="{{ old('nama') }}" required autocomplete="name">
                @foreach ((array) $errors->get('nama') as $msg)
                    <p class="field-error" role="alert">{{ $msg }}</p>
                @endforeach
            </div>
            {{-- Jabatan --}}
            <div class="field">
                <label for="jabatan">Jabatan</label>
                <input id="jabatan" type="text" name="jabatan" value="{{ old('jabatan') }}" required autocomplete="off">
                @foreach ((array) $errors->get('jabatan') as $msg)
                    <p class="field-error" role="alert">{{ $msg }}</p>
                @endforeach
            </div>
            {{-- Foto profil --}}
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
                <input id="telepon" type="text" name="telepon" value="{{ old('telepon') }}" inputmode="tel" maxlength="20" autocomplete="tel">
                @foreach ((array) $errors->get('telepon') as $msg)
                    <p class="field-error" role="alert">{{ $msg }}</p>
                @endforeach
            </div>
            {{-- Nomor urut tampil --}}
            <div class="field">
                <label for="urutan">Urutan Tampil</label>
                <input id="urutan" type="number" name="urutan" value="{{ old('urutan', 0) }}" min="0">
                @foreach ((array) $errors->get('urutan') as $msg)
                    <p class="field-error" role="alert">{{ $msg }}</p>
                @endforeach
            </div>
            {{-- Baris tombol simpan + batal --}}
            <div class="aksi-baris">
                <button type="submit" class="btn-simpan">Simpan</button>
                <a class="btn-sekunder" href="{{ route('admin.perangkat-desa.index') }}">Batal</a>
            </div>
        </form>
    </section>
@endsection

{{-- JS khusus halaman ini dimuat via stack layout --}}
@push('scripts')
    @vite(['resources/js/admin/perangkat-desa/create.js'])
@endpush
