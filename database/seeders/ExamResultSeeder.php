<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\UserModel;
use App\Models\ExamScheduleModel;
use App\Models\ExamResultModel;

class ExamResultSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Get all schedule IDs
        $scheduleIds = ExamScheduleModel::pluck('schedule_id')->toArray();
        if (empty($scheduleIds)) {
            $this->command->info('No exam schedules found. Please run ExamScheduleSeeder first.');
            return;
        }
        
        // Get student user IDs
        $studentIds = UserModel::where('role', 'student')->pluck('user_id')->toArray();
        if (empty($studentIds)) {
            $this->command->info('No student users found. Please run StudentSeeder first.');
            return;
        }

        // Create results for students with "success" exam status
        $successStudents = UserModel::where('role', 'student')
                                ->where('exam_status', 'success')
                                ->get();
        
        foreach ($successStudents as $student) {
            // Assign to a random schedule
            $scheduleId = $scheduleIds[array_rand($scheduleIds)];
            
            // Generate a qualifying score (≥ 500) for free exam
            $score = rand(500, 990);
            
            ExamResultModel::firstOrCreate(
                [
                    'user_id' => $student->user_id,
                    'schedule_id' => $scheduleId
                ],
                [
                    'score' => $score,
                    'cerfificate_url' => "storage/certificates/{$student->identity_number}.pdf"
                ]
            );
        }

        // Create results for students with "fail" exam status
        $failStudents = UserModel::where('role', 'student')
                              ->where('exam_status', 'fail')
                              ->get();
        
        foreach ($failStudents as $student) {
            // Assign to a random schedule
            $scheduleId = $scheduleIds[array_rand($scheduleIds)];
            
            // Generate a non-qualifying score (< 500) for paid exam
            $score = rand(10, 499);
            
            ExamResultModel::firstOrCreate(
                [
                    'user_id' => $student->user_id,
                    'schedule_id' => $scheduleId
                ],
                [
                    'score' => $score,
                    'cerfificate_url' => "" // No certificate for failed exams
                ]
            );
        }

        // Create some manual specific examples
        $this->createSpecificExamples($scheduleIds);
    }

    /**
     * Create some specific examples for demonstration purposes
     * 
     * @param array $scheduleIds
     * @return void
     */
    private function createSpecificExamples($scheduleIds)
    {
        // Example 1: A student with a perfect TOEIC score
        $perfectStudent = UserModel::where('role', 'student')
                                ->where('exam_status', 'success')
                                ->first();
        
        if ($perfectStudent) {
            ExamResultModel::firstOrCreate(
                [
                    'user_id' => $perfectStudent->user_id,
                    'schedule_id' => $scheduleIds[0] // Using the first schedule
                ],
                [
                    'score' => 990, // Perfect TOEIC score
                    'cerfificate_url' => "storage/certificates/distinction_{$perfectStudent->identity_number}.pdf"
                ]
            );
        }

        // Example 2: A student with a borderline qualifying score
        $borderlineStudent = UserModel::where('role', 'student')
                                  ->where('exam_status', 'success')
                                  ->skip(1)
                                  ->first();
        
        if ($borderlineStudent) {
            ExamResultModel::firstOrCreate(
                [
                    'user_id' => $borderlineStudent->user_id,
                    'schedule_id' => $scheduleIds[count($scheduleIds) > 1 ? 1 : 0] // Using the second schedule if available
                ],
                [
                    'score' => 500, // Exactly at the threshold
                    'cerfificate_url' => "storage/certificates/{$borderlineStudent->identity_number}.pdf"
                ]
            );
        }

        // Example 3: A student with a borderline non-qualifying score
        $borderlineFailStudent = UserModel::where('role', 'student')
                                      ->where('exam_status', 'fail')
                                      ->first();
        
        if ($borderlineFailStudent) {
            ExamResultModel::firstOrCreate(
                [
                    'user_id' => $borderlineFailStudent->user_id,
                    'schedule_id' => $scheduleIds[count($scheduleIds) > 2 ? 2 : 0] // Using the third schedule if available
                ],
                [
                    'score' => 499, // Just below the threshold
                    'cerfificate_url' => "" // No certificate for failed exams
                ]
            );
        }
    }
}
