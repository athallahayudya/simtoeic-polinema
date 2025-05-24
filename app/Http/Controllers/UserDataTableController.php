<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\UserModel;
use App\Models\StudentModel;
use App\Models\LecturerModel;
use App\Models\StaffModel;
use App\Models\AlumniModel;
use Yajra\DataTables\Facades\DataTables;

class UserDataTableController extends Controller
{
    /**
     * Get users for DataTables.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getUsers(Request $request)
    {
        $users = UserModel::select(['user_id', 'role', 'identity_number', 'exam_status', 'phone_number']);
        
        return DataTables::of($users)
            ->addColumn('name', function ($user) {
                switch ($user->role) {
                    case 'student':
                        $profile = StudentModel::where('user_id', $user->user_id)->first();
                        return $profile ? $profile->name : 'N/A';
                    case 'lecturer':
                        $profile = LecturerModel::where('user_id', $user->user_id)->first();
                        return $profile ? $profile->name : 'N/A';
                    case 'staff':
                        $profile = StaffModel::where('user_id', $user->user_id)->first();
                        return $profile ? $profile->name : 'N/A';
                    case 'alumni':
                        $profile = AlumniModel::where('user_id', $user->user_id)->first();
                        return $profile ? $profile->name : 'N/A';
                    case 'admin':
                        return 'Admin';
                    default:
                        return 'N/A';
                }
            })
            ->editColumn('role', function ($user) {
                return ucfirst($user->role);
            })
            ->editColumn('exam_status', function ($user) {
                $statusMap = [
                    'not_yet' => '<span class="badge badge-warning">Not Yet</span>',
                    'success' => '<span class="badge badge-success">Success</span>',
                    'fail' => '<span class="badge badge-danger">Failed</span>'
                ];
                return $statusMap[$user->exam_status] ?? '<span class="badge badge-secondary">Unknown</span>';
            })
            ->addColumn('actions', function ($user) {
                return '
                <button class="btn btn-sm btn-info view-btn" data-id="'.$user->user_id.'"><i class="fas fa-eye"></i></button>
                <button class="btn btn-sm btn-primary edit-btn" data-id="'.$user->user_id.'"><i class="fas fa-edit"></i></button>
                <button class="btn btn-sm btn-danger delete-btn" data-id="'.$user->user_id.'"><i class="fas fa-trash"></i></button>';
            })
            ->rawColumns(['exam_status', 'actions'])
            ->make(true);
    }
}