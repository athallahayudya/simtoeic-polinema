@extends('layouts.app')

@section('title', 'Exam Registration')

@push('style')
    <style>
        .status-card {
            border-radius: 12px;
            overflow: hidden;
            transition: all 0.3s ease;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.08);
        }

        .status-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.15);
        }

        .card-paid {
            border-left: 5px solid #fc544b;
        }

        .status-header {
            padding: 15px 20px;
            border-bottom: 1px solid #f9f9f9;
        }

        .status-icon {
            height: 65px;
            width: 65px;
            line-height: 65px;
            border-radius: 50%;
            text-align: center;
            font-size: 26px;
            margin-right: 15px;
        }

        .icon-paid {
            background-color: rgba(252, 84, 75, 0.15);
            color: #fc544b;
        }

        .exam-info {
            background-color: #f8f9fa;
            border-radius: 8px;
            padding: 15px;
            margin-bottom: 20px;
        }

        .info-item {
            padding: 8px 0;
            border-bottom: 1px dashed #e9ecef;
        }

        .info-item:last-child {
            border-bottom: none;
        }

        .btn-register {
            padding: 12px 25px;
            font-weight: 600;
            letter-spacing: 0.5px;
        }

        .btn-itc {
            background-color: #3d9cec !important;
            color: white !important;
            border: none !important;
            text-decoration: none !important;
        }

        .btn-itc:hover,
        .btn-itc:focus,
        .btn-itc:active {
            background-color: #2c88d9 !important;
            color: white !important;
            text-decoration: none !important;
            border: none !important;
            box-shadow: 0 4px 8px rgba(60, 156, 236, 0.3) !important;
        }

        .score-badge {
            padding: 8px 15px;
            border-radius: 30px;
            font-weight: 600;
        }

        .score-low {
            background-color: #fc544b;
            color: white;
        }

        .score-high {
            background-color: #47c363;
            color: white;
        }

        .score-none {
            background-color: #6777ef;
            color: white;
        }
    </style>
@endpush

@section('main')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Exam Registration</h1>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item active"><a href="{{ route('alumni.dashboard') }}">Dashboard</a></div>
                    <div class="breadcrumb-item">Exam Registration</div>
                </div>
            </div>

            <div class="section-body">
                <h2 class="section-title">TOEIC Exam Registration</h2>
                <p class="section-lead">Register for your TOEIC exam based on your current status.</p>

                <div class="row">
                    <div class="col-12">
                        @if (session('success'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                <strong>Success!</strong> {{ session('success') }}
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                        @endif

                        @if (session('error'))
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <strong>Error!</strong> {{ session('error') }}
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                        @endif
                    </div>

                    <!-- User Profile Card -->
                    <div class="col-12 col-lg-4 col-md-6">
                        <div class="card card-primary">
                            <div class="card-header">
                                <h4>Your Profile</h4>
                            </div>
                            <div class="card-body">
                                <div class="d-flex align-items-center mb-4">
                                    @if(isset($alumni->photo) && $alumni->photo)
                                        <img src="{{ asset($alumni->photo) }}" alt="Profile"
                                            style="width: 60px; height: 60px; border-radius: 50%; object-fit: cover; box-shadow: 0 2px 5px rgba(0,0,0,0.1);"
                                            class="mr-3">
                                    @else
                                        <div class="avatar-item mr-3 bg-primary text-white"
                                            style="width: 60px; height: 60px; border-radius: 50%; display: flex; align-items: center; justify-content: center; box-shadow: 0 2px 5px rgba(0,0,0,0.1);">
                                            <span style="font-size: 24px;">{{ substr($alumni->name ?? 'U', 0, 1) }}</span>
                                        </div>
                                    @endif
                                    <div>
                                        <h5 class="mb-0">{{ $alumni->name ?? 'User' }}</h5>
                                    </div>
                                </div>
                                <div class="info-item d-flex justify-content-between">
                                    <span>Exam Status</span>
                                    <span class="font-weight-bold">
                                        @if($user->exam_status == 'not_yet')
                                            <span class="badge badge-info">Not Taken</span>
                                        @elseif($user->exam_status == 'fail')
                                            <span class="badge badge-danger">Failed</span>
                                        @elseif($user->exam_status == 'success')
                                            <span class="badge badge-success">Passed</span>
                                        @else
                                            <span class="badge badge-secondary">Unknown</span>
                                        @endif
                                    </span>
                                </div>

                                @if(isset($examResults))
                                    <div class="mt-3 text-center">
                                        <div class="score-badge {{ $examResults->score < 500 ? 'score-low' : 'score-high' }}">
                                            <i
                                                class="fas {{ $examResults->score < 500 ? 'fa-times-circle' : 'fa-check-circle' }} mr-1"></i>
                                            Score: {{ $examResults->score }}
                                        </div>
                                    </div>
                                @else
                                    <div class="mt-3 text-center">
                                        <div class="score-badge score-none">
                                            <i class="fas fa-question-circle mr-1"></i>
                                            No Exam Score Yet
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>

                    <!-- Registration Options -->
                    <div class="col-12 col-lg-8 col-md-6">
                        <!-- Paid Exam Registration Card -->
                        <div class="card status-card card-paid">
                            <div class="status-header d-flex align-items-center">
                                <div class="status-icon icon-paid">
                                    <i class="fas fa-file-invoice-dollar"></i>
                                </div>
                                <div>
                                    <h4>Paid Exam Registration</h4>
                                    <p class="mb-0">
                                        You need to register for a paid examination
                                    </p>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="exam-info">
                                    <h6><i class="fas fa-info-circle mr-2"></i>Exam Information:</h6>
                                    <div class="info-item d-flex justify-content-between">
                                        <span>Status</span>
                                        <span class="badge badge-danger">PAID</span>
                                    </div>
                                    <div class="info-item d-flex justify-content-between">
                                        <span>Provider</span>
                                        <span>ITC Indonesia</span>
                                    </div>
                                    <div class="info-item d-flex justify-content-between">
                                        <span>Cost</span>
                                        <span>Based on Selected Package</span>
                                    </div>
                                    <div class="info-item d-flex justify-content-between">
                                        <span>Payment Methods</span>
                                        <span>Credit Card, Bank Transfer</span>
                                    </div>
                                </div>

                                <div class="alert alert-warning">
                                    <i class="fas fa-exclamation-triangle mr-1"></i>
                                    You will be redirected to ITC Indonesia's website to complete your registration.
                                </div>

                                <div class="text-center mt-3">
                                    <a href="https://itc-indonesia.com/" target="_blank"
                                        class="btn btn-itc btn-lg btn-register">
                                        <i class="fas fa-external-link-alt mr-2"></i> Register at ITC Indonesia
                                    </a>
                                </div>
                            </div>
                        </div>

                        <!-- Exam Guidelines -->
                        <div class="card mt-4">
                            <div class="card-header">
                                <h4><i class="fas fa-clipboard-check mr-2"></i>Exam Guidelines</h4>
                            </div>
                            <div class="card-body">
                                <ul class="list-group">
                                    <li class="list-group-item d-flex align-items-center">
                                        <i class="fas fa-check-circle text-success mr-3"></i>
                                        <div>
                                            <strong>Be prepared</strong>
                                            <p class="mb-0 text-muted">Arrive at least 30 minutes before the exam starts
                                            </p>
                                        </div>
                                    </li>
                                    <li class="list-group-item d-flex align-items-center">
                                        <i class="fas fa-check-circle text-success mr-3"></i>
                                        <div>
                                            <strong>Bring necessary documents</strong>
                                            <p class="mb-0 text-muted">Alumni ID card and registration confirmation</p>
                                        </div>
                                    </li>
                                    <li class="list-group-item d-flex align-items-center">
                                        <i class="fas fa-check-circle text-success mr-3"></i>
                                        <div>
                                            <strong>Follow dress code</strong>
                                            <p class="mb-0 text-muted">Formal or semi-formal attire is required</p>
                                        </div>
                                    </li>
                                    <li class="list-group-item d-flex align-items-center">
                                        <i class="fas fa-check-circle text-success mr-3"></i>
                                        <div>
                                            <strong>No electronic devices</strong>
                                            <p class="mb-0 text-muted">Mobile phones and electronic devices are not
                                                allowed
                                                during the exam</p>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection

@push('scripts')
    <script>
        $(document).ready(function () {
            // Add smooth animations
            $('.status-card').css('opacity', 0).animate({
                opacity: 1
            }, 500);

            // Optional: Add confirmation for registration
            $('form').on('submit', function (e) {
                e.preventDefault();

                Swal.fire({
                    title: 'Confirm Registration',
                    text: "Are you sure you want to register for this exam?",
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, register me!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        this.submit();
                    }
                });
            });
        });
    </script>
@endpush