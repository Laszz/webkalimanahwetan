{{-- Halaman perangkat desa - kepala desa di atas + staf berurutan (pakai layout warga) --}}
@extends('layouts.warga')

{{-- Judul tab browser --}}
@section('title', 'Perangkat Desa - Desa Kalimanah')

{{-- CSS + JS khusus halaman ini dimuat via stack layout --}}
@push('styles')
    @vite(['resources/css/warga/perangkat-desa/index.css'])
@endpush

@section('content')
    {{-- Susunan pamong aktif: kepala desa (urutan 0) paling atas --}}
    <section class="page-container perangkat" aria-labelledby="perangkat-judul">
        <h1 id="perangkat-judul">Perangkat Desa</h1>
        <p class="perangkat-sub">Pamong yang melayani warga.</p>

        @php
            // Kepala desa = jabatan mengandung "kepala desa", cadangan = urutan terkecil (koleksi sudah urut)
            $kepala = $perangkats->first(fn ($p) => str_contains(strtolower($p->jabatan), 'kepala desa')) ?? $perangkats->first();
            $staf = $kepala ? $perangkats->where('id', '!=', $kepala->id)->values() : collect();
        @endphp

        @if ($kepala)
            {{-- Label + kartu besar kepala desa --}}
            <h2 class="perangkat-label">Kepala Desa</h2>
            <article class="kepala-card" aria-label="Kepala Desa">
                @if ($kepala->foto)
                    <img src="{{ asset('storage/' . $kepala->foto) }}" loading="lazy" alt="Foto {{ $kepala->nama }}">
                @else
                    <span class="perangkat-inisial" aria-hidden="true">{{ strtoupper(substr($kepala->nama, 0, 1)) }}</span>
                @endif
                <div>
                    <p class="kepala-label">Kepala Desa</p>
                    <h2>{{ $kepala->nama }}</h2>
                    @if ($kepala->telepon)
                        <p><a href="tel:{{ $kepala->telepon }}">{{ $kepala->telepon }}</a></p>
                    @endif
                </div>
            </article>
        @endif

        @if ($staf->isNotEmpty())
            {{-- Kartu staf berurutan 1 ke bawah --}}
            <h2 class="perangkat-label">Perangkat & Staf</h2>
            <ul class="perangkat-grid">
                @foreach ($staf as $perangkat)
                    <li>
                        {{-- Foto atau inisial --}}
                        @if ($perangkat->foto)
                            <img src="{{ asset('storage/' . $perangkat->foto) }}" loading="lazy" alt="Foto {{ $perangkat->nama }}">
                        @else
                            <span class="perangkat-inisial" aria-hidden="true">{{ strtoupper(substr($perangkat->nama, 0, 1)) }}</span>
                        @endif
                        {{-- Nama + jabatan + telepon --}}
                        <h3>{{ $perangkat->nama }}</h3>
                        <p>{{ $perangkat->jabatan }}</p>
                        @if ($perangkat->telepon)
                            <p><a href="tel:{{ $perangkat->telepon }}">{{ $perangkat->telepon }}</a></p>
                        @endif
                    </li>
                @endforeach
            </ul>
        @elseif (!$kepala)
            {{-- Belum ada perangkat aktif --}}
            <p><strong>Belum ada perangkat desa.</strong></p>
        @endif
    </section>
@endsection

{{-- JS khusus halaman ini dimuat via stack layout --}}
@push('scripts')
    @vite(['resources/js/warga/perangkat-desa/index.js'])
@endpush
