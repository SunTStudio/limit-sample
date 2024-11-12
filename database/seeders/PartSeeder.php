<?php

namespace Database\Seeders;

use App\Models\Part;
use Illuminate\Database\Seeder;

class PartSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Part::insert([
            [
                'model_part_id' => '1',
                'name' => 'Reflektor',
                'foto_part' => 'D26AV3.png',
                'created_at' => '2024-10-14 09:18:39',
            ],
            [
                'model_part_id' => '1',
                'name' => 'RCL',
                'foto_part' => 'D26AV3.png',
                'created_at' => '2024-10-14 09:18:39',
            ],
            [
                'model_part_id' => '1',
                'name' => 'CBDG',
                'foto_part' => 'D26AV3.png',
                'created_at' => '2024-10-14 09:18:39',
            ],
            [
                'model_part_id' => '1',
                'name' => 'BDG',
                'foto_part' => 'D26AV3.png',
                'created_at' => '2024-10-14 09:18:39',
            ],
        ]);
    }
}
