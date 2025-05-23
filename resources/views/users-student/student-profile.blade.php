@extends('layouts.app')

@section('title', 'Student Profile')

@push('style')
    <!-- CSS Libraries -->
    <link rel="stylesheet" href="{{ asset('library/summernote/dist/summernote-bs4.css') }}">
    <link rel="stylesheet" href="{{ asset('library/bootstrap-social/assets/css/bootstrap.css') }}">
    <style>
        .document-preview {
            border-radius: 5px;
            border: 1px solid #eee;
            padding: 10px;
            margin-bottom: 10px;
        }
        .document-preview img {
            max-height: 150px;
            object-fit: contain;
        }
        .section-title {
            margin-top: 5px; /* Reduced top margin further */
        }
        .profile-widget-picture {
            width: 160px !important; /* Larger profile picture */
            height: 160px !important;
            object-fit: cover;
            margin: 0 auto 15px;
            display: block;
        }
        .profile-widget-header {
            text-align: center;
            padding-top: 20px;
        }
        .profile-widget-name {
            margin-bottom: 15px;
        }
        .profile-widget-items {
            border-top: 1px solid #f2f2f2;
            padding-top: 15px;
            margin-top: 5px;
            margin-bottom: 15px;
        }
        .warning-text {
            color: #f86c6b;
            font-size: 12px;
            margin-top: 5px;
        }
    </style>
@endpush

@section('main')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Student Profile</h1>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item active"><a href="{{ route('student.dashboard') }}">Dashboard</a></div>
                    <div class="breadcrumb-item">Profile</div>
                </div>
            </div>
            <div class="section-body">
                @if (session('success'))
                    <div class="alert alert-success alert-dismissible fade show">
                        {{ session('success') }}
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                @endif

                <h2 class="section-title">Hi, {{ $student->name ?? 'Student' }}!</h2>
                <p class="section-lead">
                    Change information about yourself on this page.
                </p>

                <div class="row mt-sm-4">
                    <div class="col-12 col-md-12 col-lg-5">
                        <div class="card profile-widget">
                            <div class="profile-widget-header">
                                <img alt="profile photo" 
                                    src="{{ $student->photo ? asset($student->photo) : asset('img/avatar/avatar-1.png') }}"
                                    class="rounded-circle profile-widget-picture">
                            </div>
                            
                            <div class="profile-widget-items">
                                <div class="profile-widget-item">
                                    <div class="profile-widget-item-label">NIM</div>
                                    <div class="profile-widget-item-value">{{ $student->nim ?? 'N/A' }}</div>
                                </div>
                                <div class="profile-widget-item">
                                    <div class="profile-widget-item-label">Major</div>
                                    <div class="profile-widget-item-value">{{ $student->major ?? 'N/A' }}</div>
                                </div>
                                <div class="profile-widget-item">
                                    <div class="profile-widget-item-label">Study Program</div>
                                    <div class="profile-widget-item-value">{{ $student->study_program ?? 'N/A' }}</div>
                                </div>
                            </div>
                    
                            <div class="card-footer text-center">
                                <div class="font-weight-bold mb-2">Documents</div>
                                <div class="row justify-content-center">
                                    <div class="col-6">
                                        <a href="{{ $student->ktp_scan ? asset($student->ktp_scan) : '#' }}" 
                                        class="btn btn-outline-primary btn-block {{ !$student->ktp_scan ? 'disabled' : '' }}" 
                                        {{ $student->ktp_scan ? 'target="_blank"' : '' }}>
                                            <i class="fas fa-id-card mr-1"></i> KTP
                                        </a>
                                    </div>
                                    <div class="col-6">
                                        <a href="{{ $student->ktm_scan ? asset($student->ktm_scan) : '#' }}" 
                                        class="btn btn-outline-info btn-block {{ !$student->ktm_scan ? 'disabled' : '' }}"
                                        {{ $student->ktm_scan ? 'target="_blank"' : '' }}>
                                            <i class="fas fa-id-badge mr-1"></i> KTM
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-12 col-md-12 col-lg-7">
                        <div class="card">
                            <form method="POST" action="{{ route('student.profile.update') }}" class="needs-validation" enctype="multipart/form-data" novalidate="">
                                @csrf
                                <div class="card-header">
                                    <h4>Edit Profile</h4>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Student ID</label>
                                                <input type="text" class="form-control readonly-field" value="{{ $student->student_id ?? '-' }}" readonly>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>NIM</label>
                                                <input type="text" class="form-control readonly-field" value="{{ $student->nim ?? '' }}" readonly>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Full Name</label>
                                                <input type="text" name="name" class="form-control readonly-field" value="{{ $student->name ?? '' }}" readonly>
                                                <input type="hidden" name="name" value="{{ $student->name ?? '' }}">
                                                @error('name')
                                                    <div class="text-danger">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Phone Number</label>
                                                <input type="tel" class="form-control readonly-field" value="{{ $student->user->phone_number ?? '' }}" readonly>
                                                <input type="hidden" name="phone_number" value="{{ $student->user->phone_number ?? '' }}">
                                                @error('phone_number')
                                                    <div class="text-danger">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Major</label>
                                                <input type="text" name="major" class="form-control" value="{{ $student->major ?? '' }}" required>
                                                @error('major')
                                                    <div class="text-danger">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Study Program</label>
                                                <input type="text" name="study_program" class="form-control" value="{{ $student->study_program ?? '' }}" required>
                                                @error('study_program')
                                                    <div class="text-danger">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Home Address</label>
                                                <textarea name="home_address" class="form-control" required>{{ $student->home_address ?? '' }}</textarea>
                                                @error('home_address')
                                                    <div class="text-danger">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Current Address</label>
                                                <textarea name="current_address" class="form-control" required>{{ $student->current_address ?? '' }}</textarea>
                                                @error('current_address')
                                                    <div class="text-danger">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="form-group">
                                        <label>Profile Photo</label>
                                        <input type="file" name="photo" class="form-control-file" id="profile-photo-input" {{ $student->photo ? 'disabled' : '' }}>
                                        @if($student->photo)
                                            <div class="warning-text">
                                                <i class="fas fa-exclamation-triangle"></i> Profile photo cannot be changed once uploaded.
                                            </div>
                                        @else
                                            <div class="warning-text">
                                                <i class="fas fa-exclamation-triangle"></i> Please upload your profile photo carefully. It cannot be changed later.
                                            </div>
                                        @endif
                                        
                                        @if($student && $student->photo)
                                            <div class="document-preview mt-2">
                                                <img src="{{ asset($student->photo) }}" alt="Profile" class="img-fluid" id="profile-photo-preview">
                                            </div>
                                        @else
                                            <div class="document-preview mt-2" id="profile-photo-container" style="display:none">
                                                <img src="" alt="Profile" class="img-fluid" id="profile-photo-preview">
                                            </div>
                                        @endif
                                        @error('photo')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    
                                    <div class="row">
                                    <div class="col-md-6">
                                            <div class="form-group">
                                                <label>KTP Scan (ID Card)</label>
                                                <input type="file" name="ktp_scan" class="form-control-file" id="ktp-scan-input" {{ $student->ktp_scan ? 'disabled' : '' }}>
                                                @if($student->ktp_scan)
                                                    <div class="warning-text">
                                                        <i class="fas fa-exclamation-triangle"></i> KTP document cannot be changed once uploaded.
                                                    </div>
                                                    <div class="mt-2">
                                                        <a href="{{ asset($student->ktp_scan) }}" target="_blank" class="btn btn-sm btn-info">View KTP Document</a>
                                                    </div>
                                                @else
                                                    <div class="warning-text">
                                                        <i class="fas fa-exclamation-triangle"></i> Please upload your KTP carefully. It cannot be changed later.
                                                    </div>
                                                    <div class="document-preview mt-2" id="ktp-scan-container" style="display:none"></div>
                                                @endif
                                                @error('ktp_scan')
                                                    <div class="text-danger">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>KTM Scan (Student Card)</label>
                                                <input type="file" name="ktm_scan" class="form-control-file" id="ktm-scan-input" {{ $student->ktm_scan ? 'disabled' : '' }}>
                                                @if($student->ktm_scan)
                                                    <div class="warning-text">
                                                        <i class="fas fa-exclamation-triangle"></i> KTM document cannot be changed once uploaded.
                                                    </div>
                                                    <div class="mt-2">
                                                        <a href="{{ asset($student->ktm_scan) }}" target="_blank" class="btn btn-sm btn-info">View KTM Document</a>
                                                    </div>
                                                @else
                                                    <div class="warning-text">
                                                        <i class="fas fa-exclamation-triangle"></i> Please upload your KTM carefully. It cannot be changed later.
                                                    </div>
                                                    <div class="document-preview mt-2" id="ktm-scan-container" style="display:none"></div>
                                                @endif
                                                @error('ktm_scan')
                                                    <div class="text-danger">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                </div>  
                                </div>
                                <div class="card-footer text-right">
                                    <button type="submit" class="btn btn-primary">Save Changes</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection

@push('scripts')
    <!-- JS Libraries -->
    <script src="{{ asset('library/summernote/dist/summernote-bs4.js') }}"></script>

    <!-- Page Specific JS File -->
    <script>
        // For profile photo preview
        document.getElementById('profile-photo-input')?.addEventListener('change', function(e) {
            const [file] = e.target.files;
            if (file && file.type.match('image.*')) {
                const reader = new FileReader();
                reader.onload = function(evt) {
                    const preview = document.getElementById('profile-photo-preview');
                    const container = document.getElementById('profile-photo-container');
                    
                    if (preview) {
                        preview.src = evt.target.result;
                        if (container) container.style.display = 'block';
                    }
                };
                reader.readAsDataURL(file);
            }
        });
        
        // For KTP scan preview
        document.getElementById('ktp-scan-input')?.addEventListener('change', function(e) {
            const [file] = e.target.files;
            if (file && file.type.match('image.*')) {
                const reader = new FileReader();
                reader.onload = function(evt) {
                    const preview = document.getElementById('ktp-scan-preview');
                    const container = document.getElementById('ktp-scan-container');
                    
                    if (preview) {
                        preview.src = evt.target.result;
                        if (container) container.style.display = 'block';
                    }
                };
                reader.readAsDataURL(file);
            }
        });
        
        // For KTM scan preview
        document.getElementById('ktm-scan-input')?.addEventListener('change', function(e) {
            const [file] = e.target.files;
            if (file && file.type.match('image.*')) {
                const reader = new FileReader();
                reader.onload = function(evt) {
                    const preview = document.getElementById('ktm-scan-preview');
                    const container = document.getElementById('ktm-scan-container');
                    
                    if (preview) {
                        preview.src = evt.target.result;
                        if (container) container.style.display = 'block';
                    }
                };
                reader.readAsDataURL(file);
            }
        });
        
        // Auto-hide alerts after 5 seconds
        setTimeout(function() {
            $('.alert').fadeOut('slow');
        }, 5000);
    </script>
@endpush