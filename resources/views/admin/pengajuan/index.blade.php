{{-- Halaman pengajuan masuk - daftar + saring status (pakai layout admin) --}}
@extends('layouts.admin')

{{-- Judul tab + judul bar atas --}}
@section('title', 'Pengajuan Surat - Desa Kalimanah')

{{-- CSS + JS khusus halaman ini dimuat via stack layout --}}
@push('styles')
    @vite(['resources/css/admin/pengajuan/index.css'])
@endpush

@section('content')
    {{-- Judul halaman + saringan status --}}
    <section class="page-head" aria-labelledby="pengajuan-judul">
        <h1 id="pengajuan-judul">Pengajuan Surat</h1>
        <p class="page-sub">Verifikasi permohonan warga satu per satu.</p>
        {{-- Saringan status pengajuan --}}
        <nav class="filter-nav" aria-label="Saring status pengajuan">
            <a href="{{ route('admin.pengajuan.index') }}" class="{{ request('status') ? '' : 'aktif' }}">Semua</a>
            <a href="{{ route('admin.pengajuan.index', ['status' => 'menunggu']) }}" class="{{ request('status') === 'menunggu' ? 'aktif' : '' }}">Menunggu</a>
            <a href="{{ route('admin.pengajuan.index', ['status' => 'diproses']) }}" class="{{ request('status') === 'diproses' ? 'aktif' : '' }}">Diproses</a>
            <a href="{{ route('admin.pengajuan.index', ['status' => 'selesai']) }}" class="{{ request('status') === 'selesai' ? 'aktif' : '' }}">Selesai</a>
            <a href="{{ route('admin.pengajuan.index', ['status' => 'ditolak']) }}" class="{{ request('status') === 'ditolak' ? 'aktif' : '' }}">Ditolak</a>
        </nav>
    </section>

    {{-- Tabel pengajuan --}}
    <section aria-label="Daftar pengajuan surat">
        <div class="table-wrap">
            <table class="data-table">
                {{-- Kepala kolom --}}
                <thead>
                    <tr>
                        <th scope="col">No</th>
                        <th scope="col">Warga</th>
                        <th scope="col">Layanan</th>
                        <th scope="col">Tanggal</th>
                        <th scope="col">Status</th>
                        <th scope="col">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($pengajuans as $pengajuan)
                        <tr>
                            {{-- Nomor urut lanjut antar halaman --}}
                            <td>{{ $pengajuans->firstItem() + $loop->index }}</td>
                            <td>{{ $pengajuan->user->name ?? '-' }}</td>
                            <td>{{ $pengajuan->layanan->nama ?? '-' }}</td>
                            <td>{{ $pengajuan->created_at->format('d M Y') }}</td>
                            {{-- Penanda status pengajuan --}}
                            <td><span class="status status-{{ $pengajuan->status }}">{{ ucfirst($pengajuan->status) }}</span></td>
                            <td>
                                {{-- Tombol periksa berkas --}}
                                <a class="btn-kecil btn-lihat" href="{{ route('admin.pengajuan.show', $pengajuan) }}">Periksa</a>
                                {{-- Tombol ubah keputusan --}}
                                <a class="btn-kecil btn-ubah" href="{{ route('admin.pengajuan.edit', $pengajuan) }}">Ubah</a>
                                {{-- Tombol hapus (minta konfirmasi via JS) --}}
                                <form method="POST" action="{{ route('admin.pengajuan.destroy', $pengajuan) }}" data-konfirmasi="Hapus pengajuan {{ $pengajuan->layanan->nama ?? '' }} milik {{ $pengajuan->user->name ?? '' }}?">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn-kecil btn-hapus">Hapus</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        {{-- Belum ada pengajuan pada saringan ini --}}
                        <tr><td colspan="6" class="kosong">Belum ada pengajuan.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        {{-- Navigasi halaman --}}
        {{ $pengajuans->links() }}
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
    @vite(['resources/js/admin/pengajuan/index.js'])
@endpush
