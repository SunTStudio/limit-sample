<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next, ...$roles)
    {
        // Ambil role dari session
        $userRoles = session('roles', []);

        // Periksa apakah role yang diminta ada di dalam array roles
        // Check if any of the required roles exist in the user's roles
        foreach ($roles as $role) {
            if (in_array($role, $userRoles)) {
                return $next($request);
            }
        }

        // Jika role tidak ada, redirect ke halaman akses ditolak atau halaman lain
        // dd(in_array($role, $roles));
        return redirect()->route('access-denied');
    }
}
