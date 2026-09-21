{{-- Halaman ajukan surat - pilih layanan + isi syarat (pakai layout warga) --}}
@extends('layouts.warga')

{{-- Judul tab browser --}}
@section('title', 'Ajukan Surat - Desa Kalimanah')

{{-- CSS + JS khusus halaman ini dimuat via stack layout --}}
@push('styles')
    @vite(['resources/css/warga/pengajuan/create.css'])
@endpush

@section('content')
    {{-- Form pengajuan surat --}}
    <section class="page-container pengajuan-form" aria-labelledby="pengajuan-judul">
        <h1 id="pengajuan-judul">Ajukan Layanan</h1>
        <p class="pengajuan-sub">Pilih layanan, isi keperluan dan syaratnya.</p>

        {{-- Kirim ke store pengajuan warga --}}
        <form class="form-card" method="POST" action="{{ route('warga.pengajuan.store') }}" enctype="multipart/form-data">
            @csrf
            {{-- Nama layanan yang diajukan (dari tombol Ajukan, tanpa dropdown) --}}
            <div class="field">
                <label>Nama Layanan</label>
                <p class="layanan-nama">{{ $layanan->nama }}</p>
                <input type="hidden" name="layanan_id" value="{{ $layanan->id }}">
            </div>

            {{-- Keperluan pengajuan --}}
            <div class="field">
                <label for="keperluan">Keperluan</label>
                <textarea id="keperluan" name="keperluan" rows="3" placeholder="Contoh: melamar pekerjaan">{{ old('keperluan') }}</textarea>
                @foreach ((array) $errors->get('keperluan') as $msg)
                    <p class="field-error" role="alert">{{ $msg }}</p>
                @endforeach
            </div>

            {{-- Syarat layanan terpilih: file diunggah, teks ditulis --}}
            <h2 class="kartu-judul">Syarat {{ $layanan->nama }}</h2>
            @foreach ($layanan->syaratLayanan as $syarat)
                <div class="field">
                    <label for="syarat-{{ $syarat->id }}">{{ $syarat->nama }}{{ $syarat->wajib ? ' (wajib)' : '' }}</label>
                    @if ($syarat->tipe === 'file')
                        <input id="syarat-{{ $syarat->id }}" type="file" name="syarat[{{ $syarat->id }}]" accept="image/jpeg,image/png,application/pdf" @required($syarat->wajib)>
                    @else
                        <input id="syarat-{{ $syarat->id }}" type="text" name="syarat[{{ $syarat->id }}]" value="{{ old('syarat.' . $syarat->id) }}" @required($syarat->wajib) autocomplete="off">
                    @endif
                </div>
            @endforeach

            {{-- Baris tombol kirim + batal --}}
            <div class="aksi-baris">
                <button type="submit" class="btn-simpan">Kirim Pengajuan</button>
                <a class="btn-sekunder" href="{{ route('warga.layanan.index') }}">Batal</a>
            </div>
        </form>
    </section>
@endsection

{{-- JS khusus halaman ini dimuat via stack layout --}}
@push('scripts')
    @vite(['resources/js/warga/pengajuan/create.js'])
@endpush
