<?php


namespace App\Http\Controllers;

use App\Models\StaffModel;
use App\Models\ExamScheduleModel;
use App\Models\ExamResultModel;
use App\Models\AnnouncementModel;
use App\Models\ExamRegistrationModel;
use App\Models\UserModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class StaffController extends Controller
{
    public function list()
    {
        $staff = StaffModel::select('staff_id', 'user_id', 'name', 'nip', 'ktp_scan', 'photo', 'home_address', 'current_address')
            ->with('user');

        return DataTables::of($staff)
            ->addIndexColumn()
            ->editColumn('ktp_scan', function ($staff) {
                return $staff->ktp_scan ? asset($staff->ktp_scan) : '-';
            })
            ->editColumn('photo', function ($staff) {
                return $staff->photo ? asset($staff->photo) : '-';
            })
            ->addColumn('exam_status', function ($staff) {
                $examStatus = $staff->user ? $staff->user->exam_status : '-';
                $badgeClass = '';
                switch (strtolower($examStatus)) {
                    case 'success':
                        $badgeClass = 'badge-success';
                        break;
                    case 'not_yet':
                        $badgeClass = 'badge-warning';
                        break;
                    case 'fail':
                        $badgeClass = 'badge-danger';
                        break;
                    default:
                        $badgeClass = 'badge-secondary';
                }
                return '<span class="badge ' . $badgeClass . '">' . ucfirst($examStatus) . '</span>';
            })
            ->addColumn('action', function ($staff) {
                $btn = '<button onclick="modalAction(\'' . url('/manage-users/staff/' . $staff->staff_id . '/show_ajax') . '\')" class="btn btn-sm btn-info"><i class="fas fa-eye"></i></button> ';
                $btn .= '<button onclick="modalAction(\'' . url('/manage-users/staff/' . $staff->staff_id . '/edit_ajax') . '\')" class="btn btn-sm btn-primary"><i class="fas fa-edit"></i></button> ';
                $btn .= '<button onclick="modalAction(\'' . url('/manage-users/staff/' . $staff->staff_id . '/delete_ajax') . '\')" class="btn btn-sm btn-danger"><i class="fas fa-trash"></i></button> ';
                return $btn;
            })
            ->rawColumns(['action', 'ktp_scan', 'photo', 'exam_status'])
            ->make(true);
    }

    public function edit_ajax(string $id)
    {
        $staff = StaffModel::find($id);
        return view('users-admin.manage-user.staff.edit', ['staff' => $staff]);
    }

    public function update_ajax(Request $request, $id)
    {
        $rules = [
            'name'            => 'required|string|max:100',
            'photo'           => 'nullable|file|mimes:jpg,jpeg,png|max:2048',
            'home_address'    => 'required|string|max:255',
            'current_address' => 'required|string|max:255',
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json([
                'status'   => false,
                'message'  => 'Validation failed.',
                'msgField' => $validator->errors()
            ]);
        }

        $staff = StaffModel::find($id);
        if ($staff) {
            $data = $request->only(['name', 'home_address', 'current_address']);

            if ($request->hasFile('photo')) {
                if ($staff->photo && Storage::disk('public')->exists(str_replace('storage/', '', $staff->photo))) {
                    Storage::disk('public')->delete(str_replace('storage/', '', $staff->photo));
                }
                $path = $request->file('photo')->store('staff/photos', 'public');
                $staff->photo = 'storage/' . $path;
            }

            $staff->update($data);

            return response()->json([
                'status'  => true,
                'message' => 'Staff data successfully updated'
            ]);
        } else {
            return response()->json([
                'status'  => false,
                'message' => 'Data not found.'
            ]);
        }
    }

    public function confirm_ajax(string $id)
    {
        $staff = StaffModel::find($id);
        return view('users-admin.manage-user.staff.delete', ['staff' => $staff]);
    }

    public function delete_ajax(string $id)
    {
        $staff = StaffModel::find($id);
        if ($staff) {
            $staff->delete();

            return response()->json([
                'status' => true,
                'message' => 'Staff data has been successfully deleted.'
            ]);
        } else {
            return response()->json([
                'status' => false,
                'message' => 'Data not found.'
            ]);
        }
    }

    public function show_ajax(string $id)
    {
        $staff = StaffModel::find($id);
        return view('users-admin.manage-user.staff.show', ['staff' => $staff]);
    }

    // Dashboard
    public function dashboard()
    {
        $type_menu = 'dashboard';
        $schedules = ExamScheduleModel::join('exam_result', 'exam_schedule.schedule_id', '=', 'exam_result.schedule_id')
            ->where('exam_result.user_id', auth()->id())
            ->select('exam_schedule.*')
            ->paginate(10);

        $examResults = ExamResultModel::where('user_id', auth()->id())->latest()->first();
        $announcements = AnnouncementModel::where('announcement_status', 'published')
            ->where(function ($query) {
                $query->whereJsonContains('visible_to', 'staff')
                    ->orWhereNull('visible_to')
                    ->orWhere('visible_to', '[]')
                    ->orWhere('visible_to', '');
            })
            ->orderBy('announcement_date', 'desc')
            ->first();
        // Get exam scores only for the current logged-in staff
        $examScores = ExamResultModel::where('user_id', auth()->id())
            ->with(['user.staff', 'schedule'])
            ->orderBy('created_at', 'desc')
            ->get();

        // Enhanced profile completeness check
        $staff = StaffModel::where('user_id', auth()->id())->first();
        $user = Auth::guard('web')->user();

        $isComplete = true;
        $missingFiles = [];
        $completedItems = 0;
        $totalItems = 5; // Total required fields: photo, ktp_scan, home_address, current_address, phone_number

        // Check each required field and count completed ones
        if ($staff && $staff->photo) {
            $completedItems++;
        } else {
            $isComplete = false;
            $missingFiles[] = 'Profile Photo';
        }

        if ($staff && $staff->ktp_scan) {
            $completedItems++;
        } else {
            $isComplete = false;
            $missingFiles[] = 'ID Card (KTP) Scan';
        }

        if ($staff && $staff->home_address) {
            $completedItems++;
        } else {
            $isComplete = false;
            $missingFiles[] = 'Home Address';
        }

        if ($staff && $staff->current_address) {
            $completedItems++;
        } else {
            $isComplete = false;
            $missingFiles[] = 'Current Address';
        }

        if ($user && $user->phone_number) {
            $completedItems++;
        } else {
            $isComplete = false;
            $missingFiles[] = 'Phone Number';
        }

        // Calculate accurate completion percentage
        $completionPercentage = $totalItems > 0 ? round(($completedItems / $totalItems) * 100) : 0;

        // Check if the score is below or equal to 70
        $examFailed = false;
        if ($examResults && $examResults->score <= 70) {
            $examFailed = true;
        }

        return view('users-staff.staff-dashboard', compact(
            'schedules',
            'type_menu',
            'examResults',
            'announcements',
            'examFailed',
            'isComplete',
            'missingFiles',
            'completedItems',
            'totalItems',
            'completionPercentage',
            'examScores'
        ));
    }

    public function profile()
    {
        $staff = StaffModel::where('user_id', auth()->id())->first();

        return view('users-staff.staff-profile', [
            'type_menu' => 'profile',
            'staff' => $staff
        ]);
    }

    public function updateProfile(Request $request)
    {
        $user = Auth::guard('web')->user();
        if (!$user || $user->role !== 'staff') {
            abort(403, 'Unauthorized or insufficient permissions.');
        }

        $staff = staffModel::where('user_id', $user->user_id)->firstOrFail();

        $request->validate([
            'name' => 'required|string|max:255',
            'phone_number' => 'required|string|min:10|max:15|regex:/^[0-9+\-\s]+$/',
            'home_address' => 'required|string',
            'current_address' => 'required|string',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'ktp_scan' => 'nullable|file|mimes:jpeg,png,jpg,pdf|max:2048',
        ]);

        $staff->name = $request->input('name');
        $staff->home_address = $request->input('home_address');
        $staff->current_address = $request->input('current_address');

        // Update phone number
        $userModel = UserModel::find($user->user_id);
        if ($userModel) {
            $userModel->phone_number = $request->input('phone_number');
            $userModel->save();
        }

        // Handle photo upload  
        if ($request->hasFile('photo')) {
            // Delete old photo if exists
            if ($staff->photo && Storage::disk('public')->exists(str_replace('storage/', '', $staff->photo))) {
                Storage::disk('public')->delete(str_replace('storage/', '', $staff->photo));
            }
            $path = $request->file('photo')->store('staff/photos', 'public');
            $staff->photo = 'storage/' . $path;
        }

        // Handle KTP scan upload
        if ($request->hasFile('ktp_scan')) {
            if ($staff->ktp_scan && Storage::disk('public')->exists(str_replace('storage/', '', $staff->ktp_scan))) {
                Storage::disk('public')->delete(str_replace('storage/', '', $staff->ktp_scan));
            }
            $ktpPath = $request->file('ktp_scan')->store('staff/ktp', 'public');
            $staff->ktp_scan = 'storage/' . $ktpPath;
        }

        // Save the staff model
        $staff->save();

        return redirect()->route('staff.profile')->with('success', 'Profile updated successfully!');
    }

    public function showRegistrationForm()
    {
        $user = Auth::guard('web')->user();
        if (!$user || $user->role !== 'staff') {
            abort(403, 'Unauthorized or insufficient permissions.');
        }

        // Get staff data      
        $staff = StaffModel::where('user_id', $user->user_id)->first();

        // Check profile completeness
        $isProfileComplete = true;
        if (
            !$staff || !$staff->photo || !$staff->ktp_scan  || !$staff->home_address
            || !$staff->current_address || !$user->phone_number
        ) {
            $isProfileComplete = false;
        }

        // Get latest exam result (score > 0 means it's a real score)
        $examResults = ExamRegistrationModel::where('user_id', $user->user_id)
            ->where('score', '>', 0)
            ->latest()
            ->first();

        // Check if staff is already registered for an upcoming exam
        $isRegistered = ExamRegistrationModel::where('user_id', $user->user_id)
            ->where('score', 0)  // 0 means "registered but not taken"
            ->whereHas('schedule', function ($query) {
                $query->where('exam_date', '>', now());
            })
            ->exists();

        return view('users-staff.staff-registration', [
            'type_menu' => 'registration',
            'user' => $user,
            'staff' => $staff,
            'examResults' => $examResults,
            'isProfileComplete' => $isProfileComplete,
            'isRegistered' => $isRegistered
        ]);
    }
}
