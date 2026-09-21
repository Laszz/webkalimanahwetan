{{-- Halaman unggah template hasil (pakai layout admin) --}}
@extends('layouts.admin')

{{-- Judul tab + judul bar atas --}}
@section('title', 'Unggah Template - Desa Kalimanah')

{{-- CSS + JS khusus halaman ini dimuat via stack layout --}}
@push('styles')
    @vite(['resources/css/admin/template/create.css'])
@endpush

@section('content')
    {{-- Form unggah template Word per layanan --}}
    <section class="page-container-kecil" aria-labelledby="template-judul">
        <h1 id="template-judul">Unggah Template</h1>
        <p class="page-sub">Satu layanan satu template Word (.doc/.docx, maks 5MB).</p>

        {{-- Kirim ke store template --}}
        <form class="form-card" method="POST" action="{{ route('admin.template.store') }}" enctype="multipart/form-data">
            @csrf
            {{-- Layanan yang belum punya template --}}
            <div class="field">
                <label for="layanan_id">Layanan</label>
                <select id="layanan_id" name="layanan_id" required>
                    <option value="" disabled {{ old('layanan_id') ? '' : 'selected' }}>Pilih layanan</option>
                    @foreach ($layanans as $layanan)
                        <option value="{{ $layanan->id }}" {{ (string) old('layanan_id') === (string) $layanan->id ? 'selected' : '' }}>{{ $layanan->nama }}</option>
                    @endforeach
                </select>
                @if ($layanans->isEmpty())
                    <p class="field-info">Semua layanan sudah punya template.</p>
                @endif
                @foreach ((array) $errors->get('layanan_id') as $msg)
                    <p class="field-error" role="alert">{{ $msg }}</p>
                @endforeach
            </div>
            {{-- File Word resmi --}}
            <div class="field">
                <label for="file">File Word</label>
                <input id="file" type="file" name="file" accept=".doc,.docx" required>
                @foreach ((array) $errors->get('file') as $msg)
                    <p class="field-error" role="alert">{{ $msg }}</p>
                @endforeach
            </div>
            {{-- Variabel yang bisa dipakai di isi Word, tulis mis. @{{ nama }} --}}
            <div class="field-info">
                <strong>Variabel template:</strong>
                @{{ nama }} @{{ nik }} @{{ no_kk }} @{{ tempat_lahir }} @{{ tanggal_lahir }} @{{ jenis_kelamin }} @{{ alamat }} @{{ rt }} @{{ rw }} @{{ agama }} @{{ status_kawin }} @{{ pekerjaan }} @{{ telepon }}                 @{{ keperluan }} @{{ nama_layanan }} @{{ nomor_surat }} @{{ tanggal_surat }} @{{ nama_kepala_desa }} @{{ alamat_desa }} @{{ kode_pos_desa }} @{{ telepon_desa }} @{{ email_desa }}
            </div>
            {{-- Baris tombol simpan + batal --}}
            <div class="aksi-baris">
                <button type="submit" class="btn-simpan">Simpan</button>
                <a class="btn-sekunder" href="{{ route('admin.template.index') }}">Batal</a>
            </div>
        </form>
    </section>
@endsection

{{-- JS khusus halaman ini dimuat via stack layout --}}
@push('scripts')
    @vite(['resources/js/admin/template/create.js'])
@endpush
