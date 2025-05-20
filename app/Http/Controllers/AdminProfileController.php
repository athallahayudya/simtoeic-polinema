<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\AdminModel;
use Illuminate\Support\Facades\Storage;

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

        // Jika tidak ada record admin, buat placeholder atau kembalikan pesan
        if (!$admin) {
            return view('pages.features-profile', [
                'message' => 'Admin profile not found. Please contact support to create your profile.',
            ]);
        }

        return view('pages.features-profile', compact('admin'));
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
            'home_address' => 'required|string|max:255',
            'current_address' => 'required|string|max:255',
            'phone_number' => 'required|string|max:20',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'ktp_scan' => 'nullable|file|mimes:jpeg,png,jpg,pdf|max:2048',
        ]);

        // Update data admin
        $admin->name = $request->input('name');
        $admin->nidn = $request->input('nidn');
        $admin->home_address = $request->input('home_address');
        $admin->current_address = $request->input('current_address');

        // Update phone number di tabel user
        $user->phone_number = $request->input('phone_number');
        $user->save();

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