{{-- Halaman detail perangkat desa (pakai layout admin) --}}
@extends('layouts.admin')

{{-- Judul tab + judul bar atas --}}
@section('title', 'Detail Perangkat - Desa Kalimanah')

{{-- CSS + JS khusus halaman ini dimuat via stack layout --}}
@push('styles')
    @vite(['resources/css/admin/perangkat-desa/show.css'])
@endpush

@section('content')
    {{-- Info perangkat lengkap --}}
    <section class="detail" aria-labelledby="perangkat-judul">
        {{-- Kartu profil: foto + nama + jabatan + status --}}
        <div class="profil-card">
            @if ($perangkat->foto)
                <img src="{{ asset('storage/' . $perangkat->foto) }}" alt="Foto {{ $perangkat->nama }}">
            @else
                <span class="profil-inisial" aria-hidden="true">{{ strtoupper(substr($perangkat->nama, 0, 1)) }}</span>
            @endif
            <div>
                <h1 id="perangkat-judul">{{ $perangkat->nama }}</h1>
                <p class="detail-meta">
                    <span>{{ $perangkat->jabatan }}</span>
                    <span class="status {{ $perangkat->aktif ? 'status-buka' : 'status-tutup' }}">{{ $perangkat->aktif ? 'Aktif' : 'Nonaktif' }}</span>
                </p>
            </div>
        </div>

        {{-- Baris biodata --}}
        <dl class="biodata-card">
            <div><dt>Jabatan</dt><dd>{{ $perangkat->jabatan }}</dd></div>
            <div><dt>Telepon</dt><dd>@if ($perangkat->telepon)<a href="tel:{{ $perangkat->telepon }}">{{ $perangkat->telepon }}</a>@else - @endif</dd></div>
            <div><dt>Urutan Tampil</dt><dd>{{ $perangkat->urutan }}</dd></div>
        </dl>

        {{-- Baris tombol ubah + kembali --}}
        <div class="aksi-baris">
            <a class="btn-ubah" href="{{ route('admin.perangkat-desa.edit', $perangkat) }}">Ubah</a>
            <a class="btn-sekunder" href="{{ route('admin.perangkat-desa.index') }}">Kembali</a>
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
    @vite(['resources/js/admin/perangkat-desa/show.js'])
@endpush
