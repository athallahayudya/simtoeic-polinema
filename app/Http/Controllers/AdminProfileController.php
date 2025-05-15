<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\AdminModel;

class AdminProfileController extends Controller
{
public function show()
{
    $user = Auth::guard('web')->user();
    if (!$user) {
        abort(403, 'Unauthorized');
    }
    $userId = $user->user_id;
    $results = AdminModel::where('user_id', $userId)->get();
    dd("User ID: $userId", $results);
    $admin = AdminModel::where('user_id', $userId)->firstOrFail();
    return view('admin.profile', compact('admin'));
}

    public function update(Request $request)
    {
        $admin = AdminModel::where('user_id', Auth::id())->firstOrFail();

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