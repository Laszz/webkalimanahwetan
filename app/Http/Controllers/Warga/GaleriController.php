<?php

// Controller galeri sisi WARGA - lihat dokumentasi foto yang sudah terbit

namespace App\Http\Controllers\Warga;

use App\Http\Controllers\Controller;
use App\Models\Galeri;
use Illuminate\View\View;

class GaleriController extends Controller
{
    // Daftar foto terbit, terbaru dulu 12 per halaman
    public function index(): View
    {
        $galeris = Galeri::published()->paginate(12);

        return view('warga.galeri.index', compact('galeris'));
    }

    // Detail satu foto terbit
    public function show(Galeri $galeri): View
    {
        // Hanya foto terbit yang boleh dibuka
        abort_unless($galeri->published_at && $galeri->published_at->isPast(), 404);

        return view('warga.galeri.show', compact('galeri'));
    }
}
