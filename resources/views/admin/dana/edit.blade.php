{{-- Halaman ubah dana APBDes (pakai layout admin) --}}
@extends('layouts.admin')

{{-- Judul tab + judul bar atas --}}
@section('title', 'Ubah Dana - Desa Kalimanah')

{{-- CSS + JS khusus halaman ini dimuat via stack layout --}}
@push('styles')
    @vite(['resources/css/admin/dana/edit.css'])
@endpush

@section('content')
    {{-- Form ubah terisi data lama --}}
    <section class="page-container-kecil" aria-labelledby="dana-judul">
        <h1 id="dana-judul">Ubah Dana</h1>
        <p class="page-sub">Perbarui pagu {{ $dana->sumber_dana }} tahun {{ $dana->tahun }}.</p>

        {{-- Kirim perubahan ke update dana --}}
        <form class="form-card" method="POST" action="{{ route('admin.dana.update', $dana) }}">
            @csrf
            @method('PUT')
            {{-- Tahun anggaran --}}
            <div class="field">
                <label for="tahun">Tahun</label>
                <input id="tahun" type="number" name="tahun" min="2000" max="2100" value="{{ old('tahun', $dana->tahun) }}" required>
                @foreach ((array) $errors->get('tahun') as $msg)
                    <p class="field-error" role="alert">{{ $msg }}</p>
                @endforeach
            </div>
            {{-- Sumber dana baku --}}
            <div class="field">
                <label for="sumber_dana">Sumber Dana</label>
                <select id="sumber_dana" name="sumber_dana" required>
                    @foreach (\App\Models\Dana::SUMBER as $opsi)
                        <option value="{{ $opsi }}" {{ old('sumber_dana', $dana->sumber_dana) === $opsi ? 'selected' : '' }}>{{ $opsi }}</option>
                    @endforeach
                </select>
                @foreach ((array) $errors->get('sumber_dana') as $msg)
                    <p class="field-error" role="alert">{{ $msg }}</p>
                @endforeach
            </div>
            {{-- Pagu tampil bertitik, kirim angka polos via JS; tidak boleh di bawah terpakai --}}
            <div class="field">
                <label for="anggaran">Anggaran (Rp)</label>
                <input id="anggaran" type="text" name="anggaran" inputmode="numeric" data-rupiah value="{{ old('anggaran', $dana->anggaran) }}" required>
                @foreach ((array) $errors->get('anggaran') as $msg)
                    <p class="field-error" role="alert">{{ $msg }}</p>
                @endforeach
            </div>
            {{-- Baris tombol simpan + batal --}}
            <div class="aksi-baris">
                <button type="submit" class="btn-simpan">Simpan Perubahan</button>
                <a class="btn-sekunder" href="{{ route('admin.dana.index') }}">Batal</a>
            </div>
        </form>
    </section>
@endsection

{{-- JS khusus halaman ini dimuat via stack layout --}}
@push('scripts')
    @vite(['resources/js/admin/dana/edit.js'])
@endpush
