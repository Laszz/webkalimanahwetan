<?php

// Controller katalog layanan sisi WARGA - jelajah jenis surat yang bisa diajukan

namespace App\Http\Controllers\Warga;

use App\Http\Controllers\Controller;
use App\Models\Layanan;
use Illuminate\View\View;

class LayananController extends Controller
{
    // Semua layanan aktif + jumlah syarat, 12 per halaman
    public function index(): View
    {
        $layanans = Layanan::aktif()->withCount('syaratLayanan')->latest()->paginate(12);

        return view('warga.layanan.index', compact('layanans'));
    }

    // Detail layanan + syarat yang harus dipenuhi sebelum mengajukan
    public function show(Layanan $layanan): View
    {
        // Hanya layanan aktif yang boleh dibuka warga
        abort_unless($layanan->aktif, 404);

        $layanan->load('syaratLayanan');

        return view('warga.layanan.show', compact('layanan'));
    }
}
