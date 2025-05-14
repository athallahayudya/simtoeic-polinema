<?php

namespace App\Http\Controllers;

use App\Models\LecturerModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;

class LecturerController extends Controller
{
    public function list()
    {
        $lecturers = LecturerModel::select('lecturer_id', 'user_id', 'name', 'nidn', 'ktp_scan', 'photo', 'home_address', 'current_address')
                                 ->with('user');

        return DataTables::of($lecturers)
            ->addIndexColumn()
            ->addColumn('action', function ($lecturer) {
                $btn = '<button onclick="modalAction(\''.url('/admin/manage-users/lecturers/' . $lecturer->lecturer_id . '/show_ajax').'\')" class="btn btn-info btn-sm">Detail</button> ';
                $btn .= '<button onclick="modalAction(\''.url('/admin/manage-users/lecturers/' . $lecturer->lecturer_id . '/edit_ajax').'\')" class="btn btn-warning btn-sm">Edit</button> ';
                $btn .= '<button onclick="modalAction(\''.url('/admin/manage-users/lecturers/' . $lecturer->lecturer_id . '/delete_ajax').'\')" class="btn btn-danger btn-sm">Hapus</button> ';
                return $btn;
            })
            ->rawColumns(['action'])
            ->make(true);
    }

    public function edit_ajax(string $id)
    {
        $lecturer = LecturerModel::find($id);

        return view('AdminManageUsers.lecturers.edit_ajax', ['lecturer' => $lecturer]);
    }

    public function update_ajax(Request $request, $id)
    {
        if ($request->ajax() || $request->wantsJson()) {
            $rules = [
                'user_id' => 'required|exists:users,id',
                'name' => 'required|string|max:100',
                'nidn' => 'required|string|max:18|unique:lecturers,nidn,'.$id, 
                'ktp_scan' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
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

            $lecturer = LecturerModel::find($id);
            if ($lecturer) {
                $data = $request->only(['user_id', 'name', 'nidn', 'home_address', 'current_address']);

                if ($request->hasFile('ktp_scan')) {
                    $data['ktp_scan'] = $request->file('ktp_scan')->store('ktp_scans', 'public');
                }
                if ($request->hasFile('photo')) {
                    $data['photo'] = $request->file('photo')->store('photos', 'public');
                }

                $lecturer->update($data);
                return response()->json([
                    'status' => true,
                    'message' => 'Data dosen berhasil diupdate'
                ]);
            } else {
                return response()->json([
                    'status' => false,
                    'message' => 'Data tidak ditemukan'
                ]);
            }
        }
        return redirect('/admin/manage-users/lecturers');
    }

    public function confirm_ajax(string $id)
    {
        $lecturer = LecturerModel::find($id);

        return view('AdminManageUsers.lecturers.confirm_ajax', ['lecturer' => $lecturer]);
    }

    public function delete_ajax(Request $request, $id)
    {
        if ($request->ajax() || $request->wantsJson()) {
            $lecturer = LecturerModel::find($id);
            if ($lecturer) {
                $lecturer->delete();
                return response()->json([
                    'status' => true,
                    'message' => 'Data dosen berhasil dihapus.'
                ]);
            } else {
                return response()->json([
                    'status' => false,
                    'message' => 'Data tidak ditemukan.'
                ]);
            }
        }
        return redirect('/admin/manage-users/lecturers');
    }

    public function show_ajax(string $id)
    {
        $lecturer = LecturerModel::find($id);

        return view('AdminManageUsers.lecturers.show_ajax', [
            'lecturer' => $lecturer
        ]);
    }
}