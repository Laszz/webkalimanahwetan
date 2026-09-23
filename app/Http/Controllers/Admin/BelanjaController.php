<?php

// Controller belanja APBDes sisi ADMIN - pakai dana untuk kegiatan per bidang

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreBelanjaRequest;
use App\Http\Requests\Admin\UpdateBelanjaRequest;
use App\Models\Belanja;
use App\Models\Dana;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class BelanjaController extends Controller
{
    // Semua belanja + nama dana, bisa saring per tahun dan bidang, terbaru dulu 15 per halaman
    public function index(Request $request): View
    {
        $belanjas = Belanja::query()
            ->with(['dana:id,tahun,sumber_dana,anggaran'])
            ->when($request->query('tahun'), fn ($query, $tahun) => $query->whereHas('dana', fn ($q) => $q->where('tahun', $tahun)))
            ->when($request->query('bidang'), fn ($query, $bidang) => $query->where('bidang', $bidang))
            ->latest()
            ->paginate(15);

        return view('admin.belanja.index', compact('belanjas'));
    }

    // Form belanja baru (pilih dana yang masih bersisa)
    public function create(): View
    {
        $danas = Dana::withSum('belanjas as terpakai', 'nominal')->orderByDesc('tahun')->orderBy('sumber_dana')->get();

        return view('admin.belanja.create', compact('danas'));
    }

    // Simpan belanja baru
    public function store(StoreBelanjaRequest $request): RedirectResponse
    {
        Belanja::create($request->validated());

        return redirect()
            ->route('admin.belanja.index')
            ->with('success', 'Belanja tersimpan.');
    }

    // Form ubah belanja
    public function edit(Belanja $belanja): View
    {
        $danas = Dana::withSum('belanjas as terpakai', 'nominal')->orderByDesc('tahun')->orderBy('sumber_dana')->get();

        return view('admin.belanja.edit', compact('belanja', 'danas'));
    }

    // Simpan perubahan belanja
    public function update(UpdateBelanjaRequest $request, Belanja $belanja): RedirectResponse
    {
        $belanja->update($request->validated());

        return redirect()
            ->route('admin.belanja.index')
            ->with('success', 'Belanja diperbarui.');
    }

    // Hapus belanja (sisa dana kembali)
    public function destroy(Belanja $belanja): RedirectResponse
    {
        $belanja->delete();

        return redirect()
            ->route('admin.belanja.index')
            ->with('success', 'Belanja dihapus.');
    }
}
