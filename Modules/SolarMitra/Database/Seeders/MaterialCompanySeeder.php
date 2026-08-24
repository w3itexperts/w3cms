<?php

namespace Modules\SolarMitra\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MaterialCompanySeeder extends Seeder
{
    public function run(): void
    {
        $companies = [
            ['title' => 'TATA Power Solar', 'description' => 'TATA Power Solar Systems Limited', 'created_at' => now(), 'updated_at' => now()],
            ['title' => 'Adani Solar', 'description' => 'Adani Green Energy Limited', 'created_at' => now(), 'updated_at' => now()],
            ['title' => 'Vikram Solar', 'description' => 'Vikram Solar Limited', 'created_at' => now(), 'updated_at' => now()],
            ['title' => 'Waaree Energies', 'description' => 'Waaree Energies Limited', 'created_at' => now(), 'updated_at' => now()],
            ['title' => 'RenewSys', 'description' => 'RenewSys India Private Limited', 'created_at' => now(), 'updated_at' => now()],
            ['title' => 'Emmvee', 'description' => 'Emmvee Photovoltaic Power Private Limited', 'created_at' => now(), 'updated_at' => now()],
            ['title' => 'Loom Solar', 'description' => 'Loom Solar Private Limited', 'created_at' => now(), 'updated_at' => now()],
            ['title' => 'Goldi Solar', 'description' => 'Goldi Solar Private Limited', 'created_at' => now(), 'updated_at' => now()],
            ['title' => 'Mundra Solar', 'description' => 'Mundra Solar PV Limited', 'created_at' => now(), 'updated_at' => now()],
            ['title' => 'Websol', 'description' => 'Websol Energy System Limited', 'created_at' => now(), 'updated_at' => now()],
            ['title' => 'Luminous', 'description' => 'Leading manufacturer of inverters, batteries, and solar energy solutions.', 'created_at' => now(), 'updated_at' => now()],
            ['title' => 'Rayzon', 'description' => 'Manufacturer of high-efficiency solar photovoltaic modules.', 'created_at' => now(), 'updated_at' => now()],
            ['title' => 'Entoric', 'description' => 'Provider of electrical and solar energy products.', 'created_at' => now(), 'updated_at' => now()],
            ['title' => 'Solax', 'description' => 'Global brand specializing in solar inverters and energy storage systems.', 'created_at' => now(), 'updated_at' => now()],
            ['title' => 'RR', 'description' => 'Manufacturer of electrical wires, cables, and industrial solutions.', 'created_at' => now(), 'updated_at' => now()],
            ['title' => 'Finolex', 'description' => 'Trusted brand for electrical cables, wires, and communication solutions.', 'created_at' => now(), 'updated_at' => now()],
            ['title' => 'Deluxe', 'description' => 'Supplier of electrical products and accessories.', 'created_at' => now(), 'updated_at' => now()],
            ['title' => 'Havells', 'description' => 'Leading manufacturer of electrical equipment and consumer appliances.', 'created_at' => now(), 'updated_at' => now()],
            ['title' => 'L&T', 'description' => 'Provider of industrial electrical, automation, and infrastructure solutions.', 'created_at' => now(), 'updated_at' => now()],
            ['title' => 'HPL', 'description' => 'Manufacturer of meters, switchgear, LED lighting, and electrical products.', 'created_at' => now(), 'updated_at' => now()],
            ['title' => 'Genus', 'description' => 'Manufacturer of smart meters, inverters, batteries, and solar solutions.', 'created_at' => now(), 'updated_at' => now()],
            ['title' => 'Apollo', 'description' => 'Provider of electrical and energy-related products.', 'created_at' => now(), 'updated_at' => now()],
            ['title' => 'Polycab', 'description' => 'India’s leading manufacturer of wires, cables, and electrical products.', 'created_at' => now(), 'updated_at' => now()],
            ['title' => 'K-Solare', 'description' => 'Manufacturer of solar modules, inverters, and renewable energy solutions.', 'created_at' => now(), 'updated_at' => now()],
        ];

        DB::table('material_companies')->insert($companies);

        // Connect companies to categories via pivot table
        $categoryCompanyMap = [
            'Panel'              => ['TATA Power Solar','Adani Solar','Vikram Solar','Waaree Energies','RenewSys','Emmvee','Loom Solar','Goldi Solar','Mundra Solar','Websol','Rayzon','K-Solare'],
            'Inverter'           => ['Luminous','Solax','Genus','K-Solare','Entoric'],
            'Battery'            => ['Luminous','Genus'],
            'Wire'               => ['RR','Finolex','Havells','Polycab','L&T','Deluxe'],
            'DC Wire'            => ['RR','Finolex','Havells','Polycab'],
            'ACDB'               => ['Entoric','Havells','L&T'],
            'DCDB'               => ['Entoric','Havells','L&T'],
            'MC4 Connector'      => ['K-Solare','Havells'],
            'Structure'          => ['L&T','Havells'],
            'Solar meter'        => ['HPL','Genus'],
            'Net meter'          => ['HPL','Genus'],
            'MCB'                => ['Havells','L&T','Polycab'],
            'Lightning Arrester' => ['Havells','L&T'],
            'Earthing Rod'       => ['Havells','L&T'],
            'Earthing Cable'     => ['Polycab','Finolex'],
            'Condute pipe'       => ['Havells','L&T'],
            'T - Elbow'          => ['Havells'],
            'Shaddle'            => ['Havells'],
        ];

        $pivotRows = [];
        foreach ($categoryCompanyMap as $categoryTitle => $companyTitles) {
            $category = DB::table('material_categories')->where('title', $categoryTitle)->first();
            if (!$category) continue;

            $companyIds = DB::table('material_companies')
                ->whereIn('title', $companyTitles)
                ->pluck('id');

            foreach ($companyIds as $companyId) {
                $pivotRows[] = [
                    'material_company_id'  => $companyId,
                    'material_category_id' => $category->id,
                ];
            }
        }

        if (!empty($pivotRows)) {
            DB::table('material_companies_material_categories')->insert($pivotRows);
        }


    }
}
