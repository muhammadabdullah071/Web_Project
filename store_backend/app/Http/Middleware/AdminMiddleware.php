<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        // Not logged in → redirect to login
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Please login to access the admin panel.');
        }

        // Logged in but not admin/owner → 403
        if (Auth::user()->is_admin || Auth::user()->role === \App\Models\User::ROLE_ADMIN || Auth::user()->role === \App\Models\User::ROLE_OWNER) {
            return $next($request);
        }

        abort(403, 'Unauthorized. This area is reserved for Platform Executives.');
    }
}
