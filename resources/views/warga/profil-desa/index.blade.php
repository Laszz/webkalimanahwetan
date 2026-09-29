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
            <div class="profil-wrap">
                {{-- Kepala: label + nama + wilayah --}}
                <p class="profil-kicker">Profil Desa</p>
                <h1 id="profil-desa-judul">{{ $profil->nama_desa }}</h1>
                {{-- Wilayah statis Kalimanah Wetan --}}
                <p class="profil-wilayah">Kecamatan Kalimanah · Kabupaten Purbalingga</p>

                {{-- Visi desa kutipan utama --}}
                <h2 class="profil-label">Visi</h2>
                <blockquote class="visi-card">
                    <p>{{ $profil->visi }}</p>
                </blockquote>

                {{-- Misi desa: pecah per baris bernomor + judul --}}
                <h2 class="profil-label">Misi</h2>
                @php
                    // Judul baku RPJM desa (teks misi tidak punya pemisah judul-isi,
                    // jadi cocokkan awalan baris; terpanjang dulu; tak cocok = teks utuh)
                    $judulMisi = ['Berdaya Saing', 'Berakhlak Mulia', 'Mandiri', 'Sejahtera', 'Maju'];
                    $barisMisi = preg_split('/\R\s*\R|\R/', trim($profil->misi));
                    $misiList = [];
                    foreach ((array) $barisMisi as $baris) {
                        $baris = trim(preg_replace('/^\s*\d+[.)]\s*/', '', $baris));
                        if ($baris === '') {
                            continue;
                        }
                        $judul = null;
                        foreach ($judulMisi as $cocok) {
                            if (stripos($baris, $cocok) === 0) {
                                $judul = $cocok;
                                $baris = trim(substr($baris, strlen($cocok)));
                                break;
                            }
                        }
                        $misiList[] = ['judul' => $judul, 'isi' => $baris];
                    }
                @endphp
                <ol class="misi-grid">
                    @foreach ($misiList as $misi)
                        <li>
                            <span class="misi-nomor" aria-hidden="true">{{ str_pad($loop->iteration, 2, '0', STR_PAD_LEFT) }}</span>
                            <div>
                                @if ($misi['judul'])
                                    <strong class="misi-judul">{{ $misi['judul'] }}</strong>
                                @endif
                                <p>{{ $misi['isi'] }}</p>
                            </div>
                        </li>
                    @endforeach
                </ol>

                @if ($profil->sejarah)
                    {{-- Sejarah desa dalam kotak --}}
                    <h2 class="profil-label">Sejarah</h2>
                    <div class="isi-box">
                        <div class="pra">{!! nl2br(e($profil->sejarah)) !!}</div>
                    </div>
                @endif
            </div>
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
