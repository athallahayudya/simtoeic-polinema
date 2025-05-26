<?php


namespace App\Http\Controllers;

use App\Models\StaffModel;
use App\Models\ExamScheduleModel;
use App\Models\ExamResultModel;
use App\Models\AnnouncementModel;
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
            ->addColumn('action', function ($staff) {
                $btn = '<button onclick="modalAction(\''.url('/manage-users/staff/' . $staff->staff_id . '/show_ajax').'\')" class="btn btn-info btn-sm">Detail</button> ';
                $btn .= '<button onclick="modalAction(\''.url('/manage-users/staff/' . $staff->staff_id . '/edit_ajax').'\')" class="btn btn-warning btn-sm">Edit</button> ';
                $btn .= '<button onclick="modalAction(\''.url('/manage-users/staff/' . $staff->staff_id . '/delete_ajax').'\')" class="btn btn-danger btn-sm">Delete</button> ';
                return $btn;
            })
            ->rawColumns(['action', 'ktp_scan', 'photo'])
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
            $data = $request->only(['name','home_address','current_address']);

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
            return redirect('/manage-users/staff/');
        } else {
            return redirect('/manage-users/staff/');
        }
    }

    public function show_ajax(string $id)
    {
        $staff = StaffModel::find($id);
        return view('users-admin.manage-user.staff.show', ['staff' => $staff]);
    }

    // Dashboard method disamakan dengan LecturerController
    public function dashboard()
    {
        $type_menu = 'dashboard';
        $schedules = ExamScheduleModel::paginate(10);
        $examResults = ExamResultModel::where('user_id', auth()->id())->latest()->first();

        // Ambil examScores beserta relasi (staff, lecturer, student, alumni)
        $examScores = ExamResultModel::with([
            'user' => function($query) {
                $query->with(['staff', 'lecturer', 'student', 'alumni']);
            }
        ])->get();

        // Ambil announcement terbaru
        $announcements = AnnouncementModel::latest()->first();

        return view('users-staff.staff-dashboard', compact('type_menu', 'schedules', 'examResults', 'examScores', 'announcements'));
    }

    // Profile method disamakan dengan LecturerController
    public function profile()
    {
        $user = Auth::guard('web')->user();
        if (!$user) {
            abort(403, 'Unauthorized');
        }

        if ($user->role !== 'staff') {
            abort(403, 'Only staff users can access this page.');
        }

        $userId = $user->user_id;
        $staff = StaffModel::where('user_id', $userId)->first();

        if (!$staff) {
            return view('users-staff.profile.not-found', [
                'message' => 'Your staff profile has not been set up yet. Please contact the system administrator.'
            ]);
        }

        return view('users-staff.staff-profile', compact('staff'));
    }

    // Update profile method disamakan dengan LecturerController
    public function update(Request $request)
    {
        $user = Auth::guard('web')->user();
        $staff = StaffModel::where('user_id', $user->user_id)->firstOrFail();

        $request->validate([
            'photo'        => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'phone_number' => 'nullable|string|max:20',
        ]);

        // Update nomor telepon pada tabel users
        $user->phone_number = $request->input('phone_number');
        $user->save();

        // Upload foto jika ada dan hapus foto lama jika tersedia
        if ($request->hasFile('photo')) {
            if ($staff->photo && Storage::disk('public')->exists($staff->photo)) {
                Storage::disk('public')->delete($staff->photo);
            }
            $path = $request->file('photo')->store('staff/photos', 'public');
            $staff->photo = $path;
        }

        $staff->save();

        return redirect()->route('staff.profile')->with('success', 'Profile updated successfully!');
    }
}