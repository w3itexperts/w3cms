<?php

namespace Modules\SolarMitra\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LeadStageSeeder extends Seeder
{
    public function run(): void
    {
        $stages = [
            [
                'name' => 'New',
                'slug' => 'new',
                'order' => 1,
                'color' => '#6c757d',
                'is_final' => false,
                'is_success' => false,
                'description' => null,
                'created_at' => '2026-01-29 10:42:23',
                'updated_at' => '2026-01-29 10:42:23',
            ],
            [
                'name' => 'Contacted',
                'slug' => 'contacted',
                'order' => 2,
                'color' => '#17a2b8',
                'is_final' => false,
                'is_success' => false,
                'description' => null,
                'created_at' => '2026-01-29 10:42:23',
                'updated_at' => '2026-01-29 10:42:23',
            ],
            [
                'name' => 'Qualified',
                'slug' => 'qualified',
                'order' => 3,
                'color' => '#007bff',
                'is_final' => false,
                'is_success' => false,
                'description' => null,
                'created_at' => '2026-01-29 10:42:23',
                'updated_at' => '2026-01-29 10:42:23',
            ],
            [
                'name' => 'Interested',
                'slug' => 'interested',
                'order' => 4,
                'color' => '#6610f2',
                'is_final' => false,
                'is_success' => false,
                'description' => null,
                'created_at' => '2026-01-29 10:42:23',
                'updated_at' => '2026-01-29 10:42:23',
            ],
            [
                'name' => 'Proposal Sent',
                'slug' => 'proposal-sent',
                'order' => 5,
                'color' => '#fd7e14',
                'is_final' => false,
                'is_success' => false,
                'description' => null,
                'created_at' => '2026-01-29 10:42:23',
                'updated_at' => '2026-01-29 10:42:23',
            ],
            [
                'name' => 'Follow-Up',
                'slug' => 'follow-up',
                'order' => 6,
                'color' => '#ffc107',
                'is_final' => false,
                'is_success' => false,
                'description' => null,
                'created_at' => '2026-01-29 10:42:23',
                'updated_at' => '2026-01-29 10:42:23',
            ],
            [
                'name' => 'Negotiation',
                'slug' => 'negotiation',
                'order' => 7,
                'color' => '#20c997',
                'is_final' => false,
                'is_success' => false,
                'description' => null,
                'created_at' => '2026-01-29 10:42:23',
                'updated_at' => '2026-01-29 10:42:23',
            ],
            [
                'name' => 'Won',
                'slug' => 'won',
                'order' => 8,
                'color' => '#28a745',
                'is_final' => true,
                'is_success' => true,
                'description' => null,
                'created_at' => '2026-01-29 10:42:23',
                'updated_at' => '2026-01-29 10:42:23',
            ],
            [
                'name' => 'Lost',
                'slug' => 'lost',
                'order' => 9,
                'color' => '#dc3545',
                'is_final' => true,
                'is_success' => false,
                'description' => null,
                'created_at' => '2026-01-29 10:42:23',
                'updated_at' => '2026-01-29 10:42:23',
            ],
            [
                'name' => 'On Hold',
                'slug' => 'on-hold',
                'order' => 10,
                'color' => '#adb5bd',
                'is_final' => false,
                'is_success' => false,
                'description' => null,
                'created_at' => '2026-01-29 10:42:23',
                'updated_at' => '2026-01-29 10:42:23',
            ],
            [
                'name' => 'Incomplete',
                'slug' => 'incomplete',
                'order' => 11,
                'color' => '#ff4c41',
                'is_final' => false,
                'is_success' => false,
                'description' => null,
                'created_at' => '2026-05-05 11:21:05',
                'updated_at' => '2026-05-05 12:15:22',
            ],
        ];

        foreach ($stages as $record) {
            $exists = DB::table('lead_stages')
                ->where('slug', $record['slug'])
                ->exists();

            if (!$exists) {
                DB::table('lead_stages')->insert($record);
            }
        }

    }
}
