{{-- Halaman tambah agenda (pakai layout admin) --}}
@extends('layouts.admin')

{{-- Judul tab + judul bar atas --}}
@section('title', 'Tambah Agenda - Desa Kalimanah')

{{-- CSS + JS khusus halaman ini dimuat via stack layout --}}
@push('styles')
    @vite(['resources/css/admin/agenda/create.css'])
@endpush

@section('content')
    {{-- Form tambah agenda --}}
    <section class="page-container-kecil" aria-labelledby="agenda-judul">
        <h1 id="agenda-judul">Tambah Agenda</h1>
        <p class="page-sub">Jadwalkan kegiatan desa baru.</p>

        {{-- Kirim ke store agenda --}}
        <form class="form-card" method="POST" action="{{ route('admin.agenda.store') }}">
            @csrf
            {{-- Judul kegiatan --}}
            <div class="field">
                <label for="judul">Judul Kegiatan</label>
                <input id="judul" type="text" name="judul" value="{{ old('judul') }}" required autocomplete="off">
                @foreach ((array) $errors->get('judul') as $msg)
                    <p class="field-error" role="alert">{{ $msg }}</p>
                @endforeach
            </div>
            {{-- Penjelasan kegiatan --}}
            <div class="field">
                <label for="deskripsi">Deskripsi</label>
                <textarea id="deskripsi" name="deskripsi" rows="3">{{ old('deskripsi') }}</textarea>
                @foreach ((array) $errors->get('deskripsi') as $msg)
                    <p class="field-error" role="alert">{{ $msg }}</p>
                @endforeach
            </div>
            {{-- Lokasi kegiatan --}}
            <div class="field">
                <label for="tempat">Tempat</label>
                <input id="tempat" type="text" name="tempat" value="{{ old('tempat') }}" required autocomplete="off">
                @foreach ((array) $errors->get('tempat') as $msg)
                    <p class="field-error" role="alert">{{ $msg }}</p>
                @endforeach
            </div>
            {{-- Waktu mulai --}}
            <div class="field">
                <label for="mulai">Mulai Tanggal</label>
                <input id="mulai" type="datetime-local" name="mulai" value="{{ old('mulai') }}" required>
                @foreach ((array) $errors->get('mulai') as $msg)
                    <p class="field-error" role="alert">{{ $msg }}</p>
                @endforeach
            </div>
            {{-- Waktu selesai opsional --}}
            <div class="field">
                <label for="selesai">Selesai Tanggal</label>
                <input id="selesai" type="datetime-local" name="selesai" value="{{ old('selesai') }}">
                @foreach ((array) $errors->get('selesai') as $msg)
                    <p class="field-error" role="alert">{{ $msg }}</p>
                @endforeach
            </div>
            {{-- Baris tombol simpan + batal --}}
            <div class="aksi-baris">
                <button type="submit" class="btn-simpan">Simpan</button>
                <a class="btn-sekunder" href="{{ route('admin.agenda.index') }}">Batal</a>
            </div>
        </form>
    </section>
@endsection

{{-- JS khusus halaman ini dimuat via stack layout --}}
@push('scripts')
    @vite(['resources/js/admin/agenda/create.js'])
@endpush
