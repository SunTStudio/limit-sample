<?php

namespace Database\Seeders;

use App\Models\Detail_departements;
use Illuminate\Database\Seeder;

class Detail_DepartmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Detail_departements::create([
            'departement_id' => 1,
            'name' => 'Marketing',
            'code' => 'MKT',
        ]);

        Detail_departements::create([
            'departement_id' => 13,
            'name' => 'Process Engineering',
            'code' => 'PE',
        ]);

        Detail_departements::create([
            'departement_id' => 3,
            'name' => 'New Product Development',
            'code' => 'NPD',
        ]);

        Detail_departements::create([
            'departement_id' => 3,
            'name' => 'Research And Development',
            'code' => 'RND',
        ]);

        Detail_departements::create([
            'departement_id' => 12,
            'name' => 'Assy Koja',
            'code' => 'ASSY',
        ]);

        Detail_departements::create([
            'departement_id' => 12,
            'name' => 'Injection Surface',
            'code' => 'INJ',
        ]);

        Detail_departements::create([
            'departement_id' => 5,
            'name' => 'Human Resource',
            'code' => 'HR',
        ]);

        Detail_departements::create([
            'departement_id' => 5,
            'name' => 'General Affair',
            'code' => 'GA',
        ]);

        Detail_departements::create([
            'departement_id' => 5,
            'name' => 'Environtment Health Safety',
            'code' => 'EHS',
        ]);

        Detail_departements::create([
            'departement_id' => 5,
            'name' => 'Information Technology',
            'code' => 'IT',
        ]);

        Detail_departements::create([
            'departement_id' => 5,
            'name' => 'Export Import',
            'code' => 'EXIM',
        ]);

        Detail_departements::create([
            'departement_id' => 5,
            'name' => 'Legal',
            'code' => 'LA',
        ]);

        Detail_departements::create([
            'departement_id' => 6,
            'name' => 'Purchasing',
            'code' => 'PUR',
        ]);

        Detail_departements::create([
            'departement_id' => 7,
            'name' => 'Finance',
            'code' => 'FA',
        ]);

        Detail_departements::create([
            'departement_id' => 13,
            'name' => 'Quality Control',
            'code' => 'QC',
        ]);

        Detail_departements::create([
            'departement_id' => 13,
            'name' => 'Quality Assurance',
            'code' => 'QA',
        ]);

        Detail_departements::create([
            'departement_id' => 12,
            'name' => 'Delivery',
            'code' => 'DEL',
        ]);

        Detail_departements::create([
            'departement_id' => 12,
            'name' => 'Warehouse',
            'code' => 'WH',
        ]);

        Detail_departements::create([
            'departement_id' => 12,
            'name' => 'Maintanance Engineering',
            'code' => 'ME',
        ]);

        Detail_departements::create([
            'departement_id' => 11,
            'name' => 'Board Of Direction',
            'code' => 'BOD',
        ]);
    }
}
