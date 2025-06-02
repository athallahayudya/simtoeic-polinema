@extends('layouts.app')

@section('title', 'Manage Users')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/user-management.css') }}">
@endsection

@section('main')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1></i> Manage Users</h1>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item active"><a href="{{ url('/dashboard-admin') }}">Dashboard</a></div>
                    <div class="breadcrumb-item">Manage Users</div>
                </div>
            </div>

            <div class="section-body " style="margin-top: -10px;">
                <h2 class="section-title">User Management Panel</h2>

                <!-- User statistics summary -->
                <div class="row mb-4">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h4>User Statistics Overview</h4>
                                <div class="card-header-action">
                                    <span id="last-updated" class="text-muted small"></span>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="row text-center">
                                    <div class="col-md-3 col-sm-6 mb-3 mb-lg-0">
                                        <div class="p-3">
                                            <div id="staff-count" class="text-primary stats-number">{{ $staffCount }}</div>
                                            <div class="text-muted">Total Staff</div>
                                        </div>
                                    </div>
                                    <div class="col-md-3 col-sm-6 mb-3 mb-lg-0">
                                        <div class="p-3">
                                            <div id="student-count" class="text-danger stats-number">{{ $studentCount }}
                                            </div>
                                            <div class="text-muted">Total Students</div>
                                        </div>
                                    </div>
                                    <div class="col-md-3 col-sm-6 mb-3 mb-lg-0">
                                        <div class="p-3">
                                            <div id="alumni-count" class="text-warning stats-number">{{ $alumniCount }}
                                            </div>
                                            <div class="text-muted">Total Alumni</div>
                                        </div>
                                    </div>
                                    <div class="col-md-3 col-sm-6">
                                        <div class="p-3">
                                            <div id="lecturer-count" class="text-success stats-number">{{ $lecturerCount }}
                                            </div>
                                            <div class="text-muted">Total Lecturers</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row" style="margin-top: -20px;">
                    <!-- Staff -->
                    <div class="col-lg-3 col-md-6 col-sm-6 col-12 mb-4">
                        <a href="{{ url('/manage-users/staff/') }}" class="text-decoration-none">
                            <div class="card user-card card-border-left bg-staff">
                                <div class="card-body p-0">
                                    <div class="card-icon bg-primary">
                                        <i class="fas fa-users text-white"></i>
                                    </div>
                                    <div class="p-4">
                                        <div class="card-title text-dark">Staff Management</div>
                                        <p class="text-muted mb-3">Manage staff accounts, roles and permissions</p>
                                        <div class="card-action text-primary">
                                            Manage <i class="fas fa-arrow-right ml-1"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>

                    <!-- Student -->
                    <div class="col-lg-3 col-md-6 col-sm-6 col-12 mb-4">
                        <a href="{{ url('/manage-users/student/') }}" class="text-decoration-none">
                            <div class="card user-card card-border-left bg-student">
                                <div class="card-body p-0">
                                    <div class="card-icon bg-danger">
                                        <i class="fas fa-user-graduate text-white"></i>
                                    </div>
                                    <div class="p-4">
                                        <div class="card-title text-dark">Student Management</div>
                                        <p class="text-muted mb-3">Manage student accounts and registrations</p>
                                        <div class="card-action text-danger">
                                            Manage <i class="fas fa-arrow-right ml-1"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>

                    <!-- Alumni -->
                    <div class="col-lg-3 col-md-6 col-sm-6 col-12 mb-4">
                        <a href="{{ url('/manage-users/alumni/') }}" class="text-decoration-none">
                            <div class="card user-card card-border-left bg-alumni">
                                <div class="card-body p-0">
                                    <div class="card-icon bg-warning">
                                        <i class="fas fa-user-tie text-white"></i>
                                    </div>
                                    <div class="p-4">
                                        <div class="card-title text-dark">Alumni Management</div>
                                        <p class="text-muted mb-3">Manage alumni profiles and connections</p>
                                        <div class="card-action text-warning">
                                            Manage <i class="fas fa-arrow-right ml-1"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>

                    <!-- Lecturer -->
                    <div class="col-lg-3 col-md-6 col-sm-6 col-12 mb-4">
                        <a href="{{ url('/manage-users/lecturer/') }}" class="text-decoration-none">
                            <div class="card user-card card-border-left bg-lecturer">
                                <div class="card-body p-0">
                                    <div class="card-icon bg-success">
                                        <i class="fas fa-chalkboard-teacher text-white"></i>
                                    </div>
                                    <div class="p-4">
                                        <div class="card-title text-dark">Lecturer Management</div>
                                        <p class="text-muted mb-3">Manage lecturer profiles and assignments</p>
                                        <div class="card-action text-success">
                                            Manage <i class="fas fa-arrow-right ml-1"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection

@section('scripts')
    <script src="{{ asset('js/user-statistics.js') }}"></script>
@endsection