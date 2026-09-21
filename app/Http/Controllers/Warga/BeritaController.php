<?php

// Controller berita sisi WARGA - baca kabar dan pengumuman yang sudah terbit

namespace App\Http\Controllers\Warga;

use App\Http\Controllers\Controller;
use App\Models\Berita;
use Illuminate\Http\Request;
use Illuminate\View\View;

class BeritaController extends Controller
{
    // Daftar berita terbit + cari judul/ringkasan/isi; hero = terbaru, sisanya 8 per halaman
    public function index(Request $request): View
    {
        // Kata kunci pencarian dari query ?q=
        $cari = trim((string) $request->query('q', ''));

        $query = Berita::published()
            ->when($cari !== '', fn ($q) => $q->where(function ($w) use ($cari) {
                $w->where('judul', 'like', "%{$cari}%")
                    ->orWhere('ringkasan', 'like', "%{$cari}%")
                    ->orWhere('konten', 'like', "%{$cari}%");
            }));

        // Tanpa pencarian di halaman 1: berita paling baru tampil besar di atas
        $beritaTerbaru = null;
        if ($cari === '' && (int) $request->query('page', 1) === 1) {
            $beritaTerbaru = (clone $query)->first();
            if ($beritaTerbaru) {
                $query->whereKeyNot($beritaTerbaru->getKey());
            }
        }

        $beritas = $query->paginate(8)->withQueryString();

        return view('warga.berita.index', compact('beritas', 'beritaTerbaru', 'cari'));
    }

    // Detail berita terbit berdasarkan slug
    public function show(string $slug): View
    {
        $berita = Berita::published()->where('slug', $slug)->firstOrFail();

        return view('warga.berita.show', compact('berita'));
    }
}
