{{-- Halaman detail pos APBDes (pakai layout admin) --}}
@extends('layouts.admin')

{{-- Judul tab + judul bar atas --}}
@section('title', 'Detail APBDes - Desa Kalimanah')

{{-- CSS + JS khusus halaman ini dimuat via stack layout --}}
@push('styles')
    @vite(['resources/css/admin/apbdes/show.css'])
@endpush

@section('content')
    {{-- Info pos anggaran lengkap --}}
    <section class="detail" aria-labelledby="apbdes-judul">
        <h1 id="apbdes-judul">{{ $apbde->uraian }}</h1>
        {{-- Baris tahun + bidang + sumber dana --}}
        <p class="detail-meta">
            <span>Tahun {{ $apbde->tahun }}</span>
            <span>{{ $apbde->bidang }}</span>
            <span>{{ $apbde->sumber_dana }}</span>
        </p>

        {{-- Angka anggaran vs realisasi --}}
        @php
            $persen = $apbde->anggaran > 0 ? min(100, round(($apbde->realisasi / $apbde->anggaran) * 100)) : 0;
            $sisa = max(0, $apbde->anggaran - $apbde->realisasi);
        @endphp
        <dl class="angka-grid">
            <div>
                <dt>Anggaran</dt>
                <dd>Rp{{ number_format($apbde->anggaran, 0, ',', '.') }}</dd>
            </div>
            <div>
                <dt>Realisasi ({{ $persen }}%)</dt>
                <dd>Rp{{ number_format($apbde->realisasi, 0, ',', '.') }}</dd>
            </div>
            <div>
                <dt>Sisa</dt>
                <dd>Rp{{ number_format($sisa, 0, ',', '.') }}</dd>
            </div>
        </dl>

        {{-- Batang serapan anggaran --}}
        <div class="serapan" role="img" aria-label="Serapan {{ $persen }} persen">
            <div class="serapan-isi" style="width: {{ $persen }}%"></div>
        </div>

        {{-- Baris tombol ubah + kembali --}}
        <div class="aksi-baris">
            <a class="btn-ubah" href="{{ route('admin.apbdes.edit', $apbde) }}">Ubah</a>
            <a class="btn-sekunder" href="{{ route('admin.apbdes.index') }}">Kembali</a>
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
    @vite(['resources/js/admin/apbdes/show.js'])
@endpush
