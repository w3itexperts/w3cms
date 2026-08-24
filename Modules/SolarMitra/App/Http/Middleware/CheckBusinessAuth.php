<?php

namespace Modules\SolarMitra\App\Http\Middleware;
use Illuminate\Support\Facades\Auth;
use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Closure;
use Illuminate\Http\Request;

class CheckBusinessAuth extends Middleware
{
    /**
     * Handle an incoming request.
     */
    

    protected function redirectTo(Request $request): ?string
    {
        $url = route('login');
        if($request->segment(1) === 'business') {
            $url = route('business.solarmitra.auth.login');
        }

        return $request->expectsJson() ? null : $url;
    }
}
