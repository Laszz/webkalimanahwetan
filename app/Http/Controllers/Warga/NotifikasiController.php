<?php

// Controller notifikasi sisi WARGA - daftar pemberitahuan dan tandai dibaca

namespace App\Http\Controllers\Warga;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
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
}
