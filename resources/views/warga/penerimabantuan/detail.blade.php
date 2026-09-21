{{-- Halaman detail penerimaan bantuan milik sendiri (pakai layout warga) --}}
@extends('layouts.warga')

{{-- Judul tab browser --}}
@section('title', 'Detail Bantuan - Desa Kalimanah')

{{-- CSS + JS khusus halaman ini dimuat via stack layout --}}
@push('styles')
    @vite(['resources/css/warga/penerimabantuan/detail.css'])
@endpush

@section('content')
    {{-- Rincian bantuan + penerima --}}
    <section class="page-container terima" aria-labelledby="terima-judul">
        <h1 id="terima-judul">{{ $penerima->jenisBantuan->nama ?? '-' }}</h1>
        <p class="terima-sub">{{ $penerima->jenisBantuan->deskripsi ?? 'Tanpa deskripsi.' }}</p>

        {{-- Kartu isi bantuan --}}
        <h2 class="kartu-judul">Isi Bantuan</h2>
        <dl class="terima-card">
            <div><dt>Nominal</dt><dd>Rp {{ number_format($penerima->nominal, 0, ',', '.') }}</dd></div>
            <div><dt>Periode</dt><dd>{{ $penerima->bulan ? 'Bulan ' . $penerima->bulan . ' ' . $penerima->tahun : 'Tahun ' . $penerima->tahun }}</dd></div>
            <div><dt>Keterangan</dt><dd>{{ $penerima->keterangan ?? '-' }}</dd></div>
        </dl>

        {{-- Kartu data penerima --}}
        <h2 class="kartu-judul">Data Penerima</h2>
        <dl class="terima-card">
            <div><dt>Nama</dt><dd>{{ $penerima->warga->nama ?? '-' }}</dd></div>
            <div><dt>RT/RW</dt><dd>RT {{ $penerima->warga->rt ?? '-' }}/RW {{ $penerima->warga->rw ?? '-' }}</dd></div>
        </dl>

        {{-- Tombol kembali ke dashboard --}}
        <a class="btn-kembali" href="{{ route('warga.dashboard') }}">Kembali</a>
    </section>
@endsection

{{-- JS khusus halaman ini dimuat via stack layout --}}
@push('scripts')
    @vite(['resources/js/warga/penerimabantuan/detail.js'])
@endpush
