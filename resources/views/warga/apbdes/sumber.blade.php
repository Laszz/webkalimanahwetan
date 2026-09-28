{{-- Halaman sumber dana APBDes satu tahun (pakai layout warga) --}}
@extends('layouts.warga')

{{-- Judul tab browser --}}
@section('title', 'Sumber Dana APBDes - Desa Kalimanah')

{{-- CSS + JS khusus halaman ini dimuat via stack layout --}}
@push('styles')
    @vite(['resources/css/warga/apbdes/sumber.css'])
@endpush

@section('content')
    {{-- Pagu tiap sumber dana tahun berjalan --}}
    <section class="page-container apbdes" aria-labelledby="apbdes-judul">
        <h1 id="apbdes-judul">Sumber Dana {{ $tahun }}</h1>
        <p class="apbdes-sub">Pagu tiap sumber dana tahun {{ $tahun }}.</p>

        @forelse ($danas as $dana)
            @php
                $terpakaiDana = (int) $dana->terpakai;
                $sisaDana = max(0, $dana->anggaran - $terpakaiDana);
                $persenDana = $dana->anggaran > 0 ? min(100, round(($terpakaiDana / $dana->anggaran) * 100)) : 0;
            @endphp
            <div class="dana-row">
                <div class="dana-head">
                    <h3><span class="dana-nomor" aria-hidden="true">{{ str_pad($loop->iteration, 2, '0', STR_PAD_LEFT) }}</span> {{ $dana->sumber_dana }}</h3>
                </div>
                <dl class="dana-rows">
                    <div><dt>Total Dana</dt><dd>Rp{{ number_format($dana->anggaran, 0, ',', '.') }}</dd></div>
                    <div><dt>Realisasi</dt><dd>Rp{{ number_format($terpakaiDana, 0, ',', '.') }}</dd></div>
                    <div><dt>Sisa</dt><dd>Rp{{ number_format($sisaDana, 0, ',', '.') }}</dd></div>
                </dl>
                <div class="serapan serapan-tipis" role="img" aria-label="Serapan {{ $dana->sumber_dana }} {{ $persenDana }} persen">
                    <div class="serapan-isi" style="width: {{ $persenDana }}%"></div>
                </div>
                <p class="progress-teks">{{ $persenDana }}% terealisasi</p>
            </div>
        @empty
            {{-- Tahun ada tapi belum ada dana --}}
            <p class="kosong-teks"><strong>Belum ada dana tahun {{ $tahun }}.</strong></p>
        @endforelse

        {{-- Kembali ke ringkasan tahun yang sama --}}
        <a class="btn-kembali" href="{{ route('warga.apbdes.index', ['tahun' => $tahun]) }}">Kembali</a>
    </section>
@endsection

{{-- JS khusus halaman ini dimuat via stack layout --}}
@push('scripts')
    @vite(['resources/js/warga/apbdes/sumber.js'])
@endpush
