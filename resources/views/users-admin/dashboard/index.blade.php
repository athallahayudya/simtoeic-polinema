@extends('layouts.app')

@section('title', 'Admin Dashboard')

@push('style')
    <!-- CSS Libraries -->
    <link rel="stylesheet" href="{{ asset('library/chart.js/dist/Chart.min.css') }}">
    <style>
        /* General card styling for the new design */
        .stat-card {
            background-color: #ffffff; /* White background for cards */
            border-radius: 8px; /* Reduced border-radius */
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1); /* Lighter shadow */
            transition: all 0.3s ease;
            overflow: hidden;
            height: auto; /* Allow height to adjust to content */
            display: flex;
            flex-direction: column;
            margin-bottom: 0px; /* Even further reduced margin between cards */
            border: 1px solid #e0e0e0; /* Subtle border */
        }

        .stat-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.15); /* Slightly stronger hover shadow */
        }

        .stat-card .card-header {
            padding: 10px 20px; /* Adjust padding for compact header */
            display: flex;
            justify-content: space-between;
            align-items: center; /* Align items to center */
            font-size: 0.9rem;
            border-bottom: none; /* No border below header */
            border-top-left-radius: 8px; /* Reduced border-radius */
            border-top-right-radius: 8px; /* Reduced border-radius */
        }

        .stat-card .card-header h6 {
            margin-bottom: 0;
            font-weight: 600; /* Bolder header text */
            color: #ffffff; /* White text for highlighted header */
            text-align: left; /* Left align header text */
            flex-grow: 1; /* Allow title to take available space */
        }

        .stat-card .card-header .header-right {
            display: flex;
            align-items: center;
            font-size: 0.85rem;
            font-weight: 600;
            color: #ffffff; /* White text for header right content */
        }

        .stat-card .card-header .header-right i {
            margin-right: 5px;
            font-size: 0.75rem; /* Smaller icon */
        }

        .stat-card .card-body {
            padding: 15px 20px; /* Adjust padding for compact body */
            display: flex;
            flex-direction: column;
            text-align: left; /* Left align content in card body */
            color: #333333; /* Darker text for body content */
        }

        .stat-card h2 {
            font-size: 2.2rem; /* Slightly smaller number */
            font-weight: 700; /* Bolder number */
            line-height: 1.1;
            margin-bottom: 5px; /* Small margin below number */
            color: #333333; /* Darker color for the number */
        }

        .stat-card small {
            font-size: 0.8rem; /* Smaller descriptive text */
            line-height: 1.3;
            color: #666666; /* Slightly lighter color for descriptive text */
            margin-bottom: 2px; /* Small margin between small texts */
        }

        .stat-card small:last-child {
            margin-bottom: 0; /* No bottom margin for the last small text */
        }

        /* Specific color adjustments for icons/percentages if needed */
        .text-success-light {
            color: #d4edda !important; /* Lighter green for positive growth on dark background */
        }

        .text-danger-light {
            color: #f8d7da !important; /* Lighter red for negative growth on dark background */
        }

        /* Highlight colors for card headers */
        .stat-card .card-header.bg-primary {
            background-color: #6777ef !important; /* Primary color */
        }
        .stat-card .card-header.bg-secondary {
            background-color: #6c757d !important; /* Secondary color */
        }
        .stat-card .card-header.bg-info {
            background-color: #3abaf4 !important; /* Info color */
        }
        .stat-card .card-header.bg-warning {
            background-color: #ffa426 !important; /* Warning color */
        }
        .stat-card .card-header.bg-success {
            background-color: #47c363 !important; /* Success color */
        }
        .stat-card .card-header.bg-danger {
            background-color: #fc544b !important; /* Danger color */
        }

        /* Other existing styles (keep if still relevant) */
        .card-dashboard {
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
            transition: transform 0.2s;
            border: none;
        }
        
        .card-dashboard:hover {
            transform: translateY(-5px);
        }
        
        .card-dashboard .card-header {
            background-color: #fff;
            border-bottom: 1px solid rgba(0, 0, 0, 0.05);
            padding: 20px 25px;
        }
        
        .announcement-item {
            padding: 15px;
            border-radius: 8px;
            margin-bottom: 10px;
            background-color: #f8f9fa;
            transition: all 0.2s ease;
            border-left: 4px solid #6777ef;
        }
        
        .announcement-item:hover {
            background-color: #eef0f8;
        }
        
        .score-badge {
            padding: 5px 10px;
            border-radius: 20px;
            font-weight: 600;
        }
        
        .campus-item {
            padding: 12px 15px;
            border-radius: 8px;
            margin-bottom: 10px;
            background-color: #f8f9fa;
            transition: all 0.2s ease;
        }
        
        .campus-item:hover {
            background-color: #eef0f8;
        }
        
        .table-results th {
            font-weight: 600;
            color: #6c757d;
        }
        
        .table-results {
            border-radius: 8px;
            overflow: hidden;
        }

        /* Statistics table styling */
        .table-borderless td {
            border: none !important;
        }

        .border-bottom {
            border-bottom: 1px solid #e9ecef !important;
        }

        /* Responsive adjustments */
        @media (max-width: 768px) {
            .stat-card .card-body {
                padding: 1rem !important;
            }

            .stat-card h2 {
                font-size: 1.5rem !important;
            }

            .stat-card .fa-lg {
                font-size: 1.2em !important;
            }
        }
    </style>
@endpush

@section('main')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1></i> Admin Dashboard</h1>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item active"><a href="#">Dashboard</a></div>
                </div>
            </div>

            <!-- Main Statistics Cards -->
            <div class="row mb-0">
                <!-- Student Users Card -->
                <div class="col-lg-3 col-md-6 col-sm-6 col-12 mb-0">
                    <a href="{{ route('users') }}" class="text-decoration-none">
                        <div class="card stat-card">
                            <div class="card-header bg-primary">
                                <h6 class="mb-0">Student Users</h6>
                                <div class="header-right">
                                    @if(($studentGrowth ?? 0) >= 0)
                                        <i class="fas fa-arrow-up text-success-light"></i> <span class="text-success-light">+{{ $studentGrowth ?? 0 }}%</span>
                                    @else
                                        <i class="fas fa-arrow-down text-danger-light"></i> <span class="text-danger-light">{{ $studentGrowth ?? 0 }}%</span>
                                    @endif
                                </div>
                            </div>
                            <div class="card-body">
                                <h2 class="font-weight-bold">{{ number_format($totalStudents ?? 0) }}</h2>
                                <small>Active learners</small>
                                <small>Users registered this month</small>
                            </div>
                        </div>
                    </a>
                </div>

                <!-- Staff Users Card -->
                <div class="col-lg-3 col-md-6 col-sm-6 col-12 mb-0">
                    <a href="{{ route('users') }}" class="text-decoration-none">
                        <div class="card stat-card">
                            <div class="card-header bg-secondary">
                                <h6 class="mb-0">Staff Users</h6>
                                <div class="header-right">
                                    @if(($staffGrowth ?? 0) >= 0)
                                        <i class="fas fa-arrow-up text-success-light"></i> <span class="text-success-light">+{{ $staffGrowth ?? 0 }}%</span>
                                    @else
                                        <i class="fas fa-arrow-down text-danger-light"></i> <span class="text-danger-light">{{ $staffGrowth ?? 0 }}%</span>
                                    @endif
                                </div>
                            </div>
                            <div class="card-body">
                                <h2 class="font-weight-bold">{{ number_format($totalStaff ?? 0) }}</h2>
                                <small>Administrative team</small>
                                <small>Users registered this month</small>
                            </div>
                        </div>
                    </a>
                </div>

                <!-- Lecturer Users Card -->
                <div class="col-lg-3 col-md-6 col-sm-6 col-12 mb-0">
                    <a href="{{ route('users') }}" class="text-decoration-none">
                        <div class="card stat-card">
                            <div class="card-header bg-info">
                                <h6 class="mb-0">Lecturer Users</h6>
                                <div class="header-right">
                                    @if(($lecturerGrowth ?? 0) >= 0)
                                        <i class="fas fa-arrow-up text-success-light"></i> <span class="text-success-light">+{{ $lecturerGrowth ?? 0 }}%</span>
                                    @else
                                        <i class="fas fa-arrow-down text-danger-light"></i> <span class="text-danger-light">{{ $lecturerGrowth ?? 0 }}%</span>
                                    @endif
                                </div>
                            </div>
                            <div class="card-body">
                                <h2 class="font-weight-bold">{{ number_format($totalLecturers ?? 0) }}</h2>
                                <small>Teaching faculty</small>
                                <small>Users registered this month</small>
                            </div>
                        </div>
                    </a>
                </div>

                <!-- Alumni Users Card -->
                <div class="col-lg-3 col-md-6 col-sm-6 col-12 mb-0">
                    <a href="{{ route('users') }}" class="text-decoration-none">
                        <div class="card stat-card">
                            <div class="card-header bg-warning">
                                <h6 class="mb-0">Alumni Users</h6>
                                <div class="header-right">
                                    @if(($alumniGrowth ?? 0) >= 0)
                                        <i class="fas fa-arrow-up text-success-light"></i> <span class="text-success-light">+{{ $alumniGrowth ?? 0 }}%</span>
                                    @else
                                        <i class="fas fa-arrow-down text-danger-light"></i> <span class="text-danger-light">{{ $alumniGrowth ?? 0 }}%</span>
                                    @endif
                                </div>
                            </div>
                            <div class="card-body">
                                <h2 class="font-weight-bold">{{ number_format($totalAlumni ?? 0) }}</h2>
                                <small>Graduate network</small>
                                <small>Users registered this month</small>
                            </div>
                        </div>
                    </a>
                </div>
            </div>

            <!-- Secondary Statistics Cards -->
            <div class="row mb-0">
                <!-- Users Taken TOEIC Card -->
                <div class="col-lg-3 col-md-6 col-sm-6 col-12 mb-0">
                    <a href="{{ route('exam-results.index') }}" class="text-decoration-none">
                        <div class="card stat-card">
                            <div class="card-header bg-success">
                                <h6 class="mb-0">Taken TOEIC</h6>
                                <div class="header-right">
                                    <i class="fas fa-check-circle text-success-light"></i> <span class="text-success-light">+12.5%</span>
                                </div>
                            </div>
                            <div class="card-body">
                                <h2 class="font-weight-bold">{{ number_format($totalExamParticipants ?? 0) }}</h2>
                                <small>Completed exams</small>
                                <small>Success rate tracking</small>
                            </div>
                        </div>
                    </a>
                </div>

                <!-- Users Not Taken TOEIC Card -->
                <div class="col-lg-3 col-md-6 col-sm-6 col-12 mb-0">
                    <a href="{{ route('users') }}" class="text-decoration-none">
                        <div class="card stat-card">
                            <div class="card-header bg-danger">
                                <h6 class="mb-0">Not Taken TOEIC</h6>
                                <div class="header-right">
                                    <i class="fas fa-exclamation-triangle text-danger-light"></i> <span class="text-danger-light">-20%</span>
                                </div>
                            </div>
                            <div class="card-body">
                                <h2 class="font-weight-bold">{{ number_format(($totalUsers ?? 0) - ($totalExamParticipants ?? 0)) }}</h2>
                                <small>Pending exams</small>
                                <small>Needs attention</small>
                            </div>
                        </div>
                    </a>
                </div>

                <!-- Basic Statistics Card -->
                <div class="col-lg-6 col-md-12 col-sm-12 col-12 mb-0">
                    <div class="card stat-card">
                        <div class="card-header bg-primary">
                            <h6 class="mb-0 font-weight-bold">Basic Stats</h6>
                            <div class="header-right">
                                <i class="fas fa-chart-bar text-info-light"></i> <span class="text-info-light">+5.0%</span>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6 mb-0">
                                    <div class="d-flex align-items-center">
                                        <div class="mr-3 text-primary">
                                            <i class="fas fa-chart-line fa-2x"></i>
                                        </div>
                                        <div>
                                            <div class="text-muted small">Average Score (μ)</div>
                                            <h5 class="mb-0 font-weight-bold">{{ number_format($averageScore ?? 0, 0) }}</h5>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 mb-0">
                                    <div class="d-flex align-items-center">
                                        <div class="mr-3 text-info">
                                            <i class="fas fa-ruler-combined fa-2x"></i>
                                        </div>
                                        <div>
                                            <div class="text-muted small">Standard Deviation (σ)</div>
                                            <h5 class="mb-0 font-weight-bold">{{ number_format($standardDeviation ?? 0, 0) }}</h5>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 mb-1">
                                    <div class="d-flex align-items-center">
                                        <div class="mr-3 text-danger">
                                            <i class="fas fa-arrow-down fa-2x"></i>
                                        </div>
                                        <div>
                                            <div class="text-muted small">Lowest Score (min)</div>
                                            <h5 class="mb-0 font-weight-bold">{{ number_format($lowestScore ?? 0, 0) }}</h5>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 mb-1">
                                    <div class="d-flex align-items-center">
                                        <div class="mr-3 text-success">
                                            <i class="fas fa-arrow-up fa-2x"></i>
                                        </div>
                                        <div>
                                            <div class="text-muted small">Highest Score (max)</div>
                                            <h5 class="mb-0 font-weight-bold">{{ number_format($highestScore ?? 0, 0) }}</h5>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 mb-1">
                                    <div class="d-flex align-items-center">
                                        <div class="mr-3 text-warning">
                                            <i class="fas fa-percent fa-2x"></i>
                                        </div>
                                        <div>
                                            <div class="text-muted small">Median (M)</div>
                                            <h5 class="mb-0 font-weight-bold">{{ number_format($median ?? 0, 0) }}</h5>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 mb-1">
                                    <div class="d-flex align-items-center">
                                        <div class="mr-3 text-secondary">
                                            <i class="fas fa-chart-bar fa-2x"></i>
                                        </div>
                                        <div>
                                            <div class="text-muted small">Mode</div>
                                            <h5 class="mb-0 font-weight-bold">{{ number_format($mode ?? 0, 0) }}</h5>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
                
            <!-- Charts and Results Row -->
                <div class="row" style="margin-top: -20px;">
                    <!-- Recent Exam Results -->
                    <div class="col-lg-8 mb-4">
                        <div class="card card-dashboard h-100">
                            <div class="card-header d-flex justify-content-between align-items-center">
                                <div>
                                    <h4 class="mb-0"><i class="fas fa-list-alt mr-2 text-primary"></i> Recent Exam Results</h4>
                                    <small class="text-muted">Latest TOEIC exam performances</small>
                                </div>
                                @if(Route::has('exam-results.index'))
                                <a href="{{ route('exam-results.index') }}" class="btn btn-primary btn-sm">
                                    View All <i class="fas fa-arrow-right ml-1"></i>
                                </a>
                                @endif
                            </div>
                            <div class="card-body px-0 py-0">
                                <div class="table-responsive">
                                    <table class="table table-striped table-results mb-0">
                                        <thead>
                                            <tr>
                                                <th class="px-4 py-3">User</th>
                                                <th class="py-3">Role</th>
                                                <th class="py-3">Score</th>
                                                <th class="py-3">Status</th>
                                                <th class="py-3">Date</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @if(isset($recentExamResults) && $recentExamResults->count() > 0)
                                                @foreach($recentExamResults as $result)
                                                    <tr>
                                                        <td class="px-4 py-3">
                                                            @if(isset($result->user))
                                                                @if(isset($result->user->student) && $result->user->student)
                                                                    {{ $result->user->student->name ?? 'N/A' }}
                                                                @elseif(isset($result->user->staff) && $result->user->staff)
                                                                    {{ $result->user->staff->name ?? 'N/A' }}
                                                                @elseif(isset($result->user->lecturer) && $result->user->lecturer)
                                                                    {{ $result->user->lecturer->name ?? 'N/A' }}
                                                                @elseif(isset($result->user->alumni) && $result->user->alumni)
                                                                    {{ $result->user->alumni->name ?? 'N/A' }}
                                                                @else
                                                                    {{ $result->user->identity_number ?? 'Unknown' }}
                                                                @endif
                                                            @else
                                                                Unknown User
                                                            @endif
                                                        </td>
                                                        <td class="py-3">
                                                            @if(isset($result->user) && isset($result->user->role))
                                                                <span class="badge badge-{{ $result->user->role == 'student' ? 'primary' : ($result->user->role == 'lecturer' ? 'success' : 'secondary') }}">
                                                                    {{ ucfirst($result->user->role) }}
                                                                </span>
                                                            @else
                                                                <span class="badge badge-secondary">Unknown</span>
                                                            @endif
                                                        </td>
                                                        <td class="py-3">
                                                            <span class="score-badge {{ ($result->score ?? 0) >= 80 ? 'bg-success text-white' : (($result->score ?? 0) >= 60 ? 'bg-warning text-white' : 'bg-danger text-white') }}">
                                                                {{ $result->score ?? 0 }}
                                                            </span>
                                                        </td>
                                                        <td class="py-3">
                                                            @if(($result->score ?? 0) >= 80)
                                                                <span class="badge badge-success">Excellent</span>
                                                            @elseif(($result->score ?? 0) >= 60)
                                                                <span class="badge badge-warning">Good</span>
                                                            @else
                                                                <span class="badge badge-danger">Needs Improvement</span>
                                                            @endif
                                                        </td>
                                                        <td class="py-3">{{ isset($result->created_at) ? $result->created_at->format('M d, Y') : 'N/A' }}</td>
                                                    </tr>
                                                @endforeach
                                            @else
                                                <tr>
                                                    <td colspan="5" class="text-center py-4">
                                                        <i class="fas fa-clipboard fa-2x text-muted mb-2"></i>
                                                        <p class="mb-0 text-muted">No exam results found</p>
                                                    </td>
                                                </tr>
                                            @endif
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Score Distribution Chart -->
                    <div class="col-lg-4 mb-4">
                        <div class="card card-dashboard h-70">
                            <div class="card-header">
                                <h4 class="mb-0"><i class="fas fa-chart-pie mr-2 text-primary"></i> Exam Qualification</h4>
                            </div>
                            <div class="card-body">
                                <div class="chart-container" style="position: relative; height:250px;">
                                    <canvas id="scoreDistributionChart"></canvas>
                                </div>
                                <div class="score-legend mt-4">
                                    <div class="row">
                                        <div class="col-6">
                                            <div class="d-flex align-items-center">
                                                <span class="badge bg-success text-white mr-2" style="width: 16px; height: 16px;">&nbsp;</span>
                                                <div>
                                                    <div class="font-weight-bold">Score ≥ 500</div>
                                                    <small class="text-muted">Free Exam Qualification</small>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="d-flex align-items-center">
                                                <span class="badge bg-danger text-white mr-2" style="width: 16px; height: 16px;">&nbsp;</span>
                                                <div>
                                                    <div class="font-weight-bold">Score < 500</div>
                                                    <small class="text-muted">Paid Exam Required</small>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                
                    <!-- Campus Distribution and Announcements Row -->
                    <div class="row ml-1 flex-row flex-lg-nowrap"> 
                            <!-- Campus Distribution -->
                            <div class="col-lg-8 mb-4">
                                <div class="card card-dashboard h-100">
                                    <div class="card-header d-flex flex-column align-items-start">
                                        <h4 class="mb-0">
                                            <i class="fas fa-university mr-2 text-primary"></i> 
                                            Campus Distribution
                                        </h4>
                                        <medium class="text-muted">Student distribution</medium>
                                    </div>
                                <div class="card-body">
                                    @if(isset($campusDistribution) && $campusDistribution->count() > 0)
                                        @foreach($campusDistribution as $campus)
                                            <div class="campus-item">
                                                <div class="d-flex justify-content-between mb-2">
                                                    <span>
                                                        <i class="fas fa-map-marker-alt text-primary mr-1"></i>
                                                        {{ ucfirst(str_replace('_', ' ', $campus->campus ?? 'Unknown')) }}
                                                    </span>
                                                    <span class="badge badge-primary">{{ $campus->total ?? 0 }}</span>
                                                </div>
                                                <div class="progress" style="height: 8px; border-radius: 4px;">
                                                    <div class="progress-bar bg-primary" 
                                                        style="width: {{ ($totalStudents ?? 1) > 0 ? (($campus->total ?? 0) / ($totalStudents ?? 1)) * 100 : 0 }}%"></div>
                                                </div>
                                            </div>
                                        @endforeach
                                    @else
                                        <div class="text-center py-5">
                                            <i class="fas fa-university fa-3x text-muted mb-3"></i>
                                            <p class="text-muted">No campus data available</p>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                        
                        <!-- Announcements -->
                        <div class="col-lg-8 mb-4">
                            <div class="card card-dashboard h-100">
                                <div class="card-header d-flex justify-content-between align-items-center">
                                    <div>
                                        <h4 class="mb-0"><i class="fas fa-bullhorn mr-2 text-primary"></i> Announcements</h4>
                                        <medium class="text-muted">Latest system announcements</medium>
                                    </div>
                                    @if(Route::has('announcements.index'))
                                    <a href="{{ route('announcements.index') }}" class="btn btn-primary btn-sm">
                                        All Announcements <i class="fas fa-arrow-right ml-1"></i>
                                    </a>
                                    @endif
                                </div>
                                <div class="card-body" style="max-height: 300px; overflow-y: auto;">
                                    @if(isset($recentAnnouncements) && $recentAnnouncements->count() > 0)
                                        @foreach($recentAnnouncements->take(3) as $announcement)
                                            <div class="announcement-item">
                                                <div class="d-flex justify-content-between mb-2">
                                                    <h6 class="mb-0 font-weight-bold">{{ Str::limit($announcement->title ?? 'No Title', 50) }}</h6>
                                                    <span class="badge badge-light">
                                                        {{ isset($announcement->announcement_date) ? \Carbon\Carbon::parse($announcement->announcement_date)->format('M d') : '' }}
                                                    </span>
                                                </div>
                                                <p class="text-muted small mb-1">
                                                    {{ Str::limit(strip_tags($announcement->content ?? ''), 100) }}
                                                </p>
                                                <div class="d-flex justify-content-between align-items-center">
                                                    <small class="text-muted">
                                                        <i class="fas fa-clock mr-1"></i>
                                                        {{ isset($announcement->announcement_date) ? \Carbon\Carbon::parse($announcement->announcement_date)->diffForHumans() : 'Unknown date' }}
                                                    </small>
                                                    @if(Route::has('announcements.show'))
                                                    <a href="{{ route('announcements.show', $announcement->id) }}" class="btn btn-sm btn-light">
                                                        Read more
                                                    </a>
                                                    @endif
                                                </div>
                                            </div>
                                        @endforeach
                                    @else
                                        <div class="text-center py-5">
                                            <i class="fas fa-bullhorn fa-3x text-muted mb-3"></i>
                                            <p class="text-muted">No announcements found</p>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection

@push('scripts')
    <!-- JS Libraries -->
    <script src="{{ asset('library/chart.js/dist/Chart.min.js') }}"></script>

    <script>
        // Score Distribution Chart - Exam Qualification
        var ctx2 = document.getElementById('scoreDistributionChart').getContext('2d');
        
        // Calculate counts for scores above and below 500
        var scoreDistributionData = @json($scoreDistribution ?? collect());
        var aboveThreshold = 0;
        var belowThreshold = 0;
        
        // If we have actual score data, calculate the distribution
        if(scoreDistributionData.length > 0) {
            // Try to use the raw exam results if available
            var examResults = @json($allExamResults ?? collect());
            
            if(examResults.length > 0) {
                // Count directly from raw scores
                examResults.forEach(function(result) {
                    if(result.score >= 500) {
                        aboveThreshold++;
                    } else {
                        belowThreshold++;
                    }
                });
            } else {
                // Estimate from the existing score distribution data
                // This is just an approximation since we don't have the raw scores
                scoreDistributionData.forEach(function(item) {
                    // Parse the grade to get the score range
                    var gradeText = item.grade || "";
                    var count = item.count || 0;
                    
                    if(gradeText.includes("Excellent") || gradeText.includes("Good") || 
                       (gradeText.includes("Average") && !gradeText.includes("Below"))) {
                        // These are likely above 500
                        aboveThreshold += count;
                    } else {
                        // These are likely below 500
                        belowThreshold += count;
                    }
                });
            }
        }
        
        var scoreDistributionChart = new Chart(ctx2, {
            type: 'doughnut',
            data: {
                labels: ['Score ≥ 500 (Free Exam)', 'Score < 500 (Paid Exam)'],
                datasets: [{
                    data: [aboveThreshold, belowThreshold],
                    backgroundColor: [
                        '#28a745', // Green for qualifying scores (≥ 500)
                        '#dc3545'  // Red for non-qualifying scores (< 500)
                    ],
                    borderWidth: 0
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                cutoutPercentage: 70,
                legend: {
                    display: false
                },
                tooltips: {
                    callbacks: {
                        label: function(tooltipItem, data) {
                            var dataset = data.datasets[tooltipItem.datasetIndex];
                            var total = dataset.data.reduce(function(previousValue, currentValue) {
                                return previousValue + currentValue;
                            }, 0);
                            var currentValue = dataset.data[tooltipItem.index];
                            var percentage = Math.floor(((currentValue/total) * 100)+0.5);        
                            return data.labels[tooltipItem.index] + ': ' + currentValue + ' (' + percentage + '%)';
                        }
                    }
                }
            }
        });
    </script>
@endpush
