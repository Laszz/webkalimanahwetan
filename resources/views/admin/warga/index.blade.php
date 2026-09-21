{{-- Halaman data warga - daftar biodata + hapus (pakai layout admin) --}}
@extends('layouts.admin')

{{-- Judul tab + judul bar atas --}}
@section('title', 'Data Warga - Desa Kalimanah')

{{-- CSS + JS khusus halaman ini dimuat via stack layout --}}
@push('styles')
    @vite(['resources/css/admin/warga/index.css'])
@endpush

@section('content')
    {{-- Judul halaman --}}
    <section class="page-head" aria-labelledby="warga-judul">
        <h1 id="warga-judul">Data Warga</h1>
        <p class="page-sub">Biodata kependudukan yang sudah diisi warga.</p>
    </section>

    {{-- Tabel biodata warga --}}
    <section aria-label="Daftar biodata warga">
        <div class="table-wrap">
            <table class="data-table">
                {{-- Kepala kolom --}}
                <thead>
                    <tr>
                        <th scope="col">No</th>
                        <th scope="col">Nama</th>
                        <th scope="col">No. Telepon</th>
                        <th scope="col">Email Akun</th>
                        <th scope="col">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($wargas as $warga)
                        <tr>
                            {{-- Nomor urut lanjut antar halaman --}}
                            <td>{{ $wargas->firstItem() + $loop->index }}</td>
                            {{-- Nama + telepon dari biodata --}}
                            <td>{{ $warga->nama }}</td>
                            <td>{{ $warga->telepon ?? '-' }}</td>
                            {{-- Email dari akun pemilik --}}
                            <td>{{ $warga->user->email ?? '-' }}</td>
                            <td>
                                {{-- Tombol lihat detail --}}
                                <a class="btn-kecil btn-lihat" href="{{ route('admin.warga.show', $warga) }}">Lihat</a>
                                {{-- Tombol hapus biodata (minta konfirmasi via JS) --}}
                                <form method="POST" action="{{ route('admin.warga.destroy', $warga) }}" data-konfirmasi="Hapus biodata {{ $warga->nama }}?">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn-kecil btn-hapus">Hapus</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        {{-- Belum ada biodata masuk --}}
                        <tr><td colspan="5" class="kosong">Belum ada biodata warga.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        {{-- Navigasi halaman --}}
        {{ $wargas->links() }}
    </section>
@endsection

{{-- JS khusus halaman ini dimuat via stack layout --}}
@push('scripts')
    @vite(['resources/js/admin/warga/index.js'])
@endpush
