<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\UserModel;
use App\Models\StudentModel;
use App\Models\LecturerModel;
use App\Models\StaffModel;
use App\Models\AlumniModel;
use Yajra\DataTables\Facades\DataTables;

class UserDataTableController extends Controller
{
    /**
     * Get users for DataTables.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getUsers(Request $request)
    {
        $users = UserModel::select(['user_id', 'role', 'identity_number', 'exam_status', 'phone_number']);

        // Search by name or identity_number
        if ($search = $request->input('search.value')) {
            $users->where(function ($q) use ($search) {
                // Search by identity_number
                $q->where('identity_number', 'like', "%{$search}%");

                // Search by name in all related tables
                $studentIds = StudentModel::where('name', 'like', "%{$search}%")->pluck('user_id');
                $lecturerIds = LecturerModel::where('name', 'like', "%{$search}%")->pluck('user_id');
                $staffIds = StaffModel::where('name', 'like', "%{$search}%")->pluck('user_id');
                $alumniIds = AlumniModel::where('name', 'like', "%{$search}%")->pluck('user_id');

                $allIds = $studentIds->merge($lecturerIds)->merge($staffIds)->merge($alumniIds);

                if ($allIds->count() > 0) {
                    $q->orWhereIn('user_id', $allIds);
                }
            });
        }

        return DataTables::of($users)
            ->addColumn('name', function ($user) {
                switch ($user->role) {
                    case 'student':
                        $profile = StudentModel::where('user_id', $user->user_id)->first();
                        return $profile ? $profile->name : 'N/A';
                    case 'lecturer':
                        $profile = LecturerModel::where('user_id', $user->user_id)->first();
                        return $profile ? $profile->name : 'N/A';
                    case 'staff':
                        $profile = StaffModel::where('user_id', $user->user_id)->first();
                        return $profile ? $profile->name : 'N/A';
                    case 'alumni':
                        $profile = AlumniModel::where('user_id', $user->user_id)->first();
                        return $profile ? $profile->name : 'N/A';
                    case 'admin':
                        return 'Admin';
                    default:
                        return 'N/A';
                }
            })
            ->editColumn('role', function ($user) {
                return ucfirst($user->role);
            })
            ->editColumn('exam_status', function ($user) {
                $statusMap = [
                    'not_yet' => '<span class="badge badge-warning">Not Yet</span>',
                    'success' => '<span class="badge badge-success">Success</span>',
                    'fail' => '<span class="badge badge-danger">Failed</span>'
                ];
                return $statusMap[$user->exam_status] ?? '<span class="badge badge-secondary">Unknown</span>';
            })
            ->addColumn('actions', function ($user) {
                return '
        <a href="' . url('/registration/' . $user->user_id . '/show') . '" class="btn btn-sm btn-info"><i class="fas fa-eye"></i></a>
        <a href="' . url('/registration/' . $user->user_id . '/edit') . '" class="btn btn-sm btn-primary"><i class="fas fa-edit"></i></a>
        <button class="btn btn-sm btn-danger delete-btn" data-id="' . $user->user_id . '"><i class="fas fa-trash"></i></button>';
            })
            ->rawColumns(['exam_status', 'actions'])
            ->make(true);
    }

    public function showUser($id)
    {
        $user = UserModel::findOrFail($id);

        // Ambil nama dari relasi
        switch ($user->role) {
            case 'student':
                $profile = StudentModel::where('user_id', $user->user_id)->first();
                $name = $profile ? $profile->name : 'N/A';
                break;
            case 'lecturer':
                $profile = LecturerModel::where('user_id', $user->user_id)->first();
                $name = $profile ? $profile->name : 'N/A';
                break;
            case 'staff':
                $profile = StaffModel::where('user_id', $user->user_id)->first();
                $name = $profile ? $profile->name : 'N/A';
                break;
            case 'alumni':
                $profile = AlumniModel::where('user_id', $user->user_id)->first();
                $name = $profile ? $profile->name : 'N/A';
                break;
            case 'admin':
                $name = 'Admin';
                break;
            default:
                $name = 'N/A';
        }

        // Kirim data ke view
        return view('users-admin.registration.show', [
            'user' => (object)[
                'user_id' => $user->user_id,
                'name' => $name,
                'role' => $user->role,
                'identity_number' => $user->identity_number,
                'exam_status' => $user->exam_status,
            ]
        ]);
    }

    public function editUser($id)
    {
        $user = UserModel::findOrFail($id);

        // Ambil nama dari relasi
        switch ($user->role) {
            case 'student':
                $profile = StudentModel::where('user_id', $user->user_id)->first();
                $name = $profile ? $profile->name : 'N/A';
                break;
            case 'lecturer':
                $profile = LecturerModel::where('user_id', $user->user_id)->first();
                $name = $profile ? $profile->name : 'N/A';
                break;
            case 'staff':
                $profile = StaffModel::where('user_id', $user->user_id)->first();
                $name = $profile ? $profile->name : 'N/A';
                break;
            case 'alumni':
                $profile = AlumniModel::where('user_id', $user->user_id)->first();
                $name = $profile ? $profile->name : 'N/A';
                break;
            case 'admin':
                $name = 'Admin';
                break;
            default:
                $name = 'N/A';
        }

        // Kirim data ke view
        return view('users-admin.registration.edit', [
            'user' => (object)[
                'user_id' => $user->user_id,
                'name' => $name,
                'role' => $user->role,
                'identity_number' => $user->identity_number,
                'exam_status' => $user->exam_status,
            ]
        ]);
    }

    public function deleteUser($id)
    {
        $user = UserModel::findOrFail($id);
        $user->delete();

        return response()->json(['success' => true]);
    }

    public function updateUser(Request $request, $id)
    {
        $user = UserModel::findOrFail($id);
        $user->identity_number = $request->input('identity_number');
        $user->role = $request->input('role');
        $user->exam_status = $request->input('exam_status');
        $user->save();

        // Update name di relasi jika ada
        switch ($user->role) {
            case 'student':
                $profile = StudentModel::where('user_id', $user->user_id)->first();
                if ($profile) $profile->update(['name' => $request->input('name')]);
                break;
            case 'lecturer':
                $profile = LecturerModel::where('user_id', $user->user_id)->first();
                if ($profile) $profile->update(['name' => $request->input('name')]);
                break;
            case 'staff':
                $profile = StaffModel::where('user_id', $user->user_id)->first();
                if ($profile) $profile->update(['name' => $request->input('name')]);
                break;
            case 'alumni':
                $profile = AlumniModel::where('user_id', $user->user_id)->first();
                if ($profile) $profile->update(['name' => $request->input('name')]);
                break;
        }

        return redirect()->route('registration')->with('success', 'User updated successfully');
    }

public function showDeleteModal($id)
{
    $user = UserModel::find($id);

    // Ambil nama dari relasi jika perlu
    if ($user) {
        switch ($user->role) {
            case 'student':
                $profile = StudentModel::where('user_id', $user->user_id)->first();
                $user->name = $profile ? $profile->name : 'N/A';
                break;
            case 'lecturer':
                $profile = LecturerModel::where('user_id', $user->user_id)->first();
                $user->name = $profile ? $profile->name : 'N/A';
                break;
            case 'staff':
                $profile = StaffModel::where('user_id', $user->user_id)->first();
                $user->name = $profile ? $profile->name : 'N/A';
                break;
            case 'alumni':
                $profile = AlumniModel::where('user_id', $user->user_id)->first();
                $user->name = $profile ? $profile->name : 'N/A';
                break;
            default:
                $user->name = 'N/A';
        }
    }

    return view('users-admin.registration.delete', compact('user'))->render();
}
}