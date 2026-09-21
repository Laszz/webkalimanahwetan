{{-- Halaman ubah agenda (pakai layout admin) --}}
@extends('layouts.admin')

{{-- Judul tab + judul bar atas --}}
@section('title', 'Ubah Agenda - Desa Kalimanah')

{{-- CSS + JS khusus halaman ini dimuat via stack layout --}}
@push('styles')
    @vite(['resources/css/admin/agenda/edit.css'])
@endpush

@section('content')
    {{-- Form ubah terisi data lama --}}
    <section class="page-container-kecil" aria-labelledby="agenda-judul">
        <h1 id="agenda-judul">Ubah Agenda</h1>
        <p class="page-sub">Perbarui jadwal kegiatan desa.</p>

        {{-- Kirim perubahan ke update agenda --}}
        <form class="form-card" method="POST" action="{{ route('admin.agenda.update', $agenda) }}">
            @csrf
            @method('PUT')
            {{-- Judul kegiatan --}}
            <div class="field">
                <label for="judul">Judul Kegiatan</label>
                <input id="judul" type="text" name="judul" value="{{ old('judul', $agenda->judul) }}" required autocomplete="off">
                @foreach ((array) $errors->get('judul') as $msg)
                    <p class="field-error" role="alert">{{ $msg }}</p>
                @endforeach
            </div>
            {{-- Penjelasan kegiatan --}}
            <div class="field">
                <label for="deskripsi">Deskripsi</label>
                <textarea id="deskripsi" name="deskripsi" rows="3">{{ old('deskripsi', $agenda->deskripsi) }}</textarea>
                @foreach ((array) $errors->get('deskripsi') as $msg)
                    <p class="field-error" role="alert">{{ $msg }}</p>
                @endforeach
            </div>
            {{-- Lokasi kegiatan --}}
            <div class="field">
                <label for="tempat">Tempat</label>
                <input id="tempat" type="text" name="tempat" value="{{ old('tempat', $agenda->tempat) }}" required autocomplete="off">
                @foreach ((array) $errors->get('tempat') as $msg)
                    <p class="field-error" role="alert">{{ $msg }}</p>
                @endforeach
            </div>
            {{-- Waktu mulai --}}
            <div class="field">
                <label for="mulai">Mulai Tanggal</label>
                <input id="mulai" type="datetime-local" name="mulai" value="{{ old('mulai', $agenda->mulai?->format('Y-m-d\TH:i')) }}" required>
                @foreach ((array) $errors->get('mulai') as $msg)
                    <p class="field-error" role="alert">{{ $msg }}</p>
                @endforeach
            </div>
            {{-- Waktu selesai opsional --}}
            <div class="field">
                <label for="selesai">Selesai Tanggal</label>
                <input id="selesai" type="datetime-local" name="selesai" value="{{ old('selesai', $agenda->selesai?->format('Y-m-d\TH:i')) }}">
                @foreach ((array) $errors->get('selesai') as $msg)
                    <p class="field-error" role="alert">{{ $msg }}</p>
                @endforeach
            </div>
            {{-- Baris tombol simpan + batal --}}
            <div class="aksi-baris">
                <button type="submit" class="btn-simpan">Simpan Perubahan</button>
                <a class="btn-sekunder" href="{{ route('admin.agenda.show', $agenda) }}">Batal</a>
            </div>
        </form>
    </section>
@endsection

{{-- JS khusus halaman ini dimuat via stack layout --}}
@push('scripts')
    @vite(['resources/js/admin/agenda/edit.js'])
@endpush
