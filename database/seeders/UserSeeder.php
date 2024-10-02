<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //buat role
        Role::firstOrCreate(['name' => 'Admin']);
        Role::firstOrCreate(['name' => 'Section Head']);
        Role::firstOrCreate(['name' => 'Departement Head']);
        Role::firstOrCreate(['name' => 'Guest']);

        // Seed users
        $risky = User::create([
            'name' => 'risky',
            'email' => 'mahsunmuh0@gmail.com',
            'password' => Hash::make('admin123'),
            'NPK' => '000001',
            'position_id' => '3',
        ]);

        $teguh = User::create([
            'name' => 'teguh',
            'email' => 'mahsunmuh0@gmail.com',
            'password' => Hash::make('admin123'),
            'NPK' => '000002',
            'position_id' => '1',
        ]);

        $agus = User::create([
            'name' => 'agus.tri',
            'email' => 'mahsunmuh0@gmail.com',
            'password' => Hash::make('admin123'),
            'NPK' => '000003',
            'position_id' => '2',
        ]);

        $guest = User::create([
            'name' => 'guest',
            'email' => 'guest@gmail.com',
            'password' => Hash::make('guest123'),
            'NPK' => '000000',
            'position_id' => '4',
        ]);



        // Assign roles to users
        $risky->assignRole('Admin');
        $teguh->assignRole('Section Head');
        $agus->assignRole('Departement Head');
        $guest->assignRole('Guest');
    }
}
