<?php

namespace Database\Seeders;

use App\Models\Departments;
use Illuminate\Database\Seeder;

class DepartmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Departments::create([
            'code' => 'MKT',
            'name' => 'Marketing',
        ]);

        Departments::create([
            'code' => 'PE',
            'name' => 'Process Engineering',
        ]);

        Departments::create([
            'code' => 'PRODENG',
            'name' => 'Product Engineering',
        ]);

        Departments::create([
            'code' => 'PROD',
            'name' => 'Produksi',
        ]);

        Departments::create([
            'code' => 'HRGAEI',
            'name' => 'HRGA EHS IT',
        ]);

        Departments::create([
            'code' => 'PUR',
            'name' => 'Purchasing',
        ]);

        Departments::create([
            'code' => 'FA',
            'name' => 'Finance',
        ]);

        Departments::create([
            'code' => 'QUALITY',
            'name' => 'Quality',
        ]);

        Departments::create([
            'code' => 'PPIC',
            'name' => 'Product Plan Inventory Control',
        ]);

        Departments::create([
            'code' => 'ME',
            'name' => 'Maintenance Engineering',
        ]);

        Departments::create([
            'code' => 'BOD',
            'name' => 'Board Of Director',
        ]);

        Departments::create([
            'code' => 'PPM',
            'name' => 'PRODPPICME',
        ]);

        Departments::create([
            'code' => 'PEQA',
            'name' => 'PEQUALITY',
        ]);
    }
}
