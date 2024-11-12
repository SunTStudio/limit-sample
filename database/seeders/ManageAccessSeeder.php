<?php

namespace Database\Seeders;

use App\Models\ManageAccess;
use Illuminate\Database\Seeder;

class ManageAccessSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        ManageAccess::create([
            'peran' => 'Section Head 1',
            'user_id' => null,
        ]);

        ManageAccess::create([
            'peran' => 'Section Head 2',
            'user_id' => null,
        ]);

        ManageAccess::create([
            'peran' => 'Department Head',
            'user_id' => null,
        ]);
    }
}
