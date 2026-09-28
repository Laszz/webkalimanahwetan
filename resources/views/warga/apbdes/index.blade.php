{{-- Halaman APBDes - ringkasan + navigasi rincian per tahun (pakai layout warga) --}}
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
        <h1 id="apbdes-judul">APBDes {{ $tahun }}</h1>
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
            {{-- Satu kartu ringkasan tahun aktif --}}
            @php
                $persen = $totalAnggaran > 0 ? min(100, round(($totalRealisasi / $totalAnggaran) * 100)) : 0;
                $sisa = max(0, $totalAnggaran - $totalRealisasi);
            @endphp
            <div class="ringkas-card">
                <div class="ringkas-row">
                    <div>
                        <p>Anggaran {{ $tahun }}</p>
                        <strong>Rp{{ number_format($totalAnggaran, 0, ',', '.') }}</strong>
                    </div>
                    <div>
                        <p>Realisasi</p>
                        <strong>Rp{{ number_format($totalRealisasi, 0, ',', '.') }}</strong>
                    </div>
                    <div>
                        <p>Sisa</p>
                        <strong>Rp{{ number_format($sisa, 0, ',', '.') }}</strong>
                    </div>
                </div>
                {{-- Batang realisasi anggaran + persen --}}
                <div class="progress-head">
                    <p class="progress-label">Realisasi Anggaran</p>
                    <span class="progress-persen">{{ $persen }}%</span>
                </div>
                <div class="serapan" role="img" aria-label="Realisasi anggaran {{ $persen }} persen">
                    <div class="serapan-isi" style="width: {{ $persen }}%"></div>
                </div>
                <p class="progress-teks">Rp{{ number_format($totalRealisasi, 0, ',', '.') }} dari Rp{{ number_format($totalAnggaran, 0, ',', '.') }}</p>
            </div>

            {{-- Dua kartu navigasi ke rincian tahun terpilih --}}
            <div class="nav-grid">
                <a class="nav-card" href="{{ route('warga.apbdes.sumber', $tahun) }}">
                    <strong>Sumber Dana</strong>
                    <span>Lihat rincian sumber dana</span>
                    <span class="nav-panah" aria-hidden="true">→</span>
                </a>
                <a class="nav-card" href="{{ route('warga.apbdes.belanja', $tahun) }}">
                    <strong>Belanja per Bidang</strong>
                    <span>Lihat penggunaan anggaran berdasarkan bidang</span>
                    <span class="nav-panah" aria-hidden="true">→</span>
                </a>
            </div>

            {{-- Cuplikan entri paling baru --}}
            @if ($danaTerbaru || $belanjaTerbaru)
                <h2 class="apbdes-label">Update Terbaru</h2>
                <ul class="terbaru-list">
                    @if ($danaTerbaru)
                        <li>
                            <div>
                                <strong>{{ $danaTerbaru->sumber_dana }}</strong>
                                <span>Sumber Dana · Rp{{ number_format($danaTerbaru->anggaran, 0, ',', '.') }}</span>
                            </div>
                            <a href="{{ route('warga.apbdes.sumber', $tahun) }}">Lihat</a>
                        </li>
                    @endif
                    @if ($belanjaTerbaru)
                        <li>
                            <div>
                                <strong>{{ $belanjaTerbaru->uraian }}</strong>
                                <span>Belanja per Bidang · Rp{{ number_format($belanjaTerbaru->nominal, 0, ',', '.') }}</span>
                            </div>
                            <a href="{{ route('warga.apbdes.belanja', $tahun) }}">Lihat</a>
                        </li>
                    @endif
                </ul>
            @endif
        @else
            {{-- Belum ada tahun anggaran sama sekali --}}
            <p class="kosong-teks"><strong>Data APBDes belum tersedia.</strong></p>
        @endif
    </section>
@endsection

{{-- JS khusus halaman ini dimuat via stack layout --}}
@push('scripts')
    @vite(['resources/js/warga/apbdes/index.js'])
@endpush
