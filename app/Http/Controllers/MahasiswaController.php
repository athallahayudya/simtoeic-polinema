<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ExamScheduleModel;
use App\Models\ExamResultModel; 
use App\Models\StudentModel;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;

class MahasiswaController extends Controller
{
    public function dashboard()
    {
        $schedules = ExamScheduleModel::paginate(10); // pagination 10 data per halaman
        $examResults = ExamResultModel::where('user_id', auth()->id())->latest()->first(); // hanya skor terakhir user login
        $type_menu = 'dashboard';
        // Tambahkan $isComplete dan $missingFiles jika perlu
        return view('mahasiswa.dashboard', compact('schedules', 'type_menu', 'examResults'));
    }

    public function profile()
    {
        $type_menu = 'profile'; // atau isi sesuai kebutuhan
        return view('mahasiswa.profile', compact('type_menu'));
    }

    public function list(Request $request)
    {
        $students = StudentModel::select('student_id', 'user_id', 'name', 'nim', 'study_program', 'major', 'campus', 'ktp_scan', 'ktm_scan', 'photo', 'home_address', 'current_address')
                                ->with('user');

        if ($request->student_id) {
            $students->where('student_id', $request->student_id);
        };

        return DataTables::of($students)
            ->addIndexColumn()
            ->addColumn('action', function ($student) {
                $btn = '<button onclick="modalAction(\''.url('/admin/manage-users/students/' . $student->student_id . '/show_ajax').'\')" class="btn btn-info btn-sm">Detail</button> ';
                $btn .= '<button onclick="modalAction(\''.url('/admin/manage-users/students/' . $student->student_id . '/edit_ajax').'\')" class="btn btn-warning btn-sm">Edit</button> ';
                $btn .= '<button onclick="modalAction(\''.url('/admin/manage-users/students/' . $student->student_id . '/delete_ajax').'\')" class="btn btn-danger btn-sm">Hapus</button> ';
                return $btn;
            })
            ->rawColumns(['action'])
            ->make(true);
    }

    public function edit_ajax(string $id)
    {
        $students = StudentModel::find($id);

        return view('AdminManageUsers.students.edit_ajax', ['student' => $students]);
    }

    public function update_ajax(Request $request, $id)
    {
        if ($request->ajax() || $request->wantsJson()) {
            $rules = [
                'user_id' => 'required|exists:users,id',
                'name' => 'required|string|max:100',
                'nim' => 'required|string|max:12|unique:students,nip,'.$id,
                'study_program' => 'required|string|max:100',
                'major' => 'required|string|max:100',
                'campus' => 'required|string|max:255|in:malang,psdku_kediri,psdku_lumajang', 
                'ktp_scan' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
                'ktm_scan' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048', 
                'photo' => 'nullable|file|mimes:jpg,jpeg,png|max:2048',
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
                    'user_id', 'name', 'nim', 'study_program', 'major', 'campus',
                    'home_address', 'current_address'
                ]);

                if ($request->hasFile('ktp_scan')) {
                    $data['ktp_scan'] = $request->file('ktp_scan')->store('ktp_scans', 'public');
                }
                if ($request->hasFile('ktm_scan')) {
                    $data['ktm_scan'] = $request->file('ktm_scan')->store('ktm_scans', 'public'); // Added ktm_scan storage
                }
                if ($request->hasFile('photo')) {
                    $data['photo'] = $request->file('photo')->store('photos', 'public');
                }

                $student->update($data);
                return response()->json([
                    'status' => true,
                    'message' => 'Data mahasiswa berhasil diupdate'
                ]);
            } else {
                return response()->json([
                    'status' => false,
                    'message' => 'Data tidak ditemukan'
                ]);
            }
        }
        return redirect('/admin/manage-users/students');
    }

    public function confirm_ajax(string $id)
    {
        $student = StudentModel::find($id);

        return view('AdminManageUsers.students.confirm_ajax', ['student' => $student]);
    }

    public function delete_ajax(Request $request, $id)
    {
        if ($request->ajax() || $request->wantsJson()) {
            $student = StudentModel::find($id);
            if ($student) {
                $student->delete();
                return response()->json([
                    'status' => true,
                    'message' => 'Data mahasiswa berhasil dihapus.'
                ]);
            } else {
                return response()->json([
                    'status' => false,
                    'message' => 'Data tidak ditemukan.'
                ]);
            }
        }
        return redirect('/admin/manage-users/students');
    }

    public function show_ajax(string $id)
    {
        $student = StudentModel::find($id);

        return view('AdminManageUsers.students.show_ajax', [
            'student' => $student
        ]);
    }
}
