<?php

// Controller profil sisi WARGA - isi pertama dan ubah biodata milik sendiri

namespace App\Http\Controllers\Warga;

use App\Http\Controllers\Controller;
use App\Http\Requests\Warga\StoreWargaRequest;
use App\Http\Requests\Warga\UpdateWargaRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class WargaController extends Controller
{
    // Profil biodata sendiri; lempar ke form isi jika belum ada
    public function show(): View|RedirectResponse
    {
        $warga = auth()->user()->warga;

        if (! $warga) {
            return redirect()->route('warga.profil.create');
        }

        return view('warga.profil.show', compact('warga'));
    }

    // Form isi biodata pertama (sudah punya = lempar ke ubah)
    public function create(): View|RedirectResponse
    {
        if (auth()->user()->warga) {
            return redirect()->route('warga.profil.edit');
        }

        return view('warga.profil.create');
    }

    // Simpan biodata pertama; relasi akun diisi otomatis (bukan dari input)
    public function store(StoreWargaRequest $request): RedirectResponse
    {
        auth()->user()->warga()->create($request->validated());

        return redirect()
            ->route('warga.profil.show')
            ->with('success', 'Biodata tersimpan dan menunggu verifikasi admin.');
    }

    // Form ubah biodata sendiri
    public function edit(): View|RedirectResponse
    {
        $warga = auth()->user()->warga;

        if (! $warga) {
            return redirect()->route('warga.profil.create');
        }

        return view('warga.profil.edit', compact('warga'));
    }

    // Simpan perubahan biodata sendiri
    public function update(UpdateWargaRequest $request): RedirectResponse
    {
        $warga = auth()->user()->warga;

        if (! $warga) {
            return redirect()->route('warga.profil.create');
        }

        $warga->update($request->validated());

        return redirect()
            ->route('warga.profil.show')
            ->with('success', 'Biodata diperbarui.');
    }
}
