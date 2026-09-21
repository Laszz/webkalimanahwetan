{{-- Halaman tambah penerima bantuan (pakai layout admin) --}}
@extends('layouts.admin')

{{-- Judul tab + judul bar atas --}}
@section('title', 'Tambah Penerima - Desa Kalimanah')

{{-- CSS + JS khusus halaman ini dimuat via stack layout --}}
@push('styles')
    @vite(['resources/css/admin/penerima-bantuan/create.css'])
@endpush

@section('content')
    {{-- Form tambah penerima --}}
    <section class="page-container-kecil" aria-labelledby="penerima-judul">
        <h1 id="penerima-judul">Tambah Penerima</h1>
        <p class="page-sub">Pilih warga terdaftar, bukan ketik manual.</p>

        {{-- Kirim ke store penerima bantuan --}}
        <form class="form-card" method="POST" action="{{ route('admin.penerima-bantuan.store') }}">
            @csrf
            {{-- Pilih program bantuan --}}
            <div class="field">
                <label for="jenis_bantuan_id">Program Bantuan</label>
                <select id="jenis_bantuan_id" name="jenis_bantuan_id" required>
                    <option value="" disabled selected>Pilih</option>
                    @foreach ($jenis as $item)
                        <option value="{{ $item->id }}" @selected((string) old('jenis_bantuan_id', request('jenis_bantuan')) === (string) $item->id)>{{ $item->nama }}</option>
                    @endforeach
                </select>
                @foreach ((array) $errors->get('jenis_bantuan_id') as $msg)
                    <p class="field-error" role="alert">{{ $msg }}</p>
                @endforeach
            </div>
            {{-- Pilih warga terdaftar --}}
            <div class="field">
                <label for="warga_id">Warga Penerima</label>
                <select id="warga_id" name="warga_id" required>
                    <option value="" disabled selected>Pilih</option>
                    @foreach ($wargas as $warga)
                        <option value="{{ $warga->id }}" @selected((string) old('warga_id') === (string) $warga->id)>{{ $warga->nama }}</option>
                    @endforeach
                </select>
                @foreach ((array) $errors->get('warga_id') as $msg)
                    <p class="field-error" role="alert">{{ $msg }}</p>
                @endforeach
            </div>
                {{-- Nominal rupiah; ketik polos, tampil bertitik otomatis --}}
                <div class="field">
                    <label for="nominal-tampil">Nominal (Rp)</label>
                    <input id="nominal-tampil" type="text" inputmode="numeric" value="{{ old('nominal') ? number_format(old('nominal'), 0, ',', '.') : '' }}" required autocomplete="off">
                    {{-- Nilai bersih tanpa titik untuk server --}}
                    <input id="nominal" type="hidden" name="nominal" value="{{ old('nominal') }}">
                    @foreach ((array) $errors->get('nominal') as $msg)
                        <p class="field-error" role="alert">{{ $msg }}</p>
                    @endforeach
                </div>
            {{-- Tahun penyaluran --}}
            <div class="field">
                <label for="tahun">Tahun</label>
                <input id="tahun" type="number" name="tahun" value="{{ old('tahun', date('Y')) }}" required min="2000" max="2100">
                @foreach ((array) $errors->get('tahun') as $msg)
                    <p class="field-error" role="alert">{{ $msg }}</p>
                @endforeach
            </div>
            {{-- Bulan penyaluran, kosong untuk tahunan --}}
            <div class="field">
                <label for="bulan">Bulan (kosongkan untuk tahunan)</label>
                <select id="bulan" name="bulan">
                    <option value="">Tahunan</option>
                    @for ($i = 1; $i <= 12; $i++)
                        <option value="{{ $i }}" @selected((string) old('bulan') === (string) $i)>{{ $i }}</option>
                    @endfor
                </select>
                @foreach ((array) $errors->get('bulan') as $msg)
                    <p class="field-error" role="alert">{{ $msg }}</p>
                @endforeach
            </div>
            {{-- Keterangan tambahan --}}
            <div class="field">
                <label for="keterangan">Keterangan</label>
                <textarea id="keterangan" name="keterangan" rows="3">{{ old('keterangan') }}</textarea>
                @foreach ((array) $errors->get('keterangan') as $msg)
                    <p class="field-error" role="alert">{{ $msg }}</p>
                @endforeach
            </div>
            {{-- Baris tombol simpan + batal --}}
            <div class="aksi-baris">
                <button type="submit" class="btn-simpan">Simpan</button>
                <a class="btn-sekunder" href="{{ route('admin.penerima-bantuan.index') }}">Batal</a>
            </div>
        </form>
    </section>
@endsection

{{-- JS khusus halaman ini dimuat via stack layout --}}
@push('scripts')
    @vite(['resources/js/admin/penerima-bantuan/create.js'])
@endpush
