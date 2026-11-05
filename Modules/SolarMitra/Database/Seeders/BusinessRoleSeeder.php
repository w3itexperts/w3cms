<?php

namespace Modules\SolarMitra\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BusinessRoleSeeder extends Seeder
{
    public function run(): void
    {
        // SolarMitra uses the existing W3CMS role hierarchy. Never insert
        // fixed IDs: role IDs belong to the customer's database.
        $ownerId = $this->firstOrCreateRole(
            'Business',
            null,
            0,
            'Business owner and primary administrator'
        );

        $level1Roles = [
            ['name' => 'Business Staff', 'description' => 'Staff members of the business'],
            ['name' => 'Business Clients', 'description' => 'Client users of the business'],
            ['name' => 'Business Contractor', 'description' => 'Contractor users of the business'],
            ['name' => 'Business Suppliers', 'description' => 'Supplier users of the business'],
            ['name' => 'Business Investors', 'description' => 'Investor users of the business'],
            ['name' => 'Business Partners', 'description' => 'Partner users of the business'],
        ];

        foreach ($level1Roles as $role) {
            $this->firstOrCreateRole(
                $role['name'],
                $ownerId,
                1,
                $role['description']
            );
        }

        $staffId = $this->roleId('Business Staff');

        if (!$staffId) {
            throw new \RuntimeException('Unable to find the Business Staff role.');
        }

        $staffChildren = [
            ['name' => 'CEO', 'description' => 'Chief Executive Officer'],
            ['name' => 'Operations Manager', 'description' => 'Manages day-to-day operations'],
            ['name' => 'Project Manager', 'description' => 'Manages solar projects'],
            ['name' => 'Sales Manager', 'description' => 'Manages sales team and pipeline'],
            ['name' => 'Sales Executive', 'description' => 'Handles sales activities and client acquisition'],
            ['name' => 'CRM / Lead Manager', 'description' => 'Manages CRM and lead pipeline'],
            ['name' => 'Solar Design Engineer', 'description' => 'Handles solar system design and engineering'],
            ['name' => 'Site Survey Engineer', 'description' => 'Conducts site surveys and assessments'],
            ['name' => 'Installation Supervisor', 'description' => 'Supervises solar panel installation'],
            ['name' => 'Solar Technician', 'description' => 'Handles technical installation and maintenance'],
            ['name' => 'Service Engineer', 'description' => 'Manages post-installation service and support'],
            ['name' => 'Procurement Manager', 'description' => 'Manages material procurement and vendors'],
            ['name' => 'Inventory Manager', 'description' => 'Manages inventory and stock'],
            ['name' => 'Accounts Manager', 'description' => 'Manages accounts and finances'],
            ['name' => 'Customer Support', 'description' => 'Handles customer inquiries and support'],
        ];

        foreach ($staffChildren as $child) {
            $this->firstOrCreateRole(
                $child['name'],
                $staffId,
                2,
                $child['description']
            );
        }
    }

    private function roleId(string $name): ?int
    {
        $id = DB::table('roles')
            ->where('name', $name)
            ->where('guard_name', 'business')
            ->where('role_type', 'Business')
            ->value('id');

        return $id ? (int) $id : null;
    }

    private function firstOrCreateRole(
        string $name,
        ?int $parentId,
        int $level,
        string $description
    ): int {
        $query = DB::table('roles')
            ->where('name', $name)
            ->where('guard_name', 'business')
            ->where('role_type', 'Business');

        $existingId = $query->value('id');

        if ($existingId) {
            return (int) $existingId;
        }

        return (int) DB::table('roles')->insertGetId([
            'name' => $name,
            'guard_name' => 'business',
            'role_type' => 'Business',
            'parent_id' => $parentId,
            'level' => $level,
            'status' => true,
            'description' => $description,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
