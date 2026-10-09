<?php

// Controller profil desa sisi ADMIN - kelola satu baris profil resmi

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreProfilDesaRequest;
use App\Models\ProfilDesa;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class ProfilDesaController extends Controller
{
    // Form kelola profil (isi lama tampil jika sudah ada)
    public function edit(): View
    {
        $profil = ProfilDesa::first();

        return view('admin.profil-desa.edit', compact('profil'));
    }

    // Simpan profil; buat baru jika belum ada, timpa jika sudah ada
    public function update(StoreProfilDesaRequest $request): RedirectResponse
    {
        $data = $request->validated();

        // Ganti logo hanya jika ada unggahan baru
        if ($request->hasFile('logo')) {
            $data['logo'] = $request->file('logo')->store('profil-desa', 'public');
        }

        ProfilDesa::updateOrCreate(['id' => ProfilDesa::first()?->id], $data);

        return redirect()
            ->route('admin.profil-desa.edit')
            ->with('success', 'Profil desa diperbarui.');
    }
}
