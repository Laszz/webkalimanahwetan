<?php

// Controller notifikasi sisi ADMIN - buka pemberitahuan warga

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class NotifikasiController extends Controller
{
    // Buka notifikasi: tandai dibaca lalu teruskan ke tautan tujuannya
    public function show(Request $request, string $id): RedirectResponse
    {
        // Hanya milik sendiri yang bisa dibuka
        $notifikasi = auth()->user()->notifications()->findOrFail($id);
        $notifikasi->markAsRead();

        // Gembok open-redirect: teruskan hanya kalau tujuannya satu domain
        // dengan aplikasi ini, selain itu kembali ke dashboard admin
        $url = $notifikasi->data['url'] ?? '';
        $host = parse_url($url, PHP_URL_HOST);
        $path = parse_url($url, PHP_URL_PATH) ?: '/';
        if ((is_string($host) && $host !== $request->getHost())
            || ! str_starts_with($path, '/')) {
            $url = route('admin.dashboard');
        }

        return redirect()->to($url);
    }
}
