<?php

// Controller verifikasi akun sisi ADMIN - setujui atau tolak pendaftaran warga

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class UserController extends Controller
{
    // Semua akun warga + biodata, bisa saring per status, terbaru dulu 15 per halaman
    public function index(Request $request): View
    {
        $users = User::with('warga:id,user_id,nama,nik')
            ->where('role', 'warga')
            ->when($request->query('status'), fn ($query, $status) => $query->where('status', $status))
            ->latest()
            ->paginate(15);

        return view('admin.pengguna.index', compact('users'));
    }

    // Ubah status verifikasi akun (disetujui/ditolak)
    public function update(Request $request, User $user): RedirectResponse
    {
        // Satu-satunya input: status baru sesuai alur verifikasi
        $data = $request->validate([
            'status' => ['required', 'in:disetujui,ditolak'],
        ]);

        $user->update($data);

        return redirect()
            ->route('admin.pengguna.index')
            ->with('success', 'Status akun diperbarui.');
    }

    // Hapus akun warga beserta seluruh datanya (biodata, aduan, dsb ikut via cascade)
    public function destroy(User $user): RedirectResponse
    {
        // Cegah admin menghapus akunnya sendiri agar tidak terkunci di luar
        if ($user->id === auth()->id()) {
            return redirect()
                ->route('admin.pengguna.index')
                ->with('gagal', 'Akun sendiri tidak boleh dihapus.');
        }

        $user->delete();

        return redirect()
            ->route('admin.pengguna.index')
            ->with('success', 'Akun dihapus.');
    }
}
