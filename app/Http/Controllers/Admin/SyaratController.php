<?php

// Controller syarat sisi ADMIN - kelola syarat per layanan terpilih

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreSyaratRequest;
use App\Models\Layanan;
use App\Models\SyaratLayanan;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class SyaratController extends Controller
{
    // Syarat milik satu layanan (?layanan=id); tanpa pilihan kembali ke daftar layanan
    public function index(Request $request): View|RedirectResponse
    {
        $layananId = $request->query('layanan');

        if (! $layananId) {
            return redirect()->route('admin.layanan.index');
        }

        $layanan = Layanan::with('syaratLayanan')->findOrFail($layananId);

        return view('admin.syarat-layanan.index', compact('layanan'));
    }

    // Tambah syarat ke layanan
    public function store(StoreSyaratRequest $request): RedirectResponse
    {
        $data = $request->validated();
        // Semua syarat wajib diisi warga
        $data['wajib'] = true;

        SyaratLayanan::create($data);

        return redirect()
            ->route('admin.syarat-layanan.index', ['layanan' => $data['layanan_id']])
            ->with('success', 'Syarat ditambahkan.');
    }

    // Hapus syarat (pengajuan lama yang memakainya ikut terhapus via cascade)
    public function destroy(SyaratLayanan $syarat): RedirectResponse
    {
        $layananId = $syarat->layanan_id;
        $syarat->delete();

        return redirect()
            ->route('admin.syarat-layanan.index', ['layanan' => $layananId])
            ->with('success', 'Syarat dihapus.');
    }
}
