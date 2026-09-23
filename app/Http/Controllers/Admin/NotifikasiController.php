<?php

// Controller notifikasi sisi ADMIN - buka pemberitahuan warga

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;

class NotifikasiController extends Controller
{
    // Buka notifikasi: tandai dibaca lalu teruskan ke tautan tujuannya
    public function show(string $id): RedirectResponse
    {
        // Hanya milik sendiri yang bisa dibuka
        $notifikasi = auth()->user()->notifications()->findOrFail($id);
        $notifikasi->markAsRead();

        return redirect()->to($notifikasi->data['url'] ?? route('admin.dashboard'));
    }
}
