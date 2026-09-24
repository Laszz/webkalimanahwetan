{{-- Halaman belanja - daftar + tambah/ubah/hapus (pakai layout admin) --}}
@extends('layouts.admin')

{{-- Judul tab + judul bar atas --}}
@section('title', 'Belanja APBDes - Desa Kalimanah')

{{-- CSS + JS khusus halaman ini dimuat via stack layout --}}
@push('styles')
    @vite(['resources/css/admin/belanja/index.css'])
@endpush

@section('content')
    {{-- Judul halaman + tombol tambah --}}
    <section class="page-head" aria-labelledby="belanja-judul">
        <h1 id="belanja-judul">Belanja</h1>
        <p class="page-sub">Pakai dana untuk kegiatan per bidang.</p>
        <a class="btn-tambah" href="{{ route('admin.belanja.create') }}">Tambah Belanja</a>
    </section>

    {{-- Saring per tahun dana dipakai + bidang --}}
    <section aria-label="Saring tahun dan bidang">
        <form class="filter-bar" method="GET" action="{{ route('admin.belanja.index') }}">
            <div class="field-inline">
                <label for="tahun">Tahun</label>
                <input id="tahun" type="number" name="tahun" min="2000" max="2100" value="{{ request('tahun') }}" placeholder="Semua tahun">
            </div>
            <div class="field-inline">
                <label for="bidang">Bidang</label>
                <select id="bidang" name="bidang">
                    <option value="">Semua bidang</option>
                    @foreach (\App\Models\Belanja::BIDANG as $opsi)
                        <option value="{{ $opsi }}" {{ request('bidang') === $opsi ? 'selected' : '' }}>{{ $opsi }}</option>
                    @endforeach
                </select>
            </div>
            <button type="submit" class="btn-kecil btn-lihat">Tampilkan</button>
            @if (request('tahun') || request('bidang'))
                <a class="btn-kecil btn-sekunder-inline" href="{{ route('admin.belanja.index') }}">Reset</a>
            @endif
        </form>
    </section>

    {{-- Tabel belanja --}}
    <section aria-label="Daftar belanja">
        <div class="table-wrap">
            <table class="data-table">
                {{-- Kepala kolom --}}
                <thead>
                    <tr>
                        <th scope="col">No</th>
                        <th scope="col">Tahun</th>
                        <th scope="col">Sumber Dana</th>
                        <th scope="col">Bidang</th>
                        <th scope="col">Uraian</th>
                        <th scope="col">Nominal</th>
                        <th scope="col">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($belanjas as $belanja)
                        <tr>
                            {{-- Nomor urut lanjut antar halaman --}}
                            <td>{{ $belanjas->firstItem() + $loop->index }}</td>
                            <td>{{ $belanja->dana->tahun ?? '-' }}</td>
                            <td class="rata-kiri">{{ $belanja->dana->sumber_dana ?? '-' }}</td>
                            <td>{{ $belanja->bidang }}</td>
                            <td class="rata-kiri">{{ $belanja->uraian }}</td>
                            <td class="angka">Rp{{ number_format($belanja->nominal, 0, ',', '.') }}</td>
                            <td>
                                {{-- Tombol ubah --}}
                                <a class="btn-kecil btn-ubah" href="{{ route('admin.belanja.edit', $belanja) }}">Ubah</a>
                                {{-- Tombol hapus (minta konfirmasi via JS) --}}
                                <form method="POST" action="{{ route('admin.belanja.destroy', $belanja) }}" data-konfirmasi="Hapus belanja {{ $belanja->uraian }}?">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn-kecil btn-hapus">Hapus</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        {{-- Belum ada belanja --}}
                        <tr><td colspan="7" class="kosong">Belum ada belanja.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        {{-- Navigasi halaman (bawa filter tahun) --}}
        {{ $belanjas->appends(request()->query())->links() }}
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
    @vite(['resources/js/admin/belanja/index.js'])
@endpush
