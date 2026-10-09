<?php

// Middleware non-admin - area warga khusus bukan admin, admin dibelokkan pulang

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class NonAdmin
{
    /**
     * Sudah login tapi admin = salah kamar, belokkan diam-diam ke dashboard admin.
     * Tamu sudah disaring tamu404 sebelumnya, jadi di sini pasti sudah login.
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (auth()->check() && auth()->user()->isAdmin()) {
            return redirect()->route('admin.dashboard');
        }

        return $next($request);
    }
}
