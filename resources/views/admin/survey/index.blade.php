{{-- Halaman survei - daftar + tambah/ubah/hapus (pakai layout admin) --}}
@extends('layouts.admin')

{{-- Judul tab + judul bar atas --}}
@section('title', 'Survei - Desa Kalimanah')

{{-- CSS + JS khusus halaman ini dimuat via stack layout --}}
@push('styles')
    @vite(['resources/css/admin/survey/index.css'])
@endpush

@section('content')
    {{-- Judul halaman + tombol tambah --}}
    <section class="page-head" aria-labelledby="survey-judul">
        <h1 id="survey-judul">Survei</h1>
        <p class="page-sub">Kelola survei kepuasan dan lihat hasilnya.</p>
        <a class="btn-tambah" href="{{ route('admin.survey.create') }}">Tambah Survei</a>
    </section>

    {{-- Tabel survei --}}
    <section aria-label="Daftar survei">
        <div class="table-wrap">
            <table class="data-table">
                {{-- Kepala kolom --}}
                <thead>
                    <tr>
                        <th scope="col">No</th>
                        <th scope="col">Pertanyaan</th>
                        <th scope="col">Sudah Isi</th>
                        <th scope="col">Status</th>
                        <th scope="col">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($surveys as $survey)
                        <tr>
                            {{-- Nomor urut lanjut antar halaman --}}
                            <td>{{ $surveys->firstItem() + $loop->index }}</td>
                            {{-- Teks pertanyaan pertama --}}
                            <td>{{ $survey->pertanyaan_pertama ?? '-' }}</td>
                            {{-- Total warga unik yang sudah mengisi --}}
                            <td>{{ $survey->pengisi }} warga</td>
                            {{-- Penanda buka/tutup --}}
                            <td><span class="status {{ $survey->aktif ? 'status-buka' : 'status-tutup' }}">{{ $survey->aktif ? 'Dibuka' : 'Ditutup' }}</span></td>
                            <td>
                                {{-- Tombol lihat hasil --}}
                                <a class="btn-kecil btn-lihat" href="{{ route('admin.survey.show', $survey) }}">Lihat</a>
                                {{-- Tombol ubah --}}
                                <a class="btn-kecil btn-ubah" href="{{ route('admin.survey.edit', $survey) }}">Ubah</a>
                                {{-- Tombol hapus (minta konfirmasi via JS) --}}
                                <form method="POST" action="{{ route('admin.survey.destroy', $survey) }}" data-konfirmasi="Hapus survei {{ $survey->judul }} beserta pertanyaan dan jawabannya?">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn-kecil btn-hapus">Hapus</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        {{-- Belum ada survei --}}
                        <tr><td colspan="5" class="kosong">Belum ada survei.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        {{-- Navigasi halaman --}}
        {{ $surveys->links() }}
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
    @vite(['resources/js/admin/survey/index.js'])
@endpush
