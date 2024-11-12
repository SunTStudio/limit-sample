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
        Position::create([
            'position' => 'BOD',
            'code' => 'BOD',
        ]);

        Position::create([
            'position' => 'Dept Head',
            'code' => 'DEPT',
        ]);

        Position::create([
            'position' => 'Supervisor',
            'code' => 'SPV',
        ]);

        Position::create([
            'position' => 'Officer',
            'code' => 'OFFICER',
        ]);

        Position::create([
            'position' => 'Staff',
            'code' => 'STAFF',
        ]);

        Position::create([
            'position' => 'Foreman',
            'code' => 'FRM',
        ]);
        
        Position::create([
            'position' => 'Leader',
            'code' => 'LEAD',
        ]);

        Position::create([
            'position' => 'Member',
            'code' => 'OP',
        ]);

        Position::create([
            'position' => 'SUB',
            'code' => 'SUB',
        ]);
    }
}
