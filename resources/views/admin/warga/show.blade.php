{{-- Halaman detail biodata warga (pakai layout admin) --}}
@extends('layouts.admin')

{{-- Judul tab + judul bar atas --}}
@section('title', 'Detail Warga - Desa Kalimanah')

{{-- CSS + JS khusus halaman ini dimuat via stack layout --}}
@push('styles')
    @vite(['resources/css/admin/warga/show.css'])
@endpush

@section('content')
    {{-- Biodata lengkap satu warga --}}
    <section class="detail" aria-labelledby="warga-judul">
        <h1 id="warga-judul">Detail Warga</h1>
        <p class="detail-sub">Biodata kependudukan dan akun pemilik.</p>

        {{-- Foto profil jika ada --}}
        @if ($warga->foto)
            <figure class="detail-foto">
                <img src="{{ asset('storage/' . $warga->foto) }}" alt="Foto {{ $warga->nama }}">
            </figure>
        @endif

        {{-- Kartu akun pemilik --}}
        <h2 class="kartu-judul">Akun</h2>
        <dl class="detail-card">
            <div><dt>Nama Akun</dt><dd>{{ $warga->user->name ?? '-' }}</dd></div>
            <div><dt>Email</dt><dd>{{ $warga->user->email ?? '-' }}</dd></div>
        </dl>

        {{-- Kartu biodata --}}
        <h2 class="kartu-judul">Biodata</h2>
        <dl class="detail-card">
            <div><dt>Nama</dt><dd>{{ $warga->nama }}</dd></div>
            <div><dt>NIK</dt><dd>{{ $warga->nik }}</dd></div>
            <div><dt>No. KK</dt><dd>{{ $warga->no_kk }}</dd></div>
            <div><dt>Tempat, Tanggal Lahir</dt><dd>{{ $warga->tempat_lahir ?? '-' }}, {{ $warga->tanggal_lahir?->format('d M Y') ?? '-' }}</dd></div>
            <div><dt>Jenis Kelamin</dt><dd>{{ $warga->jenis_kelamin === 'L' ? 'Laki-laki' : 'Perempuan' }}</dd></div>
            <div><dt>Alamat</dt><dd>{{ $warga->alamat }}, RT {{ $warga->rt }}/RW {{ $warga->rw }}</dd></div>
            <div><dt>Agama</dt><dd>{{ $warga->agama }}</dd></div>
            <div><dt>Status Pernikahan</dt><dd>{{ $warga->status_kawin }}</dd></div>
            <div><dt>Pekerjaan</dt><dd>{{ $warga->pekerjaan ?? '-' }}</dd></div>
            <div><dt>No. Telepon</dt><dd>{{ $warga->telepon ?? '-' }}</dd></div>
        </dl>

        {{-- Tombol kembali ke daftar --}}
        <a class="btn-kembali" href="{{ route('admin.warga.index') }}">Kembali</a>
    </section>
@endsection

{{-- JS khusus halaman ini dimuat via stack layout --}}
@push('scripts')
    @vite(['resources/js/admin/warga/show.js'])
@endpush
