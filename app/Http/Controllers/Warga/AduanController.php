<?php

// Controller aduan sisi WARGA - lapor baru dan riwayat milik sendiri

namespace App\Http\Controllers\Warga;

use App\Http\Controllers\Controller;
use App\Http\Requests\Warga\StoreAduanRequest;
use App\Models\Aduan;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AduanController extends Controller
{
    // Daftar aduan + cari judul/isi; hero = terbaru, sisanya 8 per halaman
    // Tamu lihat semua laporan (transparansi); warga login lihat milik sendiri
    public function index(Request $request): View
    {
        // Kata kunci pencarian dari query ?q=
        $cari = trim((string) $request->query('q', ''));

        $query = (auth()->check() ? auth()->user()->aduans() : Aduan::query())
            ->latest()
            ->when($cari !== '', fn ($q) => $q->where(function ($w) use ($cari) {
                $w->where('judul', 'like', "%{$cari}%")
                    ->orWhere('isi', 'like', "%{$cari}%");
            }));

        // Tanpa pencarian di halaman 1: aduan paling baru tampil besar di atas
        $aduanTerbaru = null;
        if ($cari === '' && (int) $request->query('page', 1) === 1) {
            $aduanTerbaru = (clone $query)->first();
            if ($aduanTerbaru) {
                $query->whereKeyNot($aduanTerbaru->getKey());
            }
        }

        $aduans = $query->paginate(8)->withQueryString();

        // Judul menyesuaikan: milik sendiri jika login, transparansi jika tamu
        $judul = auth()->check() ? 'Aduan Saya' : 'Aduan Warga';
        $sub = auth()->check()
            ? 'Laporan yang pernah dikirim beserta statusnya.'
            : 'Laporan warga yang masuk dan ditindaklanjuti perangkat desa.';

        return view('warga.aduan.index', compact('aduans', 'aduanTerbaru', 'cari', 'judul', 'sub'));
    }

    // Form lapor aduan baru
    public function create(): View
    {
        return view('warga.aduan.create');
    }

    // Detail aduan + tanggapan admin (publik untuk transparansi)
    public function show(Aduan $aduan): View
    {
        $aduan->load('tanggapanAduan.user:id,name');

        return view('warga.aduan.show', compact('aduan'));
    }

    // Simpan aduan; pelapor otomatis user login, foto disimpan ke storage publik
    public function store(StoreAduanRequest $request): RedirectResponse
    {
        $data = $request->validated();

        // Pindahkan foto bukti ke storage jika ada
        if ($request->hasFile('gambar')) {
            $data['gambar'] = $request->file('gambar')->store('aduan', 'public');
        }

        auth()->user()->aduans()->create($data);

        return redirect()
            ->route('warga.aduan.index')
            ->with('success', 'Aduan terkirim dan menunggu tindak lanjut.');
    }
}
