{{-- Halaman template hasil - daftar + unggah/ubah/hapus (pakai layout admin) --}}
@extends('layouts.admin')

{{-- Judul tab + judul bar atas --}}
@section('title', 'Template Hasil - Desa Kalimanah')

{{-- CSS + JS khusus halaman ini dimuat via stack layout --}}
@push('styles')
    @vite(['resources/css/admin/template/index.css'])
@endpush

@section('content')
    {{-- Judul halaman + tombol unggah --}}
    <section class="page-head" aria-labelledby="template-judul">
        <h1 id="template-judul">Template Hasil</h1>
        <p class="page-sub">File Word resmi untuk hasil pengajuan tiap layanan.</p>
        <a class="btn-tambah" href="{{ route('admin.template.create') }}">Unggah Template</a>
    </section>

    {{-- Tabel template --}}
    <section aria-label="Daftar template hasil">
        <div class="table-wrap">
            <table class="data-table">
                {{-- Kepala kolom --}}
                <thead>
                    <tr>
                        <th scope="col">No</th>
                        <th scope="col">Layanan</th>
                        <th scope="col">Status</th>
                        <th scope="col">Diperbarui</th>
                        <th scope="col">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($templates as $template)
                        <tr>
                            {{-- Nomor urut lanjut antar halaman --}}
                            <td>{{ $templates->firstItem() + $loop->index }}</td>
                            <td class="rata-kiri">{{ $template->layanan->nama ?? '-' }}</td>
                            {{-- Penanda pakai / nonaktif --}}
                            <td>
                                @if ($template->aktif)
                                    <span class="status status-aktif">Aktif</span>
                                @else
                                    <span class="status status-nonaktif">Nonaktif</span>
                                @endif
                            </td>
                            <td>{{ $template->updated_at->format('d M Y') }}</td>
                            <td>
                                {{-- Tombol ganti file / ubah status --}}
                                <a class="btn-kecil btn-ubah" href="{{ route('admin.template.edit', $template) }}">Ubah</a>
                                {{-- Tombol hapus (minta konfirmasi via JS) --}}
                                <form method="POST" action="{{ route('admin.template.destroy', $template) }}" data-konfirmasi="Hapus template {{ $template->layanan->nama ?? '' }}?">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn-kecil btn-hapus">Hapus</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        {{-- Belum ada template --}}
                        <tr><td colspan="5" class="kosong">Belum ada template hasil.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        {{-- Navigasi halaman --}}
        {{ $templates->links() }}
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
    @vite(['resources/js/admin/template/index.js'])
@endpush
