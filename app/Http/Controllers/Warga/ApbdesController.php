<?php

// Controller APBDes sisi WARGA - transparansi anggaran per tahun

namespace App\Http\Controllers\Warga;

use App\Http\Controllers\Controller;
use App\Models\Apbdes;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ApbdesController extends Controller
{
    // Pos anggaran per tahun + total pagu dan realisasi
    public function index(Request $request): View
    {
        // Tahun aktif = pilihan user atau tahun terbaru yang ada
        $tahun = $request->query('tahun', Apbdes::max('tahun'));
        $daftarTahun = Apbdes::distinct()->orderByDesc('tahun')->pluck('tahun');

        $pos = Apbdes::where('tahun', $tahun)->orderBy('bidang')->get();
        $totalAnggaran = $pos->sum('anggaran');
        $totalRealisasi = $pos->sum('realisasi');

        return view('warga.apbdes.index', compact('pos', 'daftarTahun', 'tahun', 'totalAnggaran', 'totalRealisasi'));
    }
}
