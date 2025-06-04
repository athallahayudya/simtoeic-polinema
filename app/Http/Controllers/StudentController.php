<?php

namespace App\Http\Controllers;

use App\Models\AnnouncementModel;
use Illuminate\Http\Request;
use App\Models\ExamScheduleModel;
use App\Models\ExamResultModel;
use App\Models\StudentModel;
use App\Models\UserModel;
use App\Models\ExamRegistrationModel;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class StudentController extends Controller
{
    public function dashboard()
    {
        $type_menu = 'dashboard';
        $schedules = ExamScheduleModel::join('exam_result', 'exam_schedule.shcedule_id', '=', 'exam_result.schedule_id')
            ->where('exam_result.user_id', auth()->id())
            ->select('exam_schedule.*')
            ->paginate(10);
            
        $examResults = ExamResultModel::where('user_id', auth()->id())->latest()->first();
        
        // Get the latest published announcement with PDF that's visible to students
        $announcements = AnnouncementModel::where('announcement_status', 'published')
            ->whereNotNull('announcement_file')
            ->where(function($query) {
                $query->whereJsonContains('visible_to', 'student')
                      ->orWhereNull('visible_to')
                      ->orWhere('visible_to', '[]');
            })
            ->orderBy('announcement_date', 'desc')
            ->first();
        
        $examScores = ExamResultModel::with([
            'user' => function ($query) {
                $query->with(['student', 'staff', 'lecturer', 'alumni']);
            }
        ])->get();

        // Enhanced profile completeness check
        $student = StudentModel::where('user_id', auth()->id())->first();
        $user = Auth::guard('web')->user();

        $isComplete = true;
        $missingFiles = [];
        $completedItems = 0;
        $totalItems = 6; // Total required fields: photo, ktp_scan, ktm_scan, home_address, current_address, phone_number

        // Check each required field and count completed ones
        if ($student && $student->photo) {
            $completedItems++;
        } else {
            $isComplete = false;
            $missingFiles[] = 'Profile Photo';
        }

        if ($student && $student->ktp_scan) {
            $completedItems++;
        } else {
            $isComplete = false;
            $missingFiles[] = 'ID Card (KTP) Scan';
        }

        if ($student && $student->ktm_scan) {
            $completedItems++;
        } else {
            $isComplete = false;
            $missingFiles[] = 'Student ID Card (KTM) Scan';
        }

        if ($student && $student->home_address) {
            $completedItems++;
        } else {
            $isComplete = false;
            $missingFiles[] = 'Home Address';
        }

        if ($student && $student->current_address) {
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

        return view('users-student.student-dashboard', compact(
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
        // Get the currently authenticated student
        $student = StudentModel::where('user_id', auth()->id())->first();

        return view('users-student.student-profile', [
            'type_menu' => 'profile',
            'student' => $student
        ]);
    }

    public function list(Request $request)
    {
        $students = StudentModel::select('student_id', 'user_id', 'name', 'nim', 'study_program', 'major', 'campus', 'ktp_scan', 'ktm_scan', 'photo', 'home_address', 'current_address')
            ->with('user:user_id,exam_status');

        if ($request->campus) {
            $students->where('campus', $request->campus);
        }

        return DataTables::of($students)
            ->addIndexColumn()
            ->editColumn('ktp_scan', function ($student) {
                return $student->ktp_scan ? asset($student->ktp_scan) : '-';
            })
            ->editColumn('ktm_scan', function ($student) {
                return $student->ktm_scan ? asset($student->ktm_scan) : '-';
            })
            ->editColumn('photo', function ($student) {
                return $student->photo ? asset($student->photo) : '-';
            })
            ->addColumn('action', function ($student) {
                $btn = '<button onclick="modalAction(\'' . url('/manage-users/student/' . $student->student_id . '/show_ajax') . '\')" class="btn btn-sm btn-info"><i class="fas fa-eye"></i></button> ';
                $btn .= '<button onclick="modalAction(\'' . url('/manage-users/student/' . $student->student_id . '/edit_ajax') . '\')" class="btn btn-sm btn-primary"><i class="fas fa-edit"></i></button> ';
                $btn .= '<button onclick="modalAction(\'' . url('/manage-users/student/' . $student->student_id . '/delete_ajax') . '\')" class="btn btn-sm btn-danger"><i class="fas fa-trash"></i></button> ';
                return $btn;
            })
            ->rawColumns(['action', 'ktp_scan', 'ktm_scan', 'photo'])
            ->make(true);
    }

    public function edit_ajax(string $id)
    {
        $student = StudentModel::find($id);

        return view('users-admin.manage-user.student.edit', ['student' => $student]);
    }

    public function update_ajax(Request $request, $id)
    {
        $rules = [
            'name' => 'required|string|max:100',
            'photo' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'home_address' => 'required|string',
            'current_address' => 'required|string',
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Validasi gagal.',
                'msgField' => $validator->errors()
            ]);
        }

        $student = StudentModel::find($id);
        if ($student) {
            $data = $request->only([
                'name',
                'home_address',
                'current_address'
            ]);

            if ($request->hasFile('photo')) {
                if ($student->photo && Storage::disk('public')->exists(str_replace('storage/', '', $student->photo))) {
                    Storage::disk('public')->delete(str_replace('storage/', '', $student->photo));
                }
                $path = $request->file('photo')->store('student/photos', 'public');
                $student->photo = 'storage/' . $path;
            }

            $student->update($data);
            return response()->json([
                'status' => true,
                'message' => 'Student data has been successfully updated.'
            ]);
        } else {
            return response()->json([
                'status' => false,
                'message' => 'Data not found.'
            ]);
        }
    }

    public function confirm_ajax(string $id)
    {
        $student = StudentModel::find($id);

        return view('users-admin.manage-user.student.delete', ['student' => $student]);
    }

    public function delete_ajax(string $id)
    {
        $student = StudentModel::find($id);
        if ($student) {
            $student->delete();

            return response()->json([
                'status' => true,
                'message' => 'Student data has been successfully deleted.'
            ]);
        } else {
            return response()->json([
                'status' => false,
                'message' => 'Data not found.'
            ]);

        }
        return redirect('/manage-users/student/');
    }

    public function show_ajax(string $id)
    {
        $student = StudentModel::with('user')->find($id);

        return view('users-admin.manage-user.student.show', [
            'student' => $student
        ]);
    }

    public function updateProfile(Request $request)
    {
        $user = Auth::guard('web')->user();
        if (!$user || $user->role !== 'student') {
            abort(403, 'Unauthorized or insufficient permissions.');
        }

        $student = StudentModel::where('user_id', $user->user_id)->firstOrFail();

        $request->validate([
            'name' => 'required|string|max:255',
            'phone_number' => 'required|string|min:10|max:15|regex:/^[0-9+\-\s]+$/',  // Improved validation
            'home_address' => 'required|string',
            'current_address' => 'required|string',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'ktp_scan' => 'nullable|file|mimes:jpeg,png,jpg,pdf|max:2048',
            'ktm_scan' => 'nullable|file|mimes:jpeg,png,jpg,pdf|max:2048',
        ]);

        // Update student data (exclude major and study_program)
        $student->name = $request->input('name');
        $student->home_address = $request->input('home_address');
        $student->current_address = $request->input('current_address');
        // Major and study_program are intentionally not updated as they should be fixed values

        // Update phone number in users table
        $userModel = UserModel::find($user->user_id);
        if ($userModel) {
            $userModel->phone_number = $request->input('phone_number');
            $userModel->save();
        }

        // Handle photo upload
        if ($request->hasFile('photo')) {
            // Delete old photo if exists
            if ($student->photo && Storage::disk('public')->exists(str_replace('storage/', '', $student->photo))) {
                Storage::disk('public')->delete(str_replace('storage/', '', $student->photo));
            }
            $path = $request->file('photo')->store('student/photos', 'public');
            $student->photo = 'storage/' . $path;
        }

        // Handle KTP scan upload
        if ($request->hasFile('ktp_scan')) {
            if ($student->ktp_scan && Storage::disk('public')->exists(str_replace('storage/', '', $student->ktp_scan))) {
                Storage::disk('public')->delete(str_replace('storage/', '', $student->ktp_scan));
            }
            $ktpPath = $request->file('ktp_scan')->store('student/ktp', 'public');
            $student->ktp_scan = 'storage/' . $ktpPath;
        }

        // Handle KTM scan upload
        if ($request->hasFile('ktm_scan')) {
            if ($student->ktm_scan && Storage::disk('public')->exists(str_replace('storage/', '', $student->ktm_scan))) {
                Storage::disk('public')->delete(str_replace('storage/', '', $student->ktm_scan));
            }
            $ktmPath = $request->file('ktm_scan')->store('student/ktm', 'public');
            $student->ktm_scan = 'storage/' . $ktmPath;
        }

        $student->save();

        return redirect()->route('student.profile')->with('success', 'Profile updated successfully!');
    }

    /**
     * Display the exam registration form.
     */
    public function showRegistrationForm()
    {
        $user = Auth::guard('web')->user();
        if (!$user || $user->role !== 'student') {
            abort(403, 'Unauthorized or insufficient permissions.');
        }

        // Get student data
        $student = StudentModel::where('user_id', $user->user_id)->first();

        // Check profile completeness
        $isProfileComplete = true;
        if (
            !$student || !$student->photo || !$student->ktp_scan || !$student->ktm_scan ||
            !$student->home_address || !$student->current_address || !$user->phone_number
        ) {
            $isProfileComplete = false;
        }

        // Get latest exam result (score > 0 means it's a real score)
        $examResults = ExamRegistrationModel::where('user_id', $user->user_id)
            ->where('score', '>', 0)
            ->latest()
            ->first();

        // Check if student is already registered for an upcoming exam
        $isRegistered = ExamRegistrationModel::where('user_id', $user->user_id)
            ->where('score', 0)  // 0 means "registered but not taken"
            ->whereHas('schedule', function ($query) {
                $query->where('exam_date', '>', now());
            })
            ->exists();

        return view('users-student.registration', [
            'type_menu' => 'registration',
            'user' => $user,
            'student' => $student,
            'examResults' => $examResults,
            'isProfileComplete' => $isProfileComplete,
            'isRegistered' => $isRegistered
        ]);
    }

    /**
     * Process a new exam registration.
     */
    public function registerExam(Request $request)
    {
        $user = Auth::guard('web')->user();
        if (!$user || $user->role !== 'student') {
            abort(403, 'Unauthorized or insufficient permissions.');
        }

        // Check if the student is eligible for free registration
        if ($user->exam_status !== 'not_yet') {
            return redirect()->route('student.registration.form')
                ->with('error', 'You are not eligible for free exam registration. Please use the paid option.');
        }

        // Check if student is already registered
        $isAlreadyRegistered = ExamRegistrationModel::where('user_id', $user->user_id)
            ->where('score', 0) // Use 0 as placeholder for "just registered"
            ->whereHas('schedule', function ($query) {
                $query->where('exam_date', '>', now());
            })
            ->exists();

        if ($isAlreadyRegistered) {
            return redirect()->route('student.registration.form')
                ->with('error', 'You are already registered for an upcoming exam.');
        }

        // Get upcoming exam schedules
        $upcomingSchedule = ExamScheduleModel::where('exam_date', '>', now())
            ->orderBy('exam_date')
            ->first();

        if (!$upcomingSchedule) {
            return redirect()->route('student.registration.form')
                ->with('error', 'No upcoming exam schedules available. Please try again later.');
        }

        ExamRegistrationModel::create([
            'user_id' => $user->user_id,
            'schedule_id' => $upcomingSchedule->shcedule_id,
            'score' => 0,  // Use 0 as placeholder for "not taken yet"
            'cerfificate_url' => ''  // Include with empty value
        ]);

        // Redirect with success message
        return redirect()->route('student.registration.form')
            ->with('success', 'You have successfully registered for the TOEIC exam. Please check your telegram for confirmation details.');
    }
}
