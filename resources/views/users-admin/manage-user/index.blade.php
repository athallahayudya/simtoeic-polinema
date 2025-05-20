@extends('layouts.app')

@section('title', 'Manage Users')

@section('main')
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Manage Users</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="{{ url('/dashboard-admin') }}">Dashboard</a></div>
                <div class="breadcrumb-item">Manage Users</div>
            </div>
        </div>
        <div class="section-body">
            <div class="row">
                <!-- Staff -->
                <div class="col-lg-3 col-md-6 col-sm-6 col-12 mb-4 d-flex" style="border-left-width: 10px; border-left-color: #6777EF; border-left-style: solid; border-radius: 10px; padding-left: 0;">
                    <a href="{{ url('/manage-users/staff/') }}" class="text-decoration-none w-100">
                        <div class="card card-statistic-1 h-100">
                            <div class="card-icon bg-primary">
                                <i class="fas fa-users" style="padding-right: 35px;"></i>
                            </div>
                            <div class="card-wrap">
                                <div class="card-header">
                                    <h4>STAFF</h4>
                                </div>
                                <div class="card-body" style="font-size: 20px; font-weight: 800; line-height: 1.2;">
                                    MANAGE <br> STAFF
                                </div>
                            </div>
                        </div>
                    </a>
                </div>

                <!-- Student -->
                <div class="col-lg-3 col-md-6 col-sm-6 col-12 mb-4 d-flex" style="border-left-width: 10px; border-left-color: #6777EF; border-left-style: solid; border-radius: 10px; padding-left: 0;">
                    <a href="{{ url('/manage-users/student/') }}" class="text-decoration-none w-100">
                        <div class="card card-statistic-1 h-100">
                            <div class="card-icon bg-danger">
                                <i class="fas fa-user-graduate"></i>
                            </div>
                            <div class="card-wrap">
                                <div class="card-header">
                                    <h4>STUDENT</h4>
                                </div>
                                <div class="card-body" style="font-size: 20px; font-weight: 800; line-height: 1.2;">
                                    MANAGE <br> STUDENT
                                </div>
                            </div>
                        </div>
                    </a>
                </div>

                <!-- Alumni -->
                <div class="col-lg-3 col-md-6 col-sm-6 col-12 mb-4 d-flex" style="border-left-width: 10px; border-left-color: #6777EF; border-left-style: solid; border-radius: 10px; padding-left: 0;">
                    <a href="{{ url('/manage-users/alumni/') }}" class="text-decoration-none w-100">
                        <div class="card card-statistic-1 h-100">
                            <div class="card-icon bg-warning">
                                <i class="fas fa-user-tie"></i>
                            </div>
                            <div class="card-wrap">
                                <div class="card-header">
                                    <h4>ALUMNI</h4>
                                </div>
                                <div class="card-body" style="font-size: 20px; font-weight: 800; line-height: 1.2;">
                                    MANAGE <br> ALUMNI
                                </div>
                            </div>
                        </div>
                    </a>
                </div>

                <!-- Lecturer -->
                <div class="col-lg-3 col-md-6 col-sm-6 col-12 mb-4 d-flex" style="border-left-width: 10px; border-left-color: #6777EF; border-left-style: solid; border-radius: 10px; padding-left: 0;">
                    <a href="{{ url('/manage-users/lecturer/') }}" class="text-decoration-none w-100">
                        <div class="card card-statistic-1 h-100">
                            <div class="card-icon bg-success">
                                <i class="fas fa-chalkboard-teacher"></i>
                            </div>
                            <div class="card-wrap">
                                <div class="card-header">
                                    <h4>LECTURER</h4>
                                </div>
                                <div class="card-body" style="font-size: 20px; font-weight: 800; line-height: 1.2;">
                                    MANAGE <br> LECTURER
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