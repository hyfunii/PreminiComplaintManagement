<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Auth;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next)
    {
        $user = Auth::user();

        if ($user && $user->role) {
            // Jika user memiliki role, lanjutkan ke halaman yang diminta
            return $next($request);
        }

        // Jika tidak ada role, redirect ke halaman yang diinginkan
        return redirect()->route('halaman.tanpa.role'); // Ganti dengan rute yang diinginkan
    }
}
