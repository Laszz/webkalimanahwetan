{{-- Halaman galeri - daftar foto + tambah/ubah/hapus (pakai layout admin) --}}
@extends('layouts.admin')

{{-- Judul tab + judul bar atas --}}
@section('title', 'Galeri - Desa Kalimanah')

{{-- CSS + JS khusus halaman ini dimuat via stack layout --}}
@push('styles')
    @vite(['resources/css/admin/galeri/index.css'])
@endpush

@section('content')
    {{-- Judul halaman + tombol tambah --}}
    <section class="page-head" aria-labelledby="galeri-judul">
        <h1 id="galeri-judul">Galeri</h1>
        <p class="page-sub">Dokumentasi foto kegiatan desa.</p>
        <a class="btn-tambah" href="{{ route('admin.galeri.create') }}">Tambah Foto</a>
    </section>

    {{-- Tabel foto --}}
    <section aria-label="Daftar foto galeri">
        <div class="table-wrap">
            <table class="data-table">
                {{-- Kepala kolom --}}
                <thead>
                    <tr>
                        <th scope="col">No</th>
                        <th scope="col">Judul</th>
                        <th scope="col">Terbit</th>
                        <th scope="col">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($galeris as $galeri)
                        <tr>
                            {{-- Nomor urut lanjut antar halaman --}}
                            <td>{{ $galeris->firstItem() + $loop->index }}</td>
                            <td>{{ $galeri->judul }}</td>
                            {{-- Tanggal terbit atau penanda draf --}}
                            <td>
                                @if ($galeri->published_at)
                                    {{ $galeri->published_at->format('d M Y') }}
                                @else
                                    <span class="status status-draf">Draf</span>
                                @endif
                            </td>
                            <td>
                                {{-- Tombol lihat detail --}}
                                <a class="btn-kecil btn-lihat" href="{{ route('admin.galeri.show', $galeri) }}">Lihat</a>
                                {{-- Tombol ubah --}}
                                <a class="btn-kecil btn-ubah" href="{{ route('admin.galeri.edit', $galeri) }}">Ubah</a>
                                {{-- Tombol hapus (minta konfirmasi via JS) --}}
                                <form method="POST" action="{{ route('admin.galeri.destroy', $galeri) }}" data-konfirmasi="Hapus foto {{ $galeri->judul }}?">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn-kecil btn-hapus">Hapus</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        {{-- Belum ada foto --}}
                        <tr><td colspan="4" class="kosong">Belum ada foto.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        {{-- Navigasi halaman --}}
        {{ $galeris->links() }}
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
    @vite(['resources/js/admin/galeri/index.js'])
@endpush
