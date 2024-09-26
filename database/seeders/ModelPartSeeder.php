<?php

namespace Database\Seeders;

use App\Models\ModelPart;
use Illuminate\Database\Seeder;

class ModelPartSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        ModelPart::insert([
            [
                'name' => 'D26A',
                'foto_model' => 'backD26A.jpg',
            ],
            [
                'name' => 'D30D',
                'foto_model' => 'backD40D.jpg',
            ],
            [
                'name' => 'D12L',
                'foto_model' => 'backD40D.jpg',
            ],
            [
                'name' => '660A',
                'foto_model' => 'backD40D.jpg',
            ],
        ]);

    }
}
