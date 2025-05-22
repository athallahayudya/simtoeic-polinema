@extends('layouts.app')

@section('title', 'Student Dashboard')

@push('style')
    <link rel="stylesheet" href="{{ asset('assets/modules/chartjs/Chart.min.css') }}">
@endpush

@section('main')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Dashboard</h1>
            </div>

            <div class="section-body">
                <!-- Profile Completeness Alert -->
                <div class="row mb-3">
                    <div class="col-12">
                        @if(isset($isComplete) && !$isComplete)
                            <div class="card border-left-warning shadow h-100 py-2" style="border-left: 4px solid #f6c23e;">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col-auto mr-3">
                                            <i class="fas fa-user-edit fa-2x text-warning"></i>
                                        </div>
                                        <div class="col">
                                            <div class="h5 mb-1 font-weight-bold text-warning">Complete Your Profile</div>

                                            @if(isset($missingFiles) && count($missingFiles) > 0)
                                                @php
                                                    $totalItems = count($missingFiles) + 1;
                                                    $completedItems = 1;
                                                    $percentage = round(($completedItems / $totalItems) * 100);
                                                @endphp

                                                <div class="d-flex justify-content-between align-items-center mb-1">
                                                    <span>Completion Status</span>
                                                    <span class="badge badge-warning">{{ $percentage }}%</span>
                                                </div>

                                                <div class="progress mb-2" style="height: 10px;">
                                                    <div class="progress-bar bg-warning" role="progressbar"
                                                        style="width: {{ $percentage }}%" aria-valuenow="{{ $percentage }}"
                                                        aria-valuemin="0" aria-valuemax="100"></div>
                                                </div>

                                                <p class="mb-1">Missing items:</p>
                                                <div class="row mb-3">
                                                    @foreach($missingFiles as $item)
                                                        <div class="col-md-6 col-lg-4 mb-1">
                                                            <div class="d-flex align-items-center">
                                                                <i class="fas fa-times-circle text-danger mr-2"></i>
                                                                <span>{{ $item }}</span>
                                                            </div>
                                                        </div>
                                                    @endforeach
                                                </div>
                                            @endif

                                            <a href="{{ route('profile') }}" class="btn btn-warning">
                                                <i class="fas fa-arrow-right mr-1"></i> Complete Profile Now
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @else
                            <div class="card border-left-success shadow h-100 py-2" style="border-left: 4px solid #1cc88a;">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col-auto mr-3">
                                            <i class="fas fa-check-circle fa-2x text-success"></i>
                                        </div>
                                        <div class="col">
                                            <div class="h5 mb-1 font-weight-bold text-success">Your Profile is Complete!</div>

                                            <div class="d-flex justify-content-between align-items-center mb-1">
                                                <span>Completion Status</span>
                                                <span class="badge badge-success">100%</span>
                                            </div>

                                            <div class="progress mb-3" style="height: 10px;">
                                                <div class="progress-bar bg-success" role="progressbar" style="width: 100%"
                                                    aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"></div>
                                            </div>

                                            <p class="mb-3">Thank you for completing your profile data. You are now ready to
                                                register for exams!</p>

                                            <a href="{{ route('profile') }}" class="btn btn-success">
                                                <i class="fas fa-user mr-1"></i> View Profile
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
                <!-- Announcement -->
                <div class="row mb-2" style="margin-bottom:8px !important;">
                    <div class="col-12">
                        <div class="card" style="margin-bottom:4px;">
                            <div class="card-header py-2" style="padding-top:8px; padding-bottom:8px;">
                                <strong style="font-size:15px; font-weight:800;">Announcement</strong>
                            </div>
                            <div class="card-body py-2" style="padding-top:8px; padding-bottom:8px; font-size:13px;">
                                @if ($announcements)
                                    <div>
                                        <h3>{{ $announcements->title }}</h3>
                                        <p>{{ $announcements->content }}</p>
                                        <small>{{ $announcements->created_at->format('d M Y') }}</small>
                                    </div>
                                @else
                                    <p>Tidak ada pengumuman terbaru.</p>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Card Ujian Mandiri: Hanya muncul jika skor ≤ 70 -->
                @if(isset($examResults) && $examResults->score <= 70)
                    <div class="row mt-3">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header">
                                    <h4>Test Information</h4>
                                </div>
                                <div class="card-body">
                                    <p class="text-danger">unfortunately you didnt pass the exam. please do self-exam.</p>
                                    <a href="{{ url('https://itc-indonesia.com/') }}" class="btn btn-warning">Do self</a>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif

                <!-- Exam Schedule & Exam Score -->
                <div class="row" style="margin-bottom:0;">
                    <div class="col-md-6">
                        <div class="card" style="margin-bottom:4px;">
                            <div class="card-header py-2" style="padding-top:8px; padding-bottom:8px;">
                                <strong style="font-size:15px;">Exam Schedule</strong>
                            </div>
                            <div class="card-body py-2" style="padding-top:8px; padding-bottom:8px;">
                                <table class="table table-striped mb-1" style="margin-bottom:4px;">
                                    <thead>
                                        <tr>
                                            <th style="font-size:13px;">#</th>
                                            <th style="font-size:13px;">Date</th>
                                            <th style="font-size:13px;">Time</th>
                                            <th style="font-size:13px;">Zoom Link</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($schedules as $i => $schedule)
                                            <tr>
                                                <td style="font-size:13px;">{{ $schedules->firstItem() + $i }}</td>
                                                <td style="font-size:13px;">
                                                    {{-- Example random date, replace with $schedule->exam_date if available
                                                    --}}
                                                    {{ $schedule->exam_date ?? \Carbon\Carbon::parse($schedule->exam_time)->format('Y-m-d') }}
                                                </td>
                                                <td style="font-size:13px;">
                                                    {{-- Example time, replace with $schedule->exam_time if available --}}
                                                    {{ \Carbon\Carbon::parse($schedule->exam_time)->format('H:i') }}
                                                </td>
                                                <td>
                                                    <a href="{{ $schedule->zoom_link }}" target="_blank"
                                                        class="btn btn-primary btn-sm"
                                                        style="font-size:12px; padding:2px 10px;">Join Zoom</a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                                {{ $schedules->links() }}
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card" style="margin-bottom:4px;">
                            <div class="card-header py-2" style="padding-top:8px; padding-bottom:8px;">
                                <strong style="font-size:15px;">Exam Score</strong>
                            </div>
                            <div class="card-body py-2" style="padding-top:8px; padding-bottom:8px;">
                                <table class="table table-striped mb-1" style="margin-bottom:4px;">
                                    <thead>
                                        <tr>
                                            <th style="font-size:13px;">Score</th>
                                            <th style="font-size:13px;">Certificate</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if($examResults)
                                            <tr>
                                                <td style="font-size:13px;">{{ $examResults->score }}</td>
                                                <td>
                                                    @if($examResults->certificate_url)
                                                        <a href="{{ asset($examResults->certificate_url) }}" target="_blank"
                                                            class="btn btn-info btn-sm"
                                                            style="font-size:12px; padding:2px 10px;">Download</a>
                                                    @else
                                                        -
                                                    @endif
                                                </td>
                                            </tr>
                                        @else
                                            <tr>
                                                <td colspan="2" class="text-center" style="font-size:13px;">No exam score
                                                    available.</td>
                                            </tr>
                                        @endif
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection

@push('scripts')
    <script src="{{ asset('assets/modules/chartjs/Chart.min.js') }}"></script>
@endpush