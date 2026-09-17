<?php

// Controller APBDes sisi ADMIN - kelola anggaran per bidang per tahun

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreApbdesRequest;
use App\Http\Requests\Admin\UpdateApbdesRequest;
use App\Models\Apbdes;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ApbdesController extends Controller
{
    // Semua pos anggaran, bisa saring per tahun, terbaru dulu 15 per halaman
    public function index(Request $request): View
    {
        $apbdes = Apbdes::query()
            ->when($request->query('tahun'), fn ($query, $tahun) => $query->where('tahun', $tahun))
            ->latest('tahun')
            ->paginate(15);

        return view('admin.apbdes.index', compact('apbdes'));
    }

    // Form tambah pos baru
    public function create(): View
    {
        return view('admin.apbdes.create');
    }

    // Simpan pos anggaran baru
    public function store(StoreApbdesRequest $request): RedirectResponse
    {
        $pos = Apbdes::create($request->validated());

        return redirect()
            ->route('admin.apbdes.show', $pos)
            ->with('success', 'Pos anggaran tersimpan.');
    }

    // Detail satu pos anggaran
    public function show(Apbdes $apbde): View
    {
        return view('admin.apbdes.show', compact('apbde'));
    }

    // Form ubah pos anggaran
    public function edit(Apbdes $apbde): View
    {
        return view('admin.apbdes.edit', compact('apbde'));
    }

    // Simpan perubahan pos anggaran
    public function update(UpdateApbdesRequest $request, Apbdes $apbde): RedirectResponse
    {
        $apbde->update($request->validated());

        return redirect()
            ->route('admin.apbdes.show', $apbde)
            ->with('success', 'Pos anggaran diperbarui.');
    }

    // Hapus pos anggaran
    public function destroy(Apbdes $apbde): RedirectResponse
    {
        $apbde->delete();

        return redirect()
            ->route('admin.apbdes.index')
            ->with('success', 'Pos anggaran dihapus.');
    }
}
