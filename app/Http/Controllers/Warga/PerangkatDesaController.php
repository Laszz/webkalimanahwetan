<?php

// Controller perangkat desa sisi WARGA - lihat susunan pamong yang aktif

namespace App\Http\Controllers\Warga;

use App\Http\Controllers\Controller;
use App\Models\PerangkatDesa;
use Illuminate\View\View;

class PerangkatDesaController extends Controller
{
    // Perangkat aktif berurutan nomor tampil
    public function index(): View
    {
        $perangkats = PerangkatDesa::aktif()->get();

        return view('warga.perangkat-desa.index', compact('perangkats'));
    }
}
