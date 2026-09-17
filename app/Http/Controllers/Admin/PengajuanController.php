<?php

// Controller verifikasi pengajuan sisi ADMIN - periksa berkas dan tentukan status

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PengajuanLayanan;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PengajuanController extends Controller
{
    // Semua pengajuan + pemohon dan layanan, bisa saring per status, terbaru dulu 15 per halaman
    public function index(Request $request): View
    {
        $pengajuans = PengajuanLayanan::with(['user:id,name', 'layanan:id,nama'])
            ->when($request->query('status'), fn ($query, $status) => $query->byStatus($status))
            ->latest()
            ->paginate(15);

        return view('admin.pengajuan.index', compact('pengajuans'));
    }

    // Detail pengajuan + berkas syarat terunggah untuk diverifikasi
    public function show(PengajuanLayanan $pengajuan): View
    {
        $pengajuan->load(['user:id,name', 'layanan:id,nama', 'uploadSyaratLayanan.syaratLayanan:id,nama,tipe']);

        return view('admin.pengajuan.show', compact('pengajuan'));
    }

    // Ubah status + catatan (mis. alasan penolakan)
    public function update(Request $request, PengajuanLayanan $pengajuan): RedirectResponse
    {
        // Satu-satunya input: status baru dan catatan admin
        $data = $request->validate([
            'status' => ['required', 'in:menunggu,diproses,selesai,ditolak'],
            'catatan' => ['nullable', 'string'],
        ]);

        $pengajuan->update($data);

        return redirect()
            ->route('admin.pengajuan.show', $pengajuan)
            ->with('success', 'Status pengajuan diperbarui.');
    }
}
