<!DOCTYPE html>
{{-- Halaman lupa password - minta link reset via email --}}
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    {{-- Agar layout menyesuaikan lebar HP/tablet/desktop --}}
    <meta name="viewport" content="width=device-width, initial-scale=1">
    {{-- Token keamanan Laravel, wajib untuk form POST --}}
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Lupa Password - {{ config('app.name', 'Laravel') }}</title>
    {{-- Percepat koneksi ke server font sebelum CSS butuh fontnya --}}
    <link rel="preconnect" href="https://fonts.bunny.net">
    {{-- Muat CSS + JS khusus halaman lupa password via Vite --}}
    @vite(['resources/css/auth/forgot-password.css', 'resources/js/auth/forgot-password.js'])
</head>
<body>
{{-- <main> = landmark konten utama halaman (semantik, untuk screen reader) --}}
<main class="auth-wrap">
    {{-- Kartu form lupa password --}}
    <section class="auth-card" aria-labelledby="lupa-judul">
        <h1 id="lupa-judul">Lupa Password</h1>
        {{-- Penjelasan alur reset --}}
        <p class="auth-desc">Masukkan email akun, kami kirim link untuk membuat password baru.</p>
        {{-- Pesan sesi, mis. link reset terkirim --}}
        @if (session('status'))
            <p class="status-msg" role="status">{{ session('status') }}</p>
        @endif
        {{-- Kirim permintaan link reset ke route password.email --}}
        <form method="POST" action="{{ route('password.email') }}">
            @csrf
            {{-- Label selalu tampak di atas input (bukan placeholder) + error di bawah input --}}
            <label class="field-label" for="email">Email</label>
            <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="username" />
            @foreach ((array) $errors->get('email') as $msg)
                <p class="field-error" role="alert">{{ $msg }}</p>
            @endforeach
            {{-- Tombol kirim link reset --}}
            <button type="submit" class="solid">Kirim Link Reset</button>
        </form>
        {{-- Jalan kembali ke halaman masuk --}}
        <p class="auth-back"><a href="{{ route('login') }}">Kembali masuk</a></p>
    </section>
</main>
</body>
</html>
