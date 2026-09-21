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

    {{-- Daftar pertanyaan tambahan + tambah baru --}}
    <section class="page-container-kecil" aria-labelledby="tanya-judul" style="margin-top: 32px;">
        <h2 id="tanya-judul" class="judul-seksi-kecil">Pertanyaan Tambahan</h2>
        <ul class="tanya-list">
            @forelse ($survey->pertanyaans->skip(1) as $tanya)
                <li>
                    {{-- Teks + tipe --}}
                    <div class="tanya-head">
                        <strong>{{ $tanya->pertanyaan }}</strong>
                        <span class="tanya-meta">{{ $tanya->tipe === 'skala' ? 'Skala 1-5' : 'Teks' }}</span>
                    </div>
                    {{-- Hapus pertanyaan tambahan ini (jawaban ikut terhapus) --}}
                    <form method="POST" action="{{ route('admin.pertanyaan.destroy', $tanya) }}" data-konfirmasi="Hapus pertanyaan ini beserta jawabannya?">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn-kecil btn-hapus">Hapus</button>
                    </form>
                </li>
            @empty
                {{-- Belum ada pertanyaan tambahan --}}
                <li class="kosong">Belum ada pertanyaan tambahan.</li>
            @endforelse
        </ul>

        {{-- Form tambah pertanyaan (otomatis wajib diisi warga) --}}
        <h3 class="judul-seksi-kecil">Tambah Pertanyaan</h3>
        <form class="form-card" method="POST" action="{{ route('admin.pertanyaan.store', $survey) }}">
            @csrf
            <div class="field">
                <label for="pertanyaan-tambah">Pertanyaan</label>
                <textarea id="pertanyaan-tambah" name="pertanyaan" rows="2" required>{{ old('pertanyaan') }}</textarea>
            </div>
            <div class="field-row">
                <div class="field">
                    <label for="tipe-tambah">Tipe Jawaban</label>
                    <select id="tipe-tambah" name="tipe" required>
                        <option value="skala" @selected(old('tipe') === 'skala')>Skala 1-5</option>
                        <option value="text" @selected(old('tipe') === 'text')>Teks bebas</option>
                    </select>
                </div>
                <div class="field">
                    <label for="urutan-tambah">Urutan</label>
                    <input id="urutan-tambah" type="number" name="urutan" value="{{ old('urutan', 1) }}" min="0">
                </div>
            </div>
            <button type="submit" class="btn-simpan">Tambah</button>
        </form>
    </section>
@endsection

{{-- JS khusus halaman ini dimuat via stack layout --}}
@push('scripts')
    @vite(['resources/js/admin/survey/edit.js'])
@endpush
