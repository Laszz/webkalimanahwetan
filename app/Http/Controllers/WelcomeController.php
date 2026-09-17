<?php

// Controller halaman depan publik - tampilkan ringkasan isi desa tanpa perlu login

namespace App\Http\Controllers;

use App\Models\Aduan;
use App\Models\Agenda;
use App\Models\Berita;
use Illuminate\View\View;

class WelcomeController extends Controller
{
    // Beranda publik: 5 aduan terbaru, 5 berita terbit, 3 agenda terdekat
    public function index(): View
    {
        // Aduan terbaru apa pun statusnya untuk transparansi
        $aduans = Aduan::latest()->take(5)->get();
        // Berita yang sudah terbit
        $beritas = Berita::published()->take(5)->get();
        // Agenda yang belum lewat
        $agendas = Agenda::mendatang()->take(3)->get();

        return view('welcome', compact('aduans', 'beritas', 'agendas'));
    }
}
