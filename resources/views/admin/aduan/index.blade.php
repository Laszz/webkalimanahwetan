{{-- Halaman aduan masuk - daftar + saring status (pakai layout admin) --}}
@extends('layouts.admin')

{{-- Judul tab + judul bar atas --}}
@section('title', 'Aduan Warga - Desa Kalimanah')

{{-- CSS + JS khusus halaman ini dimuat via stack layout --}}
@push('styles')
    @vite(['resources/css/admin/aduan/index.css'])
@endpush

@section('content')
    {{-- Judul halaman + saringan status --}}
    <section class="page-head" aria-labelledby="aduan-judul">
        <h1 id="aduan-judul">Aduan Warga</h1>
        <p class="page-sub">Pantau laporan masuk dan tindak lanjuti.</p>
        {{-- Saringan status aduan --}}
        <nav class="filter-nav" aria-label="Saring status aduan">
            <a href="{{ route('admin.aduan.index') }}" class="{{ request('status') ? '' : 'aktif' }}">Semua</a>
            <a href="{{ route('admin.aduan.index', ['status' => 'menunggu']) }}" class="{{ request('status') === 'menunggu' ? 'aktif' : '' }}">Menunggu</a>
            <a href="{{ route('admin.aduan.index', ['status' => 'diproses']) }}" class="{{ request('status') === 'diproses' ? 'aktif' : '' }}">Diproses</a>
            <a href="{{ route('admin.aduan.index', ['status' => 'selesai']) }}" class="{{ request('status') === 'selesai' ? 'aktif' : '' }}">Selesai</a>
        </nav>
    </section>

    {{-- Tabel aduan --}}
    <section aria-label="Daftar aduan warga">
        <div class="table-wrap">
            <table class="data-table">
                {{-- Kepala kolom --}}
                <thead>
                    <tr>
                        <th scope="col">No</th>
                        <th scope="col">Judul</th>
                        <th scope="col">Pelapor</th>
                        <th scope="col">Tanggal</th>
                        <th scope="col">Status</th>
                        <th scope="col">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($aduans as $aduan)
                        <tr>
                            {{-- Nomor urut lanjut antar halaman --}}
                            <td>{{ $aduans->firstItem() + $loop->index }}</td>
                            <td>{{ $aduan->judul }}</td>
                            <td>{{ $aduan->user->name ?? '-' }}</td>
                            <td>{{ $aduan->created_at->format('d M Y') }}</td>
                            {{-- Penanda status aduan --}}
                            <td><span class="status status-{{ $aduan->status }}">{{ ucfirst($aduan->status) }}</span></td>
                            <td>
                                {{-- Tombol lihat detail --}}
                                <a class="btn-kecil btn-lihat" href="{{ route('admin.aduan.show', $aduan) }}">Lihat</a>
                                {{-- Tombol ubah ke halaman tindak lanjut --}}
                                <a class="btn-kecil btn-ubah" href="{{ route('admin.aduan.edit', $aduan) }}">Ubah</a>
                            </td>
                        </tr>
                    @empty
                        {{-- Belum ada aduan pada saringan ini --}}
                        <tr><td colspan="6" class="kosong">Belum ada aduan.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        {{-- Navigasi halaman --}}
        {{ $aduans->links() }}
    </section>
@endsection

{{-- JS khusus halaman ini dimuat via stack layout --}}
@push('scripts')
    @vite(['resources/js/admin/aduan/index.js'])
@endpush
