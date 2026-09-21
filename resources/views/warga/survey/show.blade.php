{{-- Halaman isi survei: daftar nomor + jawaban bintang/teks (pakai layout warga) --}}
@extends('layouts.warga')

{{-- Judul tab browser --}}
@section('title', 'Isi Survei - Desa Kalimanah')

{{-- CSS + JS khusus halaman ini dimuat via stack layout --}}
@push('styles')
    @vite(['resources/css/warga/survey/show.css'])
@endpush

@section('content')
    {{-- Form jawaban survei --}}
    <section class="page-container survei-isi" aria-labelledby="survei-judul">
        <h1 id="survei-judul">{{ $survey->judul }}</h1>
        <p class="survei-sub">{{ $survey->deskripsi ?? 'Jawab semua pertanyaan wajib.' }}</p>

        @if ($survey->pertanyaans->isNotEmpty())
            {{-- Kirim jawaban ke store survei --}}
            <form method="POST" action="{{ route('warga.survey.store', $survey) }}">
                @csrf
                <ol class="soal-list">
                    @foreach ($survey->pertanyaans as $tanya)
                        <li class="soal">
                            {{-- Nomor + teks pertanyaan --}}
                            <p class="soal-teks"><span class="soal-nomor">{{ $loop->iteration }}.</span> {{ $tanya->pertanyaan }}</p>
                            @if ($tanya->tipe === 'skala')
                                {{-- Bintang 1-5 (radio dibalik agar isi dari kiri; karakter bintang asli agar selalu tampil) --}}
                                <div class="bintang" role="radiogroup" aria-label="Nilai 1 sampai 5 untuk pertanyaan {{ $loop->iteration }}">
                                    @for ($i = 5; $i >= 1; $i--)
                                        <input type="radio" id="bintang-{{ $tanya->id }}-{{ $i }}" name="jawaban[{{ $tanya->id }}]" value="{{ $i }}" @if ($i === 5) @required($tanya->wajib) @endif>
                                        <label for="bintang-{{ $tanya->id }}-{{ $i }}" title="{{ $i }}"><span class="bintang-ikon" aria-hidden="true">★</span></label>
                                    @endfor
                                </div>
                            @else
                                {{-- Kolom tulisan bebas --}}
                                <textarea name="jawaban[{{ $tanya->id }}]" rows="3" @required($tanya->wajib)>{{ old('jawaban.' . $tanya->id) }}</textarea>
                            @endif
                        </li>
                    @endforeach
                </ol>
                {{-- Baris tombol kirim + batal --}}
                <div class="aksi-baris">
                    <button type="submit" class="btn-simpan">Kirim Jawaban</button>
                    <a class="btn-sekunder" href="{{ route('warga.survey.index') }}">Batal</a>
                </div>
            </form>
        @else
            {{-- Survei belum punya pertanyaan --}}
            <p><strong>Belum ada pertanyaan di survei ini.</strong></p>
            <div class="aksi-baris">
                <a class="btn-sekunder" href="{{ route('warga.survey.index') }}">Kembali</a>
            </div>
        @endif
    </section>
@endsection

{{-- JS khusus halaman ini dimuat via stack layout --}}
@push('scripts')
    @vite(['resources/js/warga/survey/show.js'])
@endpush
