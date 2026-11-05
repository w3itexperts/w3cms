<?php

namespace Modules\SolarMitra\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MaterialUnitSeeder extends Seeder
{
    public function run(): void
    {
        $units = [
            ['title' => 'PCS', 'created_at' => now(), 'updated_at' => now()],
            ['title' => 'SQM', 'created_at' => now(), 'updated_at' => now()],
            ['title' => 'METER', 'created_at' => now(), 'updated_at' => now()],
            ['title' => 'BOX', 'created_at' => now(), 'updated_at' => now()],
            ['title' => 'SET', 'created_at' => now(), 'updated_at' => now()],
            ['title' => 'KG', 'created_at' => now(), 'updated_at' => now()],
            ['title' => 'ROLL', 'created_at' => now(), 'updated_at' => now()],
            ['title' => 'BUNDLE', 'created_at' => now(), 'updated_at' => now()],
            ['title' => 'PAIR', 'created_at' => now(), 'updated_at' => now()],
            ['title' => 'NOS', 'created_at' => now(), 'updated_at' => now()],
        ];

        foreach ($units as $record) {
            $exists = DB::table('material_units')
                ->where('title', $record['title'])
                ->exists();

            if (!$exists) {
                DB::table('material_units')->insert($record);
            }
        }
    }
}
