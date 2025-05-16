<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;
use App\Models\AdminModel;
use App\Models\UserModel;

class AdminProfileController extends Controller
{
    public function show()
    {
        $user = Auth::guard('web')->user();
        if (!$user) {
            abort(403, 'Unauthorized');
        }

        if ($user->role !== 'admin') {
            abort(403, 'Only admin users can access this page.');
        }

        $userId = $user->user_id;
        $admin = AdminModel::where('user_id', $userId)->first();

        // If no admin record exists
        if (!$admin) {
            return view('Admin.ManageUsers.admin-not-found', [
                'message' => 'Your admin profile has not been set up yet. Please contact the system administrator.'
            ]);
        }

        return view('Admin.ManageUsers.profile', compact('admin'));
    }

    public function update(Request $request)
    {
        $user = Auth::guard('web')->user();
        $admin = AdminModel::where('user_id', $user->user_id)->firstOrFail();

        $request->validate([
            'name' => 'required|string|max:100',
            'photo' => 'nullable|image|max:2048',
        ]);

        $admin->name = $request->name;

        if ($request->hasFile('photo')) {
            $path = $request->file('photo')->store('admin/photos', 'public');
            $admin->photo = 'storage/' . $path;
        }

        $admin->save();

        return redirect()->route('admin.profile')->with('success', 'Profile updated!');
    }
}