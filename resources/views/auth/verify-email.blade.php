<!DOCTYPE html>
{{-- Halaman verifikasi email - minta tautan verifikasi setelah daftar --}}
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    {{-- Agar layout menyesuaikan lebar HP/tablet/desktop --}}
    <meta name="viewport" content="width=device-width, initial-scale=1">
    {{-- Token keamanan Laravel, wajib untuk form POST --}}
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Verifikasi Email - {{ config('app.name', 'Laravel') }}</title>
    {{-- Percepat koneksi ke server font sebelum CSS butuh fontnya --}}
    <link rel="preconnect" href="https://fonts.bunny.net">
    {{-- Muat CSS + JS khusus halaman verifikasi email via Vite --}}
    @vite(['resources/css/auth/verify-email.css', 'resources/js/auth/verify-email.js'])
</head>
<body>
{{-- <main> = landmark konten utama halaman (semantik, untuk screen reader) --}}
<main class="auth-wrap">
    {{-- Kartu info verifikasi email --}}
    <section class="auth-card" aria-labelledby="verifikasi-judul">
        <h1 id="verifikasi-judul">Verifikasi Email</h1>
        {{-- Penjelasan alur verifikasi --}}
        <p class="auth-desc">Terima kasih sudah daftar. Klik tautan di email untuk verifikasi, atau kirim ulang di bawah.</p>
        {{-- Pesan sesi jika link baru saja dikirim --}}
        @if (session('status') == 'verification-link-sent')
            <p class="status-msg" role="status">Tautan verifikasi baru terkirim ke emailmu.</p>
        @endif
        {{-- Baris dua aksi: kirim ulang + keluar --}}
        <div class="auth-row">
            {{-- Kirim ulang email verifikasi --}}
            <form method="POST" action="{{ route('verification.send') }}">
                @csrf
                <button type="submit" class="solid">Kirim Ulang</button>
            </form>
            {{-- Keluar dari akun --}}
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="link-btn">Keluar</button>
            </form>
        </div>
    </section>
</main>
</body>
</html>
