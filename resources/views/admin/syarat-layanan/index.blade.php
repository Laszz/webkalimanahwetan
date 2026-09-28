{{-- Halaman syarat satu layanan - daftar + tambah/ubah/hapus (pakai layout admin) --}}
@extends('layouts.admin')

{{-- Judul tab + judul bar atas --}}
@section('title', 'Syarat Layanan - Desa Kalimanah')

{{-- CSS + JS khusus halaman ini dimuat via stack layout --}}
@push('styles')
    @vite(['resources/css/admin/syarat-layanan/index.css'])
@endpush

@section('content')
    {{-- Judul halaman + tombol tambah --}}
    <section class="page-head" aria-labelledby="syarat-judul">
        <h1 id="syarat-judul">Syarat: {{ $layanan->nama }}</h1>
        <p class="page-sub">Syarat yang harus dipenuhi warga untuk layanan ini.</p>
        <a class="btn-tambah" href="{{ route('admin.syarat-layanan.create', ['layanan' => $layanan->id]) }}">Tambah Syarat</a>
    </section>

    {{-- Tabel syarat --}}
    <section aria-label="Daftar syarat">
        <div class="table-wrap">
            <table class="data-table">
                {{-- Kepala kolom --}}
                <thead>
                    <tr>
                        <th scope="col">No</th>
                        <th scope="col">Nama</th>
                        <th scope="col">Tipe</th>
                        <th scope="col">Wajib</th>
                        <th scope="col">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($layanan->syaratLayanan as $syarat)
                        <tr>
                            {{-- Nomor urut --}}
                            <td>{{ $loop->iteration }}</td>
                            <td class="rata-kiri">{{ $syarat->nama }}</td>
                            <td>{{ $syarat->tipe === 'file' ? 'File' : 'Teks' }}</td>
                            <td>{{ $syarat->wajib ? 'Ya' : 'Tidak' }}</td>
                            <td>
                                {{-- Tombol ubah --}}
                                <a class="btn-kecil btn-ubah" href="{{ route('admin.syarat-layanan.edit', $syarat) }}">Ubah</a>
                                {{-- Tombol hapus (minta konfirmasi via JS) --}}
                                <form method="POST" action="{{ route('admin.syarat-layanan.destroy', $syarat) }}" data-konfirmasi="Hapus syarat {{ $syarat->nama }}?">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn-kecil btn-hapus">Hapus</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        {{-- Belum ada syarat --}}
                        <tr><td colspan="5" class="kosong">Belum ada syarat.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </section>

    {{-- Tombol kembali ke daftar layanan di bawah tabel --}}
    <div class="aksi-bawah">
        <a class="btn-sekunder" href="{{ route('admin.layanan.index') }}">Kembali</a>
    </div>

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
    @vite(['resources/js/admin/syarat-layanan/index.js'])
@endpush
