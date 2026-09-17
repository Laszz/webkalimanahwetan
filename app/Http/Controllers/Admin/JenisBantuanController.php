<?php

// Controller jenis bantuan sisi ADMIN - master bantuan sosial desa

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreJenisBantuanRequest;
use App\Http\Requests\Admin\UpdateJenisBantuanRequest;
use App\Models\JenisBantuan;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class JenisBantuanController extends Controller
{
    // Semua jenis + jumlah penerima, terbaru dulu 15 per halaman
    public function index(): View
    {
        $jenis = JenisBantuan::withCount('penerimaBantuan')->latest()->paginate(15);

        return view('admin.jenis-bantuan.index', compact('jenis'));
    }

    // Form tambah jenis baru
    public function create(): View
    {
        return view('admin.jenis-bantuan.create');
    }

    // Simpan jenis bantuan baru
    public function store(StoreJenisBantuanRequest $request): RedirectResponse
    {
        $jenis = JenisBantuan::create($request->validated());

        return redirect()
            ->route('admin.jenis-bantuan.show', $jenis)
            ->with('success', 'Jenis bantuan tersimpan.');
    }

    // Detail jenis + daftar penerimanya
    public function show(JenisBantuan $jenisBantuan): View
    {
        $jenisBantuan->load(['penerimaBantuan.warga:id,nama']);

        return view('admin.jenis-bantuan.show', compact('jenisBantuan'));
    }

    // Form ubah jenis bantuan
    public function edit(JenisBantuan $jenisBantuan): View
    {
        return view('admin.jenis-bantuan.edit', compact('jenisBantuan'));
    }

    // Simpan perubahan jenis bantuan
    public function update(UpdateJenisBantuanRequest $request, JenisBantuan $jenisBantuan): RedirectResponse
    {
        $jenisBantuan->update($request->validated());

        return redirect()
            ->route('admin.jenis-bantuan.show', $jenisBantuan)
            ->with('success', 'Jenis bantuan diperbarui.');
    }

    // Hapus jenis (penerima ikut terhapus via cascade)
    public function destroy(JenisBantuan $jenisBantuan): RedirectResponse
    {
        $jenisBantuan->delete();

        return redirect()
            ->route('admin.jenis-bantuan.index')
            ->with('success', 'Jenis bantuan dihapus.');
    }
}
