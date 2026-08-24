<?php

namespace Modules\SolarMitra\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class QuotationStatusSeeder extends Seeder
{
    public function run(): void
    {
        $statuses = [
            [
                'slug' => 'draft',
                 'title' => 'Draft',
                 'order_no' => 1,
                 'is_public' => false,
                 'can_edit' => true,
                 'can_convert' => false,
                 'is_final' => false,
                 'created_at' => now(),
                 'updated_at' => now()
             ],
            [
                'slug' => 'sent',
                 'title' => 'Sent',
                 'order_no' => 2,
                 'is_public' => true,
                 'can_edit' => true,
                 'can_convert' => false,
                 'is_final' => false,
                 'created_at' => now(),
                 'updated_at' => now()
             ],
            [
                'slug' => 'in-discussion',
                 'title' => 'In Discussion',
                 'order_no' => 3,
                 'is_public' => true,
                 'can_edit' => true,
                 'can_convert' => false,
                 'is_final' => false,
                 'created_at' => now(),
                 'updated_at' => now()
             ],
            [
                'slug' => 'on-hold',
                 'title' => 'On Hold',
                 'order_no' => 4,
                 'is_public' => false,
                 'can_edit' => true,
                 'can_convert' => false,
                 'is_final' => false,
                 'created_at' => now(),
                 'updated_at' => now()
             ],
            [
                'slug' => 'client-confirmed',
                 'title' => 'Client Confirmed',
                 'order_no' => 5,
                 'is_public' => true,
                 'can_edit' => false,
                 'can_convert' => true,
                 'is_final' => true,
                 'created_at' => now(),
                 'updated_at' => now()
             ],
            [
                'slug' => 'rejected',
                 'title' => 'Rejected',
                 'order_no' => 6,
                 'is_public' => false,
                 'can_edit' => false,
                 'can_convert' => false,
                 'is_final' => true,
                 'created_at' => now(),
                 'updated_at' => now()
             ],
        ];

        DB::table('quotation_statuses')->insert($statuses);
    }
}
