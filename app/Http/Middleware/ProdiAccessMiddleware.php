<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ProdiAccessMiddleware
{
    /**
     * Handle an incoming request.
     * Memastikan user hanya bisa akses data prodi mereka (kecuali admin)
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!auth()->check()) {
            return redirect()->route('login');
        }

        $user = auth()->user();

        // Admin bisa akses semua prodi
        if ($user->isAdmin()) {
            return $next($request);
        }

        // Untuk kaprodi dan anggota, cek apakah mereka punya prodi_id
        if (!$user->prodi_id) {
            abort(403, 'Anda belum terdaftar di prodi manapun. Hubungi administrator.');
        }

        return $next($request);
    }
}
