{{-- Halaman kelola profil desa (pakai layout admin) --}}
@extends('layouts.admin')

{{-- Judul tab + judul bar atas --}}
@section('title', 'Profil Desa - Desa Kalimanah')

{{-- CSS + JS khusus halaman ini dimuat via stack layout --}}
@push('styles')
    @vite(['resources/css/admin/profil-desa/edit.css'])
@endpush

@section('content')
    {{-- Form profil desa (satu baris resmi) --}}
    <section class="page-container-kecil" aria-labelledby="profil-judul">
        <h1 id="profil-judul">Profil Desa</h1>
        <p class="page-sub">Identitas, visi misi, dan sejarah resmi desa.</p>

        {{-- Kirim ke update profil desa --}}
        <form class="form-card" method="POST" action="{{ route('admin.profil-desa.update') }}" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            {{-- Nama desa --}}
            <div class="field">
                <label for="nama_desa">Nama Desa</label>
                <input id="nama_desa" type="text" name="nama_desa" value="{{ old('nama_desa', $profil->nama_desa ?? '') }}" required autocomplete="off">
                @foreach ((array) $errors->get('nama_desa') as $msg)
                    <p class="field-error" role="alert">{{ $msg }}</p>
                @endforeach
            </div>
            {{-- Visi desa --}}
            <div class="field">
                <label for="visi">Visi</label>
                <textarea id="visi" name="visi" rows="3" required>{{ old('visi', $profil->visi ?? '') }}</textarea>
                @foreach ((array) $errors->get('visi') as $msg)
                    <p class="field-error" role="alert">{{ $msg }}</p>
                @endforeach
            </div>
            {{-- Misi desa --}}
            <div class="field">
                <label for="misi">Misi</label>
                <textarea id="misi" name="misi" rows="4" required>{{ old('misi', $profil->misi ?? '') }}</textarea>
                @foreach ((array) $errors->get('misi') as $msg)
                    <p class="field-error" role="alert">{{ $msg }}</p>
                @endforeach
            </div>
            {{-- Sejarah desa --}}
            <div class="field">
                <label for="sejarah">Sejarah</label>
                <textarea id="sejarah" name="sejarah" rows="5">{{ old('sejarah', $profil->sejarah ?? '') }}</textarea>
                @foreach ((array) $errors->get('sejarah') as $msg)
                    <p class="field-error" role="alert">{{ $msg }}</p>
                @endforeach
            </div>
            {{-- Alamat balai --}}
            <div class="field">
                <label for="alamat">Alamat</label>
                <input id="alamat" type="text" name="alamat" value="{{ old('alamat', $profil->alamat ?? '') }}" autocomplete="street-address">
                @foreach ((array) $errors->get('alamat') as $msg)
                    <p class="field-error" role="alert">{{ $msg }}</p>
                @endforeach
            </div>
            {{-- Kode pos untuk kop surat --}}
            <div class="field">
                <label for="kode_pos">Kode Pos</label>
                <input id="kode_pos" type="text" name="kode_pos" value="{{ old('kode_pos', $profil->kode_pos ?? '') }}" inputmode="numeric" maxlength="10" autocomplete="postal-code">
                @foreach ((array) $errors->get('kode_pos') as $msg)
                    <p class="field-error" role="alert">{{ $msg }}</p>
                @endforeach
            </div>
            {{-- Telepon --}}
            <div class="field">
                <label for="telepon">Telepon</label>
                <input id="telepon" type="text" name="telepon" value="{{ old('telepon', $profil->telepon ?? '') }}" inputmode="tel" maxlength="20" autocomplete="tel">
                @foreach ((array) $errors->get('telepon') as $msg)
                    <p class="field-error" role="alert">{{ $msg }}</p>
                @endforeach
            </div>
            {{-- Email --}}
            <div class="field">
                <label for="email">Email</label>
                <input id="email" type="email" name="email" value="{{ old('email', $profil->email ?? '') }}" autocomplete="email">
                @foreach ((array) $errors->get('email') as $msg)
                    <p class="field-error" role="alert">{{ $msg }}</p>
                @endforeach
            </div>
            {{-- Logo desa (kosongkan untuk pakai lama) --}}
            <div class="field">
                <label for="logo">Logo</label>
                <input id="logo" type="file" name="logo" accept="image/jpeg,image/png">
                @foreach ((array) $errors->get('logo') as $msg)
                    <p class="field-error" role="alert">{{ $msg }}</p>
                @endforeach
            </div>
            {{-- Baris tombol simpan + batal --}}
            <div class="aksi-baris">
                <button type="submit" class="btn-simpan">Simpan</button>
                <a class="btn-sekunder" href="{{ route('admin.dashboard') }}">Batal</a>
            </div>
        </form>
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
    @vite(['resources/js/admin/profil-desa/edit.js'])
@endpush
