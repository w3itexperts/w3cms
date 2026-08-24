<?php

namespace Modules\SolarMitra\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class StateSeeder extends Seeder
{
    public function run(): void
    {
        $states = [
            ['country_id' => 1, 'name' => 'Andhra Pradesh', 'code' => 'AP', 'status' => true, 'created_at' => now(), 'updated_at' => now()],
            ['country_id' => 1, 'name' => 'Arunachal Pradesh', 'code' => 'AR', 'status' => true, 'created_at' => now(), 'updated_at' => now()],
            ['country_id' => 1, 'name' => 'Assam', 'code' => 'AS', 'status' => true, 'created_at' => now(), 'updated_at' => now()],
            ['country_id' => 1, 'name' => 'Bihar', 'code' => 'BR', 'status' => true, 'created_at' => now(), 'updated_at' => now()],
            ['country_id' => 1, 'name' => 'Chhattisgarh', 'code' => 'CG', 'status' => true, 'created_at' => now(), 'updated_at' => now()],
            ['country_id' => 1, 'name' => 'Goa', 'code' => 'GA', 'status' => true, 'created_at' => now(), 'updated_at' => now()],
            ['country_id' => 1, 'name' => 'Gujarat', 'code' => 'GJ', 'status' => true, 'created_at' => now(), 'updated_at' => now()],
            ['country_id' => 1, 'name' => 'Haryana', 'code' => 'HR', 'status' => true, 'created_at' => now(), 'updated_at' => now()],
            ['country_id' => 1, 'name' => 'Himachal Pradesh', 'code' => 'HP', 'status' => true, 'created_at' => now(), 'updated_at' => now()],
            ['country_id' => 1, 'name' => 'Jharkhand', 'code' => 'JH', 'status' => true, 'created_at' => now(), 'updated_at' => now()],
            ['country_id' => 1, 'name' => 'Karnataka', 'code' => 'KA', 'status' => true, 'created_at' => now(), 'updated_at' => now()],
            ['country_id' => 1, 'name' => 'Kerala', 'code' => 'KL', 'status' => true, 'created_at' => now(), 'updated_at' => now()],
            ['country_id' => 1, 'name' => 'Madhya Pradesh', 'code' => 'MP', 'status' => true, 'created_at' => now(), 'updated_at' => now()],
            ['country_id' => 1, 'name' => 'Maharashtra', 'code' => 'MH', 'status' => true, 'created_at' => now(), 'updated_at' => now()],
            ['country_id' => 1, 'name' => 'Manipur', 'code' => 'MN', 'status' => true, 'created_at' => now(), 'updated_at' => now()],
            ['country_id' => 1, 'name' => 'Meghalaya', 'code' => 'ML', 'status' => true, 'created_at' => now(), 'updated_at' => now()],
            ['country_id' => 1, 'name' => 'Mizoram', 'code' => 'MZ', 'status' => true, 'created_at' => now(), 'updated_at' => now()],
            ['country_id' => 1, 'name' => 'Nagaland', 'code' => 'NL', 'status' => true, 'created_at' => now(), 'updated_at' => now()],
            ['country_id' => 1, 'name' => 'Odisha', 'code' => 'OD', 'status' => true, 'created_at' => now(), 'updated_at' => now()],
            ['country_id' => 1, 'name' => 'Punjab', 'code' => 'PB', 'status' => true, 'created_at' => now(), 'updated_at' => now()],
            ['country_id' => 1, 'name' => 'Rajasthan', 'code' => 'RJ', 'status' => true, 'created_at' => now(), 'updated_at' => now()],
            ['country_id' => 1, 'name' => 'Sikkim', 'code' => 'SK', 'status' => true, 'created_at' => now(), 'updated_at' => now()],
            ['country_id' => 1, 'name' => 'Tamil Nadu', 'code' => 'TN', 'status' => true, 'created_at' => now(), 'updated_at' => now()],
            ['country_id' => 1, 'name' => 'Telangana', 'code' => 'TS', 'status' => true, 'created_at' => now(), 'updated_at' => now()],
            ['country_id' => 1, 'name' => 'Tripura', 'code' => 'TR', 'status' => true, 'created_at' => now(), 'updated_at' => now()],
            ['country_id' => 1, 'name' => 'Uttar Pradesh', 'code' => 'UP', 'status' => true, 'created_at' => now(), 'updated_at' => now()],
            ['country_id' => 1, 'name' => 'Uttarakhand', 'code' => 'UK', 'status' => true, 'created_at' => now(), 'updated_at' => now()],
            ['country_id' => 1, 'name' => 'West Bengal', 'code' => 'WB', 'status' => true, 'created_at' => now(), 'updated_at' => now()],
            ['country_id' => 1, 'name' => 'Delhi', 'code' => 'DL', 'status' => true, 'created_at' => now(), 'updated_at' => now()],
            ['country_id' => 1, 'name' => 'Jammu and Kashmir', 'code' => 'JK', 'status' => true, 'created_at' => now(), 'updated_at' => now()],
            ['country_id' => 1, 'name' => 'Ladakh', 'code' => 'LA', 'status' => true, 'created_at' => now(), 'updated_at' => now()],
            ['country_id' => 1, 'name' => 'Chandigarh', 'code' => 'CH', 'status' => true, 'created_at' => now(), 'updated_at' => now()],
            ['country_id' => 1, 'name' => 'Puducherry', 'code' => 'PY', 'status' => true, 'created_at' => now(), 'updated_at' => now()],
            ['country_id' => 1, 'name' => 'Andaman and Nicobar Islands', 'code' => 'AN', 'status' => true, 'created_at' => now(), 'updated_at' => now()],
            ['country_id' => 1, 'name' => 'Dadra and Nagar Haveli and Daman and Diu', 'code' => 'DD', 'status' => true, 'created_at' => now(), 'updated_at' => now()],
            ['country_id' => 1, 'name' => 'Lakshadweep', 'code' => 'LD', 'status' => true, 'created_at' => now(), 'updated_at' => now()],
        ];

        DB::table('states')->insert($states);
    }
}
