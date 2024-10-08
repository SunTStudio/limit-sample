<?php

namespace App\Http\Controllers;

use App\Models\Guest;
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

    // public function authenticate(Request $request)
    // {
    //     $credentials = $request->validate([
    //         'name' => ['required'],
    //         'password' => ['required'],
    //     ]);

    //     if (Auth::attempt($credentials)) {
    //         $request->session()->regenerate();

    //         return redirect()->intended('dashboard');
    //     }

    //     return back()->withErrors([
    //         'name' => 'Username atau Password tidak benar!',
    //     ]);
    // }

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
                    $guest = Guest::where('guest_name',$guestName)->first();
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
                return $data['permissions'];
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

        // Hapus token dan data user dari session
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
