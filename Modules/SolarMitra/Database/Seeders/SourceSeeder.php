<?php

namespace Modules\SolarMitra\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SourceSeeder extends Seeder
{
    public function run(): void
    {
        $sources = [
            ['business_id' => 0, 'name' => 'Google Ads', 'slug' => 'google-ads', 'type' => 1, 'is_active' => true, 'created_at' => now(), 'updated_at' => now()],
            ['business_id' => 0, 'name' => 'Facebook Ads', 'slug' => 'facebook-ads', 'type' => 1, 'is_active' => true, 'created_at' => now(), 'updated_at' => now()],
            ['business_id' => 0, 'name' => 'Instagram', 'slug' => 'instagram', 'type' => 1, 'is_active' => true, 'created_at' => now(), 'updated_at' => now()],
            ['business_id' => 0, 'name' => 'Existing Client', 'slug' => 'existing-client', 'type' => 3, 'is_active' => true, 'created_at' => now(), 'updated_at' => now()],
            ['business_id' => 0, 'name' => 'Employee Referral', 'slug' => 'employee-referral', 'type' => 3, 'is_active' => true, 'created_at' => now(), 'updated_at' => now()],
            ['business_id' => 0, 'name' => 'Partner Network', 'slug' => 'partner-network', 'type' => 4, 'is_active' => true, 'created_at' => now(), 'updated_at' => now()],
            ['business_id' => 0, 'name' => 'Dealer', 'slug' => 'dealer', 'type' => 4, 'is_active' => true, 'created_at' => now(), 'updated_at' => now()],
            ['business_id' => 0, 'name' => 'Distributor', 'slug' => 'distributor', 'type' => 4, 'is_active' => true, 'created_at' => now(), 'updated_at' => now()],
        ];

        DB::table('sources')->insert($sources);
    }
}
