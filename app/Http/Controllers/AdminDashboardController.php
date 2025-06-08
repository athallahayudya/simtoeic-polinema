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

        // Exam scores distribution with TOEIC standards
        $scoreDistribution = ExamResultModel::select(
            DB::raw('CASE
                WHEN score >= 945 THEN "Proficient (945-990)"
                WHEN score >= 785 THEN "Advanced (785-944)"
                WHEN score >= 550 THEN "Intermediate (550-784)"
                WHEN score >= 225 THEN "Elementary (225-549)"
                ELSE "Beginner (10-224)"
            END as grade'),
            DB::raw('COUNT(*) as count')
        )
            ->whereNotNull('score')
            ->groupBy('grade')
            ->get();

        // If no data, create default structure
        if ($scoreDistribution->isEmpty()) {
            $scoreDistribution = collect([
                (object)['grade' => 'Beginner (10-224)', 'count' => 0],
                (object)['grade' => 'Elementary (225-549)', 'count' => 0],
                (object)['grade' => 'Intermediate (550-784)', 'count' => 0],
                (object)['grade' => 'Advanced (785-944)', 'count' => 0],
                (object)['grade' => 'Proficient (945-990)', 'count' => 0],
            ]);
        }

        // Additional score statistics for enhanced display
        $totalParticipants = ExamResultModel::count();
        $passRate = $totalParticipants > 0 ? ExamResultModel::where('score', '>=', 550)->count() / $totalParticipants * 100 : 0;
        $excellentRate = $totalParticipants > 0 ? ExamResultModel::where('score', '>=', 785)->count() / $totalParticipants * 100 : 0;

        // Get all exam results for detailed chart
        $allExamResults = ExamResultModel::select('score')->get();

        // Recent announcements
        $recentAnnouncements = AnnouncementModel::where('announcement_status', 'published')
            ->orderBy('announcement_date', 'desc')
            ->limit(5)
            ->get();

        // Enhanced campus distribution with additional statistics
        $campusDistribution = StudentModel::select(
            'campus',
            DB::raw('count(*) as total'),
            DB::raw('ROUND(AVG(CASE WHEN exam_result.score IS NOT NULL THEN exam_result.score END), 1) as avg_score'),
            DB::raw('COUNT(CASE WHEN exam_result.score IS NOT NULL THEN 1 END) as exam_taken'),
            DB::raw('COUNT(CASE WHEN exam_result.score >= 550 THEN 1 END) as passed_count')
        )
            ->leftJoin('users', 'student.user_id', '=', 'users.user_id')
            ->leftJoin('exam_result', 'users.user_id', '=', 'exam_result.user_id')
            ->groupBy('campus')
            ->orderBy('total', 'desc')
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
            'campusDistribution',
            'totalParticipants',
            'passRate',
            'excellentRate',
            'allExamResults'
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
