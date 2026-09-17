<?php

// Controller galeri sisi ADMIN - kelola dokumentasi foto kegiatan desa

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreGaleriRequest;
use App\Http\Requests\Admin\UpdateGaleriRequest;
use App\Models\Galeri;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class GaleriController extends Controller
{
    // Semua foto, terbaru dulu 15 per halaman
    public function index(): View
    {
        $galeris = Galeri::latest()->paginate(15);

        return view('admin.galeri.index', compact('galeris'));
    }

    // Form tambah foto baru
    public function create(): View
    {
        return view('admin.galeri.create');
    }

    // Simpan foto baru ke storage
    public function store(StoreGaleriRequest $request): RedirectResponse
    {
        $data = $request->validated();
        $data['gambar'] = $request->file('gambar')->store('galeri', 'public');

        $galeri = Galeri::create($data);

        return redirect()
            ->route('admin.galeri.show', $galeri)
            ->with('success', 'Foto tersimpan.');
    }

    // Detail satu foto
    public function show(Galeri $galeri): View
    {
        return view('admin.galeri.show', compact('galeri'));
    }

    // Form ubah foto
    public function edit(Galeri $galeri): View
    {
        return view('admin.galeri.edit', compact('galeri'));
    }

    // Simpan perubahan; foto diganti hanya jika ada unggahan baru
    public function update(UpdateGaleriRequest $request, Galeri $galeri): RedirectResponse
    {
        $data = $request->validated();

        if ($request->hasFile('gambar')) {
            $data['gambar'] = $request->file('gambar')->store('galeri', 'public');
        }

        $galeri->update($data);

        return redirect()
            ->route('admin.galeri.show', $galeri)
            ->with('success', 'Foto diperbarui.');
    }

    // Hapus foto
    public function destroy(Galeri $galeri): RedirectResponse
    {
        $galeri->delete();

        return redirect()
            ->route('admin.galeri.index')
            ->with('success', 'Foto dihapus.');
    }
}
