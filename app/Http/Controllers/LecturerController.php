<?php

namespace App\Http\Controllers;

use App\Models\LecturerModel;
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
                $btn = '<button onclick="modalAction(\''.url('/manage-users/lecturer/' . $lecturer->lecturer_id . '/show_ajax').'\')" class="btn btn-info btn-sm">Detail</button> ';
                $btn .= '<button onclick="modalAction(\''.url('/manage-users/lecturer/' . $lecturer->lecturer_id . '/edit_ajax').'\')" class="btn btn-warning btn-sm">Edit</button> ';
                $btn .= '<button onclick="modalAction(\''.url('/manage-users/lecturer/' . $lecturer->lecturer_id . '/delete_ajax').'\')" class="btn btn-danger btn-sm">Delete</button> ';
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
    $announcements = \App\Models\AnnouncementModel::latest()->first();
    
    return view('users-lecturer.lecturer-dashboard', compact('type_menu', 'schedules', 'examResults', 'examScores', 'announcements'));
}
    
    /**
     * Display lecturer profile
     */
    public function show()
    {
        $user = Auth::guard('web')->user();
        if (!$user) {
            abort(403, 'Unauthorized');
        }

        if ($user->role !== 'lecturer') {
            abort(403, 'Only lecturer users can access this page.');
        }

        $userId = $user->user_id;
        $lecturer = LecturerModel::where('user_id', $userId)->first();

        // If no record exists
        if (!$lecturer) {
            return view('users-lecturer.profile.not-found', [
                'message' => 'Your lecturer profile has not been set up yet. Please contact the system administrator.'
            ]);
        }

        return view('users-lecturer.lecturer-profile', compact('lecturer'));
    }

public function update(Request $request)
{
    $user = Auth::guard('web')->user();
    $lecturer = LecturerModel::where('user_id', $user->user_id)->firstOrFail();

    $request->validate([
        'photo' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        'phone_number' => 'nullable|string|max:20',
    ]);

    // Update nomor telepon
    $user->phone_number = $request->input('phone_number');
    $user->save();

    // Hapus foto lama jika ada dan unggah foto baru
    if ($request->hasFile('photo')) {
        // Hapus file lama jika ada
        if ($lecturer->photo && Storage::disk('public')->exists($lecturer->photo)) {
            Storage::disk('public')->delete($lecturer->photo);
        }

        // Simpan file baru
        $path = $request->file('photo')->store('lecturer/photos', 'public');
        $lecturer->photo = $path; // Simpan path tanpa "storage/"
    }

    // // Update lecturer data
    // $lecturer->name = $request->input('name');
    // $lecturer->nidn = $request->input('nidn');

    // Update phone number and identity_number in users table
    $userModel = \App\Models\lecturerModel::find($user->lecturer_id);
    if ($userModel) {
        $userModel->phone_number = $request->input('phone_number');
        $userModel->identity_number = $request->input('nidn');
        $userModel->save();
    }

    // Handle photo upload
    if ($request->hasFile('photo')) {
        // Delete old photo if exists
        if ($lecturer->photo && Storage::disk('public')->exists($lecturer->photo)) {
            Storage::disk('public')->delete($lecturer->photo);
        }
        $path = $request->file('photo')->store('lecturer/photos', 'public');
        $lecturer->photo = $path;
    }

    // Handle KTP scan upload
    if ($request->hasFile('ktp_scan')) {
        if ($lecturer->ktp_scan && Storage::disk('public')->exists($lecturer->ktp_scan)) {
            Storage::disk('public')->delete($lecturer->ktp_scan);
        }
        $ktpPath = $request->file('ktp_scan')->store('lecturer/ktp', 'public');
        $lecturer->ktp_scan = $ktpPath;
    }

    $lecturer->save();

    return redirect()->route('lecturer.profile')->with('success', 'Profile updated successfully!');
}


}
