{{-- Halaman verifikasi akun warga - daftar + setujui/tolak (pakai layout admin) --}}
@extends('layouts.admin')

{{-- Judul tab + judul bar atas --}}
@section('title', 'Verifikasi Akun - Desa Kalimanah')

{{-- CSS + JS khusus halaman ini dimuat via stack layout --}}
@push('styles')
    @vite(['resources/css/admin/pengguna/index.css'])
@endpush

@section('content')
    {{-- Judul halaman + saringan status --}}
    <section class="page-head" aria-labelledby="pengguna-judul">
        <h1 id="pengguna-judul">Verifikasi Akun</h1>
        <p class="page-sub">Setujui akun warga yang datanya valid, tolak yang tidak sesuai.</p>
        {{-- Saringan status akun --}}
        <nav class="filter-nav" aria-label="Saring status akun">
            <a href="{{ route('admin.pengguna.index') }}" class="{{ request('status') ? '' : 'aktif' }}">Semua</a>
            <a href="{{ route('admin.pengguna.index', ['status' => 'menunggu']) }}" class="{{ request('status') === 'menunggu' ? 'aktif' : '' }}">Menunggu</a>
            <a href="{{ route('admin.pengguna.index', ['status' => 'disetujui']) }}" class="{{ request('status') === 'disetujui' ? 'aktif' : '' }}">Disetujui</a>
            <a href="{{ route('admin.pengguna.index', ['status' => 'ditolak']) }}" class="{{ request('status') === 'ditolak' ? 'aktif' : '' }}">Ditolak</a>
        </nav>
    </section>

    {{-- Tabel akun warga --}}
    <section aria-label="Daftar akun warga">
        <div class="table-wrap">
            <table class="data-table">
                {{-- Kepala kolom --}}
                <thead>
                    <tr>
                        <th scope="col">No</th>
                        <th scope="col">Nama</th>
                        <th scope="col">Email</th>
                        <th scope="col">Status</th>
                        <th scope="col">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($users as $user)
                        <tr>
                            {{-- Nomor urut lanjut antar halaman --}}
                            <td>{{ $users->firstItem() + $loop->index }}</td>
                            {{-- Nama + email akun --}}
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->email }}</td>
                            {{-- Penanda status akun --}}
                            <td><span class="status status-{{ $user->status }}">{{ ucfirst($user->status) }}</span></td>
                            <td>
                                {{-- Tombol setujui langsung --}}
                                <form method="POST" action="{{ route('admin.pengguna.update', $user) }}">
                                    @csrf
                                    @method('PUT')
                                    <input type="hidden" name="status" value="disetujui">
                                    <button type="submit" class="btn-kecil btn-setuju">Setujui</button>
                                </form>
                                {{-- Tombol tolak (minta konfirmasi via JS) --}}
                                <form method="POST" action="{{ route('admin.pengguna.update', $user) }}" data-konfirmasi="Tolak akun {{ $user->name }}?">
                                    @csrf
                                    @method('PUT')
                                    <input type="hidden" name="status" value="ditolak">
                                    <button type="submit" class="btn-kecil btn-tolak">Tolak</button>
                                </form>
                                {{-- Tombol hapus (minta konfirmasi via JS); akun sendiri disembunyikan --}}
                                @if ($user->id !== auth()->id())
                                    <form method="POST" action="{{ route('admin.pengguna.destroy', $user) }}" data-konfirmasi="Hapus akun {{ $user->name }} beserta datanya?">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn-kecil btn-hapus">Hapus</button>
                                    </form>
                                @endif
                            </td>
                        </tr>
                    @empty
                        {{-- Belum ada akun pada saringan ini --}}
                        <tr><td colspan="5" class="kosong">Belum ada akun warga.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        {{-- Navigasi halaman --}}
        {{ $users->links() }}
    </section>

    {{-- Popup hasil aksi (tampil jika ada pesan sesi sukses/gagal) --}}
    @if (session('success') || session('gagal'))
        <div class="popup" id="popup" role="alertdialog" aria-modal="true" aria-label="Hasil aksi">
            <div class="popup-kartu">
                {{-- Ikon centang/silang sesuai hasil --}}
                <i class="ph {{ session('success') ? 'ph-check-circle popup-ok' : 'ph-x-circle popup-gagal-ikon' }}" aria-hidden="true"></i>
                <p>{{ session('success') ?? session('gagal') }}</p>
                <button type="button" class="btn-kecil btn-setuju" data-tutup>Tutup</button>
            </div>
        </div>
    @endif
@endsection

{{-- JS khusus halaman ini dimuat via stack layout --}}
@push('scripts')
    @vite(['resources/js/admin/pengguna/index.js'])
@endpush
