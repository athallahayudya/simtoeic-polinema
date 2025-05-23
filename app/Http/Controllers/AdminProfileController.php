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
            // Limit the NIDN length to avoid database truncation error
            $admin->nidn = $user->identity_number ? substr($user->identity_number, 0, 20) : '';
            $admin->photo = '';
            $admin->ktp_scan = '';
            $admin->save();
        }

        // Pass both admin and user to the view
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
            'nidn' => 'required|string|max:20',
            'phone_number' => 'required|string|max:20',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'ktp_scan' => 'nullable|file|mimes:jpeg,png,jpg,pdf|max:2048',
        ]);

        // Update data admin
        $admin->name = $request->input('name');
        $admin->nidn = $request->input('nidn');

        // Update phone number and identity_number in users table
        $userModel = UserModel::find($user->user_id);
        if ($userModel) {
            $userModel->phone_number = $request->input('phone_number');
            $userModel->identity_number = $request->input('nidn');
            $userModel->save();
        }

        // Handle photo upload
        if ($request->hasFile('photo')) {
            // Hapus foto lama jika ada
            if ($admin->photo && Storage::disk('public')->exists(str_replace('storage/', '', $admin->photo))) {
                Storage::disk('public')->delete(str_replace('storage/', '', $admin->photo));
            }
            $path = $request->file('photo')->store('admin/photos', 'public');
            $admin->photo = 'storage/' . $path;
        }

        // Handle KTP scan upload
        if ($request->hasFile('ktp_scan')) {
            if ($admin->ktp_scan && Storage::disk('public')->exists(str_replace('storage/', '', $admin->ktp_scan))) {
                Storage::disk('public')->delete(str_replace('storage/', '', $admin->ktp_scan));
            }
            $ktpPath = $request->file('ktp_scan')->store('admin/ktp', 'public');
            $admin->ktp_scan = 'storage/' . $ktpPath;
        }

        $admin->save();

        return redirect()->route('admin.profile')->with('success', 'Profile updated successfully!');
    }
}
