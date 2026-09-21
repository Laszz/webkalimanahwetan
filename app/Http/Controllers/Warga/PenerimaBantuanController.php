<?php

// Controller penerima bantuan sisi WARGA - lihat jenis bantuan dan total penerima

namespace App\Http\Controllers\Warga;

use App\Http\Controllers\Controller;
use App\Models\JenisBantuan;
use App\Models\PenerimaBantuan;
use Illuminate\View\View;

class PenerimaBantuanController extends Controller
{
    // Semua jenis bantuan + total penerima, 12 per halaman
    public function index(): View
    {
        $bantuans = JenisBantuan::withCount('penerimaBantuan')->latest()->paginate(12);

        return view('warga.penerimabantuan.index', compact('bantuans'));
    }

    // Detail satu bantuan yang diterima sendiri + data penerima
    public function detail(PenerimaBantuan $penerima): View
    {
        // Hanya milik sendiri yang boleh dibuka
        abort_unless($penerima->warga_id === auth()->user()->warga?->id, 403);
        $penerima->load(['jenisBantuan:id,nama,deskripsi', 'warga:id,nama,rt,rw']);

        return view('warga.penerimabantuan.detail', compact('penerima'));
    }

    // Rekap penerima per RT/RW per periode untuk satu jenis bantuan
    public function show(JenisBantuan $bantuan): View
    {
        // Kelompokkan penerima per RT/RW + periode: hitung orang dan total nominal
        $rekap = PenerimaBantuan::where('jenis_bantuan_id', $bantuan->id)
            ->join('wargas', 'wargas.id', '=', 'penerima_bantuans.warga_id')
            ->selectRaw('wargas.rt, wargas.rw, penerima_bantuans.tahun, penerima_bantuans.bulan, COUNT(*) as total, SUM(penerima_bantuans.nominal) as total_nominal')
            ->groupBy('wargas.rt', 'wargas.rw', 'penerima_bantuans.tahun', 'penerima_bantuans.bulan')
            ->orderBy('penerima_bantuans.tahun', 'desc')
            ->orderBy('penerima_bantuans.bulan', 'desc')
            ->get();

        return view('warga.penerimabantuan.show', compact('bantuan', 'rekap'));
    }
}
