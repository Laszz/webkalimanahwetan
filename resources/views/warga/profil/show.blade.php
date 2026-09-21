{{-- Halaman profil warga - lihat biodata sendiri (pakai layout warga) --}}
@extends('layouts.warga')

{{-- Judul tab browser --}}
@section('title', 'Profil Saya - Desa Kalimanah')

{{-- CSS + JS khusus halaman ini dimuat via stack layout --}}
@push('styles')
    @vite(['resources/css/warga/profil/show.css'])
@endpush

@section('content')
    {{-- Biodata diri --}}
    <section class="page-container profil" aria-labelledby="profil-judul">
        <h1 id="profil-judul">Profil Saya</h1>
        <p class="profil-sub">Biodata kependudukan terdaftar atas akun ini.</p>

        {{-- Foto profil jika sudah diunggah --}}
        @if ($warga->foto)
            <figure class="profil-foto">
                <img src="{{ asset('storage/' . $warga->foto) }}" alt="Foto {{ $warga->nama }}">
            </figure>
        @endif

        {{-- Daftar isi biodata --}}
        <dl class="profil-card">
            <div><dt>Nama</dt><dd>{{ $warga->nama }}</dd></div>
            <div><dt>NIK</dt><dd>{{ $warga->nik }}</dd></div>
            <div><dt>No. KK</dt><dd>{{ $warga->no_kk }}</dd></div>
            <div><dt>Tempat, Tanggal Lahir</dt><dd>{{ $warga->tempat_lahir ?? '-' }}, {{ $warga->tanggal_lahir?->format('d M Y') ?? '-' }}</dd></div>
            <div><dt>Jenis Kelamin</dt><dd>{{ $warga->jenis_kelamin === 'L' ? 'Laki-laki' : 'Perempuan' }}</dd></div>
            <div><dt>Alamat</dt><dd>{{ $warga->alamat }}, RT {{ $warga->rt }}/RW {{ $warga->rw }}</dd></div>
            <div><dt>Agama</dt><dd>{{ $warga->agama }}</dd></div>
            <div><dt>Status Pernikahan</dt><dd>{{ $warga->status_kawin }}</dd></div>
            <div><dt>Pekerjaan</dt><dd>{{ $warga->pekerjaan ?? '-' }}</dd></div>
            <div><dt>No. Telepon</dt><dd>{{ $warga->telepon ?? '-' }}</dd></div>
        </dl>

        {{-- Tombol ubah biodata --}}
        <div class="aksi-baris">
            <a class="btn-profil" href="{{ route('warga.profil.edit') }}">Ubah Biodata</a>
        </div>

        {{-- Form ganti password akun (pakai rute Breeze password.update) --}}
        <h2 class="profil-label" id="ganti-password">Ganti Password</h2>
        <form class="form-card" method="POST" action="{{ route('password.update') }}">
            @csrf
            @method('PUT')
            {{-- Password lama untuk verifikasi pemilik akun; salah = popup, bukan teks Inggris --}}
            <div class="field">
                <label for="current_password">Password Lama</label>
                <div class="field-password">
                    <input id="current_password" type="password" name="current_password" required autocomplete="current-password">
                    <button type="button" class="lihat-password" aria-label="Tampilkan password lama"><i class="ph ph-eye" aria-hidden="true"></i></button>
                </div>
            </div>
            {{-- Password baru; sama dengan lama = popup, galat lain = teks di bawah --}}
            <div class="field">
                <label for="password">Password Baru</label>
                <div class="field-password">
                    <input id="password" type="password" name="password" required autocomplete="new-password">
                    <button type="button" class="lihat-password" aria-label="Tampilkan password baru"><i class="ph ph-eye" aria-hidden="true"></i></button>
                </div>
                {{-- Galat konfirmasi tampil di sini; min 8 + sama-dengan-lama tampil sebagai popup di bawah --}}
                @if ($errors->updatePassword->first('password') === 'Konfirmasi password baru tidak cocok.')
                    <p class="field-error" role="alert">Konfirmasi password baru tidak cocok.</p>
                @endif
            </div>
            {{-- Ulangi password baru --}}
            <div class="field">
                <label for="password_confirmation">Konfirmasi Password Baru</label>
                <div class="field-password">
                    <input id="password_confirmation" type="password" name="password_confirmation" required autocomplete="new-password">
                    <button type="button" class="lihat-password" aria-label="Tampilkan konfirmasi password"><i class="ph ph-eye" aria-hidden="true"></i></button>
                </div>
            </div>
            <button type="submit" class="btn-profil">Ubah Password</button>
        </form>

        {{-- Popup: password lama salah --}}
        @if ($errors->updatePassword->has('current_password'))
            <div class="popup" id="popup" role="alertdialog" aria-modal="true" aria-label="Password salah">
                <div class="popup-kartu">
                    <i class="ph ph-warning-circle popup-gagal" aria-hidden="true"></i>
                    <p>Password lama anda salah.</p>
                    <button type="button" class="btn-kecil btn-setuju" data-tutup>Tutup</button>
                </div>
            </div>
        {{-- Popup: password baru sama dengan lama --}}
        @elseif ($errors->updatePassword->first('password') === 'Password baru harus berbeda dari password lama.')
            <div class="popup" id="popup" role="alertdialog" aria-modal="true" aria-label="Password sama">
                <div class="popup-kartu">
                    <i class="ph ph-warning-circle popup-gagal" aria-hidden="true"></i>
                    <p>Ganti dengan password yang berbeda dari password lama.</p>
                    <button type="button" class="btn-kecil btn-setuju" data-tutup>Tutup</button>
                </div>
            </div>
        {{-- Popup: password baru kurang dari 8 karakter --}}
        @elseif ($errors->updatePassword->first('password') === 'Password baru minimal 8 karakter.')
            <div class="popup" id="popup" role="alertdialog" aria-modal="true" aria-label="Password pendek">
                <div class="popup-kartu">
                    <i class="ph ph-warning-circle popup-gagal" aria-hidden="true"></i>
                    <p>Password baru minimal 8 karakter.</p>
                    <button type="button" class="btn-kecil btn-setuju" data-tutup>Tutup</button>
                </div>
            </div>
        {{-- Popup: password berhasil diubah --}}
        @elseif (session('status') === 'password-updated')
            <div class="popup" id="popup" role="alertdialog" aria-modal="true" aria-label="Password berubah">
                <div class="popup-kartu">
                    <i class="ph ph-check-circle popup-ok" aria-hidden="true"></i>
                    <p>Password anda sudah berubah.</p>
                    <button type="button" class="btn-kecil btn-setuju" data-tutup>Tutup</button>
                </div>
            </div>
        @endif
    </section>
@endsection

{{-- JS khusus halaman ini dimuat via stack layout --}}
@push('scripts')
    @vite(['resources/js/warga/profil/show.js'])
@endpush
