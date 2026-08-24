<?php

namespace Modules\SolarMitra\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ClientGroupSeeder extends Seeder
{
    public function run(): void
    {
        $groups = [
            ['title' => 'Residential', 'business_id' => 0, 'created_at' => now(), 'updated_at' => now()],
            ['title' => 'Commercial', 'business_id' => 0, 'created_at' => now(), 'updated_at' => now()],
            ['title' => 'Industrial', 'business_id' => 0, 'created_at' => now(), 'updated_at' => now()],
            ['title' => 'Government', 'business_id' => 0, 'created_at' => now(), 'updated_at' => now()],
            ['title' => 'Institutional', 'business_id' => 0, 'created_at' => now(), 'updated_at' => now()],
        ];

        DB::table('client_groups')->insert($groups);
    }
}
