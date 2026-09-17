<?php

// Controller profil desa sisi WARGA - lihat profil, visi misi, dan sejarah

namespace App\Http\Controllers\Warga;

use App\Http\Controllers\Controller;
use App\Models\ProfilDesa;
use Illuminate\View\View;

class ProfilDesaController extends Controller
{
    // Satu profil resmi desa; belum diisi admin = halaman tidak ada
    public function show(): View
    {
        $profil = ProfilDesa::firstOrFail();

        return view('warga.profil-desa.show', compact('profil'));
    }
}
