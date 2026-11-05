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

        foreach ($groups as $record) {
            $exists = DB::table('client_groups')
                ->where('business_id', $record['business_id'])
                ->where('title', $record['title'])
                ->exists();

            if (!$exists) {
                DB::table('client_groups')->insert($record);
            }
        }
    }
}
