<?php

// Controller penerima bantuan sisi WARGA - lihat jenis bantuan dan total penerima

namespace App\Http\Controllers\Warga;

use App\Http\Controllers\Controller;
use App\Models\JenisBantuan;
use Illuminate\View\View;

class PenerimaBantuanController extends Controller
{
    // Semua jenis bantuan + total penerima, 12 per halaman
    public function index(): View
    {
        $bantuans = JenisBantuan::withCount('penerimaBantuan')->latest()->paginate(12);

        return view('warga.penerimabantuan.index', compact('bantuans'));
    }

    // Detail jenis + daftar penerima per periode terbaru
    public function show(JenisBantuan $bantuan): View
    {
        $bantuan->load(['penerimaBantuan' => fn ($query) => $query->with('warga:id,nama')->latest()]);

        return view('warga.penerimabantuan.show', compact('bantuan'));
    }
}
