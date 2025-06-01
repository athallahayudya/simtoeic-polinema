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
use Illuminate\Support\Facades\Log;

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
        try {
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
                    // Changed to use modalAction approach like staff management page
                    $btn = '<button onclick="modalAction(\'' . url('/registration/' . $user->user_id . '/show_ajax') . '\')" class="btn btn-sm btn-info"><i class="fas fa-eye"></i></button> ';
                    $btn .= '<button onclick="modalAction(\'' . url('/registration/' . $user->user_id . '/edit_ajax') . '\')" class="btn btn-sm btn-primary"><i class="fas fa-edit"></i></button> ';
                    $btn .= '<button onclick="modalAction(\'' . url('/registration/' . $user->user_id . '/delete_ajax') . '\')" class="btn btn-sm btn-danger"><i class="fas fa-trash"></i></button>';
                    return $btn;
                })
                ->rawColumns(['exam_status', 'actions'])
                ->make(true);
        } catch (\Exception $e) {
            Log::error('DataTables error: ' . $e->getMessage());
            return response()->json(['error' => 'Failed to load user data'], 500);
        }
    }

    // Changed approach to match staff management page
    public function show_ajax($id)
    {
        $user = UserModel::findOrFail($id);

        // Get profile data based on role
        $profile = null;
        if ($user->role === 'student') {
            $profile = StudentModel::where('user_id', $user->user_id)->first();
        } elseif ($user->role === 'lecturer') {
            $profile = LecturerModel::where('user_id', $user->user_id)->first();
        } elseif ($user->role === 'staff') {
            $profile = StaffModel::where('user_id', $user->user_id)->first();
        } elseif ($user->role === 'alumni') {
            $profile = AlumniModel::where('user_id', $user->user_id)->first();
        }

        return view('users-admin.registration.show', [
            'user' => $user,
            'profile' => $profile
        ]);
    }

    public function edit_ajax($id)
    {
        $user = UserModel::findOrFail($id);

        return view('users-admin.registration.edit', [
            'user' => $user
        ]);
    }

    public function update_ajax(Request $request, $id)
{
    // First validate the basic required fields
    $validator = Validator::make($request->all(), [
        'identity_number' => 'required',
        'role' => 'required',
        'password' => 'nullable|min:8'
    ]);

    if ($validator->fails()) {
        return response()->json([
            'status' => false,
            'message' => 'Validation failed',
            'msgField' => $validator->errors()
        ]);
    }

    try {
        $user = UserModel::findOrFail($id);

        // Check if the identity number is already used by another user
        $existingUser = UserModel::where('identity_number', $request->identity_number)
            ->where('user_id', '!=', $id)
            ->first();

        if ($existingUser) {
            return response()->json([
                'status' => false,
                'message' => 'Identity number already in use by another user',
                'msgField' => [
                    'identity_number' => ['This identity number is already registered']
                ]
            ]);
        }

        // Create data array with validated fields
        $data = [
            'identity_number' => $request->identity_number,
            'role' => $request->role
        ];

        // Only update password if provided
        if ($request->filled('password')) {
            // Additional password validation for client-side validation consistency
            if (strlen($request->password) < 8 || !preg_match('/[A-Za-z]/', $request->password) || !preg_match('/[0-9]/', $request->password)) {
                return response()->json([
                    'status' => false,
                    'message' => 'Password validation failed',
                    'msgField' => [
                        'password' => ['Password must be at least 8 characters with letters and numbers']
                    ]
                ]);
            }
            
            $data['password'] = Hash::make($request->password);
        }

        // Update the user
        $user->update($data);

        // Return success response
        return response()->json([
            'status' => true,
            'message' => 'User updated successfully'
        ]);
    } catch (\Exception $e) {
        // Log the error for debugging
        Log::error('Update user error: ' . $e->getMessage());

        // Return failure response with more user-friendly message
        $errorMessage = 'Failed to update user';

        // If it's a duplicate key error, provide a specific message
        if (
            strpos($e->getMessage(), 'Duplicate entry') !== false &&
            strpos($e->getMessage(), 'users_identity_number_unique') !== false
        ) {
            $errorMessage = 'This identity number is already being used by another user';
            return response()->json([
                'status' => false,
                'message' => $errorMessage,
                'msgField' => [
                    'identity_number' => ['This identity number is already registered']
                ]
            ]);
        }

        return response()->json([
            'status' => false,
            'message' => $errorMessage
        ]);
    }
}

    public function confirm_ajax($id)
    {
        $user = UserModel::findOrFail($id);

        return view('users-admin.registration.delete', [
            'user' => $user
        ]);
    }

    public function delete_ajax(Request $request, $id)
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
                'status' => true,
                'message' => 'User deleted successfully'
            ]);
        } catch (\Exception $e) {
            Log::error('Delete user error: ' . $e->getMessage());

            // Check if the error is related to foreign key constraints
            $errorMessage = 'Failed to delete user';
            if (strpos($e->getMessage(), 'foreign key constraint fails') !== false) {
                $errorMessage = 'Cannot delete this user as they have related data in the system';
            }

            return response()->json([
                'status' => false,
                'message' => $errorMessage
            ]);
        }
    }

    // Keep these methods for backward compatibility
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
            Log::error('Show user error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Failed to retrieve user details'
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
            Log::error('Edit user error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Failed to retrieve user data'
            ], 500);
        }
    }

    public function updateUser(Request $request, $id)
    {
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
            $data = $request->only(['identity_number', 'role']);

            if ($request->filled('password')) {
                $data['password'] = Hash::make($request->password);
            }

            $user->update($data);

            return response()->json([
                'success' => true,
                'message' => 'User updated successfully'
            ]);
        } catch (\Exception $e) {
            Log::error('Update user error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Failed to update user'
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
            Log::error('Delete user error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Failed to delete user'
            ], 500);
        }
    }
}
