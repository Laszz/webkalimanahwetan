{{-- Halaman tambah survei (pakai layout admin) --}}
@extends('layouts.admin')

{{-- Judul tab + judul bar atas --}}
@section('title', 'Tambah Survei - Desa Kalimanah')

{{-- CSS + JS khusus halaman ini dimuat via stack layout --}}
@push('styles')
    @vite(['resources/css/admin/survey/create.css'])
@endpush

@section('content')
    {{-- Form tambah survei --}}
    <section class="page-container-kecil" aria-labelledby="survey-judul">
        <h1 id="survey-judul">Tambah Survei</h1>
        <p class="page-sub">Buat survei baru, pertanyaan ditambah setelahnya.</p>

        {{-- Kirim ke store survei --}}
        <form class="form-card" method="POST" action="{{ route('admin.survey.store') }}">
            @csrf
            {{-- Pertanyaan langsung di form ini --}}
            <div class="field">
                <label for="pertanyaan">Pertanyaan</label>
                <textarea id="pertanyaan" name="pertanyaan" rows="3" required>{{ old('pertanyaan') }}</textarea>
                @foreach ((array) $errors->get('pertanyaan') as $msg)
                    <p class="field-error" role="alert">{{ $msg }}</p>
                @endforeach
            </div>
            {{-- Tipe jawaban pertanyaan pertama --}}
            <div class="field">
                <label for="tipe">Tipe Jawaban</label>
                <select id="tipe" name="tipe" required>
                    <option value="skala" @selected(old('tipe') === 'skala')>Skala 1-5</option>
                    <option value="text" @selected(old('tipe') === 'text')>Teks bebas</option>
                </select>
                @foreach ((array) $errors->get('tipe') as $msg)
                    <p class="field-error" role="alert">{{ $msg }}</p>
                @endforeach
            </div>
            {{-- Periode pengisian --}}
            <div class="field">
                <label for="mulai">Dibuka Tanggal</label>
                <input id="mulai" type="datetime-local" name="mulai" value="{{ old('mulai') }}">
                @foreach ((array) $errors->get('mulai') as $msg)
                    <p class="field-error" role="alert">{{ $msg }}</p>
                @endforeach
            </div>
            <div class="field">
                <label for="selesai">Ditutup Tanggal</label>
                <input id="selesai" type="datetime-local" name="selesai" value="{{ old('selesai') }}">
                @foreach ((array) $errors->get('selesai') as $msg)
                    <p class="field-error" role="alert">{{ $msg }}</p>
                @endforeach
            </div>
            {{-- Centang = langsung dibuka --}}
            <div class="field-check">
                <label for="aktif"><input id="aktif" type="checkbox" name="aktif" value="1" @checked(old('aktif', true))> Langsung dibuka</label>
            </div>
            {{-- Baris tombol simpan + batal --}}
            <div class="aksi-baris">
                <button type="submit" class="btn-simpan">Simpan</button>
                <a class="btn-sekunder" href="{{ route('admin.survey.index') }}">Batal</a>
            </div>
        </form>
    </section>
@endsection

{{-- JS khusus halaman ini dimuat via stack layout --}}
@push('scripts')
    @vite(['resources/js/admin/survey/create.js'])
@endpush
