<?php

// Controller agenda sisi WARGA - lihat jadwal kegiatan mendatang

namespace App\Http\Controllers\Warga;

use App\Http\Controllers\Controller;
use App\Models\Agenda;
use Illuminate\View\View;

class AgendaController extends Controller
{
    // Agenda yang belum lewat, terdekat dulu 12 per halaman
    public function index(): View
    {
        $agendas = Agenda::mendatang()->paginate(12);

        return view('warga.agenda.index', compact('agendas'));
    }
}
