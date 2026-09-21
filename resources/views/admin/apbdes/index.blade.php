{{-- Halaman APBDes - daftar + tambah/ubah/hapus (pakai layout admin) --}}
@extends('layouts.admin')

{{-- Judul tab + judul bar atas --}}
@section('title', 'APBDes - Desa Kalimanah')

{{-- CSS + JS khusus halaman ini dimuat via stack layout --}}
@push('styles')
    @vite(['resources/css/admin/apbdes/index.css'])
@endpush

@section('content')
    {{-- Judul halaman + tombol tambah --}}
    <section class="page-head" aria-labelledby="apbdes-judul">
        <h1 id="apbdes-judul">APBDes</h1>
        <p class="page-sub">Kelola anggaran per bidang per tahun.</p>
        <a class="btn-tambah" href="{{ route('admin.apbdes.create') }}">Tambah Pos</a>
    </section>

    {{-- Saring per tahun anggaran --}}
    <section aria-label="Saring tahun">
        <form class="filter-bar" method="GET" action="{{ route('admin.apbdes.index') }}">
            <div class="field-inline">
                <label for="tahun">Tahun</label>
                <input id="tahun" type="number" name="tahun" min="2000" max="2100" value="{{ request('tahun') }}" placeholder="Semua tahun">
            </div>
            <button type="submit" class="btn-kecil btn-lihat">Tampilkan</button>
            @if (request('tahun'))
                <a class="btn-kecil btn-sekunder-inline" href="{{ route('admin.apbdes.index') }}">Reset</a>
            @endif
        </form>
    </section>

    {{-- Tabel pos anggaran --}}
    <section aria-label="Daftar pos anggaran">
        <div class="table-wrap">
            <table class="data-table">
                {{-- Kepala kolom --}}
                <thead>
                    <tr>
                        <th scope="col">No</th>
                        <th scope="col">Tahun</th>
                        <th scope="col">Bidang</th>
                        <th scope="col">Uraian</th>
                        <th scope="col">Anggaran</th>
                        <th scope="col">Realisasi</th>
                        <th scope="col">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($apbdes as $pos)
                        <tr>
                            {{-- Nomor urut lanjut antar halaman --}}
                            <td>{{ $apbdes->firstItem() + $loop->index }}</td>
                            <td>{{ $pos->tahun }}</td>
                            <td>{{ $pos->bidang }}</td>
                            <td class="rata-kiri">{{ $pos->uraian }}</td>
                            <td class="angka">Rp{{ number_format($pos->anggaran, 0, ',', '.') }}</td>
                            <td class="angka">Rp{{ number_format($pos->realisasi, 0, ',', '.') }}</td>
                            <td>
                                {{-- Tombol lihat detail --}}
                                <a class="btn-kecil btn-lihat" href="{{ route('admin.apbdes.show', $pos) }}">Lihat</a>
                                {{-- Tombol ubah --}}
                                <a class="btn-kecil btn-ubah" href="{{ route('admin.apbdes.edit', $pos) }}">Ubah</a>
                                {{-- Tombol hapus (minta konfirmasi via JS) --}}
                                <form method="POST" action="{{ route('admin.apbdes.destroy', $pos) }}" data-konfirmasi="Hapus pos {{ $pos->uraian }} tahun {{ $pos->tahun }}?">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn-kecil btn-hapus">Hapus</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        {{-- Belum ada pos anggaran --}}
                        <tr><td colspan="7" class="kosong">Belum ada pos anggaran.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        {{-- Navigasi halaman (bawa filter tahun) --}}
        {{ $apbdes->appends(request()->query())->links() }}
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
    @vite(['resources/js/admin/apbdes/index.js'])
@endpush
