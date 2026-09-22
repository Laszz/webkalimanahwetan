{{-- Halaman survei - isi langsung di daftar tanpa ke show (pakai layout warga) --}}
@extends('layouts.warga')

{{-- Judul tab browser --}}
@section('title', 'Survei - Desa Kalimanah')

{{-- CSS + JS khusus halaman ini dimuat via stack layout --}}
@push('styles')
    @vite(['resources/css/warga/survey/index.css'])
@endpush

@section('content')
    {{-- Daftar survei terbuka --}}
    <section class="page-container survei" aria-labelledby="survei-judul">
        <h1 id="survei-judul">Survei Warga</h1>
        <p class="survei-sub">Sampaikan penilaianmu, sebulan sekali per survei.</p>

        {{-- Spanduk lunas bila semua survei bulan ini sudah diisi --}}
        @if ($semuaTerisi)
            <p class="info-banner" role="status">Semua survei bulan ini sudah diisi. Terima kasih.</p>
        @endif

        {{-- Kartu tiap survei --}}
        <ul class="survei-grid">
            @forelse ($surveys as $survey)
                <li>
                    {{-- Judul survei --}}
                    <h2>{{ $survey->judul }}</h2>
                    @if ($survey->sudah_isi)
                        {{-- Sudah isi bulan ini: tombol memicu popup, bukan kirim --}}
                        <p class="survei-deskripsi">{{ $survey->deskripsi ?? '' }}</p>
                        <button type="button" class="btn-isi" data-popup>Isi Survei</button>
                    @else
                        {{-- Belum isi: pertanyaan + bintang langsung di sini --}}
                        @if ($survey->deskripsi)
                            <p class="survei-deskripsi">{{ $survey->deskripsi }}</p>
                        @endif
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
                                                    <input type="radio" id="bintang-{{ $tanya->id }}-{{ $i }}" name="jawaban[{{ $tanya->id }}]" value="{{ $i }}" @checked((int) old('jawaban.' . $tanya->id) === $i) @if ($i === 5) @required($tanya->wajib) @endif>
                                                    <label for="bintang-{{ $tanya->id }}-{{ $i }}" title="{{ $i }}"><span class="bintang-ikon" aria-hidden="true">★</span></label>
                                                @endfor
                                            </div>
                                        @else
                                            {{-- Kolom tulisan bebas --}}
                                            <textarea name="jawaban[{{ $tanya->id }}]" rows="3" @required($tanya->wajib)>{{ old('jawaban.' . $tanya->id) }}</textarea>
                                        @endif
                                        @foreach ((array) $errors->get('jawaban.' . $tanya->id) as $msg)
                                            <p class="field-error" role="alert">{{ $msg }}</p>
                                        @endforeach
                                    </li>
                                @endforeach
                            </ol>
                            <button type="submit" class="btn-simpan">Kirim</button>
                        </form>
                    @endif
                </li>
            @empty
                {{-- Belum ada survei dibuka --}}
                <li><p><strong>Belum ada survei dibuka.</strong></p></li>
            @endforelse
        </ul>

        {{-- Navigasi halaman --}}
        {{ $surveys->links() }}
    </section>

    {{-- Popup: sukses/info habis aksi (langsung tampil) atau sudah mengisi (muncul saat tombol diklik) --}}
    @php($pesan = session('success') ?? session('info'))
    <div class="popup" id="popup" @unless ($pesan) hidden @endunless role="alertdialog" aria-modal="true" aria-label="Info survei">
        <div class="popup-kartu">
            <i class="ph {{ $pesan ? 'ph-check-circle popup-ok' : 'ph-clock popup-info' }}" aria-hidden="true"></i>
            <p>{{ $pesan ?? 'Anda sudah mengisi survei ini, silahkan tunggu 1 bulan lagi.' }}</p>
            <button type="button" class="btn-isi" data-tutup>Tutup</button>
        </div>
    </div>
@endsection

{{-- JS khusus halaman ini dimuat via stack layout --}}
@push('scripts')
    @vite(['resources/js/warga/survey/index.js'])
@endpush
