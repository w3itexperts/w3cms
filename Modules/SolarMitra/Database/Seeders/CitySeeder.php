<?php

namespace Modules\SolarMitra\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CitySeeder extends Seeder
{
    public function run(): void
    {
        if (DB::table('cities')->exists()) {
            $this->command?->warn('cities table is not empty. Skipping CitySeeder.');
            return;
        }

        DB::unprepared(
            file_get_contents(
                module_path('SolarMitra', 'Database/data/cities.sql')
            )
        );

        $this->command?->info('Cities seeded successfully.');
    }
}
