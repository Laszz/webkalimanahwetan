<!DOCTYPE html>
{{-- Halaman galat 403 - mandiri tanpa layout/vite agar tampil bahkan saat build mati --}}
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Akses Ditolak - Desa Kalimanah</title>
    <style>
        * { box-sizing: border-box; }
        body { margin: 0; min-height: 100vh; display: flex; align-items: center; justify-content: center; background: #FAFAFA; font-family: 'Poppins', system-ui, sans-serif; padding: 24px; }
        .kartu { background: #fff; border: 1px solid #e5e7eb; border-radius: 14px; padding: 40px 32px; max-width: 420px; width: 100%; text-align: center; }
        .kode { font-size: 3rem; font-weight: 700; color: #1E466B; margin: 0; }
        .judul { font-size: 1.1rem; font-weight: 700; margin: 8px 0; }
        .pesan { font-size: 14px; color: #6b7280; margin: 0 0 24px; line-height: 1.6; }
        .btn { display: inline-block; background: #1E466B; color: #fff; padding: 12px 32px; border-radius: 999px; font-weight: 700; font-size: 14px; text-decoration: none; }
    </style>
</head>
<body>
    <main class="kartu">
        <p class="kode">403</p>
        <h1 class="judul">Akses Ditolak</h1>
        <p class="pesan">Anda tidak punya izin membuka halaman ini. Silakan masuk dengan akun yang sesuai.</p>
        {{-- Kembali sesuai peran: admin/warga ke dashboardnya, tamu ke beranda publik --}}
        @auth
            <a class="btn" href="{{ auth()->user()->isAdmin() ? route('admin.dashboard') : route('warga.dashboard') }}">Kembali ke Beranda</a>
        @else
            <a class="btn" href="{{ url('/') }}">Kembali ke Beranda</a>
        @endauth
    </main>
</body>
</html>
