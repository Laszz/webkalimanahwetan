<?php

// Controller berita sisi WARGA - baca kabar dan pengumuman yang sudah terbit

namespace App\Http\Controllers\Warga;

use App\Http\Controllers\Controller;
use App\Models\Berita;
use Illuminate\View\View;

class BeritaController extends Controller
{
    // Daftar berita terbit, terbaru dulu 9 per halaman
    public function index(): View
    {
        $beritas = Berita::published()->paginate(9);

        return view('warga.berita.index', compact('beritas'));
    }

    // Detail berita terbit berdasarkan slug
    public function show(string $slug): View
    {
        $berita = Berita::published()->where('slug', $slug)->firstOrFail();

        return view('warga.berita.show', compact('berita'));
    }
}
