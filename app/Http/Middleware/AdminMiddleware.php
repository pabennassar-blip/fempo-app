<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class AdminMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        if (!auth()->check() || auth()->user()->email !== 'admin@fempo.local') {
            abort(403, 'Accés no autoritzat');
        }

        return $next($request);
    }
}
