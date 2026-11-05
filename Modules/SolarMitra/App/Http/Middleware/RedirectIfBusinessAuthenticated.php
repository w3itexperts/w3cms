<?php

namespace Modules\SolarMitra\App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class RedirectIfBusinessAuthenticated
{
    public function handle($request, Closure $next)
    {
        if (Auth::guard('business')->check()) {
            return redirect()->to('/business');
        }

        return $next($request);
    }
}