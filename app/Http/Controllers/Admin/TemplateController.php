<?php

// Controller template hasil sisi ADMIN - unggah Word resmi per layanan ke storage private

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreTemplateRequest;
use App\Http\Requests\Admin\UpdateTemplateRequest;
use App\Models\Layanan;
use App\Models\TemplateHasilLayanan;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class TemplateController extends Controller
{
    // Semua template + nama layanan, terbaru dulu 15 per halaman
    public function index(): View
    {
        $templates = TemplateHasilLayanan::with('layanan:id,nama')->latest()->paginate(15);

        return view('admin.template.index', compact('templates'));
    }

    // Form unggah template (pilih layanan yang belum punya template)
    public function create(): View
    {
        $layanans = Layanan::whereDoesntHave('templateHasilLayanan')->orderBy('nama')->get(['id', 'nama']);

        return view('admin.template.create', compact('layanans'));
    }

    // Simpan file Word ke storage private (tidak bisa diakses publik langsung)
    public function store(StoreTemplateRequest $request): RedirectResponse
    {
        $data = $request->validated();
        $data['file_path'] = $request->file('file')->store('template-hasil', 'local');

        TemplateHasilLayanan::create($data);

        return redirect()
            ->route('admin.template.index')
            ->with('success', 'Template tersimpan.');
    }

    // Form ganti file / ubah status pakai
    public function edit(TemplateHasilLayanan $template): View
    {
        return view('admin.template.edit', compact('template'));
    }

    // Simpan perubahan; file diganti hanya jika ada unggahan baru
    public function update(UpdateTemplateRequest $request, TemplateHasilLayanan $template): RedirectResponse
    {
        $data = [];

        if ($request->hasFile('file')) {
            $data['file_path'] = $request->file('file')->store('template-hasil', 'local');
        }

        // Checkbox tidak terkirim saat tidak dicentang = nonaktif
        $data['aktif'] = $request->boolean('aktif');

        $template->update($data);

        return redirect()
            ->route('admin.template.index')
            ->with('success', 'Template diperbarui.');
    }

    // Hapus template (file fisik dibersihkan menyusul via storage)
    public function destroy(TemplateHasilLayanan $template): RedirectResponse
    {
        $template->delete();

        return redirect()
            ->route('admin.template.index')
            ->with('success', 'Template dihapus.');
    }
}
