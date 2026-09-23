<?php

// Controller dana APBDes sisi ADMIN - kelola pagu per sumber per tahun

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreDanaRequest;
use App\Http\Requests\Admin\UpdateDanaRequest;
use App\Models\Dana;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DanaController extends Controller
{
    // Semua pagu + total terpakai, bisa saring per tahun dan sumber, terbaru dulu 15 per halaman
    public function index(Request $request): View
    {
        $danas = Dana::query()
            ->withSum('belanjas as terpakai', 'nominal')
            ->when($request->query('tahun'), fn ($query, $tahun) => $query->where('tahun', $tahun))
            ->when($request->query('sumber'), fn ($query, $sumber) => $query->where('sumber_dana', $sumber))
            ->latest('tahun')
            ->paginate(15);

        return view('admin.dana.index', compact('danas'));
    }

    // Form tambah pagu baru
    public function create(): View
    {
        return view('admin.dana.create');
    }

    // Simpan pagu baru
    public function store(StoreDanaRequest $request): RedirectResponse
    {
        Dana::create($request->validated());

        return redirect()
            ->route('admin.dana.index')
            ->with('success', 'Dana tersimpan.');
    }

    // Form ubah pagu
    public function edit(Dana $dana): View
    {
        return view('admin.dana.edit', compact('dana'));
    }

    // Simpan perubahan pagu
    public function update(UpdateDanaRequest $request, Dana $dana): RedirectResponse
    {
        $dana->update($request->validated());

        return redirect()
            ->route('admin.dana.index')
            ->with('success', 'Dana diperbarui.');
    }

    // Hapus pagu yang belum dipakai belanja
    public function destroy(Dana $dana): RedirectResponse
    {
        // Ada belanja = tolak agar riwayat tidak yatim
        if ($dana->belanjas()->exists()) {
            return redirect()
                ->route('admin.dana.index')
                ->with('gagal', 'Dana tidak bisa dihapus karena sudah dipakai belanja.');
        }

        $dana->delete();

        return redirect()
            ->route('admin.dana.index')
            ->with('success', 'Dana dihapus.');
    }
}
