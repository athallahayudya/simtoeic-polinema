@extends('layouts.app')

@section('title', 'Manage Users')

@section('main')
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Manage Users</h1>
            <div class="section-header-breadcrumb">
                <div class="col-12">
                    <a href="{{ url('/auth-register') }}" class="btn btn-primary">Added Users</a>
                </div>
            </div>
        </div>
        <div class="section-body">
            <div class="row">
                <!-- Staff -->
                <div class="col-lg-3 col-md-6 col-sm-6 col-12 mb-4 d-flex">
                    <a href="{{ url('/manage-users/staff/') }}" class="text-decoration-none w-100">
                        <div class="card card-statistic-1 h-100">
                            <div class="card-icon bg-primary">
                                <i class="fas fa-users"></i>
                            </div>
                            <div class="card-wrap">
                                <div class="card-header">
                                    <h4>STAFF</h4>
                                </div>
                                <div class="card-body">
                                    MANAGE STAFF
                                </div>
                            </div>
                        </div>
                    </a>
                </div>

                <!-- Student -->
                <div class="col-lg-3 col-md-6 col-sm-6 col-12 mb-4 d-flex">
                    <a href="{{ url('/manage-users/student/') }}" class="text-decoration-none w-100">
                        <div class="card card-statistic-1 h-100">
                            <div class="card-icon bg-danger">
                                <i class="fas fa-user-graduate"></i>
                            </div>
                            <div class="card-wrap">
                                <div class="card-header">
                                    <h4>STUDENT</h4>
                                </div>
                                <div class="card-body">
                                    MANAGE STUDENT
                                </div>
                            </div>
                        </div>
                    </a>
                </div>

                <!-- Alumni -->
                <div class="col-lg-3 col-md-6 col-sm-6 col-12 mb-4 d-flex">
                    <a href="{{ url('/manage-users/alumni/') }}" class="text-decoration-none w-100">
                        <div class="card card-statistic-1 h-100">
                            <div class="card-icon bg-warning">
                                <i class="fas fa-user-tie"></i>
                            </div>
                            <div class="card-wrap">
                                <div class="card-header">
                                    <h4>ALUMNI</h4>
                                </div>
                                <div class="card-body">
                                    MANAGE ALUMNI
                                </div>
                            </div>
                        </div>
                    </a>
                </div>

                <!-- Lecturer -->
                <div class="col-lg-3 col-md-6 col-sm-6 col-12 mb-4 d-flex">
                    <a href="{{ url('/manage-users/lecturer/') }}" class="text-decoration-none w-100">
                        <div class="card card-statistic-1 h-100">
                            <div class="card-icon bg-success">
                                <i class="fas fa-chalkboard-teacher"></i>
                            </div>
                            <div class="card-wrap">
                                <div class="card-header">
                                    <h4>LECTURER</h4>
                                </div>
                                <div class="card-body">
                                    MANAGE LECTURER
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