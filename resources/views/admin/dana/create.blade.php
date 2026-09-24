{{-- Halaman tambah dana APBDes (pakai layout admin) --}}
@extends('layouts.admin')

{{-- Judul tab + judul bar atas --}}
@section('title', 'Tambah Dana - Desa Kalimanah')

{{-- CSS + JS khusus halaman ini dimuat via stack layout --}}
@push('styles')
    @vite(['resources/css/admin/dana/create.css'])
@endpush

@section('content')
    {{-- Form tambah pagu dana --}}
    <section class="page-container-kecil" aria-labelledby="dana-judul">
        <h1 id="dana-judul">Tambah Dana</h1>
        <p class="page-sub">Satu sumber satu pagu per tahun.</p>

        {{-- Kirim ke store dana --}}
        <form class="form-card" method="POST" action="{{ route('admin.dana.store') }}">
            @csrf
            {{-- Tahun anggaran --}}
            <div class="field">
                <label for="tahun">Tahun</label>
                <input id="tahun" type="number" name="tahun" min="2000" max="2100" value="{{ old('tahun', date('Y')) }}" required>
                @foreach ((array) $errors->get('tahun') as $msg)
                    <p class="field-error" role="alert">{{ $msg }}</p>
                @endforeach
            </div>
            {{-- Sumber dana baku --}}
            <div class="field">
                <label for="sumber_dana">Sumber Dana</label>
                <select id="sumber_dana" name="sumber_dana" required>
                    <option value="" disabled {{ old('sumber_dana') ? '' : 'selected' }}>Pilih sumber dana</option>
                    @foreach (\App\Models\Dana::SUMBER as $opsi)
                        <option value="{{ $opsi }}" {{ old('sumber_dana') === $opsi ? 'selected' : '' }}>{{ $opsi }}</option>
                    @endforeach
                </select>
                @foreach ((array) $errors->get('sumber_dana') as $msg)
                    <p class="field-error" role="alert">{{ $msg }}</p>
                @endforeach
            </div>
            {{-- Pagu tampil bertitik, kirim angka polos via JS --}}
            <div class="field">
                <label for="anggaran">Anggaran (Rp)</label>
                <input id="anggaran" type="text" name="anggaran" inputmode="numeric" data-rupiah value="{{ old('anggaran') }}" required placeholder="cth. 100.000.000">
                @foreach ((array) $errors->get('anggaran') as $msg)
                    <p class="field-error" role="alert">{{ $msg }}</p>
                @endforeach
            </div>
            {{-- Baris tombol simpan + batal --}}
            <div class="aksi-baris">
                <button type="submit" class="btn-simpan">Simpan</button>
                <a class="btn-sekunder" href="{{ route('admin.dana.index') }}">Batal</a>
            </div>
        </form>
    </section>
@endsection

{{-- JS khusus halaman ini dimuat via stack layout --}}
@push('scripts')
    @vite(['resources/js/admin/dana/create.js'])
@endpush
