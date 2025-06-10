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
use Illuminate\Support\Facades\DB;

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
            // Join with profile tables to enable searching by name
            $users = UserModel::select(['users.user_id', 'users.role', 'users.identity_number', 'users.exam_status', 'users.phone_number', 'users.created_at'])
                ->leftJoin('student', 'users.user_id', '=', 'student.user_id')
                ->leftJoin('lecturer', 'users.user_id', '=', 'lecturer.user_id')
                ->leftJoin('staff', 'users.user_id', '=', 'staff.user_id')
                ->leftJoin('alumni', 'users.user_id', '=', 'alumni.user_id');

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
                ->filterColumn('name', function ($query, $keyword) {
                    $query->where(function ($q) use ($keyword) {
                        $q->whereHas('student', function ($q) use ($keyword) {
                            $q->where('name', 'like', "%{$keyword}%");
                        })
                            ->orWhereHas('lecturer', function ($q) use ($keyword) {
                                $q->where('name', 'like', "%{$keyword}%");
                            })
                            ->orWhereHas('staff', function ($q) use ($keyword) {
                                $q->where('name', 'like', "%{$keyword}%");
                            })
                            ->orWhereHas('alumni', function ($q) use ($keyword) {
                                $q->where('name', 'like', "%{$keyword}%");
                            });
                    });
                })
                ->editColumn('role', function ($user) {
                    return ucfirst($user->role);
                })
                ->editColumn('exam_status', function ($user) {
                    $statusMap = [
                        'not_yet' => '<span class="badge badge-warning">Not Yet</span>',
                        'on_process' => '<span class="badge badge-info">On Process</span>',
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

            $user->delete(); // This will trigger the deleting event in UserModel

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

    /**
     * Delete all users from the database
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function deleteAll()
    {
        try {
            Log::info('Delete all users request received');

            // Get current logged-in user ID and main admin user to preserve them
            $currentUserId = auth()->id();
            $mainAdminUser = UserModel::where('identity_number', '198506122010011002')->first();
            $mainAdminUserId = $mainAdminUser ? $mainAdminUser->user_id : null;

            $countBefore = UserModel::count();
            Log::info("Users before deletion: {$countBefore}");
            Log::info("Preserving current user ID: {$currentUserId}");
            Log::info("Preserving main admin user ID: {$mainAdminUserId}");

            // Use database transaction for safety
            DB::transaction(function () use ($currentUserId, $mainAdminUserId) {
                // Build query to exclude both current user and main admin
                $excludeUserIds = array_filter([$currentUserId, $mainAdminUserId]);

                // Delete all related profile data first (except preserved users)
                StudentModel::whereNotIn('user_id', $excludeUserIds)->delete();
                LecturerModel::whereNotIn('user_id', $excludeUserIds)->delete();
                StaffModel::whereNotIn('user_id', $excludeUserIds)->delete();
                AlumniModel::whereNotIn('user_id', $excludeUserIds)->delete();

                // Delete all users except the preserved users
                UserModel::whereNotIn('user_id', $excludeUserIds)->delete();
            });

            $countAfter = UserModel::count();
            $deletedCount = $countBefore - $countAfter;
            Log::info("Users after deletion: {$countAfter}");
            Log::info("Deleted {$deletedCount} users, preserved admin users");

            return response()->json([
                'status' => true,
                'message' => "All users have been deleted successfully. Deleted {$deletedCount} users (admin accounts preserved)."
            ]);
        } catch (\Exception $e) {
            Log::error('Error deleting all users: ' . $e->getMessage());

            return response()->json([
                'status' => false,
                'message' => 'An error occurred while deleting users: ' . $e->getMessage()
            ], 500);
        }
    }

    public function store(Request $request)
    {
        $rules = [
            'name' => 'required|min:3',
            'identity_number' => 'required|unique:users,identity_number|min:5',
            'role' => 'required|in:student,lecturer,staff,alumni,admin',
            'password' => ['required', 'min:8', 'regex:/[A-Za-z]/', 'regex:/[0-9]/'],
            'password_confirmation' => 'required|same:password'
        ];

        // Add student-specific validation rules if role is student
        if ($request->input('role') === 'student') {
            $rules['major'] = 'required';
            $rules['study_program'] = 'required';
            $rules['campus'] = 'required';
        }

        // Validate only relevant fields
        $validator = Validator::make($request->only(array_keys($rules)), $rules, [
            'password.regex' => 'Password must include at least one letter and one number',
            'password_confirmation.same' => 'Password confirmation must match password'
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        try {
            // Create the user
            $user = UserModel::create([
                'identity_number' => $request->identity_number,
                'role' => $request->role,
                'password' => Hash::make($request->password),
                'exam_status' => 'not_yet'
            ]);

            // Create appropriate profile based on role
            if ($request->role === 'student') {
                // Include all required fields for StudentModel
                StudentModel::create([
                    'user_id' => $user->user_id,
                    'name' => $request->name,
                    'nim' => $request->identity_number, // Using identity_number as NIM for students
                    'major' => $request->major,
                    'study_program' => $request->study_program,
                    'campus' => $request->campus,
                    'batch' => date('Y'),   // Add current year as batch
                    'status' => 'active',   // Add default status
                    'phone_number' => $request->phone_number ?? null,
                    'email' => $request->email ?? null
                ]);
            } elseif ($request->role === 'lecturer') {
                LecturerModel::create([
                    'user_id' => $user->user_id,
                    'name' => $request->name,
                    'nidn' => $request->identity_number, // Using identity_number as NIDN for lecturers
                    'phone_number' => $request->phone_number ?? null,
                    'email' => $request->email ?? null
                ]);
            } elseif ($request->role === 'staff') {
                StaffModel::create([
                    'user_id' => $user->user_id,
                    'name' => $request->name,
                    'nip' => $request->identity_number, // Using identity_number as NIP for staff
                    'phone_number' => $request->phone_number ?? null,
                    'email' => $request->email ?? null
                ]);
            } elseif ($request->role === 'alumni') {
                AlumniModel::create([
                    'user_id' => $user->user_id,
                    'name' => $request->name,
                    'nik' => $request->identity_number, // Using identity_number as NIK for alumni
                    'phone_number' => $request->phone_number ?? null,
                    'email' => $request->email ?? null
                ]);
            }

            return redirect()->route('registration.index')
                ->with('success', 'User created successfully');
        } catch (\Exception $e) {
            Log::error('Create user error: ' . $e->getMessage());

            return redirect()->back()
                ->with('error', 'Failed to create user: ' . $e->getMessage())
                ->withInput();
        }
    }
}
