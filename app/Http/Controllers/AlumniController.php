<?php

namespace App\Http\Controllers;

use App\Models\AlumniModel; 
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;

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
                'name' => 'required|string|max:100',
                'photo' => 'nullable|file|mimes:jpg,jpeg,png|max:2048',
                'home_address' => 'required|string',
                'current_address' => 'required|string',
            ];

            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'Validation failed.',
                    'msgField' => $validator->errors()
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
                    'status' => true,
                    'message' => 'Alumni data successfully updated'
                ]);
            } else {
                return response()->json([
                    'status' => false,
                    'message' => 'Data not found.'
                ]);
            }
        return redirect('/manage-users/alumni');
    }

    public function confirm_ajax(string $id)
    {
        $alumni = AlumniModel::find($id);

        return view('users-admin.manage-user.alumni.delete', ['alumni' => $alumni]);
    }

    public function delete_ajax( string $id)
    {
        $alumni = AlumniModel::find($id);
            if ($alumni) {
                $alumni->delete();
                return redirect('/manage-users/alumni');

                return response()->json([
                    'status' => true,
                    'message' => 'Alumni data successfully deleted'
                ]);
            } else {
                return redirect('/manage-users/alumni');

                return response()->json([
                    'status' => false,
                    'message' => 'Data not found.'
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
     */
    public function dashboard()
    {
        $type_menu = 'dashboard';
        // Get schedules and exam results similar to other controllers
        $schedules = \App\Models\ExamScheduleModel::paginate(10);
        $examResults = \App\Models\ExamResultModel::where('user_id', auth()->id())->latest()->first();
        
        return view('users-alumni.alumni-dashboard', compact('type_menu', 'schedules', 'examResults'));
    }
    
    /**
     * Display alumni profile
     */
    public function profile()
    {
        $type_menu = 'profile';
        $alumni = AlumniModel::where('user_id', auth()->id())->first();
        return view('users-alumni.alumni-profile', compact('type_menu', 'alumni'));
    }
}