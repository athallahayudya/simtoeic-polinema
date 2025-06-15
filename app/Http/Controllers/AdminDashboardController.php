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

        // User registration by month (last 6 months) - Using ORM
        $userRegistrationData = $this->getUserRegistrationByMonth();

        // Exam scores distribution with TOEIC standards - Using ORM
        $scoreDistribution = $this->getScoreDistribution();

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

        // Exam Score Distribution by Major using ORM
        $majorScoreDistribution = $this->getMajorScoreDistribution();

        // Recent announcements
        $recentAnnouncements = AnnouncementModel::where('announcement_status', 'published')
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        // Enhanced campus distribution with additional statistics - Using ORM
        $campusDistribution = $this->getCampusDistribution();

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
            'allExamResults',
            'majorScoreDistribution'
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

    /**
     * Get exam score distribution by major using ORM
     */
    private function getMajorScoreDistribution()
    {
        // Define standard majors
        $standardMajors = [
            'Teknik Elektro',
            'Teknik Mesin',
            'Teknik Sipil',
            'Teknik Kimia',
            'Akuntansi',
            'Administrasi Niaga',
            'Teknologi Informasi'
        ];

        // Get all exam results with student data using ORM relationships
        $examResults = ExamResultModel::with(['user.student'])
            ->whereHas('user.student')
            ->whereNotNull('score')
            ->get();

        // Process data for each major
        $majorStats = collect();

        foreach ($standardMajors as $major) {
            // Filter exam results for this specific major
            $majorResults = $examResults->filter(function ($result) use ($major) {
                return $result->user &&
                    $result->user->student &&
                    $result->user->student->major === $major;
            });

            // Calculate statistics
            $totalParticipants = $majorResults->count();
            $scores = $majorResults->pluck('score');

            $averageScore = $totalParticipants > 0 ? round($scores->avg(), 1) : 0;
            $minScore = $totalParticipants > 0 ? $scores->min() : 0;
            $maxScore = $totalParticipants > 0 ? $scores->max() : 0;
            $passedCount = $scores->where('>=', 550)->count();

            $majorStats->push((object) [
                'major' => $major,
                'total_participants' => $totalParticipants,
                'average_score' => $averageScore,
                'min_score' => $minScore,
                'max_score' => $maxScore,
                'passed_count' => $passedCount
            ]);
        }

        return $majorStats->sortByDesc('total_participants');
    }

    /**
     * Get user registration data by month using ORM
     */
    private function getUserRegistrationByMonth()
    {
        $users = UserModel::where('created_at', '>=', now()->subMonths(6))->get();

        $monthlyData = collect();

        foreach ($users as $user) {
            $month = $user->created_at->month;
            $existing = $monthlyData->firstWhere('month', $month);

            if ($existing) {
                $existing->count++;
            } else {
                $monthlyData->push((object)[
                    'month' => $month,
                    'count' => 1
                ]);
            }
        }

        return $monthlyData->sortBy('month');
    }

    /**
     * Get score distribution using ORM
     */
    private function getScoreDistribution()
    {
        $examResults = ExamResultModel::whereNotNull('score')->get();

        $distribution = collect([
            (object)['grade' => 'Beginner (10-224)', 'count' => 0],
            (object)['grade' => 'Elementary (225-549)', 'count' => 0],
            (object)['grade' => 'Intermediate (550-784)', 'count' => 0],
            (object)['grade' => 'Advanced (785-944)', 'count' => 0],
            (object)['grade' => 'Proficient (945-990)', 'count' => 0],
        ]);

        foreach ($examResults as $result) {
            $score = $result->score;

            if ($score >= 945) {
                $distribution[4]->count++;
            } elseif ($score >= 785) {
                $distribution[3]->count++;
            } elseif ($score >= 550) {
                $distribution[2]->count++;
            } elseif ($score >= 225) {
                $distribution[1]->count++;
            } else {
                $distribution[0]->count++;
            }
        }

        return $distribution;
    }

    /**
     * Get campus distribution using ORM
     */
    private function getCampusDistribution()
    {
        $students = StudentModel::with(['user.examResults'])
            ->whereNotNull('campus')
            ->get();

        $campusStats = collect();
        $campuses = $students->pluck('campus')->unique();

        foreach ($campuses as $campus) {
            $campusStudents = $students->where('campus', $campus);
            $total = $campusStudents->count();

            // Get all exam results for students in this campus
            $examResults = collect();
            foreach ($campusStudents as $student) {
                if ($student->user && $student->user->examResults) {
                    $examResults = $examResults->merge($student->user->examResults);
                }
            }

            $examResultsWithScore = $examResults->whereNotNull('score');
            $examTaken = $examResultsWithScore->count();
            $avgScore = $examTaken > 0 ? round($examResultsWithScore->avg('score'), 1) : 0;
            $passedCount = $examResultsWithScore->where('score', '>=', 550)->count();

            $campusStats->push((object)[
                'campus' => $campus,
                'total' => $total,
                'avg_score' => $avgScore,
                'exam_taken' => $examTaken,
                'passed_count' => $passedCount
            ]);
        }

        return $campusStats->sortByDesc('total');
    }
}
