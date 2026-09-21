{{-- Halaman daftar penerima satu program bantuan (pakai layout warga) --}}
@extends('layouts.warga')

{{-- Judul tab browser --}}
@section('title', 'Penerima Bantuan - Desa Kalimanah')

{{-- CSS + JS khusus halaman ini dimuat via stack layout --}}
@push('styles')
    @vite(['resources/css/warga/penerimabantuan/show.css'])
@endpush

@section('content')
    {{-- Penerima per program --}}
    <section class="page-container penerima" aria-labelledby="penerima-judul">
        <h1 id="penerima-judul">{{ $bantuan->nama }}</h1>
        <p class="penerima-sub">{{ $bantuan->deskripsi ?? 'Tanpa deskripsi.' }}</p>

        {{-- Tabel rekap per RT/RW --}}
        <div class="table-wrap">
            <table class="data-table">
                {{-- Kepala kolom --}}
                <thead>
                    <tr>
                        <th scope="col">RT/RW</th>
                        <th scope="col">Total Penerima</th>
                        <th scope="col">Total Nominal</th>
                        <th scope="col">Periode</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($rekap as $baris)
                        <tr>
                            {{-- Wilayah + jumlah orang di wilayah itu --}}
                            <td>RT {{ $baris->rt }}/RW {{ $baris->rw }}</td>
                            <td>{{ $baris->total }} orang</td>
                            {{-- Total nominal sekelompok --}}
                            <td>Rp {{ number_format($baris->total_nominal, 0, ',', '.') }}</td>
                            {{-- Bulan/tahun, bulan kosong = tahunan --}}
                            <td>{{ $baris->bulan ? $baris->bulan . '/' . $baris->tahun : $baris->tahun }}</td>
                        </tr>
                    @empty
                        {{-- Belum ada penerima --}}
                        <tr><td colspan="4" class="kosong">Belum ada penerima.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Tombol kembali ke daftar program --}}
        <a class="btn-kembali" href="{{ route('warga.penerimabantuan.index') }}">Kembali</a>
    </section>
@endsection

{{-- JS khusus halaman ini dimuat via stack layout --}}
@push('scripts')
    @vite(['resources/js/warga/penerimabantuan/show.js'])
@endpush
