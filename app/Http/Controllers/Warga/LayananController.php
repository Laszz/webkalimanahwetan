<?php

// Controller katalog layanan sisi WARGA - jelajah jenis surat yang bisa diajukan

namespace App\Http\Controllers\Warga;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreLayananRequest;
use App\Models\Layanan;
use Illuminate\Http\Request;
use Illuminate\View\View;

class LayananController extends Controller
{
    // Layanan aktif + cari nama/deskripsi + saring kategori, 12 per halaman
    public function index(Request $request): View
    {
        // Kata kunci + kategori dari query ?q= & ?kategori=
        $cari = trim((string) $request->query('q', ''));
        $kategori = (string) $request->query('kategori', '');

        $layanans = Layanan::aktif()
            ->withCount('syaratLayanan')
            ->when($cari !== '', fn ($q) => $q->where(function ($w) use ($cari) {
                $w->where('nama', 'like', "%{$cari}%")
                    ->orWhere('deskripsi', 'like', "%{$cari}%");
            }))
            ->when($kategori !== '', fn ($q) => $q->where('kategori', $kategori))
            ->latest()
            ->paginate(12)
            ->withQueryString();

        $kategoris = StoreLayananRequest::kategoris();

        return view('warga.layanan.index', compact('layanans', 'cari', 'kategori', 'kategoris'));
    }

    // Detail layanan + syarat yang harus dipenuhi sebelum mengajukan
    public function show(Layanan $layanan): View
    {
        // Hanya layanan aktif yang boleh dibuka warga
        abort_unless($layanan->aktif, 404);

        $layanan->load('syaratLayanan');

        return view('warga.layanan.show', compact('layanan'));
    }
}
