<?php

// Controller aduan sisi ADMIN - pantau semua laporan dan ubah status tindak lanjut

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Aduan;
use App\Notifications\AduanStatus;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AduanController extends Controller
{
    // Semua aduan + nama pelapor, bisa saring per status, terbaru dulu 15 per halaman
    public function index(Request $request): View
    {
        $aduans = Aduan::with('user:id,name')
            ->when($request->query('status'), fn ($query, $status) => $query->byStatus($status))
            ->latest()
            ->paginate(15);

        return view('admin.aduan.index', compact('aduans'));
    }

    // Detail aduan + daftar tanggapan untuk diverifikasi dan dibalas
    public function show(Aduan $aduan): View
    {
        $aduan->load(['user:id,name', 'tanggapanAduan.user:id,name']);

        return view('admin.aduan.show', compact('aduan'));
    }

    // Ubah status tindak lanjut (menunggu/diproses/selesai)
    public function update(Request $request, Aduan $aduan): RedirectResponse
    {
        // Satu-satunya input: status baru sesuai alur
        $data = $request->validate([
            'status' => ['required', 'in:menunggu,diproses,selesai'],
        ]);

        $aduan->update($data);

        // Beri tahu pelapor jika status benar berubah
        if ($aduan->wasChanged('status') && $aduan->user) {
            $aduan->user->notify(new AduanStatus($aduan));
        }

        return redirect()
            ->route('admin.aduan.index')
            ->with('success', 'Status aduan diperbarui.');
    }
}
