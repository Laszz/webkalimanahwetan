<?php

// Controller halaman depan publik - tampilkan ringkasan isi desa tanpa perlu login

namespace App\Http\Controllers;

use App\Models\Aduan;
use App\Models\Agenda;
use App\Models\Berita;
use App\Models\PerangkatDesa;
use App\Models\ProfilDesa;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class WelcomeController extends Controller
{
    // Beranda publik: sambutan kades + 5 aduan terbaru, 5 berita terbit, 3 agenda terdekat
    public function index(): View|RedirectResponse
    {
        // Sudah masuk = berandanya dashboard sesuai peran (samakan dengan tombol Beranda navbar)
        if (auth()->check()) {
            return redirect()->route(auth()->user()->isAdmin() ? 'admin.dashboard' : 'warga.dashboard');
        }        // Profil desa (sambutan) + kepala desa aktif untuk seksi sambutan
        $profil = ProfilDesa::first();
        $kepalaDesa = PerangkatDesa::aktif()->where('jabatan', 'like', '%kepala%')->first()
            ?? PerangkatDesa::aktif()->first();        // Aduan terbaru apa pun statusnya untuk transparansi
        $aduans = Aduan::latest()->take(5)->get();
        // Berita yang sudah terbit
        $beritas = Berita::published()->take(5)->get();
        // Agenda yang belum lewat
        $agendas = Agenda::mendatang()->take(3)->get();

        return view('welcome', compact('profil', 'kepalaDesa', 'aduans', 'beritas', 'agendas'));
    }
}
