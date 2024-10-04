<?php

namespace Database\Seeders;

use App\Models\Characteristics;
use Illuminate\Database\Seeder;

class CharacteristicsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Characteristics::insert([
            [
                'name' => 'Flex'
            ],
            [
                'name' => 'Stain'
            ],
            [
                'name' => 'Dented'
            ],
        ]);
    }
}
