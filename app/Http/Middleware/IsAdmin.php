<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class IsAdmin
{
    public function handle(Request $request, Closure $next)
    {
        if (!Auth::check() || !Auth::user()->is_admin) {
            // Redirection avec message flash
            return redirect('/')->with('error', 'Accès interdit. Réservé aux administrateurs.');
        }

        return $next($request);
    }
}
