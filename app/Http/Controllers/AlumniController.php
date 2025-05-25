<?php


namespace App\Http\Controllers;

use App\Models\AlumniModel; 
use App\Models\ExamScheduleModel;
use App\Models\ExamResultModel;
use App\Models\AnnouncementModel;
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
            ->addColumn('action', function ($alumni) {
                $btn = '<button onclick="modalAction(\''.url('/manage-users/alumni/' . $alumni->alumni_id . '/show_ajax').'\')" class="btn btn-info btn-sm">Detail</button> ';
                $btn .= '<button onclick="modalAction(\''.url('/manage-users/alumni/' . $alumni->alumni_id . '/edit_ajax').'\')" class="btn btn-warning btn-sm">Edit</button> ';
                $btn .= '<button onclick="modalAction(\''.url('/manage-users/alumni/' . $alumni->alumni_id . '/delete_ajax').'\')" class="btn btn-danger btn-sm">Delete</button> ';
                return $btn;
            })
            ->rawColumns(['action'])
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
            'current_address'=> 'required|string',
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json([
                'status'  => false,
                'message' => 'Validation failed.',
                'msgField'=> $validator->errors()
            ]);
        }

        $alumni = AlumniModel::find($id);
        if ($alumni) {
            $data = $request->only('name', 'home_address', 'current_address');

            if ($request->hasFile('photo')) {
                $data['photo'] = $request->file('photo')->store('photos', 'public');
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
            return redirect('/manage-users/alumni');
        } else {
            return redirect('/manage-users/alumni');
        }
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
     * Display alumni profile (Disamakan dengan LecturerController)
     */
    public function profile()
    {
        $user = Auth::guard('web')->user();
        if (!$user) {
            abort(403, 'Unauthorized');
        }

        if ($user->role !== 'alumni') {
            abort(403, 'Only alumni users can access this page.');
        }

        $userId = $user->user_id;
        $alumni = AlumniModel::where('user_id', $userId)->first();

        // Jika tidak ada record alumni, tampilkan pesan not found
        if (!$alumni) {
            return view('users-alumni.profile.not-found', [
                'message' => 'Your alumni profile has not been set up yet. Please contact the system administrator.'
            ]);
        }

        return view('users-alumni.alumni-profile', compact('alumni'));
    }

    /**
     * Update alumni profile (Disamakan dengan LecturerController)
     */
    public function update(Request $request)
    {
        $user = Auth::guard('web')->user();
        $alumni = AlumniModel::where('user_id', $user->user_id)->firstOrFail();

        $request->validate([
            'photo'       => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'phone_number'=> 'nullable|string|max:20',
        ]);

        // Update nomor telepon di tabel users
        $user->phone_number = $request->input('phone_number');
        $user->save();

        // Upload foto jika ada, hapus foto lama jika tersedia
        if ($request->hasFile('photo')) {
            if ($alumni->photo && Storage::disk('public')->exists($alumni->photo)) {
                Storage::disk('public')->delete($alumni->photo);
            }
            $path = $request->file('photo')->store('alumni/photos', 'public');
            $alumni->photo = $path;
        }

        // Simpan perubahan data alumni
        $alumni->save();

        return redirect()->route('alumni.profile')->with('success', 'Profile updated successfully!');
    }
}