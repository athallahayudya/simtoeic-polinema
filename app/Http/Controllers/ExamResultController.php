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

    /**
     * Delete all exam results from the database
     *
     * @return \Illuminate\Http\JsonResponse
     */

    public function deleteAll()
    {
        try {
            // Delete all exam results using the custom method
            ExamResultModel::deleteAllResults();

            return response()->json([
                'status' => true,
                'message' => 'All exam results have been deleted successfully.'
            ]);
        } catch (\Exception $e) {
            Log::error('Error deleting all exam results: ' . $e->getMessage());

            return response()->json([
                'status' => false,
                'message' => 'An error occurred while deleting exam results: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Remove the specified exam result from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        try {
            $examResult = ExamResultModel::findOrFail($id);
            $examResult->delete();

            return response()->json([
                'status' => true,
                'message' => 'Exam result deleted successfully.'
            ]);
        } catch (\Exception $e) {
            Log::error('Error deleting exam result: ' . $e->getMessage());

            return response()->json([
                'status' => false,
                'message' => 'An error occurred while deleting the exam result: ' . $e->getMessage()
            ], 500);
        }
    }
}
