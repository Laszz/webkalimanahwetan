{{-- Halaman detail agenda (pakai layout admin) --}}
@extends('layouts.admin')

{{-- Judul tab + judul bar atas --}}
@section('title', 'Detail Agenda - Desa Kalimanah')

{{-- CSS + JS khusus halaman ini dimuat via stack layout --}}
@push('styles')
    @vite(['resources/css/admin/agenda/show.css'])
@endpush

@section('content')
    {{-- Info agenda lengkap --}}
    <section class="detail" aria-labelledby="agenda-judul">
        <h1 id="agenda-judul">{{ $agenda->judul }}</h1>
        {{-- Baris tempat + waktu --}}
        <p class="detail-meta">
            <span>{{ $agenda->tempat }}</span>
            <span>{{ $agenda->mulai->format('d M Y H.i') }}{{ $agenda->selesai ? ' - ' . $agenda->selesai->format('d M Y H.i') : '' }}</span>
        </p>

        @if ($agenda->deskripsi)
            <p class="detail-sub">{{ $agenda->deskripsi }}</p>
        @endif

        {{-- Baris tombol ubah + kembali --}}
        <div class="aksi-baris">
            <a class="btn-ubah" href="{{ route('admin.agenda.edit', $agenda) }}">Ubah</a>
            <a class="btn-sekunder" href="{{ route('admin.agenda.index') }}">Kembali</a>
        </div>
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
    @vite(['resources/js/admin/agenda/show.js'])
@endpush
