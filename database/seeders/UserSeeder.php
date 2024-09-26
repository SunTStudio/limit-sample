<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::insert([
            [
                'name' => 'risky',
                'email' => 'mahsunmuh0@gmail.com',
                'password' => Hash::make('admin123'),
                'NPK' => '000001',
                'position_id' => '3'
            ],
            [
                'name' => 'teguh',
                'email' => 'mahsunmuh0@gmail.com',
                'password' => Hash::make('admin123'),
                'NPK' => '000002',
                'position_id' => '1'
            ],
            [
                'name' => 'agus.tri',
                'email' => 'mahsunmuh0@gmail.com',
                'password' => Hash::make('admin123'),
                'NPK' => '000003',
                'position_id' => '2'
            ],
        ]);
    }
}
