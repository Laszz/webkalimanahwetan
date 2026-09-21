<?php

// Controller perangkat desa sisi ADMIN - kelola susunan pamong desa

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StorePerangkatDesaRequest;
use App\Http\Requests\Admin\UpdatePerangkatDesaRequest;
use App\Models\PerangkatDesa;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class PerangkatDesaController extends Controller
{
    // Semua perangkat berurutan nomor tampil 15 per halaman
    public function index(): View
    {
        $perangkats = PerangkatDesa::orderBy('urutan')->paginate(15);

        return view('admin.perangkat-desa.index', compact('perangkats'));
    }

    // Form tambah perangkat baru
    public function create(): View
    {
        return view('admin.perangkat-desa.create');
    }

    // Simpan perangkat baru
    public function store(StorePerangkatDesaRequest $request): RedirectResponse
    {
        $data = $request->validated();

        // Pindahkan foto profil ke storage jika ada
        if ($request->hasFile('foto')) {
            $data['foto'] = $request->file('foto')->store('perangkat', 'public');
        }

        PerangkatDesa::create($data);

        return redirect()
            ->route('admin.perangkat-desa.index')
            ->with('success', 'Perangkat tersimpan.');
    }

    // Detail satu perangkat
    public function show(PerangkatDesa $perangkat): View
    {
        return view('admin.perangkat-desa.show', compact('perangkat'));
    }

    // Form ubah perangkat
    public function edit(PerangkatDesa $perangkat): View
    {
        return view('admin.perangkat-desa.edit', compact('perangkat'));
    }

    // Simpan perubahan; foto diganti hanya jika ada unggahan baru
    public function update(UpdatePerangkatDesaRequest $request, PerangkatDesa $perangkat): RedirectResponse
    {
        $data = $request->validated();

        if ($request->hasFile('foto')) {
            $data['foto'] = $request->file('foto')->store('perangkat', 'public');
        }

        // Checkbox tidak terkirim saat tidak dicentang = nonaktif
        $data['aktif'] = $request->boolean('aktif');

        $perangkat->update($data);

        return redirect()
            ->route('admin.perangkat-desa.show', $perangkat)
            ->with('success', 'Perangkat diperbarui.');
    }

    // Hapus perangkat
    public function destroy(PerangkatDesa $perangkat): RedirectResponse
    {
        $perangkat->delete();

        return redirect()
            ->route('admin.perangkat-desa.index')
            ->with('success', 'Perangkat dihapus.');
    }
}
