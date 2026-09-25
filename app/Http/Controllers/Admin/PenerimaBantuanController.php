<?php

// Controller penerima bantuan sisi ADMIN - catat warga penerima per periode

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StorePenerimaBantuanRequest;
use App\Models\JenisBantuan;
use App\Models\PenerimaBantuan;
use App\Models\Warga;
use App\Notifications\BantuanDiterima;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PenerimaBantuanController extends Controller
{
    // Semua penerima + jenis dan warga, bisa saring per tahun, terbaru dulu 15 per halaman
    public function index(Request $request): View
    {
        $penerimas = PenerimaBantuan::with(['jenisBantuan:id,nama', 'warga:id,nama'])
            ->when($request->query('tahun'), fn ($query, $tahun) => $query->where('tahun', $tahun))
            ->latest()
            ->paginate(15);

        return view('admin.penerima-bantuan.index', compact('penerimas'));
    }

    // Form tambah penerima (pilih jenis + warga terdaftar)
    public function create(): View
    {
        $jenis = JenisBantuan::orderBy('nama')->get(['id', 'nama']);
        $wargas = Warga::orderBy('nama')->get(['id', 'nama']);

        return view('admin.penerima-bantuan.create', compact('jenis', 'wargas'));
    }

    // Simpan penerima baru
    public function store(StorePenerimaBantuanRequest $request): RedirectResponse
    {
        $penerima = PenerimaBantuan::create($request->validated());

        // Beri tahu warga penerima jika akunnya ada
        $penerima->loadMissing(['warga.user:id,name', 'jenisBantuan:id,nama']);
        if ($penerima->warga?->user) {
            $penerima->warga->user->notify(new BantuanDiterima($penerima));
        }

        return redirect()
            ->route('admin.penerima-bantuan.index')
            ->with('success', 'Penerima tersimpan.');
    }

    // Hapus data penerima (riwayat periode berjalan ikut terhapus)
    public function destroy(PenerimaBantuan $penerimaBantuan): RedirectResponse
    {
        $penerimaBantuan->delete();

        return redirect()
            ->route('admin.penerima-bantuan.index')
            ->with('success', 'Penerima dihapus.');
    }
}
