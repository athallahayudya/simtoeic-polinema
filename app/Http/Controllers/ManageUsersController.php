<?php

namespace App\Http\Controllers;

use App\Models\AlumniModel;
use App\Models\LecturerModel;
use App\Models\StaffModel;
use App\Models\StudentModel;
use App\Models\UserModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\Facades\DataTables;

class ManageUsersController extends Controller
{
    public function list(Request $request)
    {
        $user = UserModel::select('user_id', 'identity_number', 'role', 'exam_status', 'phone_number')
            ->with(['alumni', 'student', 'staff', 'lecturer']);

        if ($request->has('role') && !empty($request->role)) {
            $user->where('role', $request->role);
        }

        return DataTables::of($user)
            ->addColumn('name', function ($user) {
                switch ($user->role) {
                    case 'student':
                        $profile = $user->student;
                        return $profile ? $profile->name : 'N/A';
                    case 'lecturer':
                        $profile = $user->lecturer;
                        return $profile ? $profile->name : 'N/A';
                    case 'staff':
                        $profile = $user->staff;
                        return $profile ? $profile->name : 'N/A';
                    case 'alumni':
                        $profile = $user->alumni;
                        return $profile ? $profile->name : 'N/A';
                    default:
                        return 'N/A';
                }
            })
            ->addColumn('home_address', function ($user) {
                switch ($user->role) {
                    case 'student':
                        $profile = $user->student;
                        return $profile ? $profile->home_address : '-';
                    case 'lecturer':
                        $profile = $user->lecturer;
                        return $profile ? $profile->home_address : '-';
                    case 'staff':
                        $profile = $user->staff;
                        return $profile ? $profile->home_address : '-';
                    case 'alumni':
                        $profile = $user->alumni;
                        return $profile ? $profile->home_address : '-';
                    default:
                        return '-';
                }
            })
            ->addColumn('current_address', function ($user) {
                switch ($user->role) {
                    case 'student':
                        $profile = $user->student;
                        return $profile ? $profile->current_address : '-';
                    case 'lecturer':
                        $profile = $user->lecturer;
                        return $profile ? $profile->current_address : '-';
                    case 'staff':
                        $profile = $user->staff;
                        return $profile ? $profile->current_address : '-';
                    case 'alumni':
                        $profile = $user->alumni;
                        return $profile ? $profile->current_address : '-';
                    default:
                        return '-';
                }
            })
            ->editColumn('ktp_scan', function ($user) {
                switch ($user->role) {
                    case 'student':
                        $profile = $user->student;
                        return $profile ? asset($profile->ktp_scan) : '-';
                    case 'lecturer':
                        $profile = $user->lecturer;
                        return $profile ? asset($profile->ktp_scan) : '-';
                    case 'staff':
                        $profile = $user->staff;
                        return $profile ? asset($profile->ktp_scan) : '-';
                    case 'alumni':
                        $profile = $user->alumni;
                        return $profile ? asset($profile->ktp_scan) : '-';
                    default:
                        return '-';
                }
            })
            ->editColumn('photo', function ($user) {
                switch ($user->role) {
                    case 'student':
                        $profile = $user->student;
                        return $profile ? asset($profile->photo) : '-';
                    case 'lecturer':
                        $profile = $user->lecturer;
                        return $profile ? asset($profile->photo) : '-';
                    case 'staff':
                        $profile = $user->staff;
                        return $profile ? asset($profile->photo) : '-';
                    case 'alumni':
                        $profile = $user->alumni;
                        return $profile ? asset($profile->photo) : '-';
                    default:
                        return '-';
                }
            })
            ->addColumn('exam_status', function ($user) {
                $examStatus = $user->exam_status ?? '-';
                $badgeClass = '';
                switch (strtolower($examStatus)) {
                    case 'success':
                        $badgeClass = 'badge-success';
                        break;
                    case 'not_yet':
                        $badgeClass = 'badge-warning';
                        break;
                    case 'on_process':
                        $badgeClass = 'badge-info';
                        break;
                    case 'fail':
                        $badgeClass = 'badge-danger';
                        break;
                    default:
                        $badgeClass = 'badge-secondary';
                }
                return '<span class="badge ' . $badgeClass . '">' . ucfirst(str_replace('_', ' ', $examStatus)) . '</span>';
            })
            ->addColumn('action', function ($user) {
                $btn = '<button onclick="modalAction(\'' . url('users/' . $user->user_id . '/show_ajax') . '\')" class="btn btn-sm btn-info"><i class="fas fa-eye"></i></button> ';
                $btn .= '<button onclick="modalAction(\'' . url('users/' . $user->user_id . '/edit_ajax') . '\')" class="btn btn-sm btn-primary"><i class="fas fa-edit"></i></button> ';
                $btn .= '<button onclick="modalAction(\'' . url('users/' . $user->user_id . '/delete_ajax') . '\')" class="btn btn-sm btn-danger"><i class="fas fa-trash"></i></button> ';
                return $btn;
            })
            ->rawColumns(['action', 'exam_status', 'name', 'home_address', 'current_address', 'ktp_scan', 'photo'])
            ->make(true);
    }

    public function show_ajax($user_id)
    {
        $user = UserModel::with(['student', 'lecturer', 'staff', 'alumni'])->findOrFail($user_id);

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

        return view('users-admin.manage-user.show', [
            'user' => $user,
            'profile' => $profile,
        ]);
    }

    public function edit_ajax($user_id)
    {
        $user = UserModel::with(['student', 'lecturer', 'staff', 'alumni'])->findOrFail($user_id);

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

        return view('users-admin.manage-user.edit', [
            'user' => $user,
            'profile' => $profile,
        ]);
    }

    public function update_ajax(Request $request, $user_id)
    {
        $user = UserModel::with(['student', 'lecturer', 'staff', 'alumni'])->findOrFail($user_id);

        $data = $request->only(['name', 'home_address', 'current_address']);

        // choose the related model based on user role
        $relatedModel = match ($user->role) {
            'student' => $user->student ?: new StudentModel(),
            'lecturer' => $user->lecturer ?: new LecturerModel(),
            'staff' => $user->staff ?: new StaffModel(),
            'alumni' => $user->alumni ?: new AlumniModel(),
            default => null,
        };

        if ($request->hasFile('photo')) {
            if ($relatedModel->photo && Storage::disk('public')->exists(str_replace('storage/', '', $relatedModel->photo))) {
                Storage::disk('public')->delete(str_replace('storage/', '', $relatedModel->photo));
            }
            $path = $request->file('photo')->store(match ($user->role) {
                'student' => 'student/photos',
                'lecturer' => 'lecturer/photos',
                'staff' => 'staff/photos',
                'alumni' => 'alumni/photos',
                default => 'user/photos',
            },  'public');
            $relatedModel->photo = 'storage/' . $path;
        }

        $relatedModel->fill($data);
        $relatedModel->user_id = $user->user_id;
        $relatedModel->save();

        // Update data in the user model
        $user->update($data);

        return response()->json(['status' => true, 'message' => 'User updated successfully']);
    }

    public function confirm_ajax($user_id)
    {
        $user = UserModel::findOrFail($user_id);

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

        return view('users-admin.manage-user.delete', [
            'user' => $user,
            'profile' => $profile
        ]);
    }

    public function delete_ajax($user_id)
    {
        $user = UserModel::findOrFail($user_id);

        if ($user) {
            $user->delete();

            return response()->json([
                'status' => true,
                'message' => 'User deleted successfully'
            ]);
        } else {
            return response()->json([
                'status' => false,
                'message' => 'User not found.'
            ]);
        }
    }
}
