<?php

// Controller data warga sisi ADMIN - pantau dan hapus biodata yang bermasalah

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Warga;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class WargaController extends Controller
{
    // Semua biodata + akun pemilik, terbaru dulu 15 per halaman
    public function index(): View
    {
        $wargas = Warga::with('user:id,name,email')->latest()->paginate(15);

        return view('admin.warga.index', compact('wargas'));
    }

    // Detail biodata + akun pemilik
    public function show(Warga $warga): View
    {
        $warga->load('user:id,name,email');

        return view('admin.warga.show', compact('warga'));
    }

    // Hapus biodata bermasalah (akun user tetap ada untuk verifikasi ulang)
    public function destroy(Warga $warga): RedirectResponse
    {
        $warga->delete();

        return redirect()
            ->route('admin.warga.index')
            ->with('success', 'Biodata warga dihapus.');
    }
}
