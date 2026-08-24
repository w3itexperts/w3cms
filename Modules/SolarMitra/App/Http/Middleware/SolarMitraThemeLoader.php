<?php

namespace Modules\SolarMitra\App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Hexadog\ThemesManager\Facades\ThemesManager;

class SolarMitraThemeLoader
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next)
    {
        if ($request->segment(1) === 'business') {
            $theme = ThemesManager::has('admin/business') ? 'admin/business' : 'admin/zenix'; 
            ThemesManager::set($theme);
        }

        return $next($request);
    }
}
