<?php

namespace Modules\SolarMitra\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SourceSeeder extends Seeder
{
    public function run(): void
    {
        $channels = DB::table('channels')->pluck('id', 'slug');
        
        $sources = [
            ['business_id' => 0, 'name' => 'Google Ads', 'slug' => 'google-ads', 'type' => 1, 'channel_id' => $channels['social-media'] ?? null, 'is_active' => true, 'created_at' => now(), 'updated_at' => now()],
            ['business_id' => 0, 'name' => 'Facebook Ads', 'slug' => 'facebook-ads', 'type' => 1, 'channel_id' => $channels['social-media'] ?? null, 'is_active' => true, 'created_at' => now(), 'updated_at' => now()],
            ['business_id' => 0, 'name' => 'Instagram', 'slug' => 'instagram', 'type' => 1, 'channel_id' => $channels['social-media'] ?? null, 'is_active' => true, 'created_at' => now(), 'updated_at' => now()],
            ['business_id' => 0, 'name' => 'Existing Client', 'slug' => 'existing-client', 'type' => 3, 'channel_id' => $channels['referral'] ?? null, 'is_active' => true, 'created_at' => now(), 'updated_at' => now()],
            ['business_id' => 0, 'name' => 'Employee Referral', 'slug' => 'employee-referral', 'type' => 3, 'channel_id' => $channels['referral'] ?? null, 'is_active' => true, 'created_at' => now(), 'updated_at' => now()],
            ['business_id' => 0, 'name' => 'Partner Network', 'slug' => 'partner-network', 'type' => 4, 'channel_id' => $channels['referral'] ?? null, 'is_active' => true, 'created_at' => now(), 'updated_at' => now()],
            ['business_id' => 0, 'name' => 'Dealer', 'slug' => 'dealer', 'type' => 4, 'channel_id' => $channels['walk-in'] ?? null, 'is_active' => true, 'created_at' => now(), 'updated_at' => now()],
            ['business_id' => 0, 'name' => 'Distributor', 'slug' => 'distributor', 'type' => 4, 'channel_id' => $channels['walk-in'] ?? null, 'is_active' => true, 'created_at' => now(), 'updated_at' => now()],
            ['business_id' => 0, 'name' => 'Phone Contact List', 'slug' => 'phone-contact-list', 'type' => 3, 'channel_id' => $channels['referral'] ?? null, 'is_active' => true, 'created_at' => now(), 'updated_at' => now()],
        ];

        foreach ($sources as $record) {
            $exists = DB::table('sources')
                ->where('business_id', $record['business_id'])
                ->where('slug', $record['slug'])
                ->exists();

            if (!$exists) {
                DB::table('sources')->insert($record);
            }
        }
    }
}
