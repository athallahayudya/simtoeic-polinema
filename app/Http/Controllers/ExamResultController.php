<?php

namespace App\Http\Controllers;

use App\Models\ExamResultModel;
use App\Models\StudentModel;
use App\Models\ExamScheduleModel;
use App\Services\PdfTableParserService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;


class ExamResultController extends Controller
{
    public function index()
    {
        // Get all exam results ordered by NIM (ascending) then by total score (descending)
        $examResults = ExamResultModel::with(['user.student', 'schedule'])
            ->orderBy('nim', 'asc')
            ->orderBy('total_score', 'desc')
            ->get();

        return view('users-admin.exam-result.index', compact('examResults'));
    }

    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|file|mimes:pdf|max:10240',
        ]);

        try {
            $file = $request->file('file');

            // Use the PDF table parser service
            $pdfParserService = new PdfTableParserService();
            $parsedData = $pdfParserService->parsePdfTables($file->getPathname());

            Log::info('Parsed PDF Results: ' . json_encode($parsedData));

            $importedCount = 0;
            $skippedCount = 0;

            foreach ($parsedData as $data) {
                try {
                    // Find student by NIM in student table
                    $student = StudentModel::where('nim', $data['nim'])->first();

                    if (!$student) {
                        // Create new student and user if not found
                        Log::info("Student with NIM {$data['nim']} not found. Creating new student record.");

                        // Create new user with exam status based on score
                        $examStatus = $data['total_score'] >= 500 ? 'success' : 'fail';
                        $user = \App\Models\UserModel::create([
                            'role' => 'student',
                            'identity_number' => $data['nim'],
                            'password' => bcrypt('password123'), // Use 'password123' as default password
                            'exam_status' => $examStatus, // Set based on exam score
                            'phone_number' => null
                        ]);

                        // Create new student profile
                        $student = StudentModel::create([
                            'user_id' => $user->user_id,
                            'name' => $data['name'],
                            'nim' => $data['nim'],
                            'study_program' => 'Unknown',
                            'major' => 'Unknown',
                            'campus' => 'malang'
                        ]);
                    } else {
                        $user = $student->user;
                    }

                    // Get default schedule (you can modify this logic as needed)
                    $defaultSchedule = ExamScheduleModel::first();

                    if (!$defaultSchedule) {
                        Log::warning("No exam schedule found. Creating default schedule.");
                        $defaultSchedule = ExamScheduleModel::create([
                            'exam_date' => now()->format('Y-m-d'),
                            'exam_time' => '09:00:00',
                            'itc_link' => '',
                            'zoom_link' => ''
                        ]);
                    }

                    // Create or update exam result
                    $examResult = ExamResultModel::updateOrCreate(
                        [
                            'user_id' => $user->user_id,
                            'exam_id' => $data['exam_id']
                        ],
                        [
                            'schedule_id' => $defaultSchedule->schedule_id,
                            'score' => $data['total_score'], // Keep legacy score field
                            'listening_score' => $data['listening_score'],
                            'reading_score' => $data['reading_score'],
                            'total_score' => $data['total_score'],
                            'status' => $data['status'],
                            'exam_date' => now()->format('Y-m-d'),
                            'cerfificate_url' => ''
                        ]
                    );

                    // Update user exam status based on score
                    // If score >= 500, set to 'success', otherwise set to 'fail'
                    $examStatus = $data['total_score'] >= 500 ? 'success' : 'fail';
                    $user->update(['exam_status' => $examStatus]);

                    Log::info("Created/Updated exam result ID: {$examResult->result_id} for user {$user->user_id}");

                    $importedCount++;
                } catch (\Exception $e) {
                    Log::error("Error importing record for NIM {$data['nim']}: " . $e->getMessage());
                    $skippedCount++;
                }
            }

            $message = "PDF imported successfully! {$importedCount} records imported";
            if ($skippedCount > 0) {
                $message .= ", {$skippedCount} records skipped";
            }

            return redirect()->route('exam-results.index')
                ->with('success', $message);
        } catch (\Exception $e) {
            Log::error('Import error: ' . $e->getMessage());
            return redirect()->back()
                ->with('error', 'Error importing file: ' . $e->getMessage());
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
