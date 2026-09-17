<?php

// Controller dashboard sisi ADMIN - ringkasan statistik desa

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Aduan;
use App\Models\Berita;
use App\Models\PengajuanLayanan;
use App\Models\User;
use App\Models\Warga;
use Illuminate\View\View;

class DashboardController extends Controller
{
    // Angka ringkas: warga, pengajuan, aduan, berita untuk kartu dashboard
    public function index(): View
    {
        // Hitung per status dalam sekali jalan per tabel
        $statistik = [
            'warga' => Warga::count(),
            'akunMenunggu' => User::where('role', 'warga')->where('status', 'menunggu')->count(),
            'pengajuanMenunggu' => PengajuanLayanan::where('status', 'menunggu')->count(),
            'pengajuanDiproses' => PengajuanLayanan::where('status', 'diproses')->count(),
            'aduanMenunggu' => Aduan::where('status', 'menunggu')->count(),
            'aduanDiproses' => Aduan::where('status', 'diproses')->count(),
            'berita' => Berita::count(),
        ];

        return view('admin.dashboard', compact('statistik'));
    }
}
