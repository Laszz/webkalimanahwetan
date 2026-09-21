<?php

// Controller dashboard sisi WARGA - ringkasan milik sendiri + seksi publik

namespace App\Http\Controllers\Warga;

use App\Http\Controllers\Controller;
use App\Models\Aduan;
use App\Models\Agenda;
use App\Models\Berita;
use App\Models\PenerimaBantuan;
use Illuminate\View\View;

class DashboardController extends Controller
{
    // Sapaan + 5 riwayat pengajuan sendiri + seksi publik (aduan, berita, agenda)
    public function index(): View
    {
        // Riwayat pengajuan milik sendiri untuk kartu ringkasan
        $riwayat = auth()->user()->pengajuanLayanan()->with('layanan:id,nama')->latest()->take(5)->get();
        // Seksi publik sama seperti halaman depan
        $aduans = Aduan::latest()->take(5)->get();
        $beritas = Berita::published()->take(5)->get();
        $agendas = Agenda::mendatang()->take(3)->get();

        // Bantuan yang diterima warga ini (lewat biodatanya); kosong jika belum terdata
        $wargaId = auth()->user()->warga?->id;
        $bantuanSaya = $wargaId
            ? PenerimaBantuan::with('jenisBantuan:id,nama')->where('warga_id', $wargaId)->latest()->take(5)->get()
            : collect();

        return view('warga.dashboard', compact('riwayat', 'aduans', 'beritas', 'agendas', 'bantuanSaya'));
    }
}
