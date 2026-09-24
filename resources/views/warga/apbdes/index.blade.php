{{-- Halaman APBDes - dana dan belanja per tahun (pakai layout warga) --}}
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
        <p class="apbdes-sub">Transparansi anggaran dan realisasi Desa Kalimanah Wetan.</p>

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
                    <p>Anggaran {{ $tahun }}</p>
                    <strong>Rp{{ number_format($totalAnggaran, 0, ',', '.') }}</strong>
                </div>
                <div>
                    <p>Realisasi ({{ $persen }}%)</p>
                    <strong>Rp{{ number_format($totalRealisasi, 0, ',', '.') }}</strong>
                </div>
                <div>
                    <p>Sisa</p>
                    <strong>Rp{{ number_format($sisa, 0, ',', '.') }}</strong>
                </div>
            </div>

            {{-- Batang realisasi anggaran + keterangan --}}
            <p class="progress-label">Realisasi Anggaran</p>
            <div class="serapan" role="img" aria-label="Realisasi anggaran {{ $persen }} persen">
                <div class="serapan-isi" style="width: {{ $persen }}%"></div>
            </div>
            <p class="progress-teks">Rp{{ number_format($totalRealisasi, 0, ',', '.') }} dari Rp{{ number_format($totalAnggaran, 0, ',', '.') }} · {{ $persen }}%</p>

            {{-- Pagu tiap sumber dana: daftar garis tanpa kartu --}}
            <h2 class="apbdes-label">Sumber Dana</h2>
            @forelse ($danas as $dana)
                @php
                    $terpakaiDana = (int) $dana->terpakai;
                    $sisaDana = max(0, $dana->anggaran - $terpakaiDana);
                    $persenDana = $dana->anggaran > 0 ? min(100, round(($terpakaiDana / $dana->anggaran) * 100)) : 0;
                @endphp
                <div class="dana-row">
                    <div class="dana-head">
                        <h3>{{ $dana->sumber_dana }}</h3>
                        <strong>Rp{{ number_format($dana->anggaran, 0, ',', '.') }}</strong>
                    </div>
                    <dl class="dana-rows">
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

            {{-- Belanja per bidang --}}
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
            @if ($belanjas->isNotEmpty())
                <h2 class="apbdes-label">Belanja per Bidang</h2>
                @foreach ($belanjas->groupBy('bidang') as $bidang => $kelompok)
                    @php
                        $totalBidang = $kelompok->sum('nominal');
                    @endphp
                    <article class="bidang-card">
                        {{-- Kepala bidang: badge + total --}}
                        <div class="bidang-head">
                            <h3><span class="bidang {{ $warnaBidang[$bidang] ?? 'bidang-abu' }}">{{ $bidang }}</span></h3>
                            <p class="bidang-total">Total: Rp{{ number_format($totalBidang, 0, ',', '.') }}</p>
                        </div>
                        {{-- Belanja bidang ini --}}
                        <ul class="pos-list">
                            @foreach ($kelompok as $belanja)
                                <li>
                                    <div class="pos-head">
                                        <strong>{{ $belanja->uraian }}</strong>
                                        <span class="pos-nominal">Rp{{ number_format($belanja->nominal, 0, ',', '.') }}</span>
                                    </div>
                                    <p class="pos-meta">{{ $belanja->dana->sumber_dana ?? '-' }}</p>
                                </li>
                            @endforeach
                        </ul>
                    </article>
                @endforeach
            @endif
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
