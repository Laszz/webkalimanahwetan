<?php

// Middleware tamu-404 - pengganti auth untuk area login agar URL tak bocor ke publik

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class Tamu404
{
    /**
     * Belum login = halaman dianggap tidak ada (404), bukan dilempar ke login.
     * Tujuannya agar tamu/hacker tak bisa membedakan URL asli vs ngawur.
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (! auth()->check()) {
            abort(404);
        }

        return $next($request);
    }
}
