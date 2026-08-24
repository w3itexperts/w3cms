<?php

namespace Modules\SolarMitra\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CountrySeeder extends Seeder
{
    public function run(): void
    {
        $countries = [
            ['name' => 'India', 'code' => 'IN', 'status' => true, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'United States', 'code' => 'US', 'status' => true, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'United Kingdom', 'code' => 'GB', 'status' => true, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Australia', 'code' => 'AU', 'status' => true, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'United Arab Emirates', 'code' => 'AE', 'status' => true, 'created_at' => now(), 'updated_at' => now()],
        ];

        DB::table('countries')->insert($countries);
    }
}
