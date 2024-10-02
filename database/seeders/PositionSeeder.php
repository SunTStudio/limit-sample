<?php

namespace Database\Seeders;

use App\Models\Position;
use Illuminate\Database\Seeder;

class PositionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Position::insert([
            [
                'Position' => 'Section Head',
                'code' => 'SecHead'
            ],
            [
                'Position' => 'Departement Head',
                'code' => 'DeptHead'
            ],
            [
                'Position' => 'Admin',
                'code' => 'Admin'
            ],
            [
                'Position' => 'Guest',
                'code' => 'Guest'
            ],
        ]);
    }
}
