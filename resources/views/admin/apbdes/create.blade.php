{{-- Halaman tambah pos APBDes (pakai layout admin) --}}
@extends('layouts.admin')

{{-- Judul tab + judul bar atas --}}
@section('title', 'Tambah Pos APBDes - Desa Kalimanah')

{{-- CSS + JS khusus halaman ini dimuat via stack layout --}}
@push('styles')
    @vite(['resources/css/admin/apbdes/create.css'])
@endpush

@section('content')
    {{-- Form tambah pos anggaran --}}
    <section class="page-container-kecil" aria-labelledby="apbdes-judul">
        <h1 id="apbdes-judul">Tambah Pos APBDes</h1>
        <p class="page-sub">Tambah satu pos anggaran per bidang.</p>

        {{-- Kirim ke store apbdes --}}
        <form class="form-card" method="POST" action="{{ route('admin.apbdes.store') }}">
            @csrf
            {{-- Tahun anggaran --}}
            <div class="field">
                <label for="tahun">Tahun</label>
                <input id="tahun" type="number" name="tahun" min="2000" max="2100" value="{{ old('tahun', date('Y')) }}" required>
                @foreach ((array) $errors->get('tahun') as $msg)
                    <p class="field-error" role="alert">{{ $msg }}</p>
                @endforeach
            </div>
            {{-- Bidang kegiatan (dropdown baku 5 bidang desa) --}}
            <div class="field">
                <label for="bidang">Bidang</label>
                <select id="bidang" name="bidang" required>
                    <option value="" disabled {{ old('bidang') ? '' : 'selected' }}>Pilih bidang</option>
                    @foreach (['Penyelenggaraan Pemerintahan', 'Pelaksanaan Pembangunan', 'Pembinaan Kemasyarakatan', 'Pemberdayaan Masyarakat', 'Penanggulangan Bencana'] as $opsi)
                        <option value="{{ $opsi }}" {{ old('bidang') === $opsi ? 'selected' : '' }}>{{ $opsi }}</option>
                    @endforeach
                </select>
                @foreach ((array) $errors->get('bidang') as $msg)
                    <p class="field-error" role="alert">{{ $msg }}</p>
                @endforeach
            </div>
            {{-- Uraian pos --}}
            <div class="field">
                <label for="uraian">Uraian</label>
                <input id="uraian" type="text" name="uraian" value="{{ old('uraian') }}" required autocomplete="off" placeholder="cth. Pembangunan jalan dusun">
                @foreach ((array) $errors->get('uraian') as $msg)
                    <p class="field-error" role="alert">{{ $msg }}</p>
                @endforeach
            </div>
            {{-- Asal dana --}}
            <div class="field">
                <label for="sumber_dana">Sumber Dana</label>
                <select id="sumber_dana" name="sumber_dana" required>
                    <option value="" disabled {{ old('sumber_dana') ? '' : 'selected' }}>Pilih sumber dana</option>
                    @foreach (['Dana Desa (DD)', 'Alokasi Dana Desa (ADD)', 'Pendapatan Asli Desa (PADes)', 'Bagi Hasil Pajak dan Retribusi Daerah', 'Bantuan Keuangan Provinsi', 'Bantuan Keuangan Kabupaten/Kota', 'Pendapatan Lain-Lain', 'Swadaya Masyarakat'] as $opsi)
                        <option value="{{ $opsi }}" {{ old('sumber_dana') === $opsi ? 'selected' : '' }}>{{ $opsi }}</option>
                    @endforeach
                </select>
                @foreach ((array) $errors->get('sumber_dana') as $msg)
                    <p class="field-error" role="alert">{{ $msg }}</p>
                @endforeach
            </div>
            {{-- Pagu anggaran rupiah tampil bertitik, kirim angka polos via JS --}}
            <div class="field">
                <label for="anggaran">Anggaran (Rp)</label>
                <input id="anggaran" type="text" name="anggaran" inputmode="numeric" data-rupiah value="{{ old('anggaran') }}" required placeholder="cth. 50.000.000">
                @foreach ((array) $errors->get('anggaran') as $msg)
                    <p class="field-error" role="alert">{{ $msg }}</p>
                @endforeach
            </div>
            {{-- Serapan boleh kosong saat rencana --}}
            <div class="field">
                <label for="realisasi">Realisasi (Rp)</label>
                <input id="realisasi" type="text" name="realisasi" inputmode="numeric" data-rupiah value="{{ old('realisasi') }}" placeholder="Kosongkan jika belum terserap">
                @foreach ((array) $errors->get('realisasi') as $msg)
                    <p class="field-error" role="alert">{{ $msg }}</p>
                @endforeach
            </div>
            {{-- Baris tombol simpan + batal --}}
            <div class="aksi-baris">
                <button type="submit" class="btn-simpan">Simpan</button>
                <a class="btn-sekunder" href="{{ route('admin.apbdes.index') }}">Batal</a>
            </div>
        </form>
    </section>
@endsection

{{-- JS khusus halaman ini dimuat via stack layout --}}
@push('scripts')
    @vite(['resources/js/admin/apbdes/create.js'])
@endpush
