<?php

namespace Modules\SolarMitra\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class StateSeeder extends Seeder
{
    public function run(): void
    {
        if (DB::table('states')->exists()) {
            $this->command?->warn('states table is not empty. Skipping StateSeeder.');
            return;
        }

        DB::unprepared(
            file_get_contents(
                module_path('SolarMitra', 'Database/data/states.sql')
            )
        );

        $this->command?->info('States seeded successfully.');
    }
}
