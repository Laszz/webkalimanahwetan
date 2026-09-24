{{-- Halaman tambah belanja APBDes (pakai layout admin) --}}
@extends('layouts.admin')

{{-- Judul tab + judul bar atas --}}
@section('title', 'Tambah Belanja - Desa Kalimanah')

{{-- CSS + JS khusus halaman ini dimuat via stack layout --}}
@push('styles')
    @vite(['resources/css/admin/belanja/create.css'])
@endpush

@section('content')
    {{-- Form belanja dari dana yang bersisa --}}
    <section class="page-container-kecil" aria-labelledby="belanja-judul">
        <h1 id="belanja-judul">Tambah Belanja</h1>
        <p class="page-sub">Pilih dana yang masih bersisa untuk kegiatan.</p>

        {{-- Kirim ke store belanja --}}
        <form class="form-card" method="POST" action="{{ route('admin.belanja.store') }}">
            @csrf
            {{-- Dana dipakai (habis = tidak bisa dipilih) --}}
            <div class="field">
                <label for="dana_id">Dana</label>
                <select id="dana_id" name="dana_id" required>
                    <option value="" disabled {{ old('dana_id') ? '' : 'selected' }}>Pilih dana</option>
                    @foreach ($danas as $dana)
                        @php
                            $sisaDana = max(0, $dana->anggaran - $dana->terpakai);
                        @endphp
                        <option value="{{ $dana->id }}" {{ (string) old('dana_id') === (string) $dana->id ? 'selected' : '' }} @disabled($sisaDana <= 0)>{{ $dana->sumber_dana }} {{ $dana->tahun }} — sisa Rp{{ number_format($sisaDana, 0, ',', '.') }}</option>
                    @endforeach
                </select>
                @if ($danas->isEmpty())
                    <p class="field-info">Belum ada dana. Buat dulu di halaman Dana.</p>
                @endif
                @foreach ((array) $errors->get('dana_id') as $msg)
                    <p class="field-error" role="alert">{{ $msg }}</p>
                @endforeach
            </div>
            {{-- Bidang kegiatan baku --}}
            <div class="field">
                <label for="bidang">Bidang</label>
                <select id="bidang" name="bidang" required>
                    <option value="" disabled {{ old('bidang') ? '' : 'selected' }}>Pilih bidang</option>
                    @foreach (\App\Models\Belanja::BIDANG as $opsi)
                        <option value="{{ $opsi }}" {{ old('bidang') === $opsi ? 'selected' : '' }}>{{ $opsi }}</option>
                    @endforeach
                </select>
                @foreach ((array) $errors->get('bidang') as $msg)
                    <p class="field-error" role="alert">{{ $msg }}</p>
                @endforeach
            </div>
            {{-- Uraian pemakaian --}}
            <div class="field">
                <label for="uraian">Uraian</label>
                <input id="uraian" type="text" name="uraian" value="{{ old('uraian') }}" required autocomplete="off" placeholder="cth. Pembangunan jalan dusun">
                @foreach ((array) $errors->get('uraian') as $msg)
                    <p class="field-error" role="alert">{{ $msg }}</p>
                @endforeach
            </div>
            {{-- Nominal tampil bertitik, kirim angka polos via JS --}}
            <div class="field">
                <label for="nominal">Nominal (Rp)</label>
                <input id="nominal" type="text" name="nominal" inputmode="numeric" data-rupiah value="{{ old('nominal') }}" required placeholder="cth. 10.000.000">
                @foreach ((array) $errors->get('nominal') as $msg)
                    <p class="field-error" role="alert">{{ $msg }}</p>
                @endforeach
            </div>
            {{-- Baris tombol simpan + batal --}}
            <div class="aksi-baris">
                <button type="submit" class="btn-simpan">Simpan</button>
                <a class="btn-sekunder" href="{{ route('admin.belanja.index') }}">Batal</a>
            </div>
        </form>
    </section>
@endsection

{{-- JS khusus halaman ini dimuat via stack layout --}}
@push('scripts')
    @vite(['resources/js/admin/belanja/create.js'])
@endpush
