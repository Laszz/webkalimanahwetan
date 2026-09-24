{{-- Halaman ubah belanja APBDes (pakai layout admin) --}}
@extends('layouts.admin')

{{-- Judul tab + judul bar atas --}}
@section('title', 'Ubah Belanja - Desa Kalimanah')

{{-- CSS + JS khusus halaman ini dimuat via stack layout --}}
@push('styles')
    @vite(['resources/css/admin/belanja/edit.css'])
@endpush

@section('content')
    {{-- Form ubah terisi data lama --}}
    <section class="page-container-kecil" aria-labelledby="belanja-judul">
        <h1 id="belanja-judul">Ubah Belanja</h1>
        <p class="page-sub">Perbarui belanja {{ $belanja->uraian }}.</p>

        {{-- Kirim perubahan ke update belanja --}}
        <form class="form-card" method="POST" action="{{ route('admin.belanja.update', $belanja) }}">
            @csrf
            @method('PUT')
            {{-- Dana dipakai (sisa dihitung tanpa nominal lama baris ini) --}}
            <div class="field">
                <label for="dana_id">Dana</label>
                <select id="dana_id" name="dana_id" required>
                    @foreach ($danas as $dana)
                        @php
                            $terpakaiLain = $dana->id === $belanja->dana_id
                                ? max(0, $dana->terpakai - $belanja->nominal)
                                : $dana->terpakai;
                            $sisaDana = max(0, $dana->anggaran - $terpakaiLain);
                        @endphp
                        <option value="{{ $dana->id }}" {{ (string) old('dana_id', $belanja->dana_id) === (string) $dana->id ? 'selected' : '' }} @disabled($sisaDana <= 0 && (string) old('dana_id', $belanja->dana_id) !== (string) $dana->id)>{{ $dana->sumber_dana }} {{ $dana->tahun }} — sisa Rp{{ number_format($sisaDana, 0, ',', '.') }}</option>
                    @endforeach
                </select>
                @foreach ((array) $errors->get('dana_id') as $msg)
                    <p class="field-error" role="alert">{{ $msg }}</p>
                @endforeach
            </div>
            {{-- Bidang kegiatan baku --}}
            <div class="field">
                <label for="bidang">Bidang</label>
                <select id="bidang" name="bidang" required>
                    @foreach (\App\Models\Belanja::BIDANG as $opsi)
                        <option value="{{ $opsi }}" {{ old('bidang', $belanja->bidang) === $opsi ? 'selected' : '' }}>{{ $opsi }}</option>
                    @endforeach
                </select>
                @foreach ((array) $errors->get('bidang') as $msg)
                    <p class="field-error" role="alert">{{ $msg }}</p>
                @endforeach
            </div>
            {{-- Uraian pemakaian --}}
            <div class="field">
                <label for="uraian">Uraian</label>
                <input id="uraian" type="text" name="uraian" value="{{ old('uraian', $belanja->uraian) }}" required autocomplete="off">
                @foreach ((array) $errors->get('uraian') as $msg)
                    <p class="field-error" role="alert">{{ $msg }}</p>
                @endforeach
            </div>
            {{-- Nominal tampil bertitik, kirim angka polos via JS --}}
            <div class="field">
                <label for="nominal">Nominal (Rp)</label>
                <input id="nominal" type="text" name="nominal" inputmode="numeric" data-rupiah value="{{ old('nominal', $belanja->nominal) }}" required>
                @foreach ((array) $errors->get('nominal') as $msg)
                    <p class="field-error" role="alert">{{ $msg }}</p>
                @endforeach
            </div>
            {{-- Baris tombol simpan + batal --}}
            <div class="aksi-baris">
                <button type="submit" class="btn-simpan">Simpan Perubahan</button>
                <a class="btn-sekunder" href="{{ route('admin.belanja.index') }}">Batal</a>
            </div>
        </form>
    </section>
@endsection

{{-- JS khusus halaman ini dimuat via stack layout --}}
@push('scripts')
    @vite(['resources/js/admin/belanja/edit.js'])
@endpush
