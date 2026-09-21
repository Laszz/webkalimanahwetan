{{-- Halaman profil desa - visi misi dan sejarah (pakai layout warga) --}}
@extends('layouts.warga')

{{-- Judul tab browser --}}
@section('title', 'Profil Desa - Desa Kalimanah')

{{-- CSS + JS khusus halaman ini dimuat via stack layout --}}
@push('styles')
    @vite(['resources/css/warga/profil-desa/index.css'])
@endpush

@section('content')
    {{-- Profil resmi desa; kosong = pesan jujur --}}
    <section class="page-container profil-desa" aria-labelledby="profil-desa-judul">
        @if ($profil)
            {{-- Kepala: logo + nama desa --}}
            <div class="profil-kepala">
                @if ($profil->logo)
                    <figure class="profil-logo">
                        <img src="{{ asset('storage/' . $profil->logo) }}" alt="Logo {{ $profil->nama_desa }}">
                    </figure>
                @endif
                <div>
                    <p class="profil-kicker">Profil Resmi</p>
                    <h1 id="profil-desa-judul">{{ $profil->nama_desa }}</h1>
                </div>
            </div>

            {{-- Visi desa kutipan utama --}}
            <h2 class="profil-label">Visi</h2>
            <blockquote class="visi-card">
                <p>{{ $profil->visi }}</p>
            </blockquote>

            {{-- Misi desa --}}
            <h2 class="profil-label">Misi</h2>
            <div class="isi-card">
                <p class="pra">{!! nl2br(e($profil->misi)) !!}</p>
            </div>

            @if ($profil->sejarah)
                {{-- Sejarah desa --}}
                <h2 class="profil-label">Sejarah</h2>
                <div class="isi-card">
                    <div class="pra">{!! nl2br(e($profil->sejarah)) !!}</div>
                </div>
            @endif
        @else
            <h1 id="profil-desa-judul">Profil Desa</h1>
            <p><strong>Profil belum diisi.</strong></p>
        @endif
    </section>
@endsection

{{-- JS khusus halaman ini dimuat via stack layout --}}
@push('scripts')
    @vite(['resources/js/warga/profil-desa/index.js'])
@endpush
