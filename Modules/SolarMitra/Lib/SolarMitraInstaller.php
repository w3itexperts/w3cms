<?php

namespace Modules\SolarMitra\Lib;

use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use RuntimeException;
use Throwable;

class SolarMitraInstaller
{
    public const VERSION = '1.0.0';

    public function install(): void
    {
        $this->checkRequirements();

        $this->runMigrations();

        $this->runSeeders();

        $this->clearCaches();
    }

    /**
     * Check whether the system meets SolarMitra requirements.
     */
    protected function checkRequirements(): void
    {
        // PHP version
        if (version_compare(PHP_VERSION, '8.2.0', '<')) {
            throw new RuntimeException(
                'SolarMitra requires PHP 8.2 or higher.'
            );
        }

        // Check required W3CMS version.
        if (version_compare(config('constants.version'), '2.8', '<')) {
            throw new RuntimeException(
                'SolarMitra requires W3CMS 2.8 or higher.'
            );
        }

        // Database connection
        try {
            DB::connection()->getPdo();
        } catch (Throwable $e) {
            throw new RuntimeException(
                'Unable to connect to the database.'
            );
        }

        // Migration directory
        if (!File::isDirectory($this->modulePath('Database/migrations'))) {
            throw new RuntimeException(
                'SolarMitra migration directory was not found.'
            );
        }
    }

    /**
     * Run SolarMitra migrations.
     */
    protected function runMigrations(): void
    {
        $this->output('Running SolarMitra migrations...');

        $exitCode = Artisan::call('migrate', [
            '--path' => 'Modules/SolarMitra/Database/migrations',
            '--force' => true,
        ]);

        if ($exitCode !== 0) {
            throw new RuntimeException(
                'SolarMitra migrations failed.' . PHP_EOL . Artisan::output()
            );
        }

        $this->output(Artisan::output());
    }

    /**
     * Run SolarMitra seeders.
     */
    protected function runSeeders(): void
    {
        $seederClass = 'Modules\\SolarMitra\\Database\\Seeders\\SolarMitraDatabaseSeeder';

        if (!class_exists($seederClass)) {
            return;
        }

        $this->output('Running SolarMitra seeders...');

        $exitCode = Artisan::call('db:seed', [
            '--class' => $seederClass,
            '--force' => true,
        ]);

        if ($exitCode !== 0) {
            throw new RuntimeException(
                'SolarMitra seeders failed.' . PHP_EOL . Artisan::output()
            );
        }

        $this->output(Artisan::output());
    }

    /**
     * Clear Laravel caches.
     */
    protected function clearCaches(): void
    {
        $this->output('Clearing Laravel caches...');

        Artisan::call('optimize:clear');

        $this->output(Artisan::output());
    }

    /**
     * Get SolarMitra module path.
     */
    protected function modulePath(string $path = ''): string
    {
        return base_path(
            'Modules/SolarMitra' .
            ($path ? DIRECTORY_SEPARATOR . ltrim($path, '/\\') : '')
        );
    }

    /**
     * Output helper.
     */
    protected function output(string $message): void
    {
        if (app()->runningInConsole()) {
            echo $message . PHP_EOL;
        }
    }
}