<?php

// Controller APBDes sisi WARGA - transparansi dana dan belanja per tahun

namespace App\Http\Controllers\Warga;

use App\Http\Controllers\Controller;
use App\Models\Belanja;
use App\Models\Dana;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ApbdesController extends Controller
{
    // Dana per tahun + belanja per bidang
    public function index(Request $request): View
    {
        // Tahun aktif = pilihan user atau tahun terbaru yang ada
        $tahun = $request->query('tahun', Dana::max('tahun'));
        $daftarTahun = Dana::distinct()->orderByDesc('tahun')->pluck('tahun');

        // Pagu tiap sumber dana tahun aktif + total terpakai
        $danas = Dana::withSum('belanjas as terpakai', 'nominal')
            ->where('tahun', $tahun)
            ->orderBy('sumber_dana')
            ->get();

        // Belanja tahun aktif berurutan bidang
        $belanjas = Belanja::with('dana:id,tahun,sumber_dana')
            ->whereHas('dana', fn ($query) => $query->where('tahun', $tahun))
            ->orderBy('bidang')
            ->latest()
            ->get();

        $totalAnggaran = $danas->sum('anggaran');
        $totalRealisasi = $danas->sum('terpakai');

        return view('warga.apbdes.index', compact('danas', 'belanjas', 'daftarTahun', 'tahun', 'totalAnggaran', 'totalRealisasi'));
    }
}
