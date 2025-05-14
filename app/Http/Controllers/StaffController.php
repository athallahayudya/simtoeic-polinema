<?php

namespace App\Http\Controllers;

use App\Models\StaffModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;

class StaffController extends Controller
{
    public function list()
    {
        $staff = StaffModel::select('staff_id', 'user_id', 'name', 'nip', 'ktp_scan', 'photo', 'home_address', 'current_address')
                                    ->with('user');
                                    
        return DataTables::of($staff)
            ->addIndexColumn()
            ->addColumn('action', function ($staff) {
                $btn = '<button onclick="modalAction(\''.url('/admin/manage-users/staff/' . $staff->staff_id . '/show_ajax').'\')" class="btn btn-info btn-sm">Detail</button> ';
                $btn .= '<button onclick="modalAction(\''.url('/admin/manage-users/staff/' . $staff->staff_id . '/edit_ajax').'\')" class="btn btn-warning btn-sm">Edit</button> ';
                $btn .= '<button onclick="modalAction(\''.url('/admin/manage-users/staff/' . $staff->staff_id . '/delete_ajax').'\')" class="btn btn-danger btn-sm">Hapus</button> ';
                return $btn;
            })
            ->rawColumns(['action'])
            ->make(true);
    }

    public function edit_ajax(string $id)
    {
        $staff = StaffModel::find($id);

        return view('AdminManageUsers.staff.edit_ajax', ['staff' => $staff]);
    }

    public function update_ajax(Request $request, $id)
    {
        if ($request->ajax() || $request->wantsJson()) {
            $rules = [
                'user_id' => 'required|exists:users,id',
                'name' => 'required|string|max:100',
                'nip' => 'required|string|unique:staff,nip,'.$id,
                'ktp_scan' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
                'photo' => 'nullable|file|mimes:jpg,jpeg,png|max:2048',
                'home_address' => 'required|string|max:255',
                'current_address' => 'required|string|max:255',
            ];

            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'Validasi gagal.',
                    'msgField' => $validator->errors()
                ]);
            }

            $staff = StaffModel::find($id);
            if ($staff) {
                $data = $request->only(['user_id', 'name', 'nip', 'home_address', 'current_address']);

                if ($request->hasFile('ktp_scan')) {
                    $data['ktp_scan'] = $request->file('ktp_scan')->store('ktp_scans', 'public');
                }
                if ($request->hasFile('photo')) {
                    $data['photo'] = $request->file('photo')->store('photos', 'public');
                }

                $staff->update($data);
                return response()->json([
                    'status' => true,
                    'message' => 'Data staff berhasil diupdate'
                ]);
            } else {
                return response()->json([
                    'status' => false,
                    'message' => 'Data tidak ditemukan'
                ]);
            }
        }
        return redirect('/admin/manage-users/staff');
    }

    public function confirm_ajax(string $id)
    {
        $staff = StaffModel::find($id);

        return view('AdminManageUsers.staff.confirm_ajax', ['staff' => $staff]);
    }

    public function delete_ajax(Request $request, $id)
    {
        if ($request->ajax() || $request->wantsJson()) {
            $staff = StaffModel::find($id);
            if ($staff) {
                $staff->delete();
                return response()->json([
                    'status' => true,
                    'message' => 'Data staff berhasil dihapus.'
                ]);
            } else {
                return response()->json([
                    'status' => false,
                    'message' => 'Data tidak ditemukan.'
                ]);
            }
        }
        return redirect('/admin/manage-users/staff');
    }

    public function show_ajax(string $id)
    {
        $staff = StaffModel::find($id);

        return view('AdminManageUsers.staff.show_ajax', [
            'staff' => $staff
        ]);
    }
}