<?php

use App\Models\Departments;
use App\Models\Detail_departements;
use App\Models\Position;
use App\Models\User;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Route;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/updateDataAPI', function (Request $request) {
    try {
        // Validasi input data
        $request->validate([
            'users' => 'required|array',
            'departments' => 'required|array',
            'detail_departments' => 'required|array',
            'positions' => 'required|array',
        ]);

        // Mengupdate model Department
        foreach ($request->input('departments') as $deptData) {
            Departments::updateOrCreate(
                ['id' => $deptData['id']], // Sesuaikan dengan kolom unik
                [
                    'code' => $deptData['code'],
                    'name' => $deptData['name'],
                    'email_depthead' => $deptData['email_depthead'] ?? null,
                    'email_spv' => $deptData['email_spv'] ?? null,
                    'email_members' => $deptData['email_members'] ?? null,
                    'deleted_at' => $deptData['deleted_at'] ?? null,
                ],
            );
        }

        // Mengupdate model Detail_departement
        foreach ($request->input('detail_departments') as $detailDeptData) {
            Detail_departements::updateOrCreate(
                ['id' => $detailDeptData['id']], // Sesuaikan dengan kolom unik
                [
                    'departement_id' => $detailDeptData['departement_id'],
                    'name' => $detailDeptData['name'],
                    'code' => $detailDeptData['code'] ?? null,
                    'email_depthead' => $detailDeptData['email_depthead'] ?? null,
                    'email_director' => $detailDeptData['email_director'] ?? null,
                    'email_spv' => $detailDeptData['email_spv'] ?? null,
                    'email_members' => $detailDeptData['email_members'] ?? null,
                ],
            );
        }

        // Mengupdate model Position
        foreach ($request->input('positions') as $positionData) {
            Position::updateOrCreate(
                ['id' => $positionData['id']], // Sesuaikan dengan kolom unik
                [
                    'position' => $positionData['position'],
                    'code' => $positionData['code'],
                ],
            );
        }

        // Ambil data roles dan permissions dari request
        $allRole = $request->input('allRole');
        $allPermission = $request->input('allPermission');
        // Bersihkan semua data role yang ada
        Role::query()->delete();

        // Bersihkan semua data permission yang ada
        Permission::query()->delete();

        foreach ($allPermission as $permissionData) {
                Permission::firstOrCreate(['name' => $permissionData['name']]);
        }

        foreach ($allRole as $roleData) {
            $newRole = Role::firstOrCreate([
                'name' => $roleData['name'],
            ]);

            $permissions = [];
            foreach ($roleData['permissions'] as $permissionData) {
                $NewPermissions = Permission::firstOrCreate([
                    'name' => $permissionData['name'],
                ]);
                $permissions[] = $NewPermissions['name'];
            }
            // Sync permissions
            $newRole->givePermissionTo($permissions);
        }

        // Mengupdate model User
        foreach ($request->input('users') as $userData) {

            if($userData['deleted_at'] != null){
                $deleteUser = User::where('npk',$userData['npk'])->first();
                if($deleteUser){
                    $deleteUser->delete();
                }
            }else{
                $user = User::updateOrCreate(
                    ['npk' => $userData['npk']],
                    [
                        'name' => $userData['name'],
                        'email' => $userData['email'],
                        'npk' => $userData['npk'] ?? null,
                        'username' => $userData['username'] ?? null, // Tambahkan null jika tidak ada
                        'gender' => $userData['gender'] ?? null,
                        'tgl_masuk' => $userData['tgl_masuk'] ?? null,
                        'tgl_lahir' => $userData['tgl_lahir'] ?? null,
                        'dept_id' => $userData['dept_id'] ?? null,
                        'position_id' => $userData['position_id'] ?? null,
                        'detail_dept_id' => $userData['detail_dept_id'] ?? null,
                        'golongan' => $userData['golongan'] ?? null,
                        'email_verified_at' => $userData['email_verified_at'] ?? null,
                        'password' => isset($userData['password']) ? $userData['password'] : null,
                    ],
                );
                // Mengupdate roles dan permissions jika ada
                if (isset($userData['role']) || isset($userData['permissions'])) {
                    $user->syncRoles($userData['role'] ?? []);
                    $user->syncPermissions($userData['permissions'] ?? []);
                }
            }

        }

        return response()->json(['success' => 'Data updated successfully']);
    } catch (\Exception $e) {
        // Log error untuk pengecekan jika dibutuhkan
        Log::error('Data update error: ' . $e->getMessage());

        // // Inisialisasi Guzzle untuk mengirim pesan error ke website 1
        // $client = new Client();
        // $client->post('http://10.14.179.250:2222/api/handleError', [
        //     'json' => [
        //         'error_message' => $e->getMessage(),
        //         'error_code' => $e->getCode(),
        //     ],
        // ]);

        return response()->json(['error' => $e->getMessage()]);
    }
});
