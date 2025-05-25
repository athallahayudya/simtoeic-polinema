<?php

namespace App\Http\Controllers;

use App\Models\ExamResultModel;
use App\Models\UserModel;
use App\Imports\ExamResultsImport;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Log;

class ExamResultController extends Controller
{
    public function index()
    {
        // Get all exam results with user data for display
        $examResults = ExamResultModel::with(['user', 'schedule'])
            ->orderBy('created_at', 'desc')
            ->get();

        return view('users-admin.exam-result.index', compact('examResults'));
    }
    
    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|file|mimes:xlsx,xls,csv|max:10240',
        ]);
        
        try {
            $file = $request->file('file');
            
            // Import the file
            Excel::import(new ExamResultsImport, $file);
            
            return redirect()->route('exam-results.index')
                ->with('success', 'Exam results imported successfully');
        } catch (\Exception $e) {
            Log::error('Import error: ' . $e->getMessage());
            return redirect()->back()
                ->with('error', 'Error importing file: ' . $e->getMessage());
        }
    }
}