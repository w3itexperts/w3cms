<?php

namespace Modules\SolarMitra\App\Providers;

use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * The module namespace to assume when generating URLs to actions.
     */
    protected string $moduleNamespace = 'Modules\SolarMitra\App\Http\Controllers';

    /**
     * Called before routes are registered.
     *
     * Register any model bindings or pattern based filters.
     */
    public function boot(): void
    {
        parent::boot();
    }

    /**
     * Define the routes for the application.
     */
    public function map(): void
    {
        $this->mapWebRoutes();

        $this->mapApiRoutes();
    }

    /**
     * Define the "web" routes for the application.
     *
     * These routes all receive session state, CSRF protection, etc.
     */
    protected function mapWebRoutes(): void
    {
        Route::middleware(['web','SolarMitraConfigurations'])
            ->namespace($this->moduleNamespace)
            ->group(module_path('SolarMitra', '/routes/web.php'));

        Route::middleware(['web','SolarMitraConfigurations'])
            ->namespace($this->moduleNamespace.'\Admin')
            ->group(module_path('SolarMitra', '/routes/admin.php'));
        
        Route::middleware(['web','SolarMitraConfigurations'])
            ->namespace($this->moduleNamespace.'\Business')
            ->prefix('business')->name('business.')
            ->group(module_path('SolarMitra', '/routes/business.php'));
    }

    /**
     * Define the "api" routes for the application.
     *
     * These routes are typically stateless.
     */
    protected function mapApiRoutes(): void
    {
        Route::prefix('api')
            ->middleware(['api','SolarMitraConfigurations'])
            ->namespace($this->moduleNamespace.'\Api')
            ->group(module_path('SolarMitra', '/routes/api.php'));
    }
}
