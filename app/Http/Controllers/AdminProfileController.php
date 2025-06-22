<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\AdminModel;
use Illuminate\Support\Facades\Storage;
use App\Models\UserModel;
use Illuminate\Support\Facades\Log;

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

        // Check if admin has uploaded a custom photo
        $hasCustomPhoto = $admin->photo && !str_contains($admin->photo, 'img/avatar/');

        return view('users-admin.profile.profile', compact('admin', 'user', 'hasCustomPhoto'));
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
            if ($admin->photo && !str_contains($admin->photo, 'img/avatar/')) {
                $oldPhotoPath = str_replace('storage/', '', $admin->photo);
                if (Storage::disk('public')->exists($oldPhotoPath)) {
                    Storage::disk('public')->delete($oldPhotoPath);
                    Log::info('Deleted old admin photo: ' . $oldPhotoPath);
                }
            }

            // Store new photo
            $file = $request->file('photo');
            $path = $file->store('admin/photos', 'public');
            $admin->photo = 'storage/' . $path; // Prepend storage/ for easy asset() linking

            Log::info('Admin photo uploaded successfully', [
                'path' => $path,
                'admin_id' => $admin->admin_id
            ]);
        }

        $admin->save();

        return redirect()->route('admin.profile')->with('success', 'Profile updated successfully!');
    }

    /**
     * Sync uploaded file from storage/app/public to public/storage
     */
    private function syncStorageFile($filePath)
    {
        try {
            $sourcePath = storage_path('app/public/' . $filePath);
            $targetPath = public_path('storage/' . $filePath);

            // Create target directory if it doesn't exist
            $targetDir = dirname($targetPath);
            if (!is_dir($targetDir)) {
                mkdir($targetDir, 0755, true);
            }

            // Copy file
            if (file_exists($sourcePath)) {
                copy($sourcePath, $targetPath);
                Log::info('File synced successfully', [
                    'source' => $sourcePath,
                    'target' => $targetPath
                ]);
            }
        } catch (\Exception $e) {
            Log::error('Failed to sync storage file: ' . $e->getMessage());
        }
    }
}
