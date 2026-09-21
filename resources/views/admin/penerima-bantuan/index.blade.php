{{-- Halaman penerima bantuan - daftar per periode (pakai layout admin) --}}
@extends('layouts.admin')

{{-- Judul tab + judul bar atas --}}
@section('title', 'Penerima Bantuan - Desa Kalimanah')

{{-- CSS + JS khusus halaman ini dimuat via stack layout --}}
@push('styles')
    @vite(['resources/css/admin/penerima-bantuan/index.css'])
@endpush

@section('content')
    {{-- Judul halaman + tombol tambah --}}
    <section class="page-head" aria-labelledby="penerima-judul">
        <h1 id="penerima-judul">Penerima Bantuan</h1>
        <p class="page-sub">Warga penerima tiap program per periode penyaluran.</p>
        <a class="btn-tambah" href="{{ route('admin.penerima-bantuan.create') }}">Tambah Penerima</a>
    </section>

    {{-- Tabel penerima --}}
    <section aria-label="Daftar penerima bantuan">
        <div class="table-wrap">
            <table class="data-table">
                {{-- Kepala kolom --}}
                <thead>
                    <tr>
                        <th scope="col">No</th>
                        <th scope="col">Nama</th>
                        <th scope="col">Bantuan</th>
                        <th scope="col">Nominal</th>
                        <th scope="col">Periode</th>
                        <th scope="col">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($penerimas as $penerima)
                        <tr>
                            {{-- Nomor urut lanjut antar halaman --}}
                            <td>{{ $penerimas->firstItem() + $loop->index }}</td>
                            <td>{{ $penerima->warga->nama ?? '-' }}</td>
                            <td>{{ $penerima->jenisBantuan->nama ?? '-' }}</td>
                            {{-- Nominal rupiah --}}
                            <td>Rp {{ number_format($penerima->nominal, 0, ',', '.') }}</td>
                            {{-- Bulan/tahun, bulan kosong = tahunan --}}
                            <td>{{ $penerima->bulan ? $penerima->bulan . '/' . $penerima->tahun : $penerima->tahun }}</td>
                            <td>
                                {{-- Tombol hapus (minta konfirmasi via JS) --}}
                                <form method="POST" action="{{ route('admin.penerima-bantuan.destroy', $penerima) }}" data-konfirmasi="Hapus {{ $penerima->warga->nama ?? 'penerima' }} dari daftar?">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn-kecil btn-hapus">Hapus</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        {{-- Belum ada penerima --}}
                        <tr><td colspan="6" class="kosong">Belum ada penerima bantuan.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        {{-- Navigasi halaman --}}
        {{ $penerimas->links() }}
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
    @vite(['resources/js/admin/penerima-bantuan/index.js'])
@endpush
