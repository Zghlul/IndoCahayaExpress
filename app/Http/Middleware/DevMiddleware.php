<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class DevMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        if (auth()->check() && in_array(auth()->user()->role, ['dev'])) {
            return $next($request);
        }

        abort(404, 'Page not found.');
    }
}