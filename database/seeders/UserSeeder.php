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
        // $users = Role::where('name', 'user')->first();
        // $guests = Role::where('name', 'guest')->first();
        // $admins = Role::where('name', 'admin')->first();

        // $user = User::create([
        //     'name' => 'John Doe',
        //     'email' => 'johndoe@example.com',
        //     'password' => Hash::make('12345678'),
        // ]);
        // $user->assignRole($users);
        // $guest = User::create([
        //     'name' => 'Jane Doe',
        //     'email' => 'janedoe@example.com',
        //     'password' => Hash::make('12345678'),
        // ]);
        // $guest->assignRole($guests);

        // $admin = User::create([
        //     'name' => 'Iqbal',
        //     'email' => 'iqbal@gmail.com',
        //     'password' => Hash::make('12345678'),
        // ]);
        // $admin->assignRole($admins);

        $AdminRole = Role::create([
            'name' => 'Admin',
        ]);

        $AdminLSRole = Role::create([
            'name' => 'AdminLS',
        ]);

        $BODRole = Role::create([
            'name' => 'Board of Directors',
        ]);

        $DeptHeadRole = Role::create([
            'name' => 'Department Head',
        ]);

        $SPVRole = Role::create([
            'name' => 'Supervisor',
        ]);

        $StaffRole = Role::create([
            'name' => 'Staff',
        ]);

        $ForemanRole = Role::create([
            'name' => 'Foreman',
        ]);

        $LeaderRole = Role::create([
            'name' => 'Leader',
        ]);

        $MemberRole = Role::create([
            'name' => 'Member',
        ]);

        $GuestRole = Role::create([
            'name' => 'Guest',
        ]);

        $Admin = User::create([
            'name' => 'Admin',
            'email' => 'admin@gmail.com',
            'username' => 'admin',
            'npk' => '',
            'gender' => 'Perempuan',
            'dept_id' => 5,
            'detail_dept_id' => 7,
            'position_id' => null,
            'golongan' => '1',
            'password' => bcrypt('admin123'),
        ]);

        $AdminLS = User::create([
            'name' => 'Admin Limit Sample',
            'email' => 'adminLS@gmail.com',
            'username' => 'adminLS',
            'npk' => '00100',
            'gender' => 'Perempuan',
            'dept_id' => 13,
            'detail_dept_id' => 15,
            'position_id' => null,
            'golongan' => '1',
            'password' => bcrypt('admin123'),
        ]);

        $BOD = User::create([
            'name' => '[Board of Directors]',
            'email' => 'bod@gmail.com',
            'username' => 'bod',
            'npk' => '10001',
            'gender' => 'Laki-Laki',
            'dept_id' => 11,
            'detail_dept_id' => 20,
            'position_id' => 5,
            'golongan' => '5',
            'password' => bcrypt('123'),
        ]);

        $BOD = User::create([
            'name' => 'Cindy Tirta',
            'email' => 'cindy@gmail.com',
            'username' => 'cindy.t',
            'npk' => '10104',
            'gender' => 'Perempuan',
            'dept_id' => 11,
            'detail_dept_id' => 20,
            'position_id' => 5,
            'golongan' => '5',
            'password' => bcrypt('123'),
        ]);

        // Dept Head
        $DeptHeadMKT = User::create([
            'name' => '[Department Head Marketing]',
            'email' => 'dhMkt@gmail.com',
            'username' => 'dhMkt',
            'npk' => '10002',
            'gender' => 'Laki-Laki',
            'dept_id' => 1,
            'detail_dept_id' => 1,
            'position_id' => 1,
            'golongan' => '3',
            'password' => bcrypt('dh123'),
        ]);
        $DeptHeadPEQA = User::create([
            'name' => '[Department Head PEQA]',
            'email' => 'dhPeQa@gmail.com',
            'username' => 'dhPeQa',
            'npk' => '10003',
            'gender' => 'Laki-Laki',
            'dept_id' => 13,
            'detail_dept_id' => 2,
            'position_id' => 1,
            'golongan' => '3',
            'password' => bcrypt('dh123'),
        ]);
        $DeptHeadPRODENG = User::create([
            'name' => '[Department Head Product Engineering]',
            'email' => 'dhPRODENG@gmail.com',
            'username' => 'dhPRODENG',
            'npk' => '10004',
            'gender' => 'Laki-Laki',
            'dept_id' => 3,
            'detail_dept_id' => 3,
            'position_id' => 1,
            'golongan' => '3',
            'password' => bcrypt('dh123'),
        ]);
        $DeptHeadPPM = User::create([
            'name' => '[Department Head PRODPPICME]',
            'email' => 'dhPPM@gmail.com',
            'username' => 'dhPPM',
            'npk' => '10005',
            'gender' => 'Laki-Laki',
            'dept_id' => 12,
            'detail_dept_id' => 5,
            'position_id' => 1,
            'golongan' => '3',
            'password' => bcrypt('dh123'),
        ]);
        $DeptHeadHRGAEI = User::create([
            'name' => 'Pandu Azaria G',
            'email' => 'pandu@gmail.com',
            'username' => 'pandu.a',
            'npk' => '10006',
            'gender' => 'Laki-Laki',
            'dept_id' => 5,
            'detail_dept_id' => 7,
            'position_id' => 1,
            'golongan' => '3',
            'password' => bcrypt('dh123'),
        ]);
        $DeptHeadPUR = User::create([
            'name' => '[Department Head Purchasing]',
            'email' => 'dhPUR@gmail.com',
            'username' => 'dhPUR',
            'npk' => '10007',
            'gender' => 'Laki-Laki',
            'dept_id' => 6,
            'detail_dept_id' => 13,
            'position_id' => 1,
            'golongan' => '3',
            'password' => bcrypt('dh123'),
        ]);
        $DeptHeadFA = User::create([
            'name' => '[Department Head Finance]',
            'email' => 'dhFA@gmail.com',
            'username' => 'dhFA',
            'npk' => '10008',
            'gender' => 'Laki-Laki',
            'dept_id' => 7,
            'detail_dept_id' => 14,
            'position_id' => 1,
            'golongan' => '3',
            'password' => bcrypt('dh123'),
        ]);
        $DeptHeadQC = User::create([
            'name' => '[Department Head Quality Care]',
            'email' => 'dhQC@gmail.com',
            'username' => 'dhQC',
            'npk' => '10128',
            'gender' => 'Laki-Laki',
            'dept_id' => 13,
            'detail_dept_id' => 15,
            'position_id' => 1,
            'golongan' => '3',
            'password' => bcrypt('admin123'),
        ]);
        // $DeptHeadBOD = User::create([
        //     'name' => '[Department Head Board Of Director]',
        //     'email' => 'dhBOD@gmail.com',
        //     'username' => 'dhBOD',
        //     'npk' => '10001',
        //     'gender' => 'Laki-Laki',
        //     'dept_id' => 11,
        //     'detail_dept_id' => 20,
        //     'position_id' => 6,
        //     'golongan' => '3',
        //     'password' => bcrypt('123'),
        // ]);

        // Dept Head End

        // SPV
        $SPVMKT = User::create([
            'name' => '[Supervisor Marketing]',
            'email' => 'spvMkt@gmail.com',
            'username' => 'spvMkt',
            'npk' => '10009',
            'gender' => 'Laki-Laki',
            'dept_id' => 1,
            'detail_dept_id' => 1,
            'position_id' => 2,
            'golongan' => '3',
            'password' => bcrypt('spv123'),
        ]);
        $SPVPEQA = User::create([
            'name' => '[Supervisor PEQA]',
            'email' => 'spvPeQa@gmail.com',
            'username' => 'spvPeQa',
            'npk' => '10010',
            'gender' => 'Laki-Laki',
            'dept_id' => 13,
            'detail_dept_id' => 2,
            'position_id' => 2,
            'golongan' => '3',
            'password' => bcrypt('spv123'),
        ]);
        $SPVQC = User::create([
            'name' => '[Supervisor QC]',
            'email' => 'spvQC@gmail.com',
            'username' => 'spvQC',
            'npk' => '10129',
            'gender' => 'Laki-Laki',
            'dept_id' => 13,
            'detail_dept_id' => 15,
            'position_id' => 2,
            'golongan' => '3',
            'password' => bcrypt('admin123'),
        ]);

        $SPVQC2 = User::create([
            'name' => '[Supervisor QC 2]',
            'email' => 'spvQC2@gmail.com',
            'username' => 'spvQC2',
            'npk' => '11129',
            'gender' => 'Laki-Laki',
            'dept_id' => 13,
            'detail_dept_id' => 16,
            'position_id' => 2,
            'golongan' => '3',
            'password' => bcrypt('admin123'),
        ]);
        $SPVPRODENG = User::create([
            'name' => '[Supervisor Product Engineering]',
            'email' => 'spvPRODENG@gmail.com',
            'username' => 'spvPRODENG',
            'npk' => '10011',
            'gender' => 'Laki-Laki',
            'dept_id' => 3,
            'detail_dept_id' => 3,
            'position_id' => 2,
            'golongan' => '3',
            'password' => bcrypt('spv123'),
        ]);
        $SPVPPM = User::create([
            'name' => '[Supervisor PRODPPICME]',
            'email' => 'spvPPM@gmail.com',
            'username' => 'spvPPM',
            'npk' => '10012',
            'gender' => 'Laki-Laki',
            'dept_id' => 12,
            'detail_dept_id' => 5,
            'position_id' => 2,
            'golongan' => '3',
            'password' => bcrypt('spv123'),
        ]);

        // HRGAEI
        $SPVHRGAEI = User::create([
            'name' => 'Tanya Mutia',
            'email' => 'tanya@gmail.com',
            'username' => 'tanya.m',
            'npk' => '10100',
            'gender' => 'Perempuan',
            'dept_id' => 5,
            'detail_dept_id' => 7,
            'position_id' => 2,
            'golongan' => '3',
            'password' => bcrypt('spv123'),
        ]);

        $SPVHRGAEI = User::create([
            'name' => 'Septin Kisriyani',
            'email' => 'septin@gmail.com',
            'username' => 'septin.k',
            'npk' => '10101',
            'gender' => 'Perempuan',
            'dept_id' => 5,
            'detail_dept_id' => 7,
            'position_id' => 2,
            'golongan' => '3',
            'password' => bcrypt('spv123'),
        ]);

        $SPVHRGAEI = User::create([
            'name' => 'Dewi Kartika',
            'email' => 'dewi@gmail.com',
            'username' => 'dewi.k',
            'npk' => '00828',
            'gender' => 'Perempuan',
            'dept_id' => 5,
            'detail_dept_id' => 8,
            'position_id' => 2,
            'golongan' => '3',
            'password' => bcrypt('spv123'),
        ]);

        $SPVHRGAEI = User::create([
            'name' => 'Iwan Muhdi',
            'email' => 'iwan@gmail.com',
            'username' => 'iwan.m',
            'npk' => '10102',
            'gender' => 'Laki-Laki',
            'dept_id' => 5,
            'detail_dept_id' => 8,
            'position_id' => 2,
            'golongan' => '3',
            'password' => bcrypt('spv123'),
        ]);

        $SPVHRGAEI = User::create([
            'name' => 'Miqdad Agil A',
            'email' => 'miqdad@gmail.com',
            'username' => 'miqdad.a',
            'npk' => '00801',
            'gender' => 'Laki-Laki',
            'dept_id' => 5,
            'detail_dept_id' => 10,
            'position_id' => 2,
            'golongan' => '3',
            'password' => bcrypt('spv123'),
        ]);

        // $SPVHRGAEI = User::create([
        //     'name' => 'Pandu Azaria G',
        //     'email' => 'pandu@gmail.com',
        //     'username' => 'spv.pandu.a',
        //     'npk' => '10013',
        //     'gender' => 'Laki-Laki',
        //     'dept_id' => 5,
        //     'detail_dept_id' => 9,
        //     'position_id' => 2,
        //     'golongan' => '3',
        //     'password' => bcrypt('spv123'),
        // ]);
        // HRGAEI End

        $SPVPUR = User::create([
            'name' => '[Supervisor Purchasing]',
            'email' => 'spvPUR@gmail.com',
            'username' => 'spvPUR',
            'npk' => '10014',
            'gender' => 'Laki-Laki',
            'dept_id' => 6,
            'detail_dept_id' => 13,
            'position_id' => 2,
            'golongan' => '3',
            'password' => bcrypt('spv123'),
        ]);
        $SPVFA = User::create([
            'name' => '[Supervisor Finance]',
            'email' => 'spvFA@gmail.com',
            'username' => 'spvFA',
            'npk' => '10015',
            'gender' => 'Laki-Laki',
            'dept_id' => 7,
            'detail_dept_id' => 14,
            'position_id' => 2,
            'golongan' => '3',
            'password' => bcrypt('spv123'),
        ]);
        // SPV END

        // Staff
        // $StaffFM = User::create([
        //     'name' => '[StaffFM]',
        //     'email' => 'stafffm@gmail.com',
        //     'username' => 'stafffm',
        //     'npk' => '32232333225',
        //     'gender' => 'Perempuan',
        //     'dept_id' => 5,
        //     'detail_dept_id' => 10,
        //     'position_id' => 3,
        //     'golongan' => '4',
        //     'password' => bcrypt('123'),
        // ]);

        $StaffMKT = User::create([
            'name' => '[Staff Marketing]',
            'email' => 'staffMkt@gmail.com',
            'username' => 'staffMkt',
            'npk' => '10016',
            'gender' => 'Laki-Laki',
            'dept_id' => 1,
            'detail_dept_id' => 1,
            'position_id' => 3,
            'golongan' => '3',
            'password' => bcrypt('staff123'),
        ]);
        $StaffPEQA = User::create([
            'name' => '[Staff PEQA]',
            'email' => 'staffPeQa@gmail.com',
            'username' => 'staffPeQa',
            'npk' => '10017',
            'gender' => 'Laki-Laki',
            'dept_id' => 13,
            'detail_dept_id' => 2,
            'position_id' => 3,
            'golongan' => '3',
            'password' => bcrypt('staff123'),
        ]);
        $StaffPRODENG = User::create([
            'name' => '[Staff Product Engineering]',
            'email' => 'staffPRODENG@gmail.com',
            'username' => 'staffPRODENG',
            'npk' => '10018',
            'gender' => 'Laki-Laki',
            'dept_id' => 3,
            'detail_dept_id' => 3,
            'position_id' => 3,
            'golongan' => '3',
            'password' => bcrypt('staff123'),
        ]);
        $StaffPPM = User::create([
            'name' => '[Staff PRODPPICME]',
            'email' => 'staffPPM@gmail.com',
            'username' => 'staffPPM',
            'npk' => '10019',
            'gender' => 'Laki-Laki',
            'dept_id' => 12,
            'detail_dept_id' => 5,
            'position_id' => 3,
            'golongan' => '3',
            'password' => bcrypt('staff123'),
        ]);

        // Staff HRGAEI
        $StaffHRGAEI = User::create([
            'name' => 'Susilo Hendro N',
            'email' => 'susilo@gmail.com',
            'username' => 'susilo.h',
            'npk' => '10020',
            'gender' => 'Laki-Laki',
            'dept_id' => 5,
            'detail_dept_id' => 8,
            'position_id' => 3,
            'golongan' => '3',
            'password' => bcrypt('staff123'),
        ]);

        $StaffHRGAEI = User::create([
            'name' => 'Sahril W',
            'email' => 'sahril@gmail.com',
            'username' => 'sahril.w',
            'npk' => '10105',
            'gender' => 'Laki-Laki',
            'dept_id' => 5,
            'detail_dept_id' => 10,
            'position_id' => 3,
            'golongan' => '3',
            'password' => bcrypt('staff123'),
        ]);

        $StaffHRGAEI = User::create([
            'name' => 'Adela Rosya A',
            'email' => 'adela@gmail.com',
            'username' => 'adela.r',
            'npk' => '10106',
            'gender' => 'Perempuan',
            'dept_id' => 5,
            'detail_dept_id' => 9,
            'position_id' => 3,
            'golongan' => '3',
            'password' => bcrypt('staff123'),
        ]);
        // Staff HRGAEI End

        $StaffPUR = User::create([
            'name' => '[Staff Purchasing]',
            'email' => 'staffPUR@gmail.com',
            'username' => 'staffPUR',
            'npk' => '10021',
            'gender' => 'Laki-Laki',
            'dept_id' => 6,
            'detail_dept_id' => 13,
            'position_id' => 3,
            'golongan' => '3',
            'password' => bcrypt('staff123'),
        ]);
        $StaffFA = User::create([
            'name' => '[Staff Finance]',
            'email' => 'staffFA@gmail.com',
            'username' => 'staffFA',
            'npk' => '10022',
            'gender' => 'Laki-Laki',
            'dept_id' => 7,
            'detail_dept_id' => 14,
            'position_id' => 3,
            'golongan' => '3',
            'password' => bcrypt('staff123'),
        ]);
        // Staff End

        // Foreman
        $ForemanMKT = User::create([
            'name' => '[Foreman Marketing]',
            'email' => 'foremanMkt@gmail.com',
            'username' => 'foremanMkt',
            'npk' => '10023',
            'gender' => 'Laki-Laki',
            'dept_id' => 1,
            'detail_dept_id' => 1,
            'position_id' => 7,
            'golongan' => '3',
            'password' => bcrypt('foreman123'),
        ]);
        $ForemanPEQA = User::create([
            'name' => '[Foreman PEQA]',
            'email' => 'foremanPeQa@gmail.com',
            'username' => 'foremanPeQa',
            'npk' => '10024',
            'gender' => 'Laki-Laki',
            'dept_id' => 13,
            'detail_dept_id' => 2,
            'position_id' => 7,
            'golongan' => '3',
            'password' => bcrypt('foreman123'),
        ]);
        $ForemanPRODENG = User::create([
            'name' => '[Foreman Product Engineering]',
            'email' => 'foremanPRODENG@gmail.com',
            'username' => 'foremanPRODENG',
            'npk' => '10025',
            'gender' => 'Laki-Laki',
            'dept_id' => 3,
            'detail_dept_id' => 3,
            'position_id' => 7,
            'golongan' => '3',
            'password' => bcrypt('foreman123'),
        ]);
        $ForemanPPM = User::create([
            'name' => '[Foreman PRODPPICME]',
            'email' => 'foremanPPM@gmail.com',
            'username' => 'foremanPPM',
            'npk' => '10026',
            'gender' => 'Laki-Laki',
            'dept_id' => 12,
            'detail_dept_id' => 5,
            'position_id' => 7,
            'golongan' => '3',
            'password' => bcrypt('foreman123'),
        ]);
        // $ForemanHRGAEI = User::create([
        //     'name' => '[Foreman HRGA EHS IT]',
        //     'email' => 'foremanHRGAEI@gmail.com',
        //     'username' => 'foremanHRGAEI',
        //     'npk' => '10027',
        //     'gender' => 'Laki-Laki',
        //     'dept_id' => 5,
        //     'detail_dept_id' => 7,
        //     'position_id' => 7,
        //     'golongan' => '3',
        //     'password' => bcrypt('foreman123'),
        // ]);
        $ForemanPUR = User::create([
            'name' => '[Foreman Purchasing]',
            'email' => 'foremanPUR@gmail.com',
            'username' => 'foremanPUR',
            'npk' => '10028',
            'gender' => 'Laki-Laki',
            'dept_id' => 6,
            'detail_dept_id' => 13,
            'position_id' => 7,
            'golongan' => '3',
            'password' => bcrypt('foreman123'),
        ]);
        $ForemanFA = User::create([
            'name' => '[Foreman Finance]',
            'email' => 'foremanFA@gmail.com',
            'username' => 'foremanFA',
            'npk' => '10029',
            'gender' => 'Laki-Laki',
            'dept_id' => 7,
            'detail_dept_id' => 14,
            'position_id' => 7,
            'golongan' => '3',
            'password' => bcrypt('foreman123'),
        ]);
        // Foreman End

        // Leader
        // $Leader = User::create([
        //     'name' => '[Leader]',
        //     'email' => 'leader@gmail.com',
        //     'username' => 'leader',
        //     'npk' => '32232333226',
        //     'gender' => 'Laki-Laki',
        //     'dept_id' => 5,
        //     'detail_dept_id' => 10,
        //     'position_id' => 7,
        //     'golongan' => '2',
        //     'password' => bcrypt('123'),
        // ]);

        $LeaderMKT = User::create([
            'name' => '[Leader Marketing]',
            'email' => 'leaderMkt@gmail.com',
            'username' => 'leaderMkt',
            'npk' => '10030',
            'gender' => 'Laki-Laki',
            'dept_id' => 1,
            'detail_dept_id' => 1,
            'position_id' => 6,
            'golongan' => '3',
            'password' => bcrypt('leader123'),
        ]);
        $LeaderPEQA = User::create([
            'name' => '[Leader PEQA]',
            'email' => 'leaderPeQa@gmail.com',
            'username' => 'leaderPeQa',
            'npk' => '10031',
            'gender' => 'Laki-Laki',
            'dept_id' => 13,
            'detail_dept_id' => 2,
            'position_id' => 6,
            'golongan' => '3',
            'password' => bcrypt('leader123'),
        ]);
        $LeaderPRODENG = User::create([
            'name' => '[Leader Product Engineering]',
            'email' => 'leaderPRODENG@gmail.com',
            'username' => 'leaderPRODENG',
            'npk' => '10032',
            'gender' => 'Laki-Laki',
            'dept_id' => 3,
            'detail_dept_id' => 3,
            'position_id' => 6,
            'golongan' => '3',
            'password' => bcrypt('leader123'),
        ]);
        $LeaderPPM = User::create([
            'name' => '[Leader PRODPPICME]',
            'email' => 'leaderPPM@gmail.com',
            'username' => 'leaderPPM',
            'npk' => '10033',
            'gender' => 'Laki-Laki',
            'dept_id' => 12,
            'detail_dept_id' => 5,
            'position_id' => 6,
            'golongan' => '3',
            'password' => bcrypt('leader123'),
        ]);
        // $LeaderHRGAEI = User::create([
        //     'name' => '[Leader HRGA EHS IT]',
        //     'email' => 'leaderHRGAEI@gmail.com',
        //     'username' => 'leaderHRGAEI',
        //     'npk' => '10034',
        //     'gender' => 'Laki-Laki',
        //     'dept_id' => 5,
        //     'detail_dept_id' => 7,
        //     'position_id' => 6,
        //     'golongan' => '3',
        //     'password' => bcrypt('leader123'),
        // ]);
        $LeaderPUR = User::create([
            'name' => '[Leader Purchasing]',
            'email' => 'leaderPUR@gmail.com',
            'username' => 'leaderPUR',
            'npk' => '10035',
            'gender' => 'Laki-Laki',
            'dept_id' => 6,
            'detail_dept_id' => 13,
            'position_id' => 6,
            'golongan' => '3',
            'password' => bcrypt('leader123'),
        ]);
        $LeaderFA = User::create([
            'name' => '[Leader Finance]',
            'email' => 'leaderFA@gmail.com',
            'username' => 'leaderFA',
            'npk' => '10036',
            'gender' => 'Laki-Laki',
            'dept_id' => 7,
            'detail_dept_id' => 14,
            'position_id' => 6,
            'golongan' => '3',
            'password' => bcrypt('leader123'),
        ]);
        // Leader End

        // Member
        // $Member = User::create([
        //     'name' => '[Member]',
        //     'email' => 'member@gmail.com',
        //     'username' => 'member',
        //     'npk' => '3223233027',
        //     'gender' => 'Laki-Laki',
        //     'dept_id' => 2,
        //     'detail_dept_id' => 2,
        //     'position_id' => 4,
        //     'golongan' => '1',
        //     'password' => bcrypt('123'),
        // ]);

        $MemberMKT = User::create([
            'name' => '[Member Marketing]',
            'email' => 'memberMkt@gmail.com',
            'username' => 'memberMkt',
            'npk' => '10037',
            'gender' => 'Laki-Laki',
            'dept_id' => 1,
            'detail_dept_id' => 1,
            'position_id' => 8,
            'golongan' => '3',
            'password' => bcrypt('member123'),
        ]);
        $MemberPEQA = User::create([
            'name' => '[Member PEQA]',
            'email' => 'memberPeQa@gmail.com',
            'username' => 'memberPeQa',
            'npk' => '10038',
            'gender' => 'Laki-Laki',
            'dept_id' => 13,
            'detail_dept_id' => 2,
            'position_id' => 8,
            'golongan' => '3',
            'password' => bcrypt('member123'),
        ]);
        $MemberPRODENG = User::create([
            'name' => '[Member Product Engineering]',
            'email' => 'memberPRODENG@gmail.com',
            'username' => 'memberPRODENG',
            'npk' => '10039',
            'gender' => 'Laki-Laki',
            'dept_id' => 3,
            'detail_dept_id' => 3,
            'position_id' => 8,
            'golongan' => '3',
            'password' => bcrypt('member123'),
        ]);
        $MemberPPM = User::create([
            'name' => '[Member PRODPPICME]',
            'email' => 'memberPPM@gmail.com',
            'username' => 'memberPPM',
            'npk' => '10040',
            'gender' => 'Laki-Laki',
            'dept_id' => 12,
            'detail_dept_id' => 5,
            'position_id' => 8,
            'golongan' => '3',
            'password' => bcrypt('member123'),
        ]);
        // $MemberHRGAEI = User::create([
        //     'name' => '[Member HRGA EHS IT]',
        //     'email' => 'memberHRGAEI@gmail.com',
        //     'username' => 'memberHRGAEI',
        //     'npk' => '10041',
        //     'gender' => 'Laki-Laki',
        //     'dept_id' => 5,
        //     'detail_dept_id' => 7,
        //     'position_id' => 8,
        //     'golongan' => '3',
        //     'password' => bcrypt('member123'),
        // ]);
        $MemberPUR = User::create([
            'name' => '[Member Purchasing]',
            'email' => 'memberPUR@gmail.com',
            'username' => 'memberPUR',
            'npk' => '10042',
            'gender' => 'Laki-Laki',
            'dept_id' => 6,
            'detail_dept_id' => 13,
            'position_id' => 8,
            'golongan' => '3',
            'password' => bcrypt('member123'),
        ]);
        $MemberFA = User::create([
            'name' => '[Member Finance]',
            'email' => 'memberFA@gmail.com',
            'username' => 'memberFA',
            'npk' => '10043',
            'gender' => 'Laki-Laki',
            'dept_id' => 7,
            'detail_dept_id' => 14,
            'position_id' => 8,
            'golongan' => '3',
            'password' => bcrypt('member123'),
        ]);
        // Member End

        $Guest = User::create([
            'name' => 'Guest',
            'email' => 'guest@gmail.com',
            'username' => 'guest',
            'gender' => 'Custom',
            'password' => bcrypt('guest123'),
        ]);

        $Admin->assignRole($AdminRole);
        $AdminLS->assignRole($AdminLSRole);
        $BOD->assignRole($BODRole);
        $DeptHeadFA->assignRole($DeptHeadRole);
        $DeptHeadHRGAEI->assignRole($DeptHeadRole);
        $DeptHeadMKT->assignRole($DeptHeadRole);
        $DeptHeadPEQA->assignRole($DeptHeadRole);
        $DeptHeadPPM->assignRole($DeptHeadRole);
        $DeptHeadPRODENG->assignRole($DeptHeadRole);
        $DeptHeadPUR->assignRole($DeptHeadRole);
        $DeptHeadQC->assignRole($DeptHeadRole);

        $SPVFA->assignRole($SPVRole);
        $SPVQC->assignRole($SPVRole);
        $SPVQC2->assignRole($SPVRole);
        $SPVHRGAEI->assignRole($SPVRole);
        $SPVMKT->assignRole($SPVRole);
        $SPVPEQA->assignRole($SPVRole);
        $SPVPPM->assignRole($SPVRole);
        $SPVPRODENG->assignRole($SPVRole);
        $SPVPUR->assignRole($SPVRole);

        $StaffFA->assignRole($StaffRole);
        $StaffHRGAEI->assignRole($StaffRole);
        $StaffMKT->assignRole($StaffRole);
        $StaffPEQA->assignRole($StaffRole);
        $StaffPPM->assignRole($StaffRole);
        $StaffPRODENG->assignRole($StaffRole);
        $StaffPUR->assignRole($StaffRole);

        $ForemanFA->assignRole($ForemanRole);
        // $ForemanHRGAEI->assignRole($ForemanRole);
        $ForemanMKT->assignRole($ForemanRole);
        $ForemanPEQA->assignRole($ForemanRole);
        $ForemanPPM->assignRole($ForemanRole);
        $ForemanPRODENG->assignRole($ForemanRole);
        $ForemanPUR->assignRole($ForemanRole);

        $LeaderFA->assignRole($LeaderRole);
        // $LeaderHRGAEI->assignRole($LeaderRole);
        $LeaderMKT->assignRole($LeaderRole);
        $LeaderPEQA->assignRole($LeaderRole);
        $LeaderPPM->assignRole($LeaderRole);
        $LeaderPRODENG->assignRole($LeaderRole);
        $LeaderPUR->assignRole($LeaderRole);

        $MemberFA->assignRole($MemberRole);
        // $MemberHRGAEI->assignRole($MemberRole);
        $MemberMKT->assignRole($MemberRole);
        $MemberPEQA->assignRole($MemberRole);
        $MemberPPM->assignRole($MemberRole);
        $MemberPRODENG->assignRole($MemberRole);
        $MemberPUR->assignRole($MemberRole);
        $Guest->assignRole($GuestRole);
    }
}
