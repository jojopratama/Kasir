<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CekRole
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next, $role)
    {
        if (Auth::check()) {
            if (Auth::user()->role !== $role) {
                abort(403, 'Akses ditolak.');
            }

            return $next($request);
        }

        // Kalau belum login
        return redirect()->route('login');
    }
}
