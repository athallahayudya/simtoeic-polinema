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
        $scheduleIds = ExamScheduleModel::pluck('shcedule_id')->toArray();
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
            
            // Generate a passing score (70-100)
            $score = rand(70, 100);
            
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
            
            // Generate a failing score (0-69)
            $score = rand(0, 69);
            
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
        // Example 1: A student with a perfect score
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
                    'score' => 100,
                    'cerfificate_url' => "storage/certificates/distinction_{$perfectStudent->identity_number}.pdf"
                ]
            );
        }

        // Example 2: A student with a borderline pass
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
                    'score' => 70,
                    'cerfificate_url' => "storage/certificates/{$borderlineStudent->identity_number}.pdf"
                ]
            );
        }

        // Example 3: A student with a borderline fail
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
                    'score' => 69,
                    'cerfificate_url' => "" // No certificate for failed exams
                ]
            );
        }
    }
}