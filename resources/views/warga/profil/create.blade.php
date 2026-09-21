{{-- Halaman isi biodata pertama kali (pakai layout warga) --}}
@extends('layouts.warga')

{{-- Judul tab browser --}}
@section('title', 'Isi Biodata - Desa Kalimanah')

{{-- CSS + JS khusus halaman ini dimuat via stack layout --}}
@push('styles')
    @vite(['resources/css/warga/profil/create.css'])
@endpush

@section('content')
    {{-- Form biodata pertama --}}
    <section class="page-container profil" aria-labelledby="profil-judul">
        <h1 id="profil-judul">Isi Biodata</h1>
        <p class="profil-sub">Lengkapi sekali, data dipakai untuk semua layanan.</p>

        {{-- Kirim ke store profil warga; enctype wajib agar file foto terkirim --}}
        <form class="form-card" method="POST" action="{{ route('warga.profil.store') }}" enctype="multipart/form-data">
            @csrf
            {{-- Kelompok identitas kependudukan --}}
            <fieldset class="form-grup">
                <legend>Data Kependudukan</legend>
                <div class="form-grid">
                    {{-- NIK 16 digit --}}
                    <div class="field">
                        <label for="nik">NIK</label>
                        <input id="nik" type="text" name="nik" value="{{ old('nik') }}" required inputmode="numeric" maxlength="16" autocomplete="off">
                        @foreach ((array) $errors->get('nik') as $msg)
                            <p class="field-error" role="alert">{{ $msg }}</p>
                        @endforeach
                    </div>
                    {{-- Nomor KK --}}
                    <div class="field">
                        <label for="no_kk">No. KK</label>
                        <input id="no_kk" type="text" name="no_kk" value="{{ old('no_kk') }}" required inputmode="numeric" maxlength="16" autocomplete="off">
                        @foreach ((array) $errors->get('no_kk') as $msg)
                            <p class="field-error" role="alert">{{ $msg }}</p>
                        @endforeach
                    </div>
                    {{-- Nama lengkap terisi otomatis dari nama akun saat daftar --}}
                    <div class="field">
                        <label for="nama">Nama Lengkap</label>
                        <input id="nama" type="text" name="nama" value="{{ old('nama', auth()->user()->name) }}" required autocomplete="name">
                        @foreach ((array) $errors->get('nama') as $msg)
                            <p class="field-error" role="alert">{{ $msg }}</p>
                        @endforeach
                    </div>
                    {{-- Tempat lahir --}}
                    <div class="field">
                        <label for="tempat_lahir">Tempat Lahir</label>
                        <input id="tempat_lahir" type="text" name="tempat_lahir" value="{{ old('tempat_lahir') }}" required autocomplete="off">
                        @foreach ((array) $errors->get('tempat_lahir') as $msg)
                            <p class="field-error" role="alert">{{ $msg }}</p>
                        @endforeach
                    </div>
                    {{-- Tanggal lahir --}}
                    <div class="field">
                        <label for="tanggal_lahir">Tanggal Lahir</label>
                        <input id="tanggal_lahir" type="date" name="tanggal_lahir" value="{{ old('tanggal_lahir') }}" required>
                        @foreach ((array) $errors->get('tanggal_lahir') as $msg)
                            <p class="field-error" role="alert">{{ $msg }}</p>
                        @endforeach
                    </div>
                    {{-- Jenis kelamin --}}
                    <div class="field">
                        <label for="jenis_kelamin">Jenis Kelamin</label>
                        <select id="jenis_kelamin" name="jenis_kelamin" required>
                            <option value="" disabled selected>Pilih</option>
                            <option value="L" @selected(old('jenis_kelamin') === 'L')>Laki-laki</option>
                            <option value="P" @selected(old('jenis_kelamin') === 'P')>Perempuan</option>
                        </select>
                        @foreach ((array) $errors->get('jenis_kelamin') as $msg)
                            <p class="field-error" role="alert">{{ $msg }}</p>
                        @endforeach
                    </div>
                </div>
            </fieldset>
            {{-- Kelompok alamat domisili --}}
            <fieldset class="form-grup">
                <legend>Alamat Domisili</legend>
                <div class="form-grid">
                    {{-- Alamat lengkap --}}
                    <div class="field field-penuh">
                        <label for="alamat">Alamat</label>
                        <input id="alamat" type="text" name="alamat" value="{{ old('alamat') }}" required autocomplete="street-address">
                        @foreach ((array) $errors->get('alamat') as $msg)
                            <p class="field-error" role="alert">{{ $msg }}</p>
                        @endforeach
                    </div>
                    {{-- RT --}}
                    <div class="field">
                        <label for="rt">RT</label>
                        <input id="rt" type="text" name="rt" value="{{ old('rt') }}" required inputmode="numeric" maxlength="3" autocomplete="off">
                        @foreach ((array) $errors->get('rt') as $msg)
                            <p class="field-error" role="alert">{{ $msg }}</p>
                        @endforeach
                    </div>
                    {{-- RW --}}
                    <div class="field">
                        <label for="rw">RW</label>
                        <input id="rw" type="text" name="rw" value="{{ old('rw') }}" required inputmode="numeric" maxlength="3" autocomplete="off">
                        @foreach ((array) $errors->get('rw') as $msg)
                            <p class="field-error" role="alert">{{ $msg }}</p>
                        @endforeach
                    </div>
                </div>
            </fieldset>
            {{-- Kelompok data tambahan --}}
            <fieldset class="form-grup">
                <legend>Data Tambahan</legend>
                <div class="form-grid">
                    {{-- Agama pilihan --}}
                    <div class="field">
                        <label for="agama">Agama</label>
                        <select id="agama" name="agama" required>
                            <option value="" disabled selected>Pilih</option>
                            <option value="Islam" @selected(old('agama') === 'Islam')>Islam</option>
                            <option value="Kristen" @selected(old('agama') === 'Kristen')>Kristen</option>
                            <option value="Katolik" @selected(old('agama') === 'Katolik')>Katolik</option>
                            <option value="Hindu" @selected(old('agama') === 'Hindu')>Hindu</option>
                            <option value="Buddha" @selected(old('agama') === 'Buddha')>Buddha</option>
                            <option value="Konghucu" @selected(old('agama') === 'Konghucu')>Konghucu</option>
                        </select>
                        @foreach ((array) $errors->get('agama') as $msg)
                            <p class="field-error" role="alert">{{ $msg }}</p>
                        @endforeach
                    </div>
                    {{-- Status pernikahan pilihan --}}
                    <div class="field">
                        <label for="status_kawin">Status Pernikahan</label>
                        <select id="status_kawin" name="status_kawin" required>
                            <option value="" disabled selected>Pilih</option>
                            <option value="Belum Menikah" @selected(old('status_kawin') === 'Belum Menikah')>Belum Menikah</option>
                            <option value="Menikah" @selected(old('status_kawin') === 'Menikah')>Menikah</option>
                            <option value="Cerai Hidup" @selected(old('status_kawin') === 'Cerai Hidup')>Cerai Hidup</option>
                            <option value="Cerai Mati" @selected(old('status_kawin') === 'Cerai Mati')>Cerai Mati</option>
                        </select>
                        @foreach ((array) $errors->get('status_kawin') as $msg)
                            <p class="field-error" role="alert">{{ $msg }}</p>
                        @endforeach
                    </div>
                    {{-- Pekerjaan --}}
                    <div class="field">
                        <label for="pekerjaan">Pekerjaan</label>
                        <input id="pekerjaan" type="text" name="pekerjaan" value="{{ old('pekerjaan') }}" autocomplete="off">
                        @foreach ((array) $errors->get('pekerjaan') as $msg)
                            <p class="field-error" role="alert">{{ $msg }}</p>
                        @endforeach
                    </div>
                    {{-- Nomor telepon --}}
                    <div class="field">
                        <label for="telepon">No. Telepon</label>
                        <input id="telepon" type="text" name="telepon" value="{{ old('telepon') }}" inputmode="tel" maxlength="20" autocomplete="tel">
                        @foreach ((array) $errors->get('telepon') as $msg)
                            <p class="field-error" role="alert">{{ $msg }}</p>
                        @endforeach
                    </div>
                    {{-- Foto profil --}}
                    <div class="field">
                        <label for="foto">Foto Profil</label>
                        <input id="foto" type="file" name="foto" accept="image/jpeg,image/png">
                        @foreach ((array) $errors->get('foto') as $msg)
                            <p class="field-error" role="alert">{{ $msg }}</p>
                        @endforeach
                    </div>
                </div>
            </fieldset>
            {{-- Tombol simpan --}}
            <button type="submit" class="btn-simpan">Simpan Biodata</button>
        </form>
    </section>
@endsection

{{-- JS khusus halaman ini dimuat via stack layout --}}
@push('scripts')
    @vite(['resources/js/warga/profil/create.js'])
@endpush
