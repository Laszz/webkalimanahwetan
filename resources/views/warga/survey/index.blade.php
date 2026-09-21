{{-- Halaman survei - daftar survei yang dibuka (pakai layout warga) --}}
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
                        {{-- Sudah isi bulan ini: tombol memicu popup, bukan pindah --}}
                        <button type="button" class="btn-isi" data-popup>Isi Survei</button>
                    @else
                        {{-- Belum isi: masuk form survei --}}
                        <a class="btn-isi" href="{{ route('warga.survey.show', $survey) }}">Isi Survei</a>
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
