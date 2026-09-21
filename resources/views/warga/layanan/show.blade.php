{{-- Halaman detail layanan + syaratnya (pakai layout warga) --}}
@extends('layouts.warga')

{{-- Judul tab browser --}}
@section('title', 'Detail Layanan - Desa Kalimanah')

{{-- CSS + JS khusus halaman ini dimuat via stack layout --}}
@push('styles')
    @vite(['resources/css/warga/layanan/show.css'])
@endpush

@section('content')
    {{-- Info layanan --}}
    <section class="page-container detail" aria-labelledby="layanan-judul">
        <h1 id="layanan-judul">{{ $layanan->nama }}</h1>
        {{-- Baris estimasi --}}
        <p class="detail-meta">
            @if ($layanan->estimasi_hari)
                <span>Estimasi {{ $layanan->estimasi_hari }} hari</span>
            @endif
            <span>{{ $layanan->syaratLayanan->count() }} syarat</span>
        </p>
        @if ($layanan->deskripsi)
            <p class="detail-sub">{{ $layanan->deskripsi }}</p>
        @endif

        {{-- Tombol ajukan layanan ini --}}
        <a class="btn-ajukan" href="{{ route('warga.pengajuan.create', ['layanan' => $layanan->id]) }}">Ajukan Sekarang</a>

        {{-- Daftar syarat yang harus dipenuhi --}}
        <h2 class="kartu-judul">Syarat yang Dibutuhkan</h2>
        <ul class="syarat-list">
            @forelse ($layanan->syaratLayanan as $syarat)
                <li>
                    {{-- Nama + tipe --}}
                    <strong>{{ $syarat->nama }}</strong>
                    <span>{{ $syarat->tipe === 'file' ? 'Unggah file' : 'Isi teks' }}{{ $syarat->wajib ? ' · Wajib' : '' }}</span>
                </li>
            @empty
                {{-- Tanpa syarat tambahan --}}
                <li class="kosong">Langsung ajukan, tanpa syarat tambahan.</li>
            @endforelse
        </ul>

        {{-- Tombol kembali ke daftar --}}
        <a class="btn-kembali" href="{{ route('warga.layanan.index') }}">Kembali</a>
    </section>
@endsection

{{-- JS khusus halaman ini dimuat via stack layout --}}
@push('scripts')
    @vite(['resources/js/warga/layanan/show.js'])
@endpush
