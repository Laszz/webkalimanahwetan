{{-- Halaman ubah pos APBDes (pakai layout admin) --}}
@extends('layouts.admin')

{{-- Judul tab + judul bar atas --}}
@section('title', 'Ubah Pos APBDes - Desa Kalimanah')

{{-- CSS + JS khusus halaman ini dimuat via stack layout --}}
@push('styles')
    @vite(['resources/css/admin/apbdes/edit.css'])
@endpush

@section('content')
    {{-- Form ubah terisi data lama --}}
    <section class="page-container-kecil" aria-labelledby="apbdes-judul">
        <h1 id="apbdes-judul">Ubah Pos APBDes</h1>
        <p class="page-sub">Perbarui pos {{ $apbde->uraian }} tahun {{ $apbde->tahun }}.</p>

        {{-- Kirim perubahan ke update apbdes --}}
        <form class="form-card" method="POST" action="{{ route('admin.apbdes.update', $apbde) }}">
            @csrf
            @method('PUT')
            {{-- Tahun anggaran --}}
            <div class="field">
                <label for="tahun">Tahun</label>
                <input id="tahun" type="number" name="tahun" min="2000" max="2100" value="{{ old('tahun', $apbde->tahun) }}" required>
                @foreach ((array) $errors->get('tahun') as $msg)
                    <p class="field-error" role="alert">{{ $msg }}</p>
                @endforeach
            </div>
            {{-- Bidang kegiatan (dropdown baku 5 bidang desa) --}}
            <div class="field">
                <label for="bidang">Bidang</label>
                <select id="bidang" name="bidang" required>
                    @foreach (['Penyelenggaraan Pemerintahan', 'Pelaksanaan Pembangunan', 'Pembinaan Kemasyarakatan', 'Pemberdayaan Masyarakat', 'Penanggulangan Bencana'] as $opsi)
                        <option value="{{ $opsi }}" {{ old('bidang', $apbde->bidang) === $opsi ? 'selected' : '' }}>{{ $opsi }}</option>
                    @endforeach
                </select>
                @foreach ((array) $errors->get('bidang') as $msg)
                    <p class="field-error" role="alert">{{ $msg }}</p>
                @endforeach
            </div>
            {{-- Uraian pos --}}
            <div class="field">
                <label for="uraian">Uraian</label>
                <input id="uraian" type="text" name="uraian" value="{{ old('uraian', $apbde->uraian) }}" required autocomplete="off">
                @foreach ((array) $errors->get('uraian') as $msg)
                    <p class="field-error" role="alert">{{ $msg }}</p>
                @endforeach
            </div>
            {{-- Asal dana (dropdown baku sumber dana desa) --}}
            <div class="field">
                <label for="sumber_dana">Sumber Dana</label>
                <select id="sumber_dana" name="sumber_dana" required>
                    @foreach (['Dana Desa (DD)', 'Alokasi Dana Desa (ADD)', 'Pendapatan Asli Desa (PADes)', 'Bagi Hasil Pajak dan Retribusi Daerah', 'Bantuan Keuangan Provinsi', 'Bantuan Keuangan Kabupaten/Kota', 'Pendapatan Lain-Lain', 'Swadaya Masyarakat'] as $opsi)
                        <option value="{{ $opsi }}" {{ old('sumber_dana', $apbde->sumber_dana) === $opsi ? 'selected' : '' }}>{{ $opsi }}</option>
                    @endforeach
                </select>
                @foreach ((array) $errors->get('sumber_dana') as $msg)
                    <p class="field-error" role="alert">{{ $msg }}</p>
                @endforeach
            </div>
            {{-- Pagu anggaran rupiah tampil bertitik, kirim angka polos via JS --}}
            <div class="field">
                <label for="anggaran">Anggaran (Rp)</label>
                <input id="anggaran" type="text" name="anggaran" inputmode="numeric" data-rupiah value="{{ old('anggaran', $apbde->anggaran) }}" required>
                @foreach ((array) $errors->get('anggaran') as $msg)
                    <p class="field-error" role="alert">{{ $msg }}</p>
                @endforeach
            </div>
            {{-- Serapan terealisasi --}}
            <div class="field">
                <label for="realisasi">Realisasi (Rp)</label>
                <input id="realisasi" type="text" name="realisasi" inputmode="numeric" data-rupiah value="{{ old('realisasi', $apbde->realisasi) }}">
                @foreach ((array) $errors->get('realisasi') as $msg)
                    <p class="field-error" role="alert">{{ $msg }}</p>
                @endforeach
            </div>
            {{-- Baris tombol simpan + batal --}}
            <div class="aksi-baris">
                <button type="submit" class="btn-simpan">Simpan Perubahan</button>
                <a class="btn-sekunder" href="{{ route('admin.apbdes.index') }}">Batal</a>
            </div>
        </form>
    </section>
@endsection

{{-- JS khusus halaman ini dimuat via stack layout (pakai ulang logic create) --}}
@push('scripts')
    @vite(['resources/js/admin/apbdes/edit.js'])
@endpush
