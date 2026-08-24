<?php

namespace Modules\SolarMitra\App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Modules\SolarMitra\Helper\SolarMitraHelper;
use Modules\SolarMitra\App\Models\QuotationStatus;

class SolarMitraConfigurations
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next)
    {
        $timezone = SolarMitraHelper::getBusinessConfig('timezone','Asia/Kolkata');

        config(['app.timezone' => $timezone]);

        date_default_timezone_set($timezone);

        config([
            'solarmitra.quotations_status' => QuotationStatus::pluck('title', 'id')->toArray(),
            'solarmitra.date_format' => SolarMitraHelper::getBusinessConfig('date_format','F j, Y'),
            'solarmitra.time_format' => SolarMitraHelper::getBusinessConfig('time_format','g:i A'),
        ]);

        config([
            'solarmitra.date_time_format' => config('solarmitra.date_format') . ' ' .config('solarmitra.time_format'),
        ]);

        return $next($request);
    }
}
