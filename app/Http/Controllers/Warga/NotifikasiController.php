<?php

namespace App\Http\Controllers\Warga;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class NotifikasiController extends Controller
{
    // Semua notifikasi milik sendiri, terbaru dulu 15 per halaman
    public function index(): View
    {
        $notifikasis = auth()->user()->notifications()->paginate(15);

        return view('warga.notifikasi.index', compact('notifikasis'));
    }

    // Tandai satu notifikasi sudah dibaca
    public function update(string $id): RedirectResponse
    {
        // Hanya milik sendiri yang bisa ditandai
        $notifikasi = auth()->user()->notifications()->findOrFail($id);
        $notifikasi->markAsRead();

        return redirect()
            ->route('warga.notifikasi.index')
            ->with('success', 'Notifikasi ditandai dibaca.');
    }

    // Buka notifikasi: tandai dibaca lalu teruskan ke tautan tujuannya
    public function show(Request $request, string $id): RedirectResponse
    {
        // Hanya milik sendiri yang bisa dibuka
        $notifikasi = auth()->user()->notifications()->findOrFail($id);
        $notifikasi->markAsRead();

        // Gembok open-redirect: teruskan hanya kalau tujuannya satu domain
        // dengan aplikasi ini, selain itu kembalikan ke daftar notifikasi
        $url = $notifikasi->data['url'] ?? '';
        $host = parse_url($url, PHP_URL_HOST);
        $path = parse_url($url, PHP_URL_PATH) ?: '/';
        if ((is_string($host) && $host !== $request->getHost())
            || ! str_starts_with($path, '/')) {
            $url = route('warga.notifikasi.index');
        }

        return redirect()->to($url);
    }

    // Hapus satu notifikasi milik sendiri
    public function destroy(string $id): RedirectResponse
    {
        // Hanya milik sendiri yang bisa dihapus
        $notifikasi = auth()->user()->notifications()->findOrFail($id);
        $notifikasi->delete();

        return redirect()
            ->route('warga.notifikasi.index')
            ->with('success', 'Notifikasi dihapus.');
    }

    // Hapus semua notifikasi milik sendiri, tetap di halaman ini
    public function destroyAll(): RedirectResponse
    {
        auth()->user()->notifications()->delete();

        return back()->with('success', 'Semua notifikasi dihapus.');
    }


}
