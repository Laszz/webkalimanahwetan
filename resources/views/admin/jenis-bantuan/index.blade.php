{{-- Halaman jenis bantuan - daftar + tambah/ubah/hapus (pakai layout admin) --}}
@extends('layouts.admin')

{{-- Judul tab + judul bar atas --}}
@section('title', 'Jenis Bantuan - Desa Kalimanah')

{{-- CSS + JS khusus halaman ini dimuat via stack layout --}}
@push('styles')
    @vite(['resources/css/admin/jenis-bantuan/index.css'])
@endpush

@section('content')
    {{-- Judul halaman + tombol tambah --}}
    <section class="page-head" aria-labelledby="bantuan-judul">
        <h1 id="bantuan-judul">Jenis Bantuan</h1>
        <p class="page-sub">Master bantuan sosial desa beserta total penerimanya.</p>
        <a class="btn-tambah" href="{{ route('admin.jenis-bantuan.create') }}">Tambah Jenis</a>
    </section>

    {{-- Tabel jenis bantuan --}}
    <section aria-label="Daftar jenis bantuan">
        <div class="table-wrap">
            <table class="data-table">
                {{-- Kepala kolom --}}
                <thead>
                    <tr>
                        <th scope="col">No</th>
                        <th scope="col">Nama</th>
                        <th scope="col">Total Penerima</th>
                        <th scope="col">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($jenis as $item)
                        <tr>
                            {{-- Nomor urut lanjut antar halaman --}}
                            <td>{{ $jenis->firstItem() + $loop->index }}</td>
                            <td>{{ $item->nama }}</td>
                            {{-- Total dari withCount controller --}}
                            <td>{{ $item->penerima_bantuan_count }}</td>
                            <td>
                                {{-- Tombol lihat detail --}}
                                <a class="btn-kecil btn-lihat" href="{{ route('admin.jenis-bantuan.show', $item) }}">Lihat</a>
                                {{-- Tombol ubah --}}
                                <a class="btn-kecil btn-ubah" href="{{ route('admin.jenis-bantuan.edit', $item) }}">Ubah</a>
                                {{-- Tombol hapus (minta konfirmasi via JS) --}}
                                <form method="POST" action="{{ route('admin.jenis-bantuan.destroy', $item) }}" data-konfirmasi="Hapus {{ $item->nama }} beserta penerimanya?">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn-kecil btn-hapus">Hapus</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        {{-- Belum ada jenis bantuan --}}
                        <tr><td colspan="4" class="kosong">Belum ada jenis bantuan.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        {{-- Navigasi halaman --}}
        {{ $jenis->links() }}
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
    @vite(['resources/js/admin/jenis-bantuan/index.js'])
@endpush
