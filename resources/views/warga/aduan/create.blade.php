{{-- Halaman buat aduan baru (pakai layout warga) --}}
@extends('layouts.warga')

{{-- Judul tab browser --}}
@section('title', 'Buat Aduan - Desa Kalimanah')

{{-- CSS + JS khusus halaman ini dimuat via stack layout --}}
@push('styles')
    @vite(['resources/css/warga/aduan/create.css'])
@endpush

@section('content')
    {{-- Form lapor aduan --}}
    <section class="page-container aduan-form" aria-labelledby="aduan-judul">
        <h1 id="aduan-judul">Buat Aduan</h1>
        <p class="aduan-sub">Ceritakan masalahnya, tambahkan foto bukti bila ada.</p>

        {{-- Kirim ke store aduan warga --}}
        <form class="form-card" method="POST" action="{{ route('warga.aduan.store') }}" enctype="multipart/form-data">
            @csrf
            {{-- Judul laporan --}}
            <div class="field">
                <label for="judul">Judul Aduan</label>
                <input id="judul" type="text" name="judul" value="{{ old('judul') }}" required autocomplete="off">
                @foreach ((array) $errors->get('judul') as $msg)
                    <p class="field-error" role="alert">{{ $msg }}</p>
                @endforeach
            </div>
            {{-- Isi laporan --}}
            <div class="field">
                <label for="isi">Isi Aduan</label>
                <textarea id="isi" name="isi" rows="5" required>{{ old('isi') }}</textarea>
                @foreach ((array) $errors->get('isi') as $msg)
                    <p class="field-error" role="alert">{{ $msg }}</p>
                @endforeach
            </div>
            {{-- Foto bukti opsional --}}
            <div class="field">
                <label for="gambar">Foto Bukti (opsional)</label>
                <input id="gambar" type="file" name="gambar" accept="image/jpeg,image/png">
                @foreach ((array) $errors->get('gambar') as $msg)
                    <p class="field-error" role="alert">{{ $msg }}</p>
                @endforeach
            </div>
            {{-- Baris tombol kirim + batal --}}
            <div class="aksi-baris">
                <button type="submit" class="btn-simpan">Kirim Aduan</button>
                <a class="btn-sekunder" href="{{ route('warga.aduan.index') }}">Batal</a>
            </div>
        </form>
    </section>
@endsection

{{-- JS khusus halaman ini dimuat via stack layout --}}
@push('scripts')
    @vite(['resources/js/warga/aduan/create.js'])
@endpush
