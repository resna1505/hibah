<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    /**
     * Pakai sebagai: ->middleware('role:operator')
     *                ->middleware('role:dosen')
     *                ->middleware('role:reviewer')
     *                ->middleware('role:operator,dosen')
     *
     * Note: 'reviewer' bukan role di users_m, melainkan dosen dengan is_reviewer=true.
     */
    public function handle(Request $request, Closure $next, string ...$allowedRoles): Response
    {
        $user = $request->user();

        if (! $user || ! $user->is_active) {
            auth()->logout();
            return redirect()->route('login')->with('error', 'Sesi tidak valid atau akun nonaktif.');
        }

        foreach ($allowedRoles as $role) {
            if ($role === 'reviewer') {
                if ($user->isReviewer()) {
                    return $next($request);
                }
                continue;
            }

            if ($user->role === $role) {
                return $next($request);
            }
        }

        abort(403, 'Anda tidak memiliki akses ke halaman ini.');
    }
}
