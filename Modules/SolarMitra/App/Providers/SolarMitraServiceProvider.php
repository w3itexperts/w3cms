<?php

namespace Modules\SolarMitra\App\Providers;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;
use Modules\SolarMitra\App\Http\Middleware\SolarMitraThemeLoader;
use Modules\SolarMitra\App\Http\Middleware\CheckBusinessAuth;
use Modules\SolarMitra\App\Http\Middleware\RedirectIfBusinessAuthenticated;
use Modules\SolarMitra\App\Http\Middleware\EnsureUserVerified;
use Modules\SolarMitra\App\Http\Middleware\SolarMitraConfigurations;
use Modules\SolarMitra\App\Console\CheckLeadFollowUp;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\AliasLoader;
use Modules\SolarMitra\Helper\SolarMitraHelper;
use Illuminate\Contracts\Http\Kernel;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Modules\SolarMitra\App\Models\Business;
use Modules\SolarMitra\App\Models\QuotationStatus;
use Modules\SolarMitra\App\Models\Contact;
use App\Models\User;
use Illuminate\Support\Facades\File;

class SolarMitraServiceProvider extends ServiceProvider
{
    protected string $moduleName = 'SolarMitra';

    protected string $moduleNameLower = 'solarmitra';

    /**
     * Boot the application events.
     */
    public function boot(): void
    {

        User::resolveRelationUsing('businesses', function ($user) {
            return $user->hasMany(Business::class, 'user_id');
        });

        User::resolveRelationUsing('contact', function ($user) {
            return $user->hasOne(Contact::class, 'user_id')->withoutGlobalScope('hide_business_contacts');
        });

        $this->app->bind('currentBusinessId', function () {

            if (\Auth::guard('api')->check()) {
                $authUser = \Auth::guard('api')->user()->load('contact','businesses');
            }
            if (\Auth::guard('business')->check()) {
                $authUser = \Auth::guard('business')->user()->load('contact','businesses');
            }
            if (empty($authUser)) return null;
                
            if  (optional($authUser->businesses)->isNotEmpty() && $authUser->businesses->first()->id) 
            {
                return optional(optional($authUser->businesses)->first())->id;
            }
            elseif($authUser->contact && optional($authUser->contact)->business_id)
            {
                return $authUser->contact->business_id;
            }
            return optional(optional($authUser->businesses)->first())->id;
            
        });
        $this->app->bind('currentBusinessUserId', function () {
            return \Auth::guard('business')->id;
        });

        $this->registerCommands();
        $this->registerCommandSchedules();
        $this->registerTranslations();
        $this->registerConfig();
        $this->registerViews();
        $this->loadMigrationsFrom(module_path($this->moduleName, 'Database/migrations'));

        User::retrieved(function ($user) {
            $user->mergeCasts([
                'mobile_verified_at' => 'datetime',
                'otp_expires_at'     => 'datetime',
            ]);
        });

        User::creating(function ($user) {
            $user->mergeCasts([
                'mobile_verified_at' => 'datetime',
                'otp_expires_at'     => 'datetime',
            ]);
        });
        

        /* Register Helper */
        AliasLoader::getInstance()->alias('SolarMitraHelper', SolarMitraHelper::class);
        
        /* Register Global Middleware */
        $kernel = $this->app->make(Kernel::class);
        $kernel->pushMiddleware(SolarMitraThemeLoader::class);
        // $kernel->pushMiddleware(SolarMitraConfigurations::class);

        /* Register Route Middleware */
        app()->make('router')->aliasMiddleware('SolarMitraConfigurations', SolarMitraConfigurations::class);
        app()->make('router')->aliasMiddleware('CheckBusinessAuth', CheckBusinessAuth::class);
        app()->make('router')->aliasMiddleware('EnsureUserVerified', EnsureUserVerified::class);
        app()->make('router')->aliasMiddleware('guest.business', RedirectIfBusinessAuthenticated::class);
       

        /* Add module Assets to global */
        $link = public_path('modules/solarmitra');
        $target = module_path('SolarMitra', 'resources/assets');

        // Create the parent directory if it doesn't exist
        File::ensureDirectoryExists(dirname($link));

        // Only create the symlink if it doesn't already exist
        if (! File::exists($link) && ! is_link($link)) {
            try {
                File::link($target, $link);
            } catch (\Throwable $e) {
                // Windows or environments where symlinks are not allowed
                File::copyDirectory($target, $link);
            }
        }
        /* Add module Assets to global End */

        $this->ensureDompdfFontsDirectoryExists();
    }

    /**
     * Ensure storage/fonts exists and is writable.
     * DomPDF does NOT create this directory itself — it only
     * writes cache files INTO it, so if the folder is missing
     * (fresh clone, wiped deploy, Docker volume, etc.) PDF
     * generation fails with a fopen() error.
     */
    protected function ensureDompdfFontsDirectoryExists(): void
    {
        $fontsPath = storage_path('fonts');

        if (!File::exists($fontsPath)) {
            File::makeDirectory($fontsPath, 0775, true, true);
        }

        // Keep a .gitkeep so the (empty) folder survives in git
        $gitkeep = $fontsPath . DIRECTORY_SEPARATOR . '.gitkeep';
        if (!File::exists($gitkeep)) {
            File::put($gitkeep, '');
        }

        // Optional but recommended: fail loudly in logs (not to user)
        // if permissions are wrong, instead of a cryptic fopen error later.
        if (!is_writable($fontsPath)) {
            logger()->warning("storage/fonts exists but is not writable by PHP process: {$fontsPath}");
        }
    }

    /**
     * Register the service provider.
     */
    public function register(): void
    {
        $this->app->register(RouteServiceProvider::class);
    }

    /**
     * Register commands in the format of Command::class
     */
    protected function registerCommands(): void
    {
        $this->commands([
            CheckLeadFollowUp::class,
        ]);
    }

    /**
     * Register command Schedules.
     */
    protected function registerCommandSchedules(): void
    {
        $this->app->booted(function () {
            $schedule = $this->app->make(Schedule::class);
            $schedule->command('solarmitra:check-lead-followup')->daily()->withoutOverlapping();
        });
    }

    /**
     * Register translations.
     */
    public function registerTranslations(): void
    {
        $langPath = resource_path('lang/modules/'.$this->moduleNameLower);

        if (is_dir($langPath)) {
            $this->loadTranslationsFrom($langPath, $this->moduleNameLower);
            $this->loadJsonTranslationsFrom($langPath);
        } else {
            $this->loadTranslationsFrom(module_path($this->moduleName, 'lang'), $this->moduleNameLower);
            $this->loadJsonTranslationsFrom(module_path($this->moduleName, 'lang'));
        }
    }


    /**
     * Register config.
     */
    protected function registerConfig(): void
    {
        $this->publishes([module_path($this->moduleName, 'config/config.php') => config_path($this->moduleNameLower.'.php')], 'config');
        $this->mergeConfigFrom(module_path($this->moduleName, 'config/config.php'), $this->moduleNameLower);
    }

    /**
     * Register views.
     */
    public function registerViews(): void
    {
        $viewPath = resource_path('views/modules/'.$this->moduleNameLower);
        $sourcePath = module_path($this->moduleName, 'resources/views');

        $this->publishes([$sourcePath => $viewPath], ['views', $this->moduleNameLower.'-module-views']);

        $this->loadViewsFrom(array_merge($this->getPublishableViewPaths(), [$sourcePath]), $this->moduleNameLower);

        $componentNamespace = str_replace('/', '\\', config('modules.namespace').'\\'.$this->moduleName.'\\'.config('modules.paths.generator.component-class.path'));
        Blade::componentNamespace($componentNamespace, $this->moduleNameLower);
    }

    /**
     * Get the services provided by the provider.
     */
    public function provides(): array
    {
        return [];
    }

    private function getPublishableViewPaths(): array
    {
        $paths = [];
        foreach (config('view.paths') as $path) {
            if (is_dir($path.'/modules/'.$this->moduleNameLower)) {
                $paths[] = $path.'/modules/'.$this->moduleNameLower;
            }
        }

        return $paths;
    }
}
