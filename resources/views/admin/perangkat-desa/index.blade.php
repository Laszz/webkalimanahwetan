{{-- Halaman perangkat desa - daftar + tambah/ubah/hapus (pakai layout admin) --}}
@extends('layouts.admin')

{{-- Judul tab + judul bar atas --}}
@section('title', 'Perangkat Desa - Desa Kalimanah')

{{-- CSS + JS khusus halaman ini dimuat via stack layout --}}
@push('styles')
    @vite(['resources/css/admin/perangkat-desa/index.css'])
@endpush

@section('content')
    {{-- Judul halaman + tombol tambah --}}
    <section class="page-head" aria-labelledby="perangkat-judul">
        <h1 id="perangkat-judul">Perangkat Desa</h1>
        <p class="page-sub">Susunan pamong desa.</p>
        <a class="btn-tambah" href="{{ route('admin.perangkat-desa.create') }}">Tambah Perangkat</a>
    </section>

    {{-- Tabel perangkat --}}
    <section aria-label="Daftar perangkat desa">
        <div class="table-wrap">
            <table class="data-table">
                {{-- Kepala kolom --}}
                <thead>
                    <tr>
                        <th scope="col">No</th>
                        <th scope="col">Nama</th>
                        <th scope="col">Jabatan</th>
                        <th scope="col">Status</th>
                        <th scope="col">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($perangkats as $perangkat)
                        <tr>
                            {{-- Nomor urut lanjut antar halaman --}}
                            <td>{{ $perangkats->firstItem() + $loop->index }}</td>
                            <td>{{ $perangkat->nama }}</td>
                            <td>{{ $perangkat->jabatan }}</td>
                            {{-- Penanda aktif/nonaktif --}}
                            <td><span class="status {{ $perangkat->aktif ? 'status-buka' : 'status-tutup' }}">{{ $perangkat->aktif ? 'Aktif' : 'Nonaktif' }}</span></td>
                            <td>
                                {{-- Tombol lihat detail --}}
                                <a class="btn-kecil btn-lihat" href="{{ route('admin.perangkat-desa.show', $perangkat) }}">Lihat</a>
                                {{-- Tombol ubah --}}
                                <a class="btn-kecil btn-ubah" href="{{ route('admin.perangkat-desa.edit', $perangkat) }}">Ubah</a>
                                {{-- Tombol hapus (minta konfirmasi via JS) --}}
                                <form method="POST" action="{{ route('admin.perangkat-desa.destroy', $perangkat) }}" data-konfirmasi="Hapus {{ $perangkat->nama }}?">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn-kecil btn-hapus">Hapus</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        {{-- Belum ada perangkat --}}
                        <tr><td colspan="5" class="kosong">Belum ada perangkat desa.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        {{-- Navigasi halaman --}}
        {{ $perangkats->links() }}
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
    @vite(['resources/js/admin/perangkat-desa/index.js'])
@endpush
