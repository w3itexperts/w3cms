<?php

namespace Modules\SolarMitra\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BusinessRoleSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Insert top-level parent: Business
        DB::table('roles')->insert([
            'name'        => 'Business',
            'guard_name'  => 'business',
            'role_type'   => 'Business',
            'level'       => 0,
            'status'      => true,
            'description' => 'Business owner and primary administrator',
            'created_at'  => now(),
            'updated_at'  => now(),
        ]);

        $ownerId = DB::table('roles')->where('name', 'Business')->where('guard_name', 'business')->value('id');

        // 2. Insert level 1 roles under Business
        $level1Roles = [
            ['name' => 'Business Staff',       'description' => 'Staff members of the business'],
            ['name' => 'Business Clients',     'description' => 'Client users of the business'],
            ['name' => 'Business Contractor',  'description' => 'Contractor users of the business'],
            ['name' => 'Business Suppliers',   'description' => 'Supplier users of the business'],
            ['name' => 'Business Investors',   'description' => 'Investor users of the business'],
            ['name' => 'Business Partners',    'description' => 'Partner users of the business'],
        ];

        foreach ($level1Roles as $role) {
            DB::table('roles')->insert([
                'name'        => $role['name'],
                'guard_name'  => 'business',
                'role_type'   => 'Business',
                'parent_id'   => $ownerId,
                'level'       => 1,
                'status'      => true,
                'description' => $role['description'],
                'created_at'  => now(),
                'updated_at'  => now(),
            ]);
        }

        // 3. Get Business Staff ID for child roles
        $staffId = DB::table('roles')->where('name', 'Business Staff')->where('guard_name', 'business')->value('id');

        // 4. Insert level 2 roles under Business Staff
        $staffChildren = [
            ['name' => 'CEO',                      'description' => 'Chief Executive Officer'],
            ['name' => 'Operations Manager',       'description' => 'Manages day-to-day operations'],
            ['name' => 'Project Manager',          'description' => 'Manages solar projects'],
            ['name' => 'Sales Manager',            'description' => 'Manages sales team and pipeline'],
            ['name' => 'Sales Executive',          'description' => 'Handles sales activities and client acquisition'],
            ['name' => 'CRM / Lead Manager',       'description' => 'Manages CRM and lead pipeline'],
            ['name' => 'Solar Design Engineer',    'description' => 'Handles solar system design and engineering'],
            ['name' => 'Site Survey Engineer',     'description' => 'Conducts site surveys and assessments'],
            ['name' => 'Installation Supervisor',  'description' => 'Supervises solar panel installation'],
            ['name' => 'Solar Technician',         'description' => 'Handles technical installation and maintenance'],
            ['name' => 'Service Engineer',         'description' => 'Manages post-installation service and support'],
            ['name' => 'Procurement Manager',      'description' => 'Manages material procurement and vendors'],
            ['name' => 'Inventory Manager',        'description' => 'Manages inventory and stock'],
            ['name' => 'Accounts Manager',         'description' => 'Manages accounts and finances'],
            ['name' => 'Customer Support',         'description' => 'Handles customer inquiries and support'],
        ];

        foreach ($staffChildren as $child) {
            DB::table('roles')->insert([
                'name'        => $child['name'],
                'guard_name'  => 'business',
                'role_type'   => 'Business',
                'parent_id'   => $staffId,
                'level'       => 2,
                'status'      => true,
                'description' => $child['description'],
                'created_at'  => now(),
                'updated_at'  => now(),
            ]);
        }
    }
}
