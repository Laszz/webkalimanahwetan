<!DOCTYPE html>
{{-- Halaman REGISTER - satu layar berisi form daftar + form masuk + panel biru geser --}}
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    {{-- Agar layout menyesuaikan lebar HP/tablet/desktop --}}
    <meta name="viewport" content="width=device-width, initial-scale=1">
    {{-- Token keamanan Laravel, wajib untuk form POST --}}
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Register - {{ config('app.name', 'Laravel') }}</title>
    {{-- Percepat koneksi ke server font sebelum CSS butuh fontnya --}}
    <link rel="preconnect" href="https://fonts.bunny.net">
    {{-- Ikon Phosphor untuk tombol mata intip password (satu keluarga ikon seluruh situs) --}}
    <link rel="stylesheet" href="https://unpkg.com/@phosphor-icons/web@2.1.1/src/regular/style.css">
    {{-- Muat CSS + JS khusus halaman register via Vite --}}
    @vite(['resources/css/auth/register.css', 'resources/js/auth/register.js'])
</head>
<body>

{{-- Tentukan panel yg tampil: ikut form yg terakhir di-submit, default-nya form daftar (register) --}}
@php($activeForm = old('auth_form', 'register'))
{{-- <main> = landmark konten utama halaman (semantik, untuk screen reader) --}}
<main class="auth-wrap">
    {{-- Kartu putih besar; class right-panel-active = posisi slider di sisi daftar --}}
    <div class="container {{ $activeForm === 'register' ? 'right-panel-active' : '' }}" id="container" data-active-form="{{ $activeForm }}">
        {{-- PANEL DAFTAR (tampil default di halaman register) --}}
        <section class="form-container sign-up-container" aria-label="Formulir pendaftaran">
            {{-- Kirim data pendaftaran ke route register --}}
            <form method="POST" action="{{ route('register') }}">
                {{-- Token anti-CSRF + penanda "form ini yg di-submit" (agar error dan panel tidak nyasar) --}}
                @csrf
                <input type="hidden" name="auth_form" value="register" />
                <h1 class="form-title">Buat Akun</h1>
                {{-- Peringatan umum jika validasi pendaftaran gagal --}}
                @if ($activeForm === 'register' && $errors->any())
                    <p class="status-msg" role="status">Periksa kembali data pendaftaran.</p>
                @endif
                {{-- Label selalu tampak di atas input (bukan placeholder) + error di bawah input --}}
                <label class="field-label" for="reg_name">Nama</label>
                <input id="reg_name" type="text" name="name" value="{{ $activeForm === 'register' ? old('name') : '' }}" required autofocus autocomplete="name" />
                @if ($activeForm === 'register')
                    @foreach ((array) $errors->get('name') as $msg)
                        <p class="field-error" role="alert">{{ $msg }}</p>
                    @endforeach
                @endif
                <label class="field-label" for="reg_email">Email</label>
                <input id="reg_email" type="email" name="email" value="{{ $activeForm === 'register' ? old('email') : '' }}" required autocomplete="username" />
                @if ($activeForm === 'register')
                    @foreach ((array) $errors->get('email') as $msg)
                        <p class="field-error" role="alert">{{ $msg }}</p>
                    @endforeach
                @endif
                {{-- Kolom password (ikon mata dipasang otomatis oleh JS) --}}
                <label class="field-label" for="reg_password">Password</label>
                <input id="reg_password" type="password" name="password" required autocomplete="new-password" />
                @if ($activeForm === 'register')
                    @foreach ((array) $errors->get('password') as $msg)
                        <p class="field-error" role="alert">{{ $msg }}</p>
                    @endforeach
                @endif
                {{-- Kolom konfirmasi password (wajib cocok dengan password) --}}
                <label class="field-label" for="password_confirmation">Konfirmasi Password</label>
                <input id="password_confirmation" type="password" name="password_confirmation" required autocomplete="new-password" />
                <div style="height:10px"></div>
                {{-- Tombol kirim pendaftaran --}}
                <button type="submit" class="solid">Daftar</button>
                {{-- Link pindah ke form masuk - khusus tampil di HP (pengganti panel biru) --}}
                <p class="mobile-switch"><a href="{{ route('login') }}" data-show="login">Sudah punya akun? Masuk</a></p>
            </form>
        </section>

        {{-- PANEL MASUK (tersembunyi, muncul saat slider digeser) --}}
        <section class="form-container sign-in-container" aria-label="Formulir masuk">
            {{-- Kirim data masuk ke route login --}}
            <form method="POST" action="{{ route('login') }}">
                @csrf
                <input type="hidden" name="auth_form" value="login" />
                <h1 class="form-title">Selamat Datang</h1>
                {{-- Pesan sesi, mis. link reset password terkirim --}}
                @if (session('status'))
                    <p class="status-msg" role="status">{{ session('status') }}</p>
                @endif
                <label class="field-label" for="email">Email</label>
                <input id="email" type="email" name="email" value="{{ $activeForm === 'login' ? old('email') : '' }}" required autocomplete="username" />
                @if ($activeForm === 'login')
                    @foreach ((array) $errors->get('email') as $msg)
                        <p class="field-error" role="alert">{{ $msg }}</p>
                    @endforeach
                @endif
                {{-- Kolom password (ikon mata dipasang otomatis oleh JS) --}}
                <label class="field-label" for="password">Password</label>
                <input id="password" type="password" name="password" required autocomplete="current-password" />
                @if ($activeForm === 'login')
                    @foreach ((array) $errors->get('password') as $msg)
                        <p class="field-error" role="alert">{{ $msg }}</p>
                    @endforeach
                @endif
                {{-- Baris "ingat saya" + link lupa password --}}
                <div class="remember-row">
                    <label for="remember_me"><input id="remember_me" type="checkbox" name="remember" style="width:auto;margin:0"> Ingat saya</label>
                    @if (Route::has('password.request'))
                        <a href="{{ route('password.request') }}">Lupa password?</a>
                    @endif
                </div>
                <div style="height:10px"></div>
                {{-- Tombol kirim masuk --}}
                <button type="submit" class="solid">Masuk</button>
                {{-- Link pindah ke form daftar - khusus tampil di HP --}}
                <p class="mobile-switch"><a href="{{ route('register') }}" data-show="register">Belum punya akun? Daftar</a></p>
            </form>
        </section>

        {{-- PANEL BIRU GESER (overlay) - tombolnya animasi slide dulu baru pindah halaman --}}
        <div class="overlay-container">
            <div class="overlay">
                {{-- Sisi kiri overlay: ajakan masuk (terlihat saat panel daftar aktif) --}}
                <div class="overlay-panel overlay-left">
                    <h1>Selamat Datang</h1>
                    <p>Masuk untuk mengakses layanan Desa Kalimanah</p>
                    <a class="ghost" data-show="login" href="{{ route('login') }}">Masuk</a>
                </div>
                {{-- Sisi kanan overlay: ajakan daftar (terlihat saat panel masuk aktif) --}}
                <div class="overlay-panel overlay-right">
                    <h1>Halo, Warga!</h1>
                    <p>Daftarkan akun untuk mengakses layanan Desa Kalimanah</p>
                    <a class="ghost" data-show="register" href="{{ route('register') }}">Daftar</a>
                </div>
            </div>
        </div>
    </div>
</main>
</body>
</html>
