{{-- Halaman berita - daftar + tambah/ubah/hapus (pakai layout admin) --}}
@extends('layouts.admin')

{{-- Judul tab + judul bar atas --}}
@section('title', 'Berita - Desa Kalimanah')

{{-- CSS + JS khusus halaman ini dimuat via stack layout --}}
@push('styles')
    @vite(['resources/css/admin/berita/index.css'])
@endpush

@section('content')
    {{-- Judul halaman + tombol tambah --}}
    <section class="page-head" aria-labelledby="berita-judul">
        <h1 id="berita-judul">Berita</h1>
        <p class="page-sub">Kabar dan pengumuman desa.</p>
        <a class="btn-tambah" href="{{ route('admin.berita.create') }}">Tambah Berita</a>
    </section>

    {{-- Tabel berita --}}
    <section aria-label="Daftar berita">
        <div class="table-wrap">
            <table class="data-table">
                {{-- Kepala kolom --}}
                <thead>
                    <tr>
                        <th scope="col">No</th>
                        <th scope="col">Judul</th>
                        <th scope="col">Penulis</th>
                        <th scope="col">Terbit</th>
                        <th scope="col">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($beritas as $berita)
                        <tr>
                            {{-- Nomor urut lanjut antar halaman --}}
                            <td>{{ $beritas->firstItem() + $loop->index }}</td>
                            <td>{{ $berita->judul }}</td>
                            <td>{{ $berita->user->name ?? '-' }}</td>
                            {{-- Tanggal terbit atau penanda draf --}}
                            <td>
                                @if ($berita->published_at)
                                    {{ $berita->published_at->format('d M Y') }}
                                @else
                                    <span class="status status-draf">Draf</span>
                                @endif
                            </td>
                            <td>
                                {{-- Tombol lihat detail --}}
                                <a class="btn-kecil btn-lihat" href="{{ route('admin.berita.show', $berita) }}">Lihat</a>
                                {{-- Tombol ubah --}}
                                <a class="btn-kecil btn-ubah" href="{{ route('admin.berita.edit', $berita) }}">Ubah</a>
                                {{-- Tombol hapus (minta konfirmasi via JS) --}}
                                <form method="POST" action="{{ route('admin.berita.destroy', $berita) }}" data-konfirmasi="Hapus berita {{ $berita->judul }}?">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn-kecil btn-hapus">Hapus</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        {{-- Belum ada berita --}}
                        <tr><td colspan="5" class="kosong">Belum ada berita.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        {{-- Navigasi halaman --}}
        {{ $beritas->links() }}
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
    @vite(['resources/js/admin/berita/index.js'])
@endpush
