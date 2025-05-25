<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\AdminModel;
use Illuminate\Support\Facades\Storage;
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

        $admin = AdminModel::where('user_id', $user->user_id)->first();

        // If admin profile doesn't exist, create a new one with user's NIDN
        if (!$admin) {
            $admin = new AdminModel();
            $admin->user_id = $user->user_id;
            $admin->name = $user->name ?? 'Admin';
            $admin->nidn = $user->identity_number ? substr($user->identity_number, 0, 20) : '';
            // Set default photo path
            $admin->photo = 'img/avatar/avatar-1.png'; // Default photo
            $admin->save();
        }

        return view('users-admin.profile.profile', compact('admin', 'user'));
    }

    public function update(Request $request)
    {
        $user = Auth::guard('web')->user();
        if (!$user || $user->role !== 'admin') {
            abort(403, 'Unauthorized or insufficient permissions.');
        }

        $admin = AdminModel::where('user_id', $user->user_id)->firstOrFail();

        $request->validate([
            'name' => 'required|string|max:255',
            'nidn' => 'nullable|string|max:20',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Update data admin
        $admin->name = $request->input('name');
        if ($request->filled('nidn')) {
            $admin->nidn = $request->input('nidn');
        }

        // Update identity_number in users table if NIDN is provided
        if ($request->filled('nidn')) {
            $userModel = UserModel::find($user->user_id);
            if ($userModel) {
                $userModel->identity_number = $request->input('nidn');
                $userModel->save();
            }
        }

        // Handle photo upload
        if ($request->hasFile('photo')) {
            // Delete old photo if it exists and it's not the default photo
            if (
                $admin->photo &&
                !str_contains($admin->photo, 'img/avatar/') &&
                Storage::disk('public')->exists(str_replace('storage/', '', $admin->photo))
            ) {
                Storage::disk('public')->delete(str_replace('storage/', '', $admin->photo));
            }

            // Store new photo
            $path = $request->file('photo')->store('admin/photos', 'public');
            $admin->photo = 'storage/' . $path;
        }

        $admin->save();

        return redirect()->route('admin.profile')->with('success', 'Profile updated successfully!');
    }
}
