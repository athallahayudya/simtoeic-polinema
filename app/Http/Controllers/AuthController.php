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
            $user = Auth::user();
            return $this->redirectBasedOnRole($user);
        }
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
}
