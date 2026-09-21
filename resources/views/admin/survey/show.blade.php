{{-- Halaman detail survei + pertanyaan + rekap hasil (pakai layout admin) --}}
@extends('layouts.admin')

{{-- Judul tab + judul bar atas --}}
@section('title', 'Detail Survei - Desa Kalimanah')

{{-- CSS + JS khusus halaman ini dimuat via stack layout --}}
@push('styles')
    @vite(['resources/css/admin/survey/show.css'])
@endpush

@section('content')
    {{-- Info survei --}}
    <section class="detail" aria-labelledby="survey-judul">
        <h1 id="survey-judul">{{ $survey->judul }}</h1>
        {{-- Baris status + periode --}}
        <p class="detail-meta">
            <span class="status {{ $survey->aktif ? 'status-buka' : 'status-tutup' }}">{{ $survey->aktif ? 'Dibuka' : 'Ditutup' }}</span>
            @if ($survey->mulai || $survey->selesai)
                <span>{{ $survey->mulai?->format('d M Y') ?? '...' }} - {{ $survey->selesai?->format('d M Y') ?? '...' }}</span>
            @endif
        </p>

        {{-- Kartu ringkasan hasil --}}
        <div class="ringkasan">
            <h2>Ringkasan</h2>
            <p><strong>{{ $ringkasan['responden'] }} Responden</strong><span>Rata-rata {{ $ringkasan['rata_rata'] !== null ? number_format($ringkasan['rata_rata'], 1, ',', '.') : '-' }}</span></p>
        </div>

        {{-- Daftar pertanyaan + hasil --}}
        <h2 class="kartu-judul">Pertanyaan dan Hasil</h2>
        <ul class="tanya-list">
            @forelse ($survey->pertanyaans as $tanya)
                <li>
                    {{-- Teks + tipe + wajib --}}
                    <div class="tanya-head">
                        <strong>{{ $tanya->pertanyaan }}</strong>
                        <span class="tanya-meta">{{ $tanya->tipe === 'skala' ? 'Skala 1-5' : 'Teks' }}{{ $tanya->wajib ? ' · Wajib' : '' }}</span>
                    </div>
                    {{-- Daftar warga yang menjawab + isi jawabannya --}}
                    @if ($tanya->jawabans->isNotEmpty())
                        <p class="tanya-hasil">{{ $tanya->jawabans->unique('user_id')->count() }} warga menjawab</p>
                        <ul class="responden-list">
                            @foreach ($tanya->jawabans as $jawaban)
                                <li>
                                    <strong>{{ $jawaban->user->name ?? '-' }}</strong>
                                    @if (is_numeric($jawaban->jawaban))
                                        {{-- Nilai angka divisualkan bintang terisi --}}
                                        <span class="bintang-kecil" aria-label="Nilai {{ $jawaban->jawaban }} dari 5">
                                            @for ($i = 1; $i <= 5; $i++)
                                                <span class="{{ $i <= (int) $jawaban->jawaban ? 'on' : '' }}">★</span>
                                            @endfor
                                        </span>
                                    @else
                                        <span>{{ $jawaban->jawaban }}</span>
                                    @endif
                                    {{-- Hapus jawaban baris ini saja --}}
                                    <form method="POST" action="{{ route('admin.jawaban.destroy', $jawaban) }}" data-konfirmasi="Hapus jawaban {{ $jawaban->user->name ?? 'ini' }}?">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn-kecil btn-hapus">Hapus</button>
                                    </form>
                                </li>
                            @endforeach
                        </ul>
                    @else
                        <p class="tanya-hasil">Belum ada jawaban.</p>
                    @endif
                </li>
            @empty
                {{-- Belum ada pertanyaan --}}
                <li class="kosong">Belum ada pertanyaan.</li>
            @endforelse
        </ul>

        {{-- Tombol kembali di bawah daftar --}}
        <div class="aksi-bawah">
            <a class="btn-sekunder" href="{{ route('admin.survey.index') }}">Kembali</a>
        </div>
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
    @vite(['resources/js/admin/survey/show.js'])
@endpush
