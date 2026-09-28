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
    // Ringkasan dana per tahun
    public function index(Request $request): View
    {
        // Tahun aktif = pilihan user atau tahun terbaru yang ada
        $tahun = $request->query('tahun', Dana::max('tahun'));
        $daftarTahun = Dana::distinct()->orderByDesc('tahun')->pluck('tahun');

        [$totalAnggaran, $totalRealisasi] = $this->ringkasan($tahun);

        // Entri paling baru tahun ini untuk cuplikan
        $danaTerbaru = Dana::withSum('belanjas as terpakai', 'nominal')
            ->where('tahun', $tahun)
            ->latest()
            ->first();
        $belanjaTerbaru = Belanja::with('dana:id,sumber_dana')
            ->whereHas('dana', fn ($query) => $query->where('tahun', $tahun))
            ->latest()
            ->first();

        return view('warga.apbdes.index', compact('daftarTahun', 'tahun', 'totalAnggaran', 'totalRealisasi', 'danaTerbaru', 'belanjaTerbaru'));
    }

    // Rincian sumber dana satu tahun
    public function sumber(int $tahun): View
    {
        // Pagu tiap sumber dana tahun ini + total terpakai
        $danas = Dana::withSum('belanjas as terpakai', 'nominal')
            ->where('tahun', $tahun)
            ->orderBy('sumber_dana')
            ->get();

        return view('warga.apbdes.sumber', compact('danas', 'tahun'));
    }

    // Rincian belanja per bidang satu tahun
    public function belanja(int $tahun): View
    {
        // Belanja tahun ini berurutan bidang
        $belanjas = Belanja::with('dana:id,tahun,sumber_dana')
            ->whereHas('dana', fn ($query) => $query->where('tahun', $tahun))
            ->orderBy('bidang')
            ->latest()
            ->get();

        return view('warga.apbdes.belanja', compact('belanjas', 'tahun'));
    }

    // Total pagu dan realisasi satu tahun
    private function ringkasan(mixed $tahun): array
    {
        $totalAnggaran = (int) Dana::where('tahun', $tahun)->sum('anggaran');
        $totalRealisasi = (int) Belanja::whereHas('dana', fn ($query) => $query->where('tahun', $tahun))->sum('nominal');

        return [$totalAnggaran, $totalRealisasi];
    }
}
