<?php

// Controller profil desa sisi WARGA - lihat profil, visi misi, dan sejarah

namespace App\Http\Controllers\Warga;

use App\Http\Controllers\Controller;
use App\Models\ProfilDesa;
use Illuminate\View\View;

class ProfilDesaController extends Controller
{
    // Satu profil resmi desa; kosong = tampil pesan, bukan 404
    public function index(): View
    {
        $profil = ProfilDesa::first();

        return view('warga.profil-desa.index', compact('profil'));
    }
}
