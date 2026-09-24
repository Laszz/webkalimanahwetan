{{-- Halaman pengajuan saya - riwayat permohonan milik sendiri (pakai layout warga) --}}
@extends('layouts.warga')

{{-- Judul tab browser --}}
@section('title', 'Pengajuan Saya - Desa Kalimanah')

{{-- CSS + JS khusus halaman ini dimuat via stack layout --}}
@push('styles')
    @vite(['resources/css/warga/pengajuan/index.css'])
@endpush

@section('content')
    {{-- Riwayat pengajuan sendiri --}}
    <section class="page-container pengajuan" aria-labelledby="pengajuan-judul">
        <h1 id="pengajuan-judul">Pengajuan Saya</h1>
        <p class="pengajuan-sub">Status permohonan surat yang pernah diajukan.</p>

        {{-- Baris tiap pengajuan --}}
        <ul class="pengajuan-list">
            @forelse ($pengajuans as $pengajuan)
                <li>
                    {{-- Nama layanan + status --}}
                    <div class="pengajuan-head">
                        <h2>{{ $pengajuan->layanan->nama ?? '-' }}</h2>
                        <span class="status status-{{ $pengajuan->status }}">{{ ucfirst($pengajuan->status) }}</span>
                    </div>
                    <p class="pengajuan-tanggal">{{ $pengajuan->created_at->format('d M Y') }}</p>
                    @if ($pengajuan->catatan)
                        <p class="pengajuan-catatan">{{ $pengajuan->catatan }}</p>
                    @endif
                    {{-- Tautan unduh muncul setelah selesai dan file hasil tersedia --}}
                    @if ($pengajuan->status === 'selesai' && $pengajuan->file_hasil)
                        <a class="btn-unduh" href="{{ route('warga.pengajuan.unduh', $pengajuan) }}">Unduh Hasil</a>
                    @endif
                </li>
            @empty
                {{-- Belum pernah mengajukan --}}
                <li class="kosong"><p><strong>Belum ada pengajuan.</strong></p></li>
            @endforelse
        </ul>

        {{-- Navigasi halaman --}}
        {{ $pengajuans->links() }}
    </section>
@endsection

{{-- JS khusus halaman ini dimuat via stack layout --}}
@push('scripts')
    @vite(['resources/js/warga/pengajuan/index.js'])
@endpush
