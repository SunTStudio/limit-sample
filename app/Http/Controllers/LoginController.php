<?php

namespace App\Http\Controllers;

use App\Models\Departments;
use App\Models\Detail_departements;
use App\Models\Guest;
use App\Models\Position;
use App\Models\User;
use Carbon\Carbon;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function index()
    {
        return view('limitSample.login');
    }

    public function loginGuest()
    {
        return view('limitSample.loginGuest');
    }

    public function accessDenied()
    {
        return view('layouts.404');
    }

    public function authenticate(Request $request)
    {
        $credentials = $request->validate([
            'username' => ['required'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials)) {
            $userData = Auth::user();
            $users = User::all()->toArray();
            $depts = Departments::all()->toArray();
            $detail_depts = Detail_departements::all()->toArray();
            $positions = Position::all()->toArray();
            $roles = Auth::user()->getRoleNames()->toArray();

            $request->session()->regenerate();
            $request->session()->put('user', $userData);
            $request->session()->put('all_users', $users);
            $request->session()->put('all_depts', $depts);
            $request->session()->put('all_detail_dept', $detail_depts);
            $request->session()->put('all_positions', $positions);
            $request->session()->put('status_login', 'local');

            session()->put('roles', $roles);

            $token = $userData->createToken('API Token')->plainTextToken;
            $request->session()->put('token', $token);
            if ($request->username == 'guest') {
                Guest::create([
                    'guest_name' => $request->guest_name,
                    'login_date' => Carbon::now()->format('Y-m-d'),
                ]);
            }
            //mencari nama detail departement untuk akses CRUD
            $userDetailDeptId = session('user')['detail_dept_id'];
            $allDetailDepts = session('all_detail_dept', []);
            $detailDeptColumn = array_column($allDetailDepts, 'id');
            $searchDetailDeptId = array_search($userDetailDeptId, $detailDeptColumn);
            $userDetailDeptName = $allDetailDepts[$searchDetailDeptId]['name'];
            session()->put('user_detail_dept_name', $userDetailDeptName);
            return redirect()->route('limitSample.dashboard')->with('success', 'Login successful.');
        }

        return back()->withErrors([
            'name' => 'Username atau Password tidak benar!',
        ]);
    }

    public function authenticateGuest(Request $request)
    {
        // Validate input
        $request->validate([
            'username' => 'required|string',
            'password' => 'required',
        ]);

        $client = new Client();

        try {
            // Send request to the API login on the main website
            $response = $client->post(env('API_BASE_URL') . '/api/login', [
                'form_params' => [
                    'username' => $request->username,
                    'password' => $request->password,
                ],
            ]);

            $data = json_decode($response->getBody()->getContents(), true);
            if (isset($data['status']) && $data['status'] === 'success') {
                $token = $data['token'];
                $userData = $data['user'];

                // Save token and user data to session
                $request->session()->put('token', $token);
                $request->session()->put('user', $userData);

                // Synchronize roles
                $this->syncRoles($userData['id'], $token);

                // Synchronize permissions
                $permissions = $this->syncPermissions($token);

                if ($permissions === null) {
                    return redirect()
                        ->back()
                        ->withErrors(['message' => 'Failed to fetch permissions.']);
                }

                $request->session()->put('permissions', $permissions);

                // Fetch additional user-related data after login
                $this->fetchUserData($request, $token);

                // Redirect based on roles
                $roles = session('roles', []);
                // if(Guest::where('guest_name' , $request->guest_name)->first() == null)
                // {
                Guest::create([
                    'guest_name' => $request->guest_name,
                    'login_date' => Carbon::now()->format('Y-m-d'),
                ]);
                // }
                $guestName = $request->guest_name;
                // //buat instance baru untuk auth tanpa menyimpannya
                // if ($userData) {
                //     // Jika tidak ada di database, buat instance baru tanpa menyimpannya
                //     $user = new User();
                //     $user->id = $userData['id'];
                //     $user->name = $userData['name'];
                //     $user->email = $userData['email'];
                //     $user->password = $userData['password']; // Pastikan password terenkripsi
                // }

                //Menghitung jumlah kunjungan Guest tersebut
                $guest = Guest::where('guest_name', $guestName)->first();
                $count = $guest->count_visit;
                $count++;
                $guest->update([
                    'count_visit' => $count,
                ]);

                // //login auth
                // Auth::login($user);
                return redirect()->route('limitSample.dashboard')->with('success', 'Login successful.');
            } else {
                return redirect()
                    ->back()
                    ->withErrors(['message' => 'Invalid credentials.']);
            }
        } catch (\GuzzleHttp\Exception\ClientException $e) {
            return redirect()
                ->back()
                ->withErrors(['message' => 'Username or password is incorrect, please try again.']);
        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->withErrors(['message' => 'An error occurred: ' . $e->getMessage()]);
        }
    }

    //login dengan portal AJI
    public function directToExternalSite(Request $request)
    {
        $token = $request->token;
        $request->session()->put('token', $token);
        $client = new Client();

        $response = $client->get(env('API_BASE_URL') . '/api/user', [
            'headers' => [
                'Authorization' => 'Bearer ' . $token,
                'Accept' => 'application/json',
            ],
        ]);
        $data = json_decode($response->getBody()->getContents(), true);
        if (isset($data['status']) && $data['status'] === 'success') {
            $userData = $data['user'];
            // Save token and user data to session
            $request->session()->put('user', $userData);

            // Synchronize roles
            $this->syncRoles($userData['id'], $token);

            // Synchronize permissions
            $permissions = $this->syncPermissions($token);

            if ($permissions === null) {
                return redirect()
                    ->back()
                    ->withErrors(['message' => 'Failed to fetch permissions.']);
            }

            $request->session()->put('permissions', $permissions);
            $this->fetchUserData($request, $token);

            // // Create a user instance manually
            // $user = new User(); // Use your User model namespace
            // $user->id = $userData['id']; // Ensure this ID matches your API user ID
            // $user->name = $userData['name'];
            // $user->email = $userData['email'];
            // $user->password = $userData['password'];
            // // You don't need to set the password here if it's not used

            // // Log the user in using their details (this method creates a session)
            // Auth::login($user); // 'true' for remember me
            if (session('user_detail_dept_name') != 'Quality Control' && session('user_detail_dept_name') != 'Quality Assurance' && session('roles', []) != 'AdminLS') {
                Guest::create([
                    'guest_name' => $userData['npk'],
                    'login_date' => Carbon::now()->format('Y-m-d'),
                ]);

                $guest = Guest::where('guest_name', $userData['npk'])->first();
                $count = $guest->count_visit;
                $count++;
                $guest->update([
                    'count_visit' => $count,
                ]);
            }
            $request->session()->put('status_login', 'api');

            // Redirect based on roles
            return redirect()->route('limitSample.dashboard')->with('success', 'Login successful.');
        } else {
            return redirect()
                ->back()
                ->withErrors(['message' => 'Invalid credentials.']);
        }
    }

    //login dari PORTAL
    // public function externalLogin(Request $request)
    // {
    //     // Validasi token yang diterima
    //     $request->validate([
    //         'token' => 'required|string',
    //     ]);

    //     $request->session()->regenerate();
    //     // Simpan token ke dalam session
    //     session(['token' => $request->token]);

    //     // Ambil token dari session
    //     $token = session('token');

    //     $client = new Client();

    //     // Kirim request ke API Web 1 untuk mendapatkan data pengguna
    //     $response = $client->get(env('API_BASE_URL') . '/api/user', [
    //         'headers' => [
    //             'Authorization' => 'Bearer ' . $token, // Kirim token di header
    //         ],
    //         'timeout' => 30,
    //     ]);

    //     // Ambil data pengguna dari response
    //     $userData = json_decode($response->getBody()->getContents(), true);
    //     return response()->json([
    //         'message' => 'Token berhasil disimpan di session',
    //         'user' => $userData,
    //     ]);
    // }

    public function login(Request $request)
    {
        // Validate input
        $request->validate([
            'username' => 'required|string',
            'password' => 'required',
        ]);

        $client = new Client();

        try {
            // Send request to the API login on the main website
            $response = $client->post(env('API_BASE_URL') . '/api/login', [
                'form_params' => [
                    'username' => $request->username,
                    'password' => $request->password,
                ],
            ]);

            $data = json_decode($response->getBody()->getContents(), true);

            if (isset($data['status']) && $data['status'] === 'success') {
                $token = $data['token'];
                $userData = $data['user'];
                // Save token and user data to session
                $request->session()->put('token', $token);
                $request->session()->put('user', $userData);

                // Synchronize roles
                $this->syncRoles($userData['id'], $token);

                // Synchronize permissions
                $permissions = $this->syncPermissions($token);

                if ($permissions === null) {
                    return redirect()
                        ->back()
                        ->withErrors(['message' => 'Failed to fetch permissions.']);
                }

                $request->session()->put('permissions', $permissions);
                $this->fetchUserData($request, $token);


                // // Create a user instance manually
                // $user = new User(); // Use your User model namespace
                // $user->id = $userData['id']; // Ensure this ID matches your API user ID
                // $user->name = $userData['name'];
                // $user->email = $userData['email'];
                // $user->password = $userData['password'];
                // // You don't need to set the password here if it's not used

                // // Log the user in using their details (this method creates a session)
                // Auth::login($user); // 'true' for remember me

                // Redirect based on roles
                return redirect()->route('limitSample.dashboard')->with('success', 'Login successful.');
            } else {
                return redirect()
                    ->back()
                    ->withErrors(['message' => 'Invalid credentials.']);
            }
        } catch (\GuzzleHttp\Exception\ClientException $e) {
            return redirect()
                ->back()
                ->withErrors(['message' => 'Username or password is incorrect, please try again.']);
        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->withErrors(['message' => 'An error occurred: ' . $e->getMessage()]);
        }
    }

    // Function to fetch additional user-related data
    private function fetchUserData(Request $request, $token)
    {
        $client = new Client();

        try {
            $response = $client->get(env('API_BASE_URL') . '/api/users', [
                'headers' => [
                    'Authorization' => 'Bearer ' . $token,
                    'Accept' => 'application/json',
                ],
            ]);

            $data = json_decode($response->getBody()->getContents(), true);

            if (isset($data['status']) && $data['status'] === 'success') {
                $users = $data['users']; // Assuming the API response contains a 'users' key
                $depts = $data['departments']; // Assuming the API response contains a 'departments' key
                $detail_depts = $data['detailDept']; // Assuming the API response contains a 'detailDept' key
                $positions = $data['positions']; // Assuming the API response contains a 'positions' key
                // Store users and other data in session
                $request->session()->put('all_users', $users);
                $request->session()->put('all_depts', $depts);
                $request->session()->put('all_detail_dept', $detail_depts);
                $request->session()->put('all_positions', $positions);

                //mencari nama detail departement untuk akses CRUD
                $userDetailDeptId = session('user')['detail_dept_id'];
                $allDetailDepts = session('all_detail_dept', []);
                $detailDeptColumn = array_column($allDetailDepts, 'id');
                $searchDetailDeptId = array_search($userDetailDeptId, $detailDeptColumn);
                $userDetailDeptName = $allDetailDepts[$searchDetailDeptId]['name'];
                session()->put('user_detail_dept_name', $userDetailDeptName);

            }
        } catch (\Exception $e) {
            // Handle any errors in fetching user data
            // Log or redirect based on your application logic
        }
    }

    protected function syncRoles($userId, $token)
    {
        $client = new Client();
        $response = $client->get(env('API_BASE_URL') . "/api/users/{$userId}/roles", [
            'headers' => [
                'Authorization' => "Bearer $token",
            ],
        ]);

        $roles = json_decode($response->getBody()->getContents())->roles;

        // Simpan role ke session
        session()->put('roles', $roles);
        // dd(session('roles'));
    }
    private function syncPermissions($token)
    {
        $client = new Client();

        try {
            // Kirim permintaan ke API user-permissions di website utama
            $response = $client->get(env('API_BASE_URL') . '/api/user-permissions', [
                'headers' => [
                    'Authorization' => 'Bearer ' . $token,
                    'Accept' => 'application/json',
                ],
            ]);

            $data = json_decode($response->getBody()->getContents(), true);

            if (isset($data['status']) && $data['status'] === 'success') {
                if(empty($data['permissions'])){
                    return $data['permissions'];
                }else{
                    session()->put('permissions', $data['permissions']);
                    return $data['permissions'];
                }

            }

            return null;
        } catch (\Exception $e) {
            // Log error jika diperlukan
            return null;
        }
    }

    public function fetchAllUsers(Request $request)
    {
    }

    public function logout(Request $request)
    {
        // Ambil token dari session
        $token = session()->get('token');

        // if ($token) {
        //     // Hapus token dari database utama menggunakan API
        //     $client = new Client();

        //     try {
        //         $client->post(env('API_BASE_URL') . '/api/logout', [
        //             'headers' => [
        //                 'Authorization' => "Bearer $token",
        //             ],
        //         ]);
        //     } catch (\Exception $e) {
        //         return redirect()
        //             ->route('login')
        //             ->withErrors(['message' => 'Logout API Error: ' . $e->getMessage()]);
        //     }
        // }

        // Hapus token dan data user dari session

        if (session('status_login') == 'local') {
            $tokenParts = explode('|', $token); // Split the token by "|"
            $tokenId = $tokenParts[0]; // Take the first part, which is "52"
            $user = Auth::user();
            $user->tokens()->where('id', $tokenId)->delete();
        } else {
            if ($token) {
                // Hapus token dari database utama menggunakan API
                $client = new Client();

                try {
                    $client->post(env('API_BASE_URL') . '/api/logout', [
                        'headers' => [
                            'Authorization' => "Bearer $token",
                        ],
                    ]);
                } catch (\Exception $e) {
                    return redirect()
                        ->route('login')
                        ->withErrors(['message' => 'Logout API Error: ' . $e->getMessage()]);
                }
            }
        }
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        // Redirect ke halaman login
        return redirect()->route('login')->with('message', 'You have been logged out.');

        // $request->session()->invalidate();

        // $request->session()->regenerateToken();

        // return redirect('login');
    }

    public function dashboard()
    {


        // dd($all_depts[$index]['name']);
        return redirect()->route('model.index');
    }

    // public function logout(Request $request)
    // {
    //     Auth::logout();

    //     $request->session()->invalidate();

    //     $request->session()->regenerateToken();

    //     return redirect('/');
    // }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    // public function create()
    // {
    //     //
    // }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    // public function store(Request $request)
    // {
    //     //
    // }

    /**
     * Display the specified resource.
     *
     */
    public function show(Request $request)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     */
    public function edit(Request $request)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     */
    public function update(Request $request)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     */
    public function destroy(Request $request)
    {
        //
    }
}
