<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        $request->authenticate();

        // Akun menunggu/ditolak tidak boleh masuk walau password benar
        $status = $request->user()->status;

        if ($status !== 'disetujui') {
            // Keluar lagi + siapkan pesan sesuai status untuk halaman login
            Auth::logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();

            throw ValidationException::withMessages([
                'email' => $status === 'ditolak'
                    ? 'Akun anda ditolak. Hubungi perangkat desa untuk info lanjut.'
                    : 'Akun anda sedang menunggu persetujuan admin.',
            ]);
        }

        $request->session()->regenerate();

        // Arahkan sesuai peran: admin ke dashboard admin, warga ke dashboard warga
        $tujuan = $request->user()->isAdmin()
            ? route('admin.dashboard', absolute: false)
            : route('warga.dashboard', absolute: false);

        // Abaikan URL tujuan jika beda area peran (mis. admin yang terpental
        // dari halaman warga saat belum login tetap ke dashboard admin)
        $tertuju = $request->session()->get('url.intended');
        if (is_string($tertuju)) {
            $path = parse_url($tertuju, PHP_URL_PATH) ?: '/';
            if (str_starts_with($path, '/admin') !== $request->user()->isAdmin()) {
                $request->session()->forget('url.intended');
            }
        }

        return redirect()->intended($tujuan);
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
