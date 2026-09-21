{{-- Halaman detail jenis bantuan + daftar penerimanya (pakai layout admin) --}}
@extends('layouts.admin')

{{-- Judul tab + judul bar atas --}}
@section('title', 'Detail Bantuan - Desa Kalimanah')

{{-- CSS + JS khusus halaman ini dimuat via stack layout --}}
@push('styles')
    @vite(['resources/css/admin/jenis-bantuan/show.css'])
@endpush

@section('content')
    {{-- Info jenis bantuan --}}
    <section class="detail" aria-labelledby="bantuan-judul">
        <h1 id="bantuan-judul">{{ $jenisBantuan->nama }}</h1>
        <p class="detail-sub">{{ $jenisBantuan->deskripsi ?? 'Tanpa deskripsi.' }}</p>

        {{-- Baris aksi: tambah penerima --}}
        <div class="aksi-baris">
            <a class="btn-tambah" href="{{ route('admin.penerima-bantuan.create', ['jenis_bantuan' => $jenisBantuan->id]) }}">Tambah Penerima</a>
        </div>

        {{-- Tabel penerima jenis ini --}}
        <h2 class="kartu-judul">Daftar Penerima</h2>
        <div class="table-wrap">
            <table class="data-table">
                {{-- Kepala kolom --}}
                <thead>
                    <tr>
                        <th scope="col">No</th>
                        <th scope="col">Nama</th>
                        <th scope="col">Nominal</th>
                        <th scope="col">Periode</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($jenisBantuan->penerimaBantuan as $penerima)
                        <tr>
                            {{-- Nomor urut --}}
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $penerima->warga->nama ?? '-' }}</td>
                            {{-- Nominal rupiah --}}
                            <td>Rp {{ number_format($penerima->nominal, 0, ',', '.') }}</td>
                            {{-- Bulan/tahun, bulan kosong = tahunan --}}
                            <td>{{ $penerima->bulan ? $penerima->bulan . '/' . $penerima->tahun : $penerima->tahun }}</td>
                        </tr>
                    @empty
                        {{-- Belum ada penerima --}}
                        <tr><td colspan="4" class="kosong">Belum ada penerima.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Tombol kembali di bawah tabel --}}
        <div class="aksi-bawah">
            <a class="btn-sekunder" href="{{ route('admin.jenis-bantuan.index') }}">Kembali</a>
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
    @vite(['resources/js/admin/jenis-bantuan/show.js'])
@endpush
