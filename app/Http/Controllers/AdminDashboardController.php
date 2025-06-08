<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\UserModel;
use App\Models\StudentModel;
use App\Models\StaffModel;
use App\Models\LecturerModel;
use App\Models\AlumniModel;
use App\Models\ExamResultModel;
use App\Models\ExamScheduleModel;
use App\Models\AnnouncementModel;
use App\Models\ExamRegistrationModel;
use Illuminate\Support\Facades\DB;

class AdminDashboardController extends Controller
{
    public function index()
    {
        $type_menu = 'dashboard';

        // Statistics for cards
        $totalUsers = UserModel::count();
        $totalStudents = StudentModel::count();
        $totalStaff = StaffModel::count();
        $totalLecturers = LecturerModel::count();
        $totalAlumni = AlumniModel::count();

        // Exam statistics
        $totalExamResults = ExamResultModel::count();
        $totalExamSchedules = ExamScheduleModel::count();
        $totalRegistrations = ExamRegistrationModel::count();

        // Count users who have taken the exam (exam_status = 'success')
        $totalExamParticipants = UserModel::where('exam_status', 'success')->count();

        // Recent exam results
        $recentExamResults = ExamResultModel::with(['user.student', 'user.staff', 'user.lecturer', 'user.alumni'])
            ->orderBy('created_at', 'desc')
            ->limit(10)
            ->get();

        // Enhanced Score statistics with detailed calculations
        $allScores = ExamResultModel::pluck('score')->filter()->values();
        $averageScore = $allScores->avg();
        $highestScore = $allScores->max();
        $lowestScore = $allScores->min();

        // Calculate additional statistics
        $scoreCount = $allScores->count();
        $standardDeviation = 0;
        $median = 0;
        $mode = 0;

        if ($scoreCount > 0) {
            // Standard Deviation calculation
            $variance = $allScores->map(function ($score) use ($averageScore) {
                return pow($score - $averageScore, 2);
            })->avg();
            $standardDeviation = sqrt($variance);

            // Median calculation
            $sortedScores = $allScores->sort()->values();
            $middle = floor($scoreCount / 2);
            if ($scoreCount % 2 == 0) {
                $median = ($sortedScores[$middle - 1] + $sortedScores[$middle]) / 2;
            } else {
                $median = $sortedScores[$middle];
            }

            // Mode calculation (most frequent score)
            $scoreFrequency = $allScores->countBy();
            $maxFrequency = $scoreFrequency->max();
            $mode = $scoreFrequency->filter(function ($frequency) use ($maxFrequency) {
                return $frequency == $maxFrequency;
            })->keys()->first();
        }

        // User growth statistics (last month vs previous month)
        $currentMonth = now();
        $lastMonth = now()->subMonth();
        $twoMonthsAgo = now()->subMonths(2);

        $currentMonthUsers = UserModel::whereMonth('created_at', $currentMonth->month)
            ->whereYear('created_at', $currentMonth->year)->count();
        $lastMonthUsers = UserModel::whereMonth('created_at', $lastMonth->month)
            ->whereYear('created_at', $lastMonth->year)->count();

        // Calculate growth percentages for each user type
        $studentGrowth = $this->calculateUserGrowth('student');
        $staffGrowth = $this->calculateUserGrowth('staff');
        $lecturerGrowth = $this->calculateUserGrowth('lecturer');
        $alumniGrowth = $this->calculateUserGrowth('alumni');

        // User registration by month (last 6 months)
        $userRegistrationData = UserModel::select(
            DB::raw('MONTH(created_at) as month'),
            DB::raw('COUNT(*) as count')
        )
            ->where('created_at', '>=', now()->subMonths(6))
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        // Exam scores distribution
        $scoreDistribution = ExamResultModel::select(
            DB::raw('CASE 
                WHEN score >= 90 THEN "Excellent (90-100)"
                WHEN score >= 80 THEN "Good (80-89)"
                WHEN score >= 70 THEN "Average (70-79)"
                WHEN score >= 60 THEN "Below Average (60-69)"
                ELSE "Poor (0-59)"
            END as grade'),
            DB::raw('COUNT(*) as count')
        )
            ->groupBy('grade')
            ->get();

        // Recent announcements
        $recentAnnouncements = AnnouncementModel::where('announcement_status', 'published')
            ->orderBy('announcement_date', 'desc')
            ->limit(5)
            ->get();

        // Campus distribution
        $campusDistribution = StudentModel::select('campus', DB::raw('count(*) as total'))
            ->groupBy('campus')
            ->get();

        return view('users-admin.dashboard.index', compact(
            'type_menu',
            'totalUsers',
            'totalStudents',
            'totalStaff',
            'totalLecturers',
            'totalAlumni',
            'totalExamResults',
            'totalExamSchedules',
            'totalRegistrations',
            'totalExamParticipants',
            'recentExamResults',
            'averageScore',
            'highestScore',
            'lowestScore',
            'standardDeviation',
            'median',
            'mode',
            'studentGrowth',
            'staffGrowth',
            'lecturerGrowth',
            'alumniGrowth',
            'userRegistrationData',
            'scoreDistribution',
            'recentAnnouncements',
            'campusDistribution'
        ));
    }

    /**
     * Calculate user growth percentage for a specific role
     */
    private function calculateUserGrowth($role)
    {
        $currentMonth = now();
        $lastMonth = now()->subMonth();

        $currentMonthCount = UserModel::where('role', $role)
            ->whereMonth('created_at', $currentMonth->month)
            ->whereYear('created_at', $currentMonth->year)
            ->count();

        $lastMonthCount = UserModel::where('role', $role)
            ->whereMonth('created_at', $lastMonth->month)
            ->whereYear('created_at', $lastMonth->year)
            ->count();

        if ($lastMonthCount == 0) {
            return $currentMonthCount > 0 ? 100 : 0;
        }

        return round((($currentMonthCount - $lastMonthCount) / $lastMonthCount) * 100, 1);
    }
}
