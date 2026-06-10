<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MaintenanceMode
{
    public function handle(Request $request, Closure $next)
    {
        $maintenance = DB::table('system_settings')
                        ->where('key', 'maintenance_mode')
                        ->value('value');

        if ($maintenance == '1') {
            if (auth()->check() && in_array(auth()->user()->role, ['admin', 'owner', 'dev'])) {
                return $next($request);
            }
            if ($request->is('login') || $request->is('logout') || $request->is('admin*')) {
                return $next($request);
            }
            return response()->view('maintenance', [], 503);
        }

        return $next($request);
    }
}