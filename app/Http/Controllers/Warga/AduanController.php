<?php

// Controller aduan sisi WARGA - lapor baru dan riwayat milik sendiri

namespace App\Http\Controllers\Warga;

use App\Http\Controllers\Controller;
use App\Http\Requests\Warga\StoreAduanRequest;
use App\Models\Aduan;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class AduanController extends Controller
{
    // Riwayat aduan milik sendiri, terbaru dulu 10 per halaman
    public function index(): View
    {
        $aduans = auth()->user()->aduans()->latest()->paginate(10);

        return view('warga.aduan.index', compact('aduans'));
    }

    // Form lapor aduan baru
    public function create(): View
    {
        return view('warga.aduan.create');
    }

    // Detail aduan milik sendiri + tanggapan admin
    public function show(Aduan $aduan): View
    {
        // Hanya pemilik yang boleh membuka
        abort_unless($aduan->user_id === auth()->id(), 403);
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
