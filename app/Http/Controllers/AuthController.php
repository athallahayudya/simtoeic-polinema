<?php

namespace App\Http\Controllers;

use App\Models\AdminModel;
use App\Models\AlumniModel;
use App\Models\LecturerModel;
use App\Models\StaffModel;
use App\Models\StudentModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\UserModel;

class AuthController extends Controller
{
    /**
     * Show login form
     */
    public function showLoginForm()
    {
        if (Auth::check()) {
            return redirect()->route('dashboard');
        }
        // return view('pages.auth-login2', ['type_menu' => 'auth']);
        return view('pages.auth-login2', ['type_menu' => 'auth']);
    }

    /**
     * Handle login request
     */
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'identity_number' => 'required',
            'password' => 'required',
            'role' => 'required|in:student,lecturer,staff,alumni,admin',
        ]);

        // Check if the user exists
        $user = UserModel::where('identity_number', $credentials['identity_number'])->first();

        if (!$user) {
            return back()->withErrors([
                'identity_number' => 'No user found with this identity number.',
            ])->withInput($request->except('password'));
        }

        // // Check if the password is correct
        if (!Hash::check($credentials['password'], $user->password)) {
            return back()->withErrors([
                'password' => 'The password is incorrect.',
            ])->withInput($request->except('password'));
        }

        // Check if the role matches
        if ($user->role !== $credentials['role']) {
            return back()->withErrors([
                'role' => "The selected role '{$credentials['role']}' does not match the user's role '{$user->role}'.",
            ])->withInput($request->except('password'));
        }

        // If all checks pass, log the user in
        Auth::login($user);

        // Redirect based on role
        return $this->redirectBasedOnRole($user);
    }

    /**
     * Redirect user based on role
     */
    private function redirectBasedOnRole($user)
    {
        if ($user->isAdmin()) {
            return redirect('/dashboard-admin');
        } elseif ($user->isLecturer()) {
            return redirect()->route('lecturer.dashboard');
        } elseif ($user->isStudent()) {
            return redirect()->route('student.dashboard');
        } elseif ($user->isStaff()) {
            return redirect()->route('staff.dashboard');
        } elseif ($user->isAlumni()) {
            return redirect()->route('alumni.dashboard');
        }

        // Default redirect
        return redirect()->route('dashboard');
    }

    /**
     * Handle logout request
     */
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        // Change this line
        return redirect()->route('auth.login');
    }

    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:100',
            'role' => 'required|in:student,lecturer,staff,alumni,admin',
            'identity_number' => 'required|string|max:50',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $user = UserModel::create([
            'role' => $request->role,
            'identity_number' => $request->identity_number,
            'password' => Hash::make($request->password),
        ]);

        // Save the name to the corresponding role table
        if ($request->role === 'student') {
            StudentModel::create([
                'user_id' => $user->user_id,
                'name' => $request->name,
                'nim' => $request->identity_number,
            ]);
        } elseif ($request->role === 'lecturer') {
            LecturerModel::create([
                'user_id' => $user->user_id,
                'name' => $request->name,
                'nidn' => $request->identity_number, 
            ]);
        } elseif ($request->role === 'staff') {
            StaffModel::create([
                'user_id' => $user->user_id,
                'name' => $request->name,
                'nip' => $request->identity_number, 
            ]);
        } elseif ($request->role === 'alumni') {
            AlumniModel::create([
                'user_id' => $user->user_id,
                'name' => $request->name,
                'nik' => $request->identity_number,
            ]);
        } elseif ($request->role === 'admin') {
            AdminModel::create([
                'user_id' => $user->user_id,
                'name' => $request->name,
                'identity_number' => $request->identity_number, 
            ]);
        }

        return redirect('/registration')->with('success', 'Registration successful');
    }
}
