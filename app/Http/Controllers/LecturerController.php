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
                $btn = '<button onclick="modalAction(\''.url('/manage-users/lecturer/' . $lecturer->lecturer_id . '/show_ajax').'\')" class="btn btn-info btn-sm">Detail</button> ';
                $btn .= '<button onclick="modalAction(\''.url('/manage-users/lecturer/' . $lecturer->lecturer_id . '/edit_ajax').'\')" class="btn btn-warning btn-sm">Edit</button> ';
                $btn .= '<button onclick="modalAction(\''.url('/manage-users/lecturer/' . $lecturer->lecturer_id . '/delete_ajax').'\')" class="btn btn-danger btn-sm">Delete</button> ';
                return $btn;
            })
            ->rawColumns(['action'])
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
                    $data['photo'] = $request->file('photo')->store('photos', 'public');
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
                return redirect('/manage-users/lecturer');

                return response()->json([
                    'status' => true,
                    'message' => 'Lecturer data successfully deleted'
                ]);
            } else {
                return redirect('/manage-users/lecturer');

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
        
        return view('users-lecturer.lecturer-dashboard', compact('type_menu', 'schedules', 'examResults'));
    }
    
    /**
     * Display lecturer profile
     */
    public function profile()
    {
        $type_menu = 'profile';
        $lecturer = LecturerModel::where('user_id', auth()->id())->first();
        return view('users-lecturer.lecturer-profile', compact('type_menu', 'lecturer'));
    }
}