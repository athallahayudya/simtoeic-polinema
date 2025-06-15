@extends('layouts.app')

@section('title', 'Admin Dashboard')

@push('style')
    <!-- CSS Libraries -->
    <link rel="stylesheet" href="{{ asset('library/chart.js/dist/Chart.min.css') }}">
    <style>
        /* Custom style to make modal backdrop transparent */
        .modal-backdrop.show {
            opacity: 0 !important;
            /* Make it completely transparent */
        }

        /* General card styling for the new design */
        .stat-card {
            background-color: #ffffff;
            /* White background for cards */
            border-radius: 3px;
            /* Same as default card border-radius */
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            /* Lighter shadow */
            transition: all 0.3s ease;
            overflow: hidden;
            height: 180px;
            /* Fixed height for alignment */
            display: flex;
            flex-direction: column;
            margin-bottom: 20px;
            /* Consistent margin between cards */
            border: 1px solid #e0e0e0;
            /* Subtle border */
        }

        .stat-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.15);
            /* Slightly stronger hover shadow */
        }

        .stat-card .card-header {
            padding: 10px 20px;
            /* Adjust padding for compact header */
            display: flex;
            justify-content: space-between;
            align-items: center;
            /* Align items to center */
            font-size: 0.9rem;
            border-bottom: none;
            /* No border below header */
            border-top-left-radius: 3px;
            /* Same as card border-radius */
            border-top-right-radius: 3px;
            /* Same as card border-radius */
        }

        .stat-card .card-header h6 {
            margin-bottom: 0;
            font-weight: 600;
            /* Bolder header text */
            color: #ffffff;
            /* White text for highlighted header */
            text-align: left;
            /* Left align header text */
            flex-grow: 1;
            /* Allow title to take available space */
        }

        .stat-card .card-header .header-right {
            display: flex;
            align-items: center;
            font-size: 0.85rem;
            font-weight: 600;
            color: #ffffff;
            /* White text for header right content */
        }

        .stat-card .card-header .header-right i {
            margin-right: 5px;
            font-size: 0.75rem;
            /* Smaller icon */
        }

        .stat-card .card-body {
            padding: 15px 20px;
            /* Adjust padding for compact body */
            display: flex;
            flex-direction: column;
            justify-content: center;
            /* Center content vertically */
            text-align: left;
            /* Left align content in card body */
            color: #333333;
            /* Darker text for body content */
            flex-grow: 1;
            /* Allow body to grow and fill available space */
            min-height: 120px;
            /* Ensure consistent body height */
        }

        .stat-card h2 {
            font-size: 2.2rem;
            /* Slightly smaller number */
            font-weight: 700;
            /* Bolder number */
            line-height: 1.1;
            margin-bottom: 5px;
            /* Small margin below number */
            color: #333333;
            /* Darker color for the number */
        }

        .stat-card small {
            font-size: 0.8rem;
            /* Smaller descriptive text */
            line-height: 1.3;
            color: #666666;
            /* Slightly lighter color for descriptive text */
            margin-bottom: 2px;
            /* Small margin between small texts */
        }

        .stat-card small:last-child {
            margin-bottom: 0;
            /* No bottom margin for the last small text */
        }

        /* Specific color adjustments for icons/percentages if needed */
        .text-success-light {
            color: #d4edda !important;
            /* Lighter green for positive growth on dark background */
        }

        .text-danger-light {
            color: #f8d7da !important;
            /* Lighter red for negative growth on dark background */
        }

        /* Highlight colors for card headers */
        .stat-card .card-header.bg-primary {
            background-color: #6777ef !important;
            /* Primary color */
        }

        .stat-card .card-header.bg-secondary {
            background-color: #6c757d !important;
            /* Secondary color */
        }

        .stat-card .card-header.bg-info {
            background-color: #3abaf4 !important;
            /* Info color */
        }

        .stat-card .card-header.bg-warning {
            background-color: #ffa426 !important;
            /* Warning color */
        }

        .stat-card .card-header.bg-success {
            background-color: #47c363 !important;
            /* Success color */
        }

        .stat-card .card-header.bg-danger {
            background-color: #fc544b !important;
            /* Danger color */
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
            padding: 15px;
            border-radius: 8px;
            margin-bottom: 15px;
            background-color: #f8f9fa;
            transition: all 0.2s ease;
            border: 1px solid #e9ecef;
        }

        .campus-item:hover {
            background-color: #eef0f8;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }

        /* Enhanced badge styling */
        .badge-lg {
            padding: 8px 12px;
            font-size: 0.9rem;
        }


        /* Ensure equal height cards in rows */
        .equal-height {
            display: flex;
            flex-direction: column;
            height: 100%;
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

        /* Major Chart Styling */
        .major-chart-container {
            background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
            border-radius: 12px;
            padding: 20px;
            margin-bottom: 20px;
        }

        .major-table-container {
            background: #ffffff;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        .major-table th {
            background-color: #f8f9fa;
            border-top: none;
            font-weight: 600;
            color: #495057;
            padding: 15px 10px;
        }

        .major-table td {
            padding: 12px 10px;
            vertical-align: middle;
        }

        .major-table .badge {
            font-size: 0.85rem;
            padding: 6px 12px;
        }

        .progress-sm {
            height: 4px;
            border-radius: 2px;
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

            .major-table th,
            .major-table td {
                padding: 8px 5px;
                font-size: 0.85rem;
            }
            
            .major-table .badge {
                font-size: 0.75rem;
                padding: 4px 8px;
            }
        }
    </style>
@endpush

@section('main')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1 style="font-size: 21px;"></i> Admin Dashboard</h1>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item active"><a href="#">Dashboard</a></div>
                </div>
            </div>

            <!-- Main Statistics Cards -->
            <div class="row mb-0">
                <!-- Student Users Card -->
                <div class="col-lg-3 col-md-6 col-sm-6 col-12 mb-0">
                    <a href="{{ route('users.index') }}" class="text-decoration-none">
                        <div class="card stat-card">
                            <div class="card-header bg-primary">
                                <h6 class="mb-0">Student Users</h6>
                                <div class="header-right">
                                    @if(($studentGrowth ?? 0) >= 0)
                                        <i class="fas fa-arrow-up text-success-light"></i> <span
                                            class="text-success-light">+{{ $studentGrowth ?? 0 }}%</span>
                                    @else
                                        <i class="fas fa-arrow-down text-danger-light"></i> <span
                                            class="text-danger-light">{{ $studentGrowth ?? 0 }}%</span>
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
                    <a href="{{ route('users.index') }}" class="text-decoration-none">
                        <div class="card stat-card">
                            <div class="card-header bg-secondary">
                                <h6 class="mb-0">Staff Users</h6>
                                <div class="header-right">
                                    @if(($staffGrowth ?? 0) >= 0)
                                        <i class="fas fa-arrow-up text-success-light"></i> <span
                                            class="text-success-light">+{{ $staffGrowth ?? 0 }}%</span>
                                    @else
                                        <i class="fas fa-arrow-down text-danger-light"></i> <span
                                            class="text-danger-light">{{ $staffGrowth ?? 0 }}%</span>
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
                    <a href="{{ route('users.index') }}" class="text-decoration-none">
                        <div class="card stat-card">
                            <div class="card-header bg-info">
                                <h6 class="mb-0">Lecturer Users</h6>
                                <div class="header-right">
                                    @if(($lecturerGrowth ?? 0) >= 0)
                                        <i class="fas fa-arrow-up text-success-light"></i> <span
                                            class="text-success-light">+{{ $lecturerGrowth ?? 0 }}%</span>
                                    @else
                                        <i class="fas fa-arrow-down text-danger-light"></i> <span
                                            class="text-danger-light">{{ $lecturerGrowth ?? 0 }}%</span>
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
                    <a href="{{ route('users.index') }}" class="text-decoration-none">
                        <div class="card stat-card">
                            <div class="card-header bg-warning">
                                <h6 class="mb-0">Alumni Users</h6>
                                <div class="header-right">
                                    @if(($alumniGrowth ?? 0) >= 0)
                                        <i class="fas fa-arrow-up text-success-light"></i> <span
                                            class="text-success-light">+{{ $alumniGrowth ?? 0 }}%</span>
                                    @else
                                        <i class="fas fa-arrow-down text-danger-light"></i> <span
                                            class="text-danger-light">{{ $alumniGrowth ?? 0 }}%</span>
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
                                    <i class="fas fa-check-circle text-success-light"></i> <span
                                        class="text-success-light">+12.5%</span>
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
                    <a href="{{ route('users.index') }}" class="text-decoration-none">
                        <div class="card stat-card">
                            <div class="card-header bg-danger">
                                <h6 class="mb-0">Not Taken TOEIC</h6>
                                <div class="header-right">
                                    <i class="fas fa-exclamation-triangle text-danger-light"></i> <span
                                        class="text-danger-light">-20%</span>
                                </div>
                            </div>
                            <div class="card-body">
                                <h2 class="font-weight-bold">
                                    {{ number_format(($totalUsers ?? 0) - ($totalExamParticipants ?? 0)) }}
                                </h2>
                                <small>Pending exams</small>
                                <small>Needs attention</small>
                            </div>
                        </div>
                    </a>
                </div>

                <!-- Basic Statistics Card -->
                <div class="col-lg-6 col-md-12 col-sm-12 col-12 mb-0">
                    <div class="card stat-card" style="height: auto;">
                        <div class="card-header bg-primary">
                            <h6 class="mb-0 font-weight-bold">Basic Stats</h6>
                            <div class="header-right">
                                <i class="fas fa-chart-bar text-info-light"></i> <span class="text-info-light">+5.0%</span>
                            </div>
                        </div>
                        <div class="card-body" style="padding: 10px;">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="d-flex align-items-center mb-2">
                                        <div class="mr-2 text-primary">
                                            <i class="fas fa-chart-line fa-lg"></i>
                                        </div>
                                        <div>
                                            <div class="text-muted small">Average Score (μ)</div>
                                            <h6 class="mb-0 font-weight-bold">{{ number_format($averageScore ?? 0, 0) }}
                                            </h6>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="d-flex align-items-center mb-2">
                                        <div class="mr-2 text-info">
                                            <i class="fas fa-ruler-combined fa-lg"></i>
                                        </div>
                                        <div>
                                            <div class="text-muted small">Standard Deviation (σ)</div>
                                            <h6 class="mb-0 font-weight-bold">
                                                {{ number_format($standardDeviation ?? 0, 0) }}
                                            </h6>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="d-flex align-items-center mb-2">
                                        <div class="mr-2 text-danger">
                                            <i class="fas fa-arrow-down fa-lg"></i>
                                        </div>
                                        <div>
                                            <div class="text-muted small">Lowest Score (min)</div>
                                            <h6 class="mb-0 font-weight-bold">{{ number_format($lowestScore ?? 0, 0) }}</h6>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="d-flex align-items-center mb-2">
                                        <div class="mr-2 text-success">
                                            <i class="fas fa-arrow-up fa-lg"></i>
                                        </div>
                                        <div>
                                            <div class="text-muted small">Highest Score (max)</div>
                                            <h6 class="mb-0 font-weight-bold">{{ number_format($highestScore ?? 0, 0) }}
                                            </h6>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="d-flex align-items-center mb-2">
                                        <div class="mr-2 text-warning">
                                            <i class="fas fa-percent fa-lg"></i>
                                        </div>
                                        <div>
                                            <div class="text-muted small">Median (M)</div>
                                            <h6 class="mb-0 font-weight-bold">{{ number_format($median ?? 0, 0) }}</h6>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="d-flex align-items-center mb-2">
                                        <div class="mr-2 text-secondary">
                                            <i class="fas fa-chart-bar fa-lg"></i>
                                        </div>
                                        <div>
                                            <div class="text-muted small">Mode</div>
                                            <h6 class="mb-0 font-weight-bold">{{ number_format($mode ?? 0, 0) }}</h6>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Charts and Results Row -->
            <div class="row mb-0">
                <!-- Score Distribution Chart - Full Width -->
                <div class="col-lg-12 mb-4">
                    <div class="card card-dashboard h-100">
                        <div class="card-header">
                            <h4 class="mb-0"><i class="fas fa-chart-bar mr-2 text-primary"></i> Exam Score Distribution</h4>
                            <small class="text-muted">TOEIC proficiency levels based on international standards</small>
                        </div>
                        <div class="card-body">
                            <div class="chart-container" style="position: relative; height:350px;">
                                <canvas id="scoreDistributionChart"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Exam Score Distribution by Major Section -->
            <div class="row mb-4">
                <div class="col-lg-12">
                    <div class="card card-dashboard h-100">
                        <div class="card-header">
                            <h4 class="mb-0"><i class="fas fa-graduation-cap mr-2 text-success"></i> Exam Score Distribution by Major</h4>
                            <small class="text-muted">Average TOEIC scores across different departments</small>
                        </div>
                        <div class="card-body">
                            <div class="chart-container" style="position: relative; height:400px;">
                                <canvas id="majorScoreDistributionChart"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Major Score Summary Table -->
            <div class="row mb-4">
                <div class="col-lg-12">
                    <div class="card card-dashboard h-100">
                        <div class="card-header">
                            <h4 class="mb-0"><i class="fas fa-table mr-2 text-primary"></i> Score Summary by Major</h4>
                            <small class="text-muted">Detailed statistics for each department</small>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-striped table-hover major-table">
                                    <thead class="thead-light">
                                        <tr>
                                            <th><i class="fas fa-university mr-1"></i> Major</th>
                                            <th class="text-center"><i class="fas fa-users mr-1"></i> Participants</th>
                                            <th class="text-center"><i class="fas fa-chart-line mr-1"></i> Average Score</th>
                                            <th class="text-center"><i class="fas fa-arrow-down mr-1"></i> Min Score</th>
                                            <th class="text-center"><i class="fas fa-arrow-up mr-1"></i> Max Score</th>
                                            <th class="text-center"><i class="fas fa-check-circle mr-1"></i> Passed</th>
                                            <th class="text-center"><i class="fas fa-percentage mr-1"></i> Pass Rate</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($majorScoreDistribution as $major)
                                        <tr>
                                            <td><strong class="text-primary">{{ $major->major }}</strong></td>
                                            <td class="text-center">
                                                <span class="badge badge-info badge-lg">{{ $major->total_participants }}</span>
                                            </td>
                                            <td class="text-center">
                                                <span class="font-weight-bold text-success">{{ number_format($major->average_score, 1) }}</span>
                                            </td>
                                            <td class="text-center">
                                                <span class="text-danger">{{ $major->min_score }}</span>
                                            </td>
                                            <td class="text-center">
                                                <span class="text-success">{{ $major->max_score }}</span>
                                            </td>
                                            <td class="text-center">
                                                <span class="badge badge-success">{{ $major->passed_count }}</span>
                                            </td>
                                            <td class="text-center">
                                                @php
                                                    $passRate = $major->total_participants > 0 ? ($major->passed_count / $major->total_participants) * 100 : 0;
                                                @endphp
                                                <span class="font-weight-bold {{ $passRate >= 50 ? 'text-success' : 'text-danger' }}">
                                                    {{ number_format($passRate, 1) }}%
                                                </span>
                                                <div class="progress mt-2 progress-sm">
                                                    <div class="progress-bar {{ $passRate >= 75 ? 'bg-success' : ($passRate >= 50 ? 'bg-warning' : 'bg-danger') }}" 
                                                         style="width: {{ $passRate }}%"
                                                         data-toggle="tooltip" 
                                                         title="{{ number_format($passRate, 1) }}% Pass Rate"></div>
                                                </div>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Announcements Section -->
            <div class="row mb-4">
                <div class="col-lg-12">
                    <div class="card card-dashboard h-100">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <div>
                                <h4 class="mb-0"><i class="fas fa-bullhorn mr-2 text-primary"></i> Announcements</h4>
                                <small class="text-muted">Manage system announcements</small>
                            </div>
                            <div class="card-header-action">
                                <a href="{{ route('announcements.create') }}" class="btn btn-primary btn-sm">
                                    <i class="fas fa-plus mr-1"></i> Add Announcement
                                </a>
                            </div>
                        </div>
                        <div class="card-body" style="max-height: 300px; overflow-y: auto;">
                            @if(isset($recentAnnouncements) && $recentAnnouncements->count() > 0)
                                <div class="table-responsive">
                                    <table class="table table-striped table-md mb-0">
                                        <thead>
                                            <tr>
                                                <th>Title</th>
                                                <th>Content</th>
                                                <th>Date</th>
                                                <th class="text-center">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($recentAnnouncements as $announcement)
                                                <tr>
                                                    <td>{{ Str::limit($announcement->title ?? 'No Title', 40) }}</td>
                                                    <td>
                                                        {{ Str::limit(strip_tags($announcement->content ?? ''), 70) }}
                                                    </td>
                                                    <td>{{ isset($announcement->announcement_date) ? \Carbon\Carbon::parse($announcement->announcement_date)->format('M d, Y') : 'N/A' }}
                                                    </td>
                                                    <td class="text-center">
                                                        <button type="button"
                                                            class="btn btn-sm btn-warning mr-1 edit-announcement-btn"
                                                            data-id="{{ $announcement->announcement_id }}" data-toggle="tooltip"
                                                            title="Edit">
                                                            <i class="fas fa-edit"></i>
                                                        </button>
                                                        <button type="button" class="btn btn-sm btn-danger delete-announcement-btn"
                                                            data-id="{{ $announcement->announcement_id }}" data-toggle="tooltip"
                                                            title="Delete">
                                                            <i class="fas fa-trash"></i>
                                                        </button>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            @else
                                <div class="text-center py-5">
                                    <i class="fas fa-bullhorn fa-3x text-muted mb-3"></i>
                                    <p class="text-muted">No announcements found. Click "Add Announcement" to create one.</p>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <!-- Generic Modal for Edit/Add -->
            <div class="modal fade" tabindex="-1" role="dialog" id="announcementModal">
                <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Edit Announcement</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <!-- Content will be loaded here via AJAX -->
                            <div class="text-center">
                                <div class="spinner-border text-primary" role="status">
                                    <span class="sr-only">Loading...</span>
                                </div>
                                <p class="mt-2">Loading announcement data...</p>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-primary" id="saveAnnouncementBtn">Save Changes</button>
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
    <script src="{{ asset('library/sweetalert/dist/sweetalert.min.js') }}"></script>

    <script>
        // Score Distribution Chart - Exam Qualification
        var ctx2 = document.getElementById('scoreDistributionChart').getContext('2d');

        // Prepare data for TOEIC proficiency levels
        var scoreRanges = {
            '0 - 250': 0,
            '255 - 500': 0,
            '501 - 700': 0,
            '701 - 900': 0,
            '901 - 990': 0
        };

        var allExamResults = @json($allExamResults ?? collect());

        if (allExamResults.length > 0) {
            allExamResults.forEach(function (result) {
                var score = result.score;
                if (score >= 0 && score <= 250) {
                    scoreRanges['0 - 250']++;
                } else if (score >= 255 && score <= 500) {
                    scoreRanges['255 - 500']++;
                } else if (score >= 501 && score <= 700) {
                    scoreRanges['501 - 700']++;
                } else if (score >= 701 && score <= 900) {
                    scoreRanges['701 - 900']++;
                } else if (score >= 901 && score <= 990) {
                    scoreRanges['901 - 990']++;
                }
            });
        }

        var scoreDistributionChart = new Chart(ctx2, {
            type: 'bar', // Changed to bar chart
            data: {
                labels: Object.keys(scoreRanges),
                datasets: [{
                    label: 'Number of Participants',
                    data: Object.values(scoreRanges),
                    backgroundColor: [
                        'rgba(220, 53, 69, 0.8)',   // Red for Beginner
                        'rgba(255, 193, 7, 0.8)',   // Yellow for Elementary
                        'rgba(255, 159, 64, 0.8)',  // Orange for Intermediate
                        'rgba(23, 162, 184, 0.8)',  // Blue for Advanced
                        'rgba(40, 167, 69, 0.8)'    // Green for Proficient
                    ],
                    borderColor: [
                        'rgb(220, 53, 69)',
                        'rgb(255, 193, 7)',
                        'rgb(255, 159, 64)',
                        'rgb(23, 162, 184)',
                        'rgb(40, 167, 69)'
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                animation: {
                    duration: 1000, // Animation duration in milliseconds
                    easing: 'easeOutQuart' // Easing function for animation
                },
                scales: {
                    yAxes: [{
                        ticks: {
                            beginAtZero: true,
                            precision: 0, // Ensure integer ticks
                            fontColor: '#666', // Darker font color for y-axis ticks
                            fontSize: 12 // Slightly larger font size
                        },
                        gridLines: {
                            display: true,
                            color: 'rgba(0, 0, 0, 0.05)' // Lighter grid lines
                        },
                        scaleLabel: {
                            display: true,
                            labelString: 'Number of Participants',
                            fontColor: '#333', // Darker font color for label
                            fontSize: 14, // Larger font size for label
                            fontStyle: 'bold'
                        }
                    }],
                    xAxes: [{
                        barPercentage: 0.7, // Adjust bar thickness
                        categoryPercentage: 0.8, // Adjust spacing between categories
                        ticks: {
                            maxRotation: 45,
                            minRotation: 45,
                            fontColor: '#666', // Darker font color for x-axis ticks
                            fontSize: 12 // Slightly larger font size
                        },
                        gridLines: {
                            display: false // Hide x-axis grid lines for cleaner look
                        },
                        scaleLabel: {
                            display: true,
                            labelString: 'TOEIC Proficiency Level',
                            fontColor: '#333', // Darker font color for label
                            fontSize: 14, // Larger font size for label
                            fontStyle: 'bold'
                        }
                    }]
                },
                legend: {
                    display: false // Hide legend as labels are self-explanatory
                },
                tooltips: {
                    backgroundColor: 'rgba(0, 0, 0, 0.7)', // Darker tooltip background
                    titleFontColor: '#fff', // White title font
                    bodyFontColor: '#fff', // White body font
                    cornerRadius: 4, // Rounded tooltip corners
                    displayColors: false, // Hide color box in tooltip
                    callbacks: {
                        label: function (tooltipItem, data) {
                            var label = data.labels[tooltipItem.index] || '';
                            if (label) {
                                label += ': ';
                            }
                            label += tooltipItem.yLabel + ' participants';
                            return label;
                        }
                    }
                },
                elements: {
                    bar: {
                        borderRadius: 5 // Rounded corners for bars
                    }
                }
            }
        });

        // Major Score Distribution Chart
        var ctxMajor = document.getElementById('majorScoreDistributionChart').getContext('2d');
        
        var majorScoreData = @json($majorScoreDistribution ?? collect());
        
        var majorLabels = [];
        var averageScores = [];
        var participantCounts = [];
        
        majorScoreData.forEach(function(item) {
            majorLabels.push(item.major);
            averageScores.push(parseFloat(item.average_score) || 0);
            participantCounts.push(parseInt(item.total_participants) || 0);
        });
        
        var majorChart = new Chart(ctxMajor, {
            type: 'bar',
            data: {
                labels: majorLabels,
                datasets: [{
                    label: 'Average TOEIC Score',
                    data: averageScores,
                    backgroundColor: [
                        'rgba(54, 162, 235, 0.8)',   // Blue - Teknik Elektro
                        'rgba(255, 99, 132, 0.8)',   // Red - Teknik Mesin
                        'rgba(255, 205, 86, 0.8)',   // Yellow - Teknik Sipil
                        'rgba(75, 192, 192, 0.8)',   // Teal - Teknik Kimia
                        'rgba(153, 102, 255, 0.8)',  // Purple - Akuntansi
                        'rgba(255, 159, 64, 0.8)',   // Orange - Administrasi Niaga
                        'rgba(199, 199, 199, 0.8)'   // Grey - Teknologi Informasi
                    ],
                    borderColor: [
                        'rgb(54, 162, 235)',
                        'rgb(255, 99, 132)',
                        'rgb(255, 205, 86)',
                        'rgb(75, 192, 192)',
                        'rgb(153, 102, 255)',
                        'rgb(255, 159, 64)',
                        'rgb(199, 199, 199)'
                    ],
                    borderWidth: 2,
                    borderRadius: 6,
                    borderSkipped: false,
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                animation: {
                    duration: 1500,
                    easing: 'easeOutQuart'
                },
                scales: {
                    yAxes: [{
                        ticks: {
                            beginAtZero: true,
                            max: 990,
                            stepSize: 100,
                            fontColor: '#666',
                            fontSize: 12,
                            callback: function(value) {
                                return value + ' pts';
                            }
                        },
                        gridLines: {
                            color: 'rgba(0, 0, 0, 0.1)',
                            drawBorder: false
                        },
                        scaleLabel: {
                            display: true,
                            labelString: 'Average TOEIC Score',
                            fontColor: '#333',
                            fontSize: 14,
                            fontStyle: 'bold'
                        }
                    }],
                    xAxes: [{
                        ticks: {
                            maxRotation: 45,
                            minRotation: 45,
                            fontColor: '#666',
                            fontSize: 11
                        },
                        gridLines: {
                            display: false
                        },
                        scaleLabel: {
                            display: true,
                            labelString: 'Department / Major',
                            fontColor: '#333',
                            fontSize: 14,
                            fontStyle: 'bold'
                        }
                    }]
                },
                legend: {
                    display: false
                },
                tooltips: {
                    backgroundColor: 'rgba(0, 0, 0, 0.8)',
                    titleFontColor: '#fff',
                    bodyFontColor: '#fff',
                    cornerRadius: 8,
                    displayColors: false,
                    callbacks: {
                        title: function(tooltipItems) {
                            return tooltipItems[0].label;
                        },
                        label: function(tooltipItem) {
                            var dataIndex = tooltipItem.index;
                            var majorData = majorScoreData[dataIndex];
                            var passRate = majorData.total_participants > 0 ? 
                                (majorData.passed_count / majorData.total_participants * 100).toFixed(1) : '0.0';
                            
                            return [
                                'Average Score: ' + tooltipItem.yLabel.toFixed(1) + ' pts',
                                'Total Participants: ' + majorData.total_participants,
                                'Passed (≥550): ' + majorData.passed_count,
                                'Pass Rate: ' + passRate + '%',
                                'Score Range: ' + majorData.min_score + ' - ' + majorData.max_score
                            ];
                        }
                    }
                },
                elements: {
                    bar: {
                        borderRadius: 6
                    }
                }
            }
        });

        // AJAX for deleting announcements
        $(document).ready(function () {
            $('.delete-announcement-btn').on('click', function (e) {
                e.preventDefault();
                var announcementId = $(this).data('id');
                var row = $(this).closest('tr'); // Get the table row to remove it later

                swal({
                    title: 'Are you sure?',
                    text: 'Once deleted, you will not be able to recover this announcement!',
                    icon: 'warning',
                    buttons: true,
                    dangerMode: true,
                })
                    .then((willDelete) => {
                        if (willDelete) {
                            $.ajax({
                                url: '/announcements/' + announcementId,
                                type: 'DELETE',
                                data: {
                                    _token: '{{ csrf_token() }}'
                                },
                                success: function (response) {
                                    if (response.status) {
                                        swal('Success!', response.message, 'success');
                                        row.remove(); // Remove the row from the table
                                        // If no more announcements, show the "No announcements found" message
                                        if ($('.table-striped tbody tr').length === 0) {
                                            $('.card-body').append('<div class="text-center py-5 no-announcements-message"><i class="fas fa-bullhorn fa-3x text-muted mb-3"></i><p class="text-muted">No announcements found. Click "Add Announcement" to create one.</p></div>');
                                        }
                                    } else {
                                        swal('Error!', response.message, 'error');
                                    }
                                },
                                error: function (xhr) {
                                    swal('Error!', 'An error occurred while deleting the announcement.', 'error');
                                    console.error(xhr.responseText);
                                }
                            });
                        }
                    });
            });
        });

        // AJAX for editing announcements (modal)
        $(document).ready(function () {
            // Load edit form into modal (hanya untuk tombol edit, bukan content)
            $('.edit-announcement-btn').on('click', function (e) {
                e.preventDefault();
                var announcementId = $(this).data('id');
                var modalBody = $('#announcementModal .modal-body');

                modalBody.html('<div class="text-center"><div class="spinner-border text-primary" role="status"><span class="sr-only">Loading...</span></div><p class="mt-2">Loading announcement data...</p></div>');
                $('#announcementModal').modal('show');

                $.ajax({
                    url: '/announcements/' + announcementId + '/edit_dashboard',
                    type: 'GET',
                    success: function (response) {
                        modalBody.html(response);

                        // Ensure form elements are interactive after loading
                        setTimeout(function () {
                            console.log('Dashboard modal form loaded');

                            // Force enable all form elements
                            $('#announcementEditForm input, #announcementEditForm select, #announcementEditForm textarea').each(function () {
                                console.log('Enabling modal element:', this);
                                $(this).prop('disabled', false);
                                $(this).prop('readonly', false);
                                $(this).removeAttr('disabled');
                                $(this).removeAttr('readonly');
                                $(this).css({
                                    'pointer-events': 'auto !important',
                                    'user-select': 'auto !important',
                                    'position': 'relative !important',
                                    'z-index': '1050 !important',
                                    'background-color': 'white !important'
                                });
                            });

                            // Enable checkboxes specifically
                            $('#announcementEditForm input[type="checkbox"]').each(function () {
                                console.log('Enabling modal checkbox:', this);
                                $(this).prop('disabled', false);
                                $(this).removeAttr('disabled');
                                $(this).css({
                                    'pointer-events': 'auto !important',
                                    'position': 'relative !important',
                                    'z-index': '1060 !important'
                                });
                            });

                            // Enable labels
                            $('#announcementEditForm label').css({
                                'pointer-events': 'auto !important',
                                'cursor': 'pointer !important'
                            });

                            // Remove any overlay or blocking elements
                            $('.modal-backdrop.show').css('z-index', '1040');

                            // Focus on first input to test
                            var titleInput = $('#announcementEditForm input[name="title"]');
                            console.log('Focusing on modal title input:', titleInput);
                            titleInput.focus();
                            titleInput.click();
                        }, 500);
                    },
                    error: function (xhr) {
                        modalBody.html('<div class="alert alert-danger">Failed to load announcement data.</div>');
                        console.error(xhr.responseText);
                    }
                });
            });

            // Handle form submission within the modal via AJAX
            $(document).on('submit', '#announcementEditForm', function (e) {
                e.preventDefault();
                var form = $(this);
                var url = form.attr('action');
                var method = form.find('input[name="_method"]').val() || form.attr('method');
                var formData = form.serialize();

                $.ajax({
                    url: url,
                    type: method,
                    data: formData,
                    success: function (response) {
                        if (response.status) {
                            swal('Success!', response.message, 'success');
                            $('#announcementModal').modal('hide');
                            // Reload the page or update the specific row in the table
                            location.reload(); // Simple reload for now, can be optimized later
                        } else {
                            swal('Error!', response.message, 'error');
                        }
                    },
                    error: function (xhr) {
                        var errors = xhr.responseJSON.errors;
                        if (errors) {
                            // Clear previous errors
                            form.find('.is-invalid').removeClass('is-invalid');
                            form.find('.invalid-feedback').remove();

                            // Display new errors
                            $.each(errors, function (key, value) {
                                var input = form.find('[name="' + key + '"]');
                                input.addClass('is-invalid');
                                input.after('<div class="invalid-feedback">' + value + '</div>');
                            });
                            swal('Validation Error!', 'Please check the form for errors.', 'error');
                        } else {
                            swal('Error!', 'An error occurred while updating the announcement.', 'error');
                        }
                        console.error(xhr.responseText);
                    }
                });
            });

            // Handle Save Changes button click (since it's outside the form)
            $(document).on('click', '#saveAnnouncementBtn', function (e) {
                e.preventDefault();
                $('#announcementEditForm').submit();
            });
        });
    </script>
@endpush