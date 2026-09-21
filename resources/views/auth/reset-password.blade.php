<!DOCTYPE html>
{{-- Halaman atur ulang password - buat password baru dari link email --}}
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    {{-- Agar layout menyesuaikan lebar HP/tablet/desktop --}}
    <meta name="viewport" content="width=device-width, initial-scale=1">
    {{-- Token keamanan Laravel, wajib untuk form POST --}}
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Atur Ulang Password - {{ config('app.name', 'Laravel') }}</title>
    {{-- Percepat koneksi ke server font sebelum CSS butuh fontnya --}}
    <link rel="preconnect" href="https://fonts.bunny.net">
    {{-- Muat CSS + JS khusus halaman atur ulang password via Vite --}}
    @vite(['resources/css/auth/reset-password.css', 'resources/js/auth/reset-password.js'])
</head>
<body>
{{-- <main> = landmark konten utama halaman (semantik, untuk screen reader) --}}
<main class="auth-wrap">
    {{-- Kartu form atur ulang password --}}
    <section class="auth-card" aria-labelledby="reset-judul">
        <h1 id="reset-judul">Atur Ulang Password</h1>
        {{-- Penjelasan singkat --}}
        <p class="auth-desc">Buat password baru untuk akunmu.</p>
        {{-- Kirim password baru ke route password.store --}}
        <form method="POST" action="{{ route('password.store') }}">
            @csrf
            {{-- Token reset dari link email (tersembunyi) --}}
            <input type="hidden" name="token" value="{{ $request->route('token') }}">
            {{-- Label selalu tampak di atas input (bukan placeholder) + error di bawah input --}}
            <label class="field-label" for="email">Email</label>
            <input id="email" type="email" name="email" value="{{ old('email', $request->email) }}" required autofocus autocomplete="username" />
            @foreach ((array) $errors->get('email') as $msg)
                <p class="field-error" role="alert">{{ $msg }}</p>
            @endforeach
            <label class="field-label" for="password">Password Baru</label>
            <input id="password" type="password" name="password" required autocomplete="new-password" />
            @foreach ((array) $errors->get('password') as $msg)
                <p class="field-error" role="alert">{{ $msg }}</p>
            @endforeach
            {{-- Kolom konfirmasi password baru (wajib cocok) --}}
            <label class="field-label" for="password_confirmation">Konfirmasi Password Baru</label>
            <input id="password_confirmation" type="password" name="password_confirmation" required autocomplete="new-password" />
            {{-- Tombol simpan password baru --}}
            <button type="submit" class="solid">Simpan Password</button>
        </form>
        {{-- Jalan kembali ke halaman masuk --}}
        <p class="auth-back"><a href="{{ route('login') }}">Kembali masuk</a></p>
    </section>
</main>
</body>
</html>
