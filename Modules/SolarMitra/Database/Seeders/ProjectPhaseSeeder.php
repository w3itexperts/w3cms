<?php

namespace Modules\SolarMitra\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProjectPhaseSeeder extends Seeder
{
    public function run(): void
    {
        $phases = [
            [
                'title' => 'Project Initiate (Start Project)',
                'description' => 'Initial phase where the project is created, client requirements are gathered, and feasibility is discussed.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Site Survey (Assign Site Surveyor/Engineer)',
                'description' => 'A site visit is conducted by a surveyor or engineer to assess location conditions, roof structure, and technical feasibility.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Quotation',
                'description' => 'Preparation and sharing of cost estimates based on survey data, system size, and customer requirements.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Documentation and Agreement',
                'description' => 'Collection of required documents and signing of agreement between client and service provider.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Subsidy if Applicable',
                'description' => 'Processing of government subsidy applications if the project qualifies under applicable schemes.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Material Procurement and Logistic',
                'description' => 'Procurement of solar panels, inverter, and other materials, along with logistics planning for delivery.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Installation',
                'description' => 'Physical installation of solar panels, inverter, wiring, and mounting structures at the site.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Inspection and Net Metering',
                'description' => 'Inspection by authorities and installation of net meter for grid-connected systems.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Testing and Submission',
                'description' => 'System testing to ensure proper functionality and submission of required reports to authorities.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Handover and Training',
                'description' => 'Project handover to client along with basic training on system usage and monitoring.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'After Sale Maintenance',
                'description' => 'Ongoing maintenance, support, and servicing after project completion to ensure system performance.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        DB::table('project_phases')->insert($phases);
    }
}
