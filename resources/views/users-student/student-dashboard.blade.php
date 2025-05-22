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
            <!-- Data Completeness Alert -->
            <div class="row mb-2" style="margin-bottom:8px !important;">
                <div class="col-12">
                    @if(isset($isComplete) && !$isComplete)
                        <div class="alert d-flex align-items-center justify-content-between" style="background:#fff7f6; border-left:3px solid #ff6b6b; border-radius:6px; padding:6px 12px; margin-bottom:4px;">
                            <div class="d-flex align-items-center" style="gap:8px;">
                                <span style="font-size:16px; color:#ff6b6b;">
                                    <i class="fas fa-times-circle"></i>
                                </span>
                                <div>
                                    <strong class="text-danger" style="font-size:14px;">Your documents are incomplete!</strong>
                                    <span class="text-muted ml-2" style="font-size:12px;">Please complete the following documents:</span>
                                    <ul class="mb-0 mt-1" style="text-align:left; font-size:12px;">
                                        @foreach($missingFiles ?? ['ID Card', 'Photo', 'Marriage Certificate'] as $file)
                                            <li>{{ $file }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                            <div class="d-flex align-items-center" style="gap:6px;">
                                <a href="{{ route('profile') }}" class="btn btn-outline-danger btn-sm" style="font-size:12px; padding:2px 10px;">Complete Now</a>
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close" style="font-size:16px;">&times;</button>
                            </div>
                        </div>
                    @else
                        <div class="alert d-flex align-items-center justify-content-between" style="background:#f6fff7; border-left:3px solid #51cf66; border-radius:6px; padding:6px 12px; margin-bottom:4px;">
                            <div class="d-flex align-items-center" style="gap:8px;">
                                <span style="font-size:16px; color:#51cf66;">
                                    <i class="fas fa-check-circle"></i>
                                </span>
                                <div>
                                    <strong class="text-success" style="font-size:14px;">Your documents are complete!</strong>
                                    <span class="text-muted ml-2" style="font-size:12px;">Thank you for completing your data.</span>
                                </div>
                            </div>
                            <div class="d-flex align-items-center" style="gap:6px;">
                                <a href="{{ route('profile') }}" class="btn btn-outline-success btn-sm" style="font-size:12px; padding:2px 10px;">View Profile</a>
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close" style="font-size:16px;">&times;</button>
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
                                            {{-- Example random date, replace with $schedule->exam_date if available --}}
                                            {{ $schedule->exam_date ?? \Carbon\Carbon::parse($schedule->exam_time)->format('Y-m-d') }}
                                        </td>
                                        <td style="font-size:13px;">
                                            {{-- Example time, replace with $schedule->exam_time if available --}}
                                            {{ \Carbon\Carbon::parse($schedule->exam_time)->format('H:i') }}
                                        </td>
                                        <td>
                                            <a href="{{ $schedule->zoom_link }}" target="_blank" class="btn btn-primary btn-sm" style="font-size:12px; padding:2px 10px;">Join Zoom</a>
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
                                                <a href="{{ asset($examResults->certificate_url) }}" target="_blank" class="btn btn-info btn-sm" style="font-size:12px; padding:2px 10px;">Download</a>
                                            @else
                                                -
                                            @endif
                                        </td>
                                    </tr>
                                    @else
                                    <tr>
                                        <td colspan="2" class="text-center" style="font-size:13px;">No exam score available.</td>
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