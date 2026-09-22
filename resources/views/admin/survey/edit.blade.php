{{-- Halaman ubah survei (pakai layout admin) --}}
@extends('layouts.admin')

{{-- Judul tab + judul bar atas --}}
@section('title', 'Ubah Survei - Desa Kalimanah')

{{-- CSS + JS khusus halaman ini dimuat via stack layout --}}
@push('styles')
    @vite(['resources/css/admin/survey/edit.css'])
@endpush

@section('content')
    {{-- Form ubah terisi data lama --}}
    <section class="page-container-kecil" aria-labelledby="survey-judul">
        <h1 id="survey-judul">Ubah Survei</h1>
        <p class="page-sub">Perbarui survei kepuasan.</p>

        {{-- Kirim perubahan ke update survei --}}
        <form class="form-card" method="POST" action="{{ route('admin.survey.update', $survey) }}">
            @csrf
            @method('PUT')
            {{-- Pertanyaan pertama, edit langsung di form ini --}}
            <div class="field">
                <label for="pertanyaan">Pertanyaan</label>
                <textarea id="pertanyaan" name="pertanyaan" rows="3" required>{{ old('pertanyaan', $pertama?->pertanyaan) }}</textarea>
                @foreach ((array) $errors->get('pertanyaan') as $msg)
                    <p class="field-error" role="alert">{{ $msg }}</p>
                @endforeach
            </div>
            {{-- Tipe jawaban pertanyaan pertama --}}
            <div class="field">
                <label for="tipe">Tipe Jawaban</label>
                <select id="tipe" name="tipe" required>
                    <option value="skala" @selected(old('tipe', $pertama?->tipe) === 'skala')>Skala 1-5</option>
                    <option value="text" @selected(old('tipe', $pertama?->tipe) === 'text')>Teks bebas</option>
                </select>
                @foreach ((array) $errors->get('tipe') as $msg)
                    <p class="field-error" role="alert">{{ $msg }}</p>
                @endforeach
            </div>
            {{-- Periode pengisian --}}
            <div class="field">
                <label for="mulai">Dibuka Tanggal</label>
                <input id="mulai" type="datetime-local" name="mulai" value="{{ old('mulai', $survey->mulai?->format('Y-m-d\TH:i')) }}">
                @foreach ((array) $errors->get('mulai') as $msg)
                    <p class="field-error" role="alert">{{ $msg }}</p>
                @endforeach
            </div>
            <div class="field">
                <label for="selesai">Ditutup Tanggal</label>
                <input id="selesai" type="datetime-local" name="selesai" value="{{ old('selesai', $survey->selesai?->format('Y-m-d\TH:i')) }}">
                @foreach ((array) $errors->get('selesai') as $msg)
                    <p class="field-error" role="alert">{{ $msg }}</p>
                @endforeach
            </div>
            {{-- Centang = survei dibuka --}}
            <div class="field-check">
                <label for="aktif"><input id="aktif" type="checkbox" name="aktif" value="1" @checked(old('aktif', $survey->aktif))> Dibuka</label>
            </div>
            {{-- Baris tombol simpan + batal --}}
            <div class="aksi-baris">
                <button type="submit" class="btn-simpan">Simpan Perubahan</button>
                <a class="btn-sekunder" href="{{ route('admin.survey.index') }}">Batal</a>
            </div>
        </form>
    </section>
@endsection

{{-- JS khusus halaman ini dimuat via stack layout --}}
@push('scripts')
    @vite(['resources/js/admin/survey/edit.js'])
@endpush
