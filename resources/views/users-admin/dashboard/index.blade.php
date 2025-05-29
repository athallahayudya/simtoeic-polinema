@extends('layouts.app')

@section('title', 'Admin Dashboard')

@push('style')
    <!-- CSS Libraries -->
    <link rel="stylesheet" href="{{ asset('library/jqvmap/dist/jqvmap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('library/summernote/dist/summernote-bs4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('library/owl.carousel/dist/assets/owl.carousel.min.css') }}">
    <link rel="stylesheet" href="{{ asset('library/owl.carousel/dist/assets/owl.theme.default.min.css') }}">
    <link rel="stylesheet" href="{{ asset('library/flag-icon-css/css/flag-icon.min.css') }}">
    <link rel="stylesheet" href="{{ asset('library/chart.js/dist/Chart.min.css') }}">
@endpush

@section('main')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Admin Dashboard</h1>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item active"><a href="#">Dashboard</a></div>
                </div>
            </div>

            <div class="section-body">
                <!-- Statistics Cards -->
                <div class="row">
                    <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                        <div class="card card-statistic-1">
                            <div class="card-icon bg-primary">
                                <i class="far fa-user"></i>
                            </div>
                            <div class="card-wrap">
                                <div class="card-header">
                                    <h4>Total Users</h4>
                                </div>
                                <div class="card-body">
                                    {{ number_format($totalUsers ?? 0) }}
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                        <div class="card card-statistic-1">
                            <div class="card-icon bg-success">
                                <i class="fas fa-user-graduate"></i>
                            </div>
                            <div class="card-wrap">
                                <div class="card-header">
                                    <h4>Students</h4>
                                </div>
                                <div class="card-body">
                                    {{ number_format($totalStudents ?? 0) }}
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                        <div class="card card-statistic-1">
                            <div class="card-icon bg-warning">
                                <i class="fas fa-chalkboard-teacher"></i>
                            </div>
                            <div class="card-wrap">
                                <div class="card-header">
                                    <h4>Lecturers</h4>
                                </div>
                                <div class="card-body">
                                    {{ number_format($totalLecturers ?? 0) }}
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                        <div class="card card-statistic-1">
                            <div class="card-icon bg-info">
                                <i class="fas fa-clipboard-list"></i>
                            </div>
                            <div class="card-wrap">
                                <div class="card-header">
                                    <h4>Exam Results</h4>
                                </div>
                                <div class="card-body">
                                    {{ number_format($totalExamResults ?? 0) }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Secondary Statistics -->
                <div class="row">
                    <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                        <div class="card card-statistic-1">
                            <div class="card-icon bg-secondary">
                                <i class="fas fa-users-cog"></i>
                            </div>
                            <div class="card-wrap">
                                <div class="card-header">
                                    <h4>Staff</h4>
                                </div>
                                <div class="card-body">
                                    {{ number_format($totalStaff ?? 0) }}
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                        <div class="card card-statistic-1">
                            <div class="card-icon bg-dark">
                                <i class="fas fa-user-tie"></i>
                            </div>
                            <div class="card-wrap">
                                <div class="card-header">
                                    <h4>Alumni</h4>
                                </div>
                                <div class="card-body">
                                    {{ number_format($totalAlumni ?? 0) }}
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                        <div class="card card-statistic-1">
                            <div class="card-icon bg-danger">
                                <i class="fas fa-calendar-alt"></i>
                            </div>
                            <div class="card-wrap">
                                <div class="card-header">
                                    <h4>Schedules</h4>
                                </div>
                                <div class="card-body">
                                    {{ number_format($totalExamSchedules ?? 0) }}
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                        <div class="card card-statistic-1">
                            <div class="card-icon bg-warning">
                                <i class="fas fa-chart-line"></i>
                            </div>
                            <div class="card-wrap">
                                <div class="card-header">
                                    <h4>Avg Score</h4>
                                </div>
                                <div class="card-body">
                                    {{ number_format($averageScore ?? 0, 1) }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Charts Row -->
                <div class="row">
                    <div class="col-lg-8">
                        <div class="card">
                            <div class="card-header">
                                <h4>User Registration Trend</h4>
                            </div>
                            <div class="card-body">
                                <canvas id="userRegistrationChart" height="100"></canvas>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="card">
                            <div class="card-header">
                                <h4>Score Distribution</h4>
                            </div>
                            <div class="card-body">
                                <canvas id="scoreDistributionChart" height="150"></canvas>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Recent Activities and Campus Distribution -->
                <div class="row">
                    <div class="col-lg-8">
                        <div class="card">
                            <div class="card-header">
                                <h4>Recent Exam Results</h4>
                                @if(Route::has('exam-results.index'))
                                <div class="card-header-action">
                                    <a href="{{ route('exam-results.index') }}" class="btn btn-primary">View All</a>
                                </div>
                                @endif
                            </div>
                            <div class="card-body p-0">
                                <div class="table-responsive">
                                    <table class="table-striped table">
                                        <thead>
                                            <tr>
                                                <th>User</th>
                                                <th>Role</th>
                                                <th>Score</th>
                                                <th>Status</th>
                                                <th>Date</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @if(isset($recentExamResults) && $recentExamResults->count() > 0)
                                                @foreach($recentExamResults as $result)
                                                    <tr>
                                                        <td>
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
                                                        <td>
                                                            @if(isset($result->user) && isset($result->user->role))
                                                                <span class="badge badge-{{ $result->user->role == 'student' ? 'primary' : ($result->user->role == 'lecturer' ? 'success' : 'secondary') }}">
                                                                    {{ ucfirst($result->user->role) }}
                                                                </span>
                                                            @else
                                                                <span class="badge badge-secondary">Unknown</span>
                                                            @endif
                                                        </td>
                                                        <td>
                                                            <span class="badge badge-{{ ($result->score ?? 0) >= 80 ? 'success' : (($result->score ?? 0) >= 60 ? 'warning' : 'danger') }}">
                                                                {{ $result->score ?? 0 }}
                                                            </span>
                                                        </td>
                                                        <td>
                                                            @if(($result->score ?? 0) >= 80)
                                                                <span class="badge badge-success">Excellent</span>
                                                            @elseif(($result->score ?? 0) >= 60)
                                                                <span class="badge badge-warning">Good</span>
                                                            @else
                                                                <span class="badge badge-danger">Needs Improvement</span>
                                                            @endif
                                                        </td>
                                                        <td>{{ isset($result->created_at) ? $result->created_at->format('M d, Y') : 'N/A' }}</td>
                                                    </tr>
                                                @endforeach
                                            @else
                                                <tr>
                                                    <td colspan="5" class="text-center">No exam results found</td>
                                                </tr>
                                            @endif
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="card">
                            <div class="card-header">
                                <h4>Campus Distribution</h4>
                            </div>
                            <div class="card-body">
                                @if(isset($campusDistribution) && $campusDistribution->count() > 0)
                                    @foreach($campusDistribution as $campus)
                                        <div class="mb-3">
                                            <div class="d-flex justify-content-between mb-1">
                                                <span class="text-muted">
                                                    {{ ucfirst(str_replace('_', ' ', $campus->campus ?? 'Unknown')) }}
                                                </span>
                                                <span class="font-weight-bold">{{ $campus->total ?? 0 }}</span>
                                            </div>
                                            <div class="progress" style="height: 8px;">
                                                <div class="progress-bar bg-primary" 
                                                     style="width: {{ ($totalStudents ?? 1) > 0 ? (($campus->total ?? 0) / ($totalStudents ?? 1)) * 100 : 0 }}%"></div>
                                            </div>
                                        </div>
                                    @endforeach
                                @else
                                    <p class="text-muted text-center">No campus data available</p>
                                @endif
                            </div>
                        </div>

                        <!-- Recent Announcements -->
                        <div class="card">
                            <div class="card-header">
                                <h4>Recent Announcements</h4>
                                @if(Route::has('announcements.index'))
                                <div class="card-header-action">
                                    <a href="{{ route('announcements.index') }}" class="btn btn-primary btn-sm">View All</a>
                                </div>
                                @endif
                            </div>
                            <div class="card-body">
                                @if(isset($recentAnnouncements) && $recentAnnouncements->count() > 0)
                                    @foreach($recentAnnouncements as $announcement)
                                        <div class="mb-3 pb-2 border-bottom">
                                            <h6 class="mb-1">{{ Str::limit($announcement->title ?? 'No Title', 30) }}</h6>
                                            <p class="text-muted small mb-1">
                                                {{ Str::limit(strip_tags($announcement->content ?? ''), 50) }}
                                            </p>
                                            <small class="text-muted">
                                                {{ isset($announcement->created_at) ? $announcement->created_at->diffForHumans() : 'Unknown date' }}
                                            </small>
                                        </div>
                                    @endforeach
                                @else
                                    <p class="text-muted text-center">No announcements found</p>
                                @endif
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
    <script src="{{ asset('library/jquery-sparkline/jquery.sparkline.min.js') }}"></script>

    <script>
        // User Registration Chart
        var ctx = document.getElementById('userRegistrationChart').getContext('2d');
        var userRegistrationData = @json($userRegistrationData ?? collect());
        var userRegistrationChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: userRegistrationData.length > 0 ? 
                    userRegistrationData.map(function(item) {
                        return new Date(2024, item.month - 1).toLocaleDateString('en', { month: 'short' });
                    }) : ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'],
                datasets: [{
                    label: 'New Users',
                    data: userRegistrationData.length > 0 ? 
                        userRegistrationData.map(function(item) { return item.count; }) : [0, 0, 0, 0, 0, 0],
                    borderColor: '#6777ef',
                    backgroundColor: 'rgba(103, 119, 239, 0.1)',
                    borderWidth: 3,
                    fill: true,
                    tension: 0.4
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });

        // Score Distribution Chart
        var ctx2 = document.getElementById('scoreDistributionChart').getContext('2d');
        var scoreDistributionData = @json($scoreDistribution ?? collect());
        var scoreDistributionChart = new Chart(ctx2, {
            type: 'doughnut',
            data: {
                labels: scoreDistributionData.length > 0 ? 
                    scoreDistributionData.map(function(item) { return item.grade; }) : 
                    ['Excellent (90-100)', 'Good (80-89)', 'Average (70-79)', 'Below Average (60-69)', 'Poor (0-59)'],
                datasets: [{
                    data: scoreDistributionData.length > 0 ? 
                        scoreDistributionData.map(function(item) { return item.count; }) : [0, 0, 0, 0, 0],
                    backgroundColor: [
                        '#28a745',
                        '#17a2b8',
                        '#ffc107',
                        '#fd7e14',
                        '#dc3545'
                    ]
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                legend: {
                    position: 'bottom'
                }
            }
        });
    </script>
@endpush