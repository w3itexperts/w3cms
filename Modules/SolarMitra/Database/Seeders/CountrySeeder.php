<?php

namespace Modules\SolarMitra\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CountrySeeder extends Seeder
{
    public function run(): void
    {
        if (DB::table('countries')->exists()) {
            $this->command?->warn('countries table is not empty. Skipping CountrySeeder.');
            return;
        }

        DB::unprepared(
            file_get_contents(
                module_path('SolarMitra', 'Database/data/countries.sql')
            )
        );

        $this->command?->info('Countries seeded successfully.');
    }
}
