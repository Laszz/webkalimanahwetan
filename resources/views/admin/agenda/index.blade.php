{{-- Halaman agenda - daftar + tambah/ubah/hapus (pakai layout admin) --}}
@extends('layouts.admin')

{{-- Judul tab + judul bar atas --}}
@section('title', 'Agenda - Desa Kalimanah')

{{-- CSS + JS khusus halaman ini dimuat via stack layout --}}
@push('styles')
    @vite(['resources/css/admin/agenda/index.css'])
@endpush

@section('content')
    {{-- Judul halaman + tombol tambah --}}
    <section class="page-head" aria-labelledby="agenda-judul">
        <h1 id="agenda-judul">Agenda</h1>
        <p class="page-sub">Jadwal kegiatan desa.</p>
        <a class="btn-tambah" href="{{ route('admin.agenda.create') }}">Tambah Agenda</a>
    </section>

    {{-- Tabel agenda --}}
    <section aria-label="Daftar agenda">
        <div class="table-wrap">
            <table class="data-table">
                {{-- Kepala kolom --}}
                <thead>
                    <tr>
                        <th scope="col">No</th>
                        <th scope="col">Judul</th>
                        <th scope="col">Tempat</th>
                        <th scope="col">Mulai</th>
                        <th scope="col">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($agendas as $agenda)
                        <tr>
                            {{-- Nomor urut lanjut antar halaman --}}
                            <td>{{ $agendas->firstItem() + $loop->index }}</td>
                            <td>{{ $agenda->judul }}</td>
                            <td>{{ $agenda->tempat }}</td>
                            <td>{{ $agenda->mulai->format('d M Y H.i') }}</td>
                            <td>
                                {{-- Tombol lihat detail --}}
                                <a class="btn-kecil btn-lihat" href="{{ route('admin.agenda.show', $agenda) }}">Lihat</a>
                                {{-- Tombol ubah --}}
                                <a class="btn-kecil btn-ubah" href="{{ route('admin.agenda.edit', $agenda) }}">Ubah</a>
                                {{-- Tombol hapus (minta konfirmasi via JS) --}}
                                <form method="POST" action="{{ route('admin.agenda.destroy', $agenda) }}" data-konfirmasi="Hapus agenda {{ $agenda->judul }}?">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn-kecil btn-hapus">Hapus</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        {{-- Belum ada agenda --}}
                        <tr><td colspan="5" class="kosong">Belum ada agenda.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        {{-- Navigasi halaman --}}
        {{ $agendas->links() }}
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
    @vite(['resources/js/admin/agenda/index.js'])
@endpush
