@extends('layouts.app')

@section('title', 'Admin Dashboard')

@push('style')
    <!-- CSS Libraries -->
    <link rel="stylesheet" href="{{ asset('library/chart.js/dist/Chart.min.css') }}">
    <style>

        
        .stat-card .card-body {
            display: flex;
            align-items: center;
            padding: 1.5rem;
        }
        .stat-card {
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.05);
            transition: all 0.3s ease;
            overflow: hidden;
            height: 100%;
        }
        
        .stat-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
        }

        .stat-icon-container {
            width: 70px;
            display: flex;
            justify-content: center;
            margin-right: 15px;
            margin-left: 10px;
        }
        
        .stat-icon {
            height: 60px;
            width: 60px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 12px;
            font-size: 24px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            position: relative;
            overflow: hidden;
        }

        .stat-content {
            flex: 1;
        }
        
        .stat-icon::after {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(45deg, rgba(255,255,255,0.1) 0%, rgba(255,255,255,0) 100%);
            z-index: 1;
        }
        
        .stat-icon i {
            position: relative;
            z-index: 2;
        }
        
        .bg-primary {
            background: linear-gradient(135deg, #6777ef 0%, #4a5fe4 100%) !important;
        }
        
        .bg-success {
            background: linear-gradient(135deg, #47c363 0%, #2bb14a 100%) !important;
        }
        
        .bg-info {
            background: linear-gradient(135deg, #3abaf4 0%, #1a9cdc 100%) !important;
        }
        
        .bg-warning {
            background: linear-gradient(135deg, #ffa426 0%, #f78c00 100%) !important;
        }
        
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
            <div class="row mb-4">
                <!-- Total Users Card -->
                <div class="col-lg-3 col-md-6 col-sm-6 col-12 mb-4">
                    <a href="{{ route('users') }}" class="text-decoration-none">
                        <div class="card stat-card h-100">
                            <div class="card-header bg-primary text-white p-3 d-flex align-items-center justify-content-center">
                                <h6 class="mb-0 text-center">Total Users</h6>
                            </div>
                            <div class="card-body p-4 d-flex align-items-center justify-content-center">
                                <h2 class="font-weight-bold text-center mb-0">{{ number_format($totalUsers ?? 0) }}</h2>
                            </div>
                        </div>
                    </a>
                </div>
                
                <!-- Users Taken TOEIC Card -->
                <div class="col-lg-3 col-md-6 col-sm-6 col-12 mb-4">
                    <a href="{{ route('exam-results.index') }}" class="text-decoration-none">
                        <div class="card stat-card h-100">
                            <div class="card-header bg-success text-white p-3 d-flex align-items-center justify-content-center">
                                <h6 class="mb-0 text-center">Taken TOEIC</h6>
                            </div>
                            <div class="card-body p-4 d-flex align-items-center justify-content-center">
                                <h2 class="font-weight-bold text-center mb-0">{{ number_format($totalExamParticipants ?? 0) }}</h2>
                            </div>
                        </div>
                    </a>
                </div>
                
                <!-- Users Not Taken TOEIC Card -->
                <div class="col-lg-3 col-md-6 col-sm-6 col-12 mb-4">
                    <a href="{{ route('users') }}" class="text-decoration-none">
                        <div class="card stat-card h-100">
                            <div class="card-header bg-info text-white p-3 d-flex align-items-center justify-content-center">
                                <h6 class="mb-0 text-center">Not Taken TOEIC</h6>
                            </div>
                            <div class="card-body p-4 d-flex align-items-center justify-content-center">
                                <h2 class="font-weight-bold text-center mb-0">{{ number_format(($totalUsers ?? 0) - ($totalExamParticipants ?? 0)) }}</h2>
                            </div>
                        </div>
                    </a>
                </div>
                
                <!-- Average Score Card -->
                <div class="col-lg-3 col-md-6 col-sm-6 col-12 mb-4">
                    <div class="card stat-card h-100">
                        <div class="card-header bg-warning text-white p-3 d-flex align-items-center justify-content-center">
                            <h6 class="mb-0 text-center">Average Score</h6>
                        </div>
                        <div class="card-body p-4 d-flex align-items-center justify-content-center">
                            <h2 class="font-weight-bold text-center mb-0">{{ number_format($averageScore ?? 0, 1) }}</h2>
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
