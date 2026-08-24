<?php

namespace Modules\SolarMitra\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\SolarMitra\App\Http\Controllers\Business\PermissionsController;

class SolarMitraDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $permissionObj = new PermissionsController;
        $permissionObj->generate_permissions();
        $permissionObj->add_to_permissions();

        $this->call([
            CountrySeeder::class,
            StateSeeder::class,
            CitySeeder::class,
            LeadStageSeeder::class,
            MaterialUnitSeeder::class,
            MaterialCategorySeeder::class,
            MaterialCompanySeeder::class,
            ChannelSeeder::class,
            SourceSeeder::class,
            ClientGroupSeeder::class,
            QuotationStatusSeeder::class,
            TransactionTypeSeeder::class,
            ProjectPhaseSeeder::class,
            ConfigMasterSeeder::class,
            BusinessRoleSeeder::class,
            RolePermissionSeeder::class,
            NotificationSeeder::class,
        ]);
    }
}
