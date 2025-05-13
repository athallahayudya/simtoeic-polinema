<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ExamScheduleModel;
use App\Models\ExamResultModel; // pastikan model ini ada

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
}
