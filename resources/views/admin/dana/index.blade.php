{{-- Halaman dana - daftar + tambah/ubah/hapus (pakai layout admin) --}}
@extends('layouts.admin')

{{-- Judul tab + judul bar atas --}}
@section('title', 'Dana APBDes - Desa Kalimanah')

{{-- CSS + JS khusus halaman ini dimuat via stack layout --}}
@push('styles')
    @vite(['resources/css/admin/dana/index.css'])
@endpush

@section('content')
    {{-- Judul halaman + tombol tambah --}}
    <section class="page-head" aria-labelledby="dana-judul">
        <h1 id="dana-judul">Dana</h1>
        <p class="page-sub">Pagu per sumber dana per tahun.</p>
        <a class="btn-tambah" href="{{ route('admin.dana.create') }}">Tambah Dana</a>
    </section>

    {{-- Saring per tahun anggaran + sumber dana --}}
    <section aria-label="Saring tahun dan sumber">
        <form class="filter-bar" method="GET" action="{{ route('admin.dana.index') }}">
            <div class="field-inline">
                <label for="tahun">Tahun</label>
                <input id="tahun" type="number" name="tahun" min="2000" max="2100" value="{{ request('tahun') }}" placeholder="Semua tahun">
            </div>
            <div class="field-inline">
                <label for="sumber">Sumber Dana</label>
                <select id="sumber" name="sumber">
                    <option value="">Semua sumber</option>
                    @foreach (\App\Models\Dana::SUMBER as $opsi)
                        <option value="{{ $opsi }}" {{ request('sumber') === $opsi ? 'selected' : '' }}>{{ $opsi }}</option>
                    @endforeach
                </select>
            </div>
            <button type="submit" class="btn-kecil btn-lihat">Tampilkan</button>
            @if (request('tahun') || request('sumber'))
                <a class="btn-kecil btn-sekunder-inline" href="{{ route('admin.dana.index') }}">Reset</a>
            @endif
        </form>
    </section>

    {{-- Tabel pagu dana --}}
    <section aria-label="Daftar dana">
        <div class="table-wrap">
            <table class="data-table">
                {{-- Kepala kolom --}}
                <thead>
                    <tr>
                        <th scope="col">No</th>
                        <th scope="col">Tahun</th>
                        <th scope="col">Sumber Dana</th>
                        <th scope="col">Anggaran</th>
                        <th scope="col">Terpakai</th>
                        <th scope="col">Sisa</th>
                        <th scope="col">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($danas as $dana)
                        <tr>
                            {{-- Nomor urut lanjut antar halaman --}}
                            <td>{{ $danas->firstItem() + $loop->index }}</td>
                            <td>{{ $dana->tahun }}</td>
                            <td class="rata-kiri">{{ $dana->sumber_dana }}</td>
                            <td class="angka">Rp{{ number_format($dana->anggaran, 0, ',', '.') }}</td>
                            <td class="angka">Rp{{ number_format($dana->terpakai, 0, ',', '.') }}</td>
                            <td class="angka">Rp{{ number_format(max(0, $dana->anggaran - $dana->terpakai), 0, ',', '.') }}</td>
                            <td>
                                {{-- Tombol ubah --}}
                                <a class="btn-kecil btn-ubah" href="{{ route('admin.dana.edit', $dana) }}">Ubah</a>
                                {{-- Tombol hapus (minta konfirmasi via JS) --}}
                                <form method="POST" action="{{ route('admin.dana.destroy', $dana) }}" data-konfirmasi="Hapus dana {{ $dana->sumber_dana }} tahun {{ $dana->tahun }}?">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn-kecil btn-hapus">Hapus</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        {{-- Belum ada dana --}}
                        <tr><td colspan="7" class="kosong">Belum ada dana.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        {{-- Navigasi halaman (bawa filter tahun) --}}
        {{ $danas->appends(request()->query())->links() }}
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

    {{-- Popup gagal hapus (dana sudah dipakai belanja) --}}
    @if (session('gagal'))
        <div class="popup" id="popup" role="alertdialog" aria-modal="true" aria-label="Gagal hapus">
            <div class="popup-kartu">
                <i class="ph ph-warning-circle popup-gagal" aria-hidden="true"></i>
                <p>{{ session('gagal') }}</p>
                <button type="button" class="btn-kecil btn-setuju" data-tutup>Tutup</button>
            </div>
        </div>
    @endif
@endsection

{{-- JS khusus halaman ini dimuat via stack layout --}}
@push('scripts')
    @vite(['resources/js/admin/dana/index.js'])
@endpush
