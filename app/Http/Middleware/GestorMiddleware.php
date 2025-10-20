<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class GestorMiddleware
{
    public function handle($request, Closure $next)
    {
        if (Auth::check() && Auth::user()->isGestor()) {
            return $next($request);
        }

        abort(403, 'Acesso negado.');
    }
}
