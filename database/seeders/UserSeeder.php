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
        Role::firstOrCreate(['name' => 'Supervisor']);
        Role::firstOrCreate(['name' => 'Department Head']);
        Role::firstOrCreate(['name' => 'Guest']);

        // Seed users
        $risky = User::create([
            'username' => 'admin',
            'email' => 'mahsunmuh0@gmail.com',
            'password' => Hash::make('admin123'),
            'NPK' => '000001',
            'position_id' => '3',
        ]);

        $teguh = User::create([
            'username' => 'spvQC',
            'email' => 'mahsunmuh0@gmail.com',
            'password' => Hash::make('admin123'),
            'NPK' => '000002',
            'position_id' => '1',
            'detail_dept_id' => 15,
        ]);

        $agus = User::create([
            'username' => 'deptHeadQC',
            'email' => 'mahsunmuh0@gmail.com',
            'password' => Hash::make('admin123'),
            'NPK' => '000003',
            'position_id' => '2',
            'detail_dept_id' => 15,
        ]);

        $guest = User::create([
            'username' => 'guest',
            'email' => 'guest@gmail.com',
            'password' => Hash::make('guest123'),
            'NPK' => '000000',
            'position_id' => '4',
        ]);



        // Assign roles to users
        $risky->assignRole('Admin');
        $teguh->assignRole('Supervisor');
        $agus->assignRole('Department Head');
        $guest->assignRole('Guest');
    }
}
