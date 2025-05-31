<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\UserModel;
use App\Models\StudentModel;
use App\Models\LecturerModel;
use App\Models\StaffModel;
use App\Models\AlumniModel;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserDataTableController extends Controller
{
    /**
     * Display the registration index page.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        return view('users-admin.registration.index', [
            'type_menu' => 'registration'
        ]);
    }
    
    /**
     * Get users for DataTables.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getUsers(Request $request)
    {
        $users = UserModel::select(['user_id', 'role', 'identity_number', 'exam_status', 'phone_number', 'created_at']);

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
                <button class="btn btn-sm btn-info view-btn" data-id="' . $user->user_id . '"><i class="fas fa-eye"></i></button>
                <button class="btn btn-sm btn-primary edit-btn" data-id="' . $user->user_id . '"><i class="fas fa-edit"></i></button>
                <button class="btn btn-sm btn-danger delete-btn" data-id="' . $user->user_id . '"><i class="fas fa-trash"></i></button>';
            })
            ->rawColumns(['exam_status', 'actions'])
            ->make(true);
    }

    public function showUser($id)
    {
        try {
            $user = UserModel::findOrFail($id);

            // Get related profile data based on role
            $profileData = null;
            if ($user->role === 'student') {
                $profileData = StudentModel::where('user_id', $user->user_id)->first();
            } elseif ($user->role === 'lecturer') {
                $profileData = LecturerModel::where('user_id', $user->user_id)->first();
            } elseif ($user->role === 'staff') {
                $profileData = StaffModel::where('user_id', $user->user_id)->first();
            } elseif ($user->role === 'alumni') {
                $profileData = AlumniModel::where('user_id', $user->user_id)->first();
            }

            return response()->json([
                'success' => true,
                'data' => $user,
                'profile' => $profileData,
                'message' => 'User details retrieved successfully'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to retrieve user details: ' . $e->getMessage()
            ], 500);
        }
    }

    public function editUser($id)
    {
        try {
            $user = UserModel::findOrFail($id);
            return response()->json([
                'success' => true,
                'data' => $user,
                'message' => 'User data retrieved for editing'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to retrieve user data: ' . $e->getMessage()
            ], 500);
        }
    }

    public function updateUser(Request $request, $id)
    {
        // Update validation rules - remove email requirement since it doesn't exist
        $validator = Validator::make($request->all(), [
            'identity_number' => 'required',
            'role' => 'required',
            'password' => 'nullable|min:8'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $user = UserModel::findOrFail($id);
            $data = $request->except(['_token', 'password', 'email']); // Remove email from the data

            if ($request->filled('password')) {
                $data['password'] = Hash::make($request->password);
            }

            $user->update($data);

            return response()->json([
                'success' => true,
                'message' => 'User updated successfully'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to update user: ' . $e->getMessage()
            ], 500);
        }
    }

    public function deleteUser($id)
    {
        try {
            $user = UserModel::findOrFail($id);

            // Delete related profile data based on role
            if ($user->role === 'student') {
                StudentModel::where('user_id', $id)->delete();
            } elseif ($user->role === 'lecturer') {
                LecturerModel::where('user_id', $id)->delete();
            } elseif ($user->role === 'staff') {
                StaffModel::where('user_id', $id)->delete();
            } elseif ($user->role === 'alumni') {
                AlumniModel::where('user_id', $id)->delete();
            }

            $user->delete();

            return response()->json([
                'success' => true,
                'message' => 'User deleted successfully'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to delete user: ' . $e->getMessage()
            ], 500);
        }
    }
}