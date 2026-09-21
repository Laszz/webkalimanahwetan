<!DOCTYPE html>
{{-- Halaman konfirmasi password - kunci area aman sebelum lanjut --}}
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    {{-- Agar layout menyesuaikan lebar HP/tablet/desktop --}}
    <meta name="viewport" content="width=device-width, initial-scale=1">
    {{-- Token keamanan Laravel, wajib untuk form POST --}}
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Konfirmasi Password - {{ config('app.name', 'Laravel') }}</title>
    {{-- Percepat koneksi ke server font sebelum CSS butuh fontnya --}}
    <link rel="preconnect" href="https://fonts.bunny.net">
    {{-- Muat CSS + JS khusus halaman konfirmasi password via Vite --}}
    @vite(['resources/css/auth/confirm-password.css', 'resources/js/auth/confirm-password.js'])
</head>
<body>
{{-- <main> = landmark konten utama halaman (semantik, untuk screen reader) --}}
<main class="auth-wrap">
    {{-- Kartu form konfirmasi password --}}
    <section class="auth-card" aria-labelledby="konfirmasi-judul">
        <h1 id="konfirmasi-judul">Konfirmasi Password</h1>
        {{-- Penjelasan mengapa diminta ulang --}}
        <p class="auth-desc">Area aman. Masukkan password sekali lagi untuk lanjut.</p>
        {{-- Kirim konfirmasi ke route password.confirm --}}
        <form method="POST" action="{{ route('password.confirm') }}">
            @csrf
            {{-- Label selalu tampak di atas input (bukan placeholder) + error di bawah input --}}
            <label class="field-label" for="password">Password</label>
            <input id="password" type="password" name="password" required autocomplete="current-password" />
            @foreach ((array) $errors->get('password') as $msg)
                <p class="field-error" role="alert">{{ $msg }}</p>
            @endforeach
            {{-- Tombol konfirmasi --}}
            <button type="submit" class="solid">Konfirmasi</button>
        </form>
        {{-- Jalan kembali ke beranda --}}
        <p class="auth-back"><a href="{{ url('/') }}">Kembali ke beranda</a></p>
    </section>
</main>
</body>
</html>
