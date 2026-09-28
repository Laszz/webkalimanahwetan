{{-- Halaman belanja APBDes per bidang satu tahun (pakai layout warga) --}}
@extends('layouts.warga')

{{-- Judul tab browser --}}
@section('title', 'Belanja APBDes - Desa Kalimanah')

{{-- CSS + JS khusus halaman ini dimuat via stack layout --}}
@push('styles')
    @vite(['resources/css/warga/apbdes/belanja.css'])
@endpush

@section('content')
    {{-- Belanja per bidang tahun berjalan --}}
    <section class="page-container apbdes" aria-labelledby="apbdes-judul">
        <h1 id="apbdes-judul">Belanja per Bidang {{ $tahun }}</h1>
        <p class="apbdes-sub">Pakai dana per kegiatan tahun {{ $tahun }}.</p>

        @forelse ($belanjas->groupBy('bidang') as $bidang => $kelompok)
            @php
                $totalBidang = $kelompok->sum('nominal');
            @endphp
            <article class="bidang-card">
                {{-- Kepala bidang: nama + total + jumlah kegiatan --}}
                <div class="bidang-head">
                    <h2>{{ $bidang }}</h2>
                    <p class="bidang-total">Rp{{ number_format($totalBidang, 0, ',', '.') }}</p>
                </div>
                <p class="bidang-jumlah">{{ $kelompok->count() }} kegiatan</p>
                {{-- Belanja bidang ini bernomor urut --}}
                <ul class="pos-list">
                    @foreach ($kelompok as $belanja)
                        <li>
                            <span class="pos-nomor" aria-hidden="true">{{ str_pad($loop->iteration, 2, '0', STR_PAD_LEFT) }}</span>
                            <div class="pos-isi">
                                <div class="pos-head">
                                    <strong>{{ $belanja->uraian }}</strong>
                                    <span class="pos-nominal">Rp{{ number_format($belanja->nominal, 0, ',', '.') }}</span>
                                </div>
                                <p class="pos-meta">{{ $belanja->dana->sumber_dana ?? '-' }}</p>
                            </div>
                        </li>
                    @endforeach
                </ul>
            </article>
        @empty
            {{-- Tahun ada tapi belum ada belanja --}}
            <p class="kosong-teks"><strong>Belum ada belanja tahun {{ $tahun }}.</strong></p>
        @endforelse

        {{-- Kembali ke ringkasan tahun yang sama --}}
        <a class="btn-kembali" href="{{ route('warga.apbdes.index', ['tahun' => $tahun]) }}">Kembali</a>
    </section>
@endsection

{{-- JS khusus halaman ini dimuat via stack layout --}}
@push('scripts')
    @vite(['resources/js/warga/apbdes/belanja.js'])
@endpush
