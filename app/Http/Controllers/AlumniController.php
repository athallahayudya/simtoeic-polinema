<?php


namespace App\Http\Controllers;

use App\Models\AlumniModel;
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

class AlumniController extends Controller
{
    public function list()
    {
        $alumni = AlumniModel::select('alumni_id', 'user_id', 'name', 'nik', 'ktp_scan', 'photo', 'home_address', 'current_address')
            ->with('user');

        return DataTables::of($alumni)
            ->addIndexColumn()
            ->editColumn('ktp_scan', function ($alumni) {
                return $alumni->ktp_scan ? asset($alumni->ktp_scan) : '-';
            })
            ->editColumn('photo', function ($alumni) {
                return $alumni->photo ? asset($alumni->photo) : '-';
            })
            ->addColumn('action', function ($alumni) {
                $btn = '<button onclick="modalAction(\'' . url('/manage-users/alumni/' . $alumni->alumni_id . '/show_ajax') . '\')" class="btn btn-info btn-sm">Detail</button> ';
                $btn .= '<button onclick="modalAction(\'' . url('/manage-users/alumni/' . $alumni->alumni_id . '/edit_ajax') . '\')" class="btn btn-warning btn-sm">Edit</button> ';
                $btn .= '<button onclick="modalAction(\'' . url('/manage-users/alumni/' . $alumni->alumni_id . '/delete_ajax') . '\')" class="btn btn-danger btn-sm">Delete</button> ';
                return $btn;
            })
            ->rawColumns(['action', 'ktp_scan', 'photo'])
            ->make(true);
    }

    public function edit_ajax(string $id)
    {
        $alumni = AlumniModel::find($id);

        return view('users-admin.manage-user.alumni.edit', ['alumni' => $alumni]);
    }

    public function update_ajax(Request $request, $id)
    {
        $rules = [
            'name'          => 'required|string|max:100',
            'photo'         => 'nullable|file|mimes:jpg,jpeg,png|max:2048',
            'home_address'  => 'required|string',
            'current_address' => 'required|string',
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json([
                'status'  => false,
                'message' => 'Validation failed.',
                'msgField' => $validator->errors()
            ]);
        }

        $alumni = AlumniModel::find($id);
        if ($alumni) {
            $data = $request->only('name', 'home_address', 'current_address');

            if ($request->hasFile('photo')) {
                if ($alumni->photo && Storage::disk('public')->exists(str_replace('storage/', '', $alumni->photo))) {
                    Storage::disk('public')->delete(str_replace('storage/', '', $alumni->photo));
                }
                $path = $request->file('photo')->store('alumni/photos', 'public');
                $alumni->photo = 'storage/' . $path;
            }

            $alumni->update($data);
            return response()->json([
                'status'  => true,
                'message' => 'Alumni data successfully updated'
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
        $alumni = AlumniModel::find($id);

        return view('users-admin.manage-user.alumni.delete', ['alumni' => $alumni]);
    }

    public function delete_ajax(string $id)
    {
        $alumni = AlumniModel::find($id);
        if ($alumni) {
            $alumni->delete();

            return response()->json([
                'status' => true,
                'message' => 'Alumni data has been successfully deleted.'
            ]);
        } else {
            return response()->json([
                'status' => false,
                'message' => 'Alumni data not found.'
            ]);
        }
        return redirect('/manage-users/alumni');
    }

    public function show_ajax(string $id)
    {
        $alumni = AlumniModel::find($id);

        return view('users-admin.manage-user.alumni.show', [
            'alumni' => $alumni
        ]);
    }

    /**
     * Display alumni dashboard
     * (Disamakan dengan LecturerController)
     */
    public function dashboard()
    {
        $type_menu = 'dashboard';
        // Get schedules and exam results similar to other controllers
        $schedules = ExamScheduleModel::paginate(10);
        $examResults = ExamResultModel::where('user_id', auth()->id())->latest()->first();

        // Ambil exam scores beserta relasi (student, staff, lecturer, alumni)
        $examScores = ExamResultModel::with([
            'user' => function ($query) {
                $query->with(['student', 'staff', 'lecturer', 'alumni']);
            }
        ])->get();

        // Ambil announcement terbaru
        $announcements = AnnouncementModel::latest()->first();

        return view('users-alumni.alumni-dashboard', compact('type_menu', 'schedules', 'examResults', 'examScores', 'announcements'));
    }

    /**
     * Display alumni profile
     */
    public function profile()
    {
        $alumni = AlumniModel::where('user_id', auth()->id())->first();

        return view('users-alumni.alumni-profile', [
            'type_menu' => 'profile',
            'alumni' => $alumni
        ]);
    }

    /**
     * Update alumni profile 
     */
    public function updateProfile(Request $request)
    {
        $user = Auth::guard('web')->user();
        if (!$user || $user->role !== 'alumni') {
            abort(403, 'Unauthorized or insufficient permissions.');
        }

        $alumni = AlumniModel::where('user_id', $user->user_id)->firstOrFail();

        $request->validate([
            'name' => 'required|string|max:255',
            'phone_number' => 'required|string|min:10|max:15|regex:/^[0-9+\-\s]+$/',  // Improved validation
            'home_address' => 'required|string',
            'current_address' => 'required|string',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'ktp_scan' => 'nullable|file|mimes:jpeg,png,jpg,pdf|max:2048',
        ]);

        $alumni->name = $request->input('name');
        $alumni->home_address = $request->input('home_address');
        $alumni->current_address = $request->input('current_address');

        // Update phone number
        $userModel = UserModel::find($user->user_id);
        if ($userModel) {
            $userModel->phone_number = $request->input('phone_number');
            $userModel->save();
        }

        // Handle photo upload  
        if ($request->hasFile('photo')) {
            // Delete old photo if exists
            if ($alumni->photo && Storage::disk('public')->exists(str_replace('storage/', '', $alumni->photo))) {
                Storage::disk('public')->delete(str_replace('storage/', '', $alumni->photo));
            }
            $path = $request->file('photo')->store('alumni/photos', 'public');
            $alumni->photo = 'storage/' . $path;
        }

        // Handle KTP scan upload
        if ($request->hasFile('ktp_scan')) {
            if ($alumni->ktp_scan && Storage::disk('public')->exists(str_replace('storage/', '', $alumni->ktp_scan))) {
                Storage::disk('public')->delete(str_replace('storage/', '', $alumni->ktp_scan));
            }
            $ktpPath = $request->file('ktp_scan')->store('alumni/ktp', 'public');
            $alumni->ktp_scan = 'storage/' . $ktpPath;
        }

        // Simpan perubahan data alumni
        $alumni->save();

        return redirect()->route('alumni.profile')->with('success', 'Profile updated successfully!');
    }

    public function showRegistrationForm()
    {
        $user = Auth::guard('web')->user();
        if (!$user || $user->role !== 'alumni') {
            abort(403, 'Unauthorized or insufficient permissions.');
        }

        // Get alumni data      
        $alumni = AlumniModel::where('user_id', $user->user_id)->first();

        // Check profile completeness
        $isProfileComplete = true;
        if (
            !$alumni || !$alumni->photo || !$alumni->ktp_scan  || !$alumni->home_address
            || !$alumni->current_address || !$user->phone_number
        ) {
            $isProfileComplete = false;
        }

        // Get latest exam result (score > 0 means it's a real score)
        $examResults = ExamRegistrationModel::where('user_id', $user->user_id)
            ->where('score', '>', 0)
            ->latest()
            ->first();

        // Check if alumni is already registered for an upcoming exam
        $isRegistered = ExamRegistrationModel::where('user_id', $user->user_id)
            ->where('score', 0)  // 0 means "registered but not taken"
            ->whereHas('schedule', function ($query) {
                $query->where('exam_date', '>', now());
            })
            ->exists();

        return view('users-alumni.alumni-registration', [
            'type_menu' => 'registration',
            'user' => $user,
            'alumni' => $alumni,
            'examResults' => $examResults,
            'isProfileComplete' => $isProfileComplete,
            'isRegistered' => $isRegistered
        ]);
    }
}
