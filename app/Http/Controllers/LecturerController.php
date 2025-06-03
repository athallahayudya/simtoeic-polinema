<?php

namespace App\Http\Controllers;

use App\Models\ExamRegistrationModel;
use App\Models\LecturerModel;
use App\Models\UserModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class LecturerController extends Controller
{
    public function list()
    {
        $lecturers = LecturerModel::select('lecturer_id', 'user_id', 'name', 'nidn', 'ktp_scan', 'photo', 'home_address', 'current_address')
                                ->with('user');

        return DataTables::of($lecturers)
            ->addIndexColumn()
            ->editColumn('ktp_scan', function ($lecturers) {
                return $lecturers->ktp_scan ? asset($lecturers->ktp_scan) : '-';
            })
            ->editColumn('photo', function ($lecturers) {
                return $lecturers->photo ? asset($lecturers->photo) : '-';
            })
            ->addColumn('action', function ($lecturer) {
                $btn = '<button onclick="modalAction(\''.url('/manage-users/lecturer/' . $lecturer->lecturer_id . '/show_ajax').'\')" class="btn btn-sm btn-info"><i class="fas fa-eye"></i></button> ';
                $btn .= '<button onclick="modalAction(\''.url('/manage-users/lecturer/' . $lecturer->lecturer_id . '/edit_ajax').'\')" class="btn btn-sm btn-primary"><i class="fas fa-edit"></i></button> ';
                $btn .= '<button onclick="modalAction(\''.url('/manage-users/lecturer/' . $lecturer->lecturer_id . '/delete_ajax').'\')" class="btn btn-sm btn-danger"><i class="fas fa-trash"></i></button> ';
                return $btn;
            })
            ->rawColumns(['action', 'ktp_scan', 'photo'])
            ->make(true);
    }

    public function edit_ajax(string $id)
    {
        $lecturer = LecturerModel::find($id);

        return view('users-admin.manage-user.lecturer.edit', ['lecturer' => $lecturer]);
    }

    public function update_ajax(Request $request, $id)
    {
            $rules = [
                'name' => 'required|string|max:100',
                'photo' => 'nullable|file|mimes:jpg,jpeg,png|max:2048',
                'home_address' => 'required|string',
                'current_address' => 'required|string',
            ];

            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'Valiation failed.',
                    'msgField' => $validator->errors()
                ]);
            }

            $lecturer = LecturerModel::find($id);
            if ($lecturer) {
                $data = $request->only([
                    'name', 
                    'home_address', 
                    'current_address'
                ]);

            if ($request->hasFile('photo')) {
                if ($lecturer->photo && Storage::disk('public')->exists(str_replace('storage/', '', $lecturer->photo))) {
                    Storage::disk('public')->delete(str_replace('storage/', '', $lecturer->photo));
                }
                $path = $request->file('photo')->store('lecturer/photos', 'public');
                $lecturer->photo = 'storage/' . $path;
            }

                $lecturer->update($data);
                return response()->json([
                    'status' => true,
                    'message' => 'Lecturer data successfully updated'
                ]);
            } else {
                return response()->json([
                    'status' => false,
                    'message' => 'Data not found.'
                ]);
            }
        return redirect('/manage-users/lecturer');
    }

    public function confirm_ajax(string $id)
    {
        $lecturer = LecturerModel::find($id);

        return view('users-admin.manage-user.lecturer.delete', ['lecturer' => $lecturer]);
    }

    public function delete_ajax( string $id)
    {
        $lecturer = LecturerModel::find($id);
        if ($lecturer) {
            $lecturer->delete();

            return response()->json([
                'status' => true,
                'message' => 'Lecturer data successfully deleted'
            ]);
        } else {
            return response()->json([
                'status' => false,
                'message' => 'Data not found.'
            ]);
        }
        return redirect('/manage-users/lecturer');
    }

    public function show_ajax(string $id)
    {
        $lecturer = LecturerModel::find($id);

        return view('users-admin.manage-user.lecturer.show', [
            'lecturer' => $lecturer
        ]);
    }

        /**
     * Display lecturer dashboard
     */
   public function dashboard()
{
    $type_menu = 'dashboard';
    // Get schedules and exam results similar to other controllers
    $schedules = \App\Models\ExamScheduleModel::paginate(10);
    $examResults = \App\Models\ExamResultModel::where('user_id', auth()->id())->latest()->first();

    // ambil skor dari 4 tabel user: student, staff, lecturer, alumni
    $examScores = \App\Models\ExamResultModel::with([
        'user' => function ($query) {
            $query->with(['student', 'staff', 'lecturer', 'alumni']);
        }
    ])->get();
    
    // Ambil announcement terbaru dari AnnouncementModel
    $announcements = \App\Models\AnnouncementModel::orderBy('announcement_date', 'desc')->first();
    
    return view('users-lecturer.lecturer-dashboard', compact('type_menu', 'schedules', 'examResults', 'examScores', 'announcements'));
}
    
    /**
     * Display lecturer profile
     */
    public function profile()
    {
        $lecturer = LecturerModel::where('user_id', auth()->id())->first();

        return view('users-lecturer.lecturer-profile', [
            'type_menu' => 'profile',
            'lecturer' => $lecturer
        ]);
    }

    public function updateProfile(Request $request)
    {
        $user = Auth::guard('web')->user();
        if (!$user || $user->role !== 'lecturer') {
            abort(403, 'Unauthorized or insufficient permissions.');
        }

        $lecturer = LecturerModel::where('user_id', $user->user_id)->firstOrFail();

        $request->validate([
            'name' => 'required|string|max:255',
            'phone_number' => 'required|string|min:10|max:15|regex:/^[0-9+\-\s]+$/',  
            'home_address' => 'required|string',
            'current_address' => 'required|string',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'ktp_scan' => 'nullable|file|mimes:jpeg,png,jpg,pdf|max:2048',
        ]);

        $lecturer -> name = $request->input('name');
        $lecturer -> home_address = $request->input('home_address');
        $lecturer -> current_address = $request->input('current_address');

        // Update phone number
        $userModel = UserModel::find($user->user_id);
        if ($userModel) {
            $userModel->phone_number = $request->input('phone_number');
            $userModel->save();
        }

        // Handle photo upload  
        if ($request->hasFile('photo')) {
            // Delete old photo if exists
            if ($lecturer->photo && Storage::disk('public')->exists(str_replace('storage/', '', $lecturer->photo))) {
                Storage::disk('public')->delete(str_replace('storage/', '', $lecturer->photo));
            }
            $path = $request->file('photo')->store('lecturer/photos', 'public');
            $lecturer->photo = 'storage/' . $path;
        }

        // Handle KTP scan upload
        if ($request->hasFile('ktp_scan')) {
            if ($lecturer->ktp_scan && Storage::disk('public')->exists(str_replace('storage/', '', $lecturer->ktp_scan))) {
                Storage::disk('public')->delete(str_replace('storage/', '', $lecturer->ktp_scan));
            }
            $ktpPath = $request->file('ktp_scan')->store('lecturer/ktp', 'public');
            $lecturer->ktp_scan = 'storage/' . $ktpPath;
        }

        // Save lecturer data
        $lecturer->save();

        return redirect()->route('lecturer.profile')->with('success', 'Profile updated successfully!');
    }

    public function showRegistrationForm()
    {
        $user = Auth::guard('web')->user();
        if (!$user || $user->role !== 'lecturer') {
            abort(403, 'Unauthorized or insufficient permissions.');
        }

        // Get lecturer data      
        $lecturer = lecturerModel::where('user_id', $user->user_id)->first();

        // Check profile completeness
        $isProfileComplete = true;
        if (
            !$lecturer || !$lecturer->photo || !$lecturer->ktp_scan  || !$lecturer->home_address
            || !$lecturer->current_address || !$user->phone_number
        ) {
            $isProfileComplete = false;
        }

        // Get latest exam result (score > 0 means it's a real score)
        $examResults = ExamRegistrationModel::where('user_id', $user->user_id)
            ->where('score', '>', 0)
            ->latest()
            ->first();

        // Check if lecturer is already registered for an upcoming exam
        $isRegistered = ExamRegistrationModel::where('user_id', $user->user_id)
            ->where('score', 0)  // 0 means "registered but not taken"
            ->whereHas('schedule', function ($query) {
                $query->where('exam_date', '>', now());
            })
            ->exists();

        return view('users-lecturer.lecturer-registration', [
            'type_menu' => 'registration',
            'user' => $user,
            'lecturer' => $lecturer,
            'examResults' => $examResults,
            'isProfileComplete' => $isProfileComplete,
            'isRegistered' => $isRegistered
        ]);
    }
}
