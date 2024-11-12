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
                'created_at' => '2024-10-14 09:18:39',
            ],
            [
                'name' => 'D30D',
                'foto_model' => 'backD40D.jpg',
                'created_at' => '2024-10-14 09:18:39',
            ],
            [
                'name' => 'D12L',
                'foto_model' => 'backD40D.jpg',
                'created_at' => '2024-10-14 09:18:39',
            ],
            [
                'name' => '660A',
                'foto_model' => 'backD40D.jpg',
                'created_at' => '2024-10-14 09:18:39',
            ],
        ]);

    }
}
