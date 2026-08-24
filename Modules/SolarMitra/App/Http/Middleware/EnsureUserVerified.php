<?php

namespace Modules\SolarMitra\App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class EnsureUserVerified
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next)
    {
        $user = auth()->user();
        if (
            !$user->is_email_verified &&
            !$user->is_mobile_verified
        ) {
            return redirect()->route('business.solarmitra.auth.verification');
        }

        return $next($request);
    }
}
