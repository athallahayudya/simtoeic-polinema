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
                $btn = '<button onclick="modalAction(\''.url('/manage-users/staff/' . $staff->staff_id . '/show_ajax').'\')" class="btn btn-info btn-sm">Detail</button> ';
                $btn .= '<button onclick="modalAction(\''.url('/manage-users/staff/' . $staff->staff_id . '/edit_ajax').'\')" class="btn btn-warning btn-sm">Edit</button> ';
                $btn .= '<button onclick="modalAction(\''.url('/manage-users/staff/' . $staff->staff_id . '/delete_ajax').'\')" class="btn btn-danger btn-sm">Delete</button> ';
                return $btn;
            })
            ->rawColumns(['action'])
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
                'name' => 'required|string|max:100',
                'photo' => 'nullable|file|mimes:jpg,jpeg,png|max:2048',
                'home_address' => 'required|string|max:255',
                'current_address' => 'required|string|max:255',
            ];

            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'Validation failed.',
                    'msgField' => $validator->errors()
                ]);
            }

            $staff = StaffModel::find($id);
            if ($staff) {
                $data = $request->only([
                    'name', 
                    'home_address', 
                    'current_address'
                ]);

                if ($request->hasFile('photo')) {
                    $data['photo'] = $request->file('photo')->store('photos', 'public');
                }

                $staff->update($data);

                return response()->json([
                    'status' => true,
                    'message' => 'Staff data successfully updated'
                ]);
            } else {

                return response()->json([
                    'status' => false,
                    'message' => 'Data not found.'
                ]);
            }
        // }
        return redirect('/manage-users/staff');
    }

    public function confirm_ajax(string $id)
    {
        $staff = StaffModel::find($id);

        return view('users-admin.manage-user.staff.delete', ['staff' => $staff]);
    }

    public function delete_ajax( string $id)
    {
            $staff = StaffModel::find($id);
            if ($staff) {
                $staff->delete();
                return redirect('/manage-users/staff/');

                return response()->json([
                    'status' => true,
                    'message' => 'Staff data successfully deleted.'
                ]);
            } else {
                return redirect('/manage-users/staff/');

                return response()->json([
                    'status' => false,
                    'message' => 'Data not found.'
                ]);
            }
        return redirect('/manage-users/staff');
    }

    public function show_ajax(string $id)
    {
        $staff = StaffModel::find($id);

        return view('users-admin.manage-user.staff.show', [
            'staff' => $staff
        ]);
    }

    public function dashboard()
    {
        $type_menu = 'dashboard';
        // Get schedules and exam results similar to StudentController
        $schedules = \App\Models\ExamScheduleModel::paginate(10);
        $examResults = \App\Models\ExamResultModel::where('user_id', auth()->id())->latest()->first();
        
        return view('users-staff.staff-dashboard', compact('type_menu', 'schedules', 'examResults'));
    }
    
    public function profile()
    {
        $type_menu = 'profile';
        return view('users-staff.staff-profile', compact('type_menu'));
    }
}