@extends('layouts.app')

@section('title', 'Admin Dashboard')

@push('style')
    <!-- CSS Libraries -->
    <link rel="stylesheet" href="{{ asset('library/chart.js/dist/Chart.min.css') }}">
    <style>
        /* General card styling for the new design */
        .stat-card {
            background-color: #ffffff;
            /* White background for cards */
            border-radius: 8px;
            /* Reduced border-radius */
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
            border-top-left-radius: 8px;
            /* Reduced border-radius */
            border-top-right-radius: 8px;
            /* Reduced border-radius */
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
                    <a href="{{ route('users') }}" class="text-decoration-none">
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
                    <a href="{{ route('users') }}" class="text-decoration-none">
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
                    <a href="{{ route('users') }}" class="text-decoration-none">
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
                    <a href="{{ route('users') }}" class="text-decoration-none">
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
                                    {{ number_format(($totalUsers ?? 0) - ($totalExamParticipants ?? 0)) }}</h2>
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
                                            <h6 class="mb-0 font-weight-bold">{{ number_format($averageScore ?? 0, 0) }}</h6>
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
                                            <h6 class="mb-0 font-weight-bold">{{ number_format($standardDeviation ?? 0, 0) }}</h6>
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
                                            <h6 class="mb-0 font-weight-bold">{{ number_format($highestScore ?? 0, 0) }}</h6>
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
                                                    <td>{{ Str::limit(strip_tags($announcement->content ?? ''), 70) }}</td>
                                                    <td>{{ isset($announcement->announcement_date) ? \Carbon\Carbon::parse($announcement->announcement_date)->format('M d, Y') : 'N/A' }}
                                                    </td>
                                                    <td class="text-center">
                                                        <a href="{{ route('announcements.edit', ['id' => $announcement->announcement_id]) }}"
                                                            class="btn btn-sm btn-warning mr-1" data-toggle="tooltip" title="Edit">
                                                            <i class="fas fa-edit"></i>
                                                        </a>
                                                        <form
                                                            action="{{ route('announcements.destroy', ['id' => $announcement->announcement_id]) }}"
                                                            method="POST" class="d-inline delete-form">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="btn btn-sm btn-danger"
                                                                data-toggle="tooltip" title="Delete"
                                                                onclick="return confirm('Are you sure you want to delete this announcement?');">
                                                                <i class="fas fa-trash"></i>
                                                            </button>
                                                        </form>
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


        </section>
    </div>
@endsection

@push('scripts')
    <!-- JS Libraries -->
    <script src="{{ asset('library/chart.js/dist/Chart.min.js') }}"></script>

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
    </script>
@endpush
