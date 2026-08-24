<?php

namespace Modules\SolarMitra\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ChannelSeeder extends Seeder
{
    public function run(): void
    {
        $channels = [
            ['business_id' => 0, 'title' => 'Website', 'slug' => 'website', 'description' => 'Website inquiries', 'is_active' => true, 'created_at' => now(), 'updated_at' => now()],
            ['business_id' => 0, 'title' => 'Referral', 'slug' => 'referral', 'description' => 'Referral leads', 'is_active' => true, 'created_at' => now(), 'updated_at' => now()],
            ['business_id' => 0, 'title' => 'Social Media', 'slug' => 'social-media', 'description' => 'Social media leads', 'is_active' => true, 'created_at' => now(), 'updated_at' => now()],
            ['business_id' => 0, 'title' => 'Cold Call', 'slug' => 'cold-call', 'description' => 'Cold calling leads', 'is_active' => true, 'created_at' => now(), 'updated_at' => now()],
            ['business_id' => 0, 'title' => 'Walk-in', 'slug' => 'walk-in', 'description' => 'Walk-in inquiries', 'is_active' => true, 'created_at' => now(), 'updated_at' => now()],
            ['business_id' => 0, 'title' => 'Email Campaign', 'slug' => 'email-campaign', 'description' => 'Email marketing leads', 'is_active' => true, 'created_at' => now(), 'updated_at' => now()],
            ['business_id' => 0, 'title' => 'Trade Show', 'slug' => 'trade-show', 'description' => 'Trade show and exhibition leads', 'is_active' => true, 'created_at' => now(), 'updated_at' => now()],
        ];

        DB::table('channels')->insert($channels);
    }
}
