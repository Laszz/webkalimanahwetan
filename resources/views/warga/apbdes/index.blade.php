{{-- Halaman APBDes - transparansi anggaran per tahun (pakai layout warga) --}}
@extends('layouts.warga')

{{-- Judul tab browser --}}
@section('title', 'APBDes - Desa Kalimanah')

{{-- CSS + JS khusus halaman ini dimuat via stack layout --}}
@push('styles')
    @vite(['resources/css/warga/apbdes/index.css'])
@endpush

@section('content')
    {{-- Transparansi anggaran desa --}}
    <section class="page-container apbdes" aria-labelledby="apbdes-judul">
        <h1 id="apbdes-judul">APBDes</h1>
        <p class="apbdes-sub">Transparansi anggaran per bidang per tahun.</p>

        {{-- Pilih tahun anggaran --}}
        <form class="filter-bar" method="GET" action="{{ route('warga.apbdes.index') }}">
            <div class="field-inline">
                <label for="tahun">Tahun</label>
                <select id="tahun" name="tahun" data-otomatis>
                    @forelse ($daftarTahun as $opsi)
                        <option value="{{ $opsi }}" {{ (string) $tahun === (string) $opsi ? 'selected' : '' }}>{{ $opsi }}</option>
                    @empty
                        <option value="" selected>Belum ada data</option>
                    @endforelse
                </select>
            </div>
            <button type="submit" class="btn-tampil">Tampilkan</button>
        </form>

        @if ($tahun)
            {{-- Tiga kartu ringkasan tahun aktif --}}
            @php
                $persen = $totalAnggaran > 0 ? min(100, round(($totalRealisasi / $totalAnggaran) * 100)) : 0;
                $sisa = max(0, $totalAnggaran - $totalRealisasi);
            @endphp
            <div class="ringkas-grid">
                <div>
                    <p class="ringkas-ikon" aria-hidden="true"><i class="ph ph-wallet"></i></p>
                    <p>Anggaran {{ $tahun }}</p>
                    <strong>Rp{{ number_format($totalAnggaran, 0, ',', '.') }}</strong>
                </div>
                <div>
                    <p class="ringkas-ikon" aria-hidden="true"><i class="ph ph-check-circle"></i></p>
                    <p>Realisasi ({{ $persen }}%)</p>
                    <strong>Rp{{ number_format($totalRealisasi, 0, ',', '.') }}</strong>
                </div>
                <div>
                    <p class="ringkas-ikon" aria-hidden="true"><i class="ph ph-piggy-bank"></i></p>
                    <p>Sisa</p>
                    <strong>Rp{{ number_format($sisa, 0, ',', '.') }}</strong>
                </div>
            </div>

            {{-- Batang serapan total --}}
            <div class="serapan" role="img" aria-label="Serapan {{ $persen }} persen">
                <div class="serapan-isi" style="width: {{ $persen }}%"></div>
            </div>

            {{-- Tabel per bidang --}}
            <div class="table-wrap">
                <table class="data-table">
                    {{-- Kepala kolom --}}
                    <thead>
                        <tr>
                            <th scope="col">Bidang</th>
                            <th scope="col">Uraian</th>
                            <th scope="col">Sumber Dana</th>
                            <th scope="col">Anggaran</th>
                            <th scope="col">Realisasi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            // Warna chip tiap bidang baku desa
                            $warnaBidang = [
                                'Penyelenggaraan Pemerintahan' => 'bidang-navy',
                                'Pelaksanaan Pembangunan' => 'bidang-biru',
                                'Pembinaan Kemasyarakatan' => 'bidang-kuning',
                                'Pemberdayaan Masyarakat' => 'bidang-hijau',
                                'Penanggulangan Bencana' => 'bidang-merah',
                            ];
                        @endphp
                        @forelse ($pos as $item)
                            <tr>
                                <td><span class="bidang {{ $warnaBidang[$item->bidang] ?? 'bidang-abu' }}">{{ $item->bidang }}</span></td>
                                <td class="rata-kiri">{{ $item->uraian }}</td>
                                <td>{{ $item->sumber_dana }}</td>
                                <td class="angka">Rp{{ number_format($item->anggaran, 0, ',', '.') }}</td>
                                <td class="angka">Rp{{ number_format($item->realisasi, 0, ',', '.') }}</td>
                            </tr>
                        @empty
                            {{-- Tahun ada tapi belum ada pos --}}
                            <tr><td colspan="5" class="kosong">Belum ada pos anggaran tahun {{ $tahun }}.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        @else
            {{-- Tabel masih kosong seluruhnya --}}
            <p class="kosong-teks"><strong>Data APBDes belum tersedia.</strong></p>
        @endif
    </section>
@endsection

{{-- JS khusus halaman ini dimuat via stack layout --}}
@push('scripts')
    @vite(['resources/js/warga/apbdes/index.js'])
@endpush
