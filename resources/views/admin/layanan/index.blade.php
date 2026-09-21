{{-- Halaman layanan - daftar + tambah/ubah/hapus (pakai layout admin) --}}
@extends('layouts.admin')

{{-- Judul tab + judul bar atas --}}
@section('title', 'Layanan - Desa Kalimanah')

{{-- CSS + JS khusus halaman ini dimuat via stack layout --}}
@push('styles')
    @vite(['resources/css/admin/layanan/index.css'])
@endpush

@section('content')
    {{-- Judul halaman + tombol tambah --}}
    <section class="page-head" aria-labelledby="layanan-judul">
        <h1 id="layanan-judul">Layanan</h1>
        <p class="page-sub">Jenis surat yang bisa diajukan warga.</p>
        <a class="btn-tambah" href="{{ route('admin.layanan.create') }}">Tambah Layanan</a>
    </section>

    {{-- Tabel layanan --}}
    <section aria-label="Daftar layanan">
        <div class="table-wrap">
            <table class="data-table">
                {{-- Kepala kolom --}}
                <thead>
                    <tr>
                        <th scope="col">No</th>
                        <th scope="col">Nama</th>
                        <th scope="col">Syarat</th>
                        <th scope="col">Status</th>
                        <th scope="col">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($layanans as $layanan)
                        <tr>
                            {{-- Nomor urut lanjut antar halaman --}}
                            <td>{{ $layanans->firstItem() + $loop->index }}</td>
                            <td>{{ $layanan->nama }}</td>
                            {{-- Total dari withCount controller --}}
                            <td>{{ $layanan->syarat_layanan_count }}</td>
                            {{-- Penanda buka/tutup --}}
                            <td><span class="status {{ $layanan->aktif ? 'status-buka' : 'status-tutup' }}">{{ $layanan->aktif ? 'Buka' : 'Tutup' }}</span></td>
                            <td>
                                {{-- Tombol lihat detail --}}
                                <a class="btn-kecil btn-lihat" href="{{ route('admin.layanan.show', $layanan) }}">Lihat</a>
                                {{-- Tombol kelola syarat layanan ini --}}
                                <a class="btn-kecil btn-syarat" href="{{ route('admin.syarat-layanan.index', ['layanan' => $layanan->id]) }}">Syarat</a>
                                {{-- Tombol ubah --}}
                                <a class="btn-kecil btn-ubah" href="{{ route('admin.layanan.edit', $layanan) }}">Ubah</a>
                                {{-- Tombol hapus (minta konfirmasi via JS) --}}
                                <form method="POST" action="{{ route('admin.layanan.destroy', $layanan) }}" data-konfirmasi="Hapus layanan {{ $layanan->nama }} beserta syaratnya?">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn-kecil btn-hapus">Hapus</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        {{-- Belum ada layanan --}}
                        <tr><td colspan="5" class="kosong">Belum ada layanan.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        {{-- Navigasi halaman --}}
        {{ $layanans->links() }}
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
    @vite(['resources/js/admin/layanan/index.js'])
@endpush
