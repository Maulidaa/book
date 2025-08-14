<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, ...$roles)
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        // Cek apakah role_id user termasuk yang diizinkan
        if (!in_array(Auth::user()->role_id, $roles)) {
            abort(403, 'Unauthorized');
        }

        return $next($request);
    }
}
