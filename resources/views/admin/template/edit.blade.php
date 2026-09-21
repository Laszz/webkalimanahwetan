{{-- Halaman ubah template hasil (pakai layout admin) --}}
@extends('layouts.admin')

{{-- Judul tab + judul bar atas --}}
@section('title', 'Ubah Template - Desa Kalimanah')

{{-- CSS + JS khusus halaman ini dimuat via stack layout --}}
@push('styles')
    @vite(['resources/css/admin/template/edit.css'])
@endpush

@section('content')
    {{-- Form ganti file / ubah status pakai --}}
    <section class="page-container-kecil" aria-labelledby="template-judul">
        <h1 id="template-judul">Ubah Template</h1>
        <p class="page-sub">Template layanan {{ $template->layanan->nama ?? '-' }}.</p>

        {{-- Kirim perubahan ke update template --}}
        <form class="form-card" method="POST" action="{{ route('admin.template.update', $template) }}" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            {{-- File Word baru, kosongkan jika pakai file lama --}}
            <div class="field">
                <label for="file">File Word Baru (kosongkan jika tidak diganti)</label>
                <input id="file" type="file" name="file" accept=".doc,.docx">
                @foreach ((array) $errors->get('file') as $msg)
                    <p class="field-error" role="alert">{{ $msg }}</p>
                @endforeach
            </div>
            {{-- Centang = template dipakai, lepas = nonaktif --}}
            <div class="field-ceklis">
                <input id="aktif" type="checkbox" name="aktif" value="1" {{ old('aktif', $template->aktif) ? 'checked' : '' }}>
                <label for="aktif">Aktif (dipakai untuk hasil pengajuan)</label>
            </div>
            {{-- Baris tombol simpan + batal --}}
            {{-- Variabel yang bisa dipakai di isi Word, tulis mis. @{{ nama }} --}}
            <div class="field-info">
                <strong>Variabel template:</strong>
                @{{ nama }} @{{ nik }} @{{ no_kk }} @{{ tempat_lahir }} @{{ tanggal_lahir }} @{{ jenis_kelamin }} @{{ alamat }} @{{ rt }} @{{ rw }} @{{ agama }} @{{ status_kawin }} @{{ pekerjaan }} @{{ telepon }}                 @{{ keperluan }} @{{ nama_layanan }} @{{ nomor_surat }} @{{ tanggal_surat }} @{{ nama_kepala_desa }} @{{ alamat_desa }} @{{ kode_pos_desa }} @{{ telepon_desa }} @{{ email_desa }}
            </div>
            <div class="aksi-baris">
                <button type="submit" class="btn-simpan">Simpan Perubahan</button>
                <a class="btn-sekunder" href="{{ route('admin.template.index') }}">Batal</a>
            </div>
        </form>
    </section>
@endsection

{{-- JS khusus halaman ini dimuat via stack layout --}}
@push('scripts')
    @vite(['resources/js/admin/template/edit.js'])
@endpush
