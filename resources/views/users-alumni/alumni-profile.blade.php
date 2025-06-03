@extends('layouts.app')

@section('title', 'Alumni Profile')

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

        /* Reduce space between breadcrumb and content */
        .section-header {
            margin-bottom: 0 !important;
        }
        
        .section-body {
            padding-top: 0 !important;
        }
        
        .section-title {
            margin-top: 0;
            margin-bottom: 10px;
        }
        
        /* End of spacing adjustment */

        .profile-widget-picture {
            width: 160px !important;
            /* Larger profile picture */
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
                <h1>Alumni Profile</h1>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item active"><a href="{{ route('alumni.dashboard') }}">Dashboard</a></div>
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

                <h2 class="section-title">Hi, {{ $alumni->name ?? 'Alumni' }}!</h2>
                <p class="section-lead">
                    Change information about yourself on this page.
                </p>

                <div class="row mt-sm-4">
                    <div class="col-12 col-md-12 col-lg-5">
                        <div class="card profile-widget">
                            <div class="profile-widget-header">
                                <img alt="profile photo"
                                    src="{{ $alumni->photo ? asset($alumni->photo) : asset('img/avatar/avatar-1.png') }}"
                                    class="rounded-circle profile-widget-picture">
                            </div>

                            <div class="profile-widget-items">
                                <div class="profile-widget-item">
                                    <div class="profile-widget-item-label">NIK</div>
                                    <div class="profile-widget-item-value">{{ $alumni->nik ?? 'N/A' }}</div>
                                </div>
                            </div>

                            <div class="card-footer text-center">
                                <div class="font-weight-bold mb-2">Documents</div>
                                <div class="row justify-content-center">
                                    <div class="col-6">
                                        <a href="{{ $alumni->ktp_scan ? asset($alumni->ktp_scan) : '#' }}"
                                            class="btn btn-outline-primary btn-block {{ !$alumni->ktp_scan ? 'disabled' : '' }}"
                                            {{ $alumni->ktp_scan ? 'target="_blank"' : '' }}>
                                            <i class="fas fa-id-card mr-1"></i> KTP
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-12 col-md-12 col-lg-7">
                        <div class="card">
                            <form method="POST" action="{{ route('alumni.profile.update') }}" class="needs-validation"
                                enctype="multipart/form-data" novalidate="">
                                @csrf
                                <div class="card-header">
                                    <h4>Edit Profile</h4>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Alumni ID</label>
                                                <input type="text" class="form-control readonly-field"
                                                    value="{{ $alumni->alumni_id ?? '-' }}" readonly>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>NIK</label>
                                                <input type="text" class="form-control readonly-field"
                                                    value="{{ $alumni->nik ?? '' }}" readonly>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Full Name</label>
                                                <input type="text" name="name" class="form-control readonly-field"
                                                    value="{{ $alumni->name ?? '' }}" readonly>
                                                <input type="hidden" name="name" value="{{ $alumni->name ?? '' }}">
                                                @error('name')
                                                    <div class="text-danger">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Phone Number</label>
                                                <input type="tel" name="phone_number" class="form-control"
                                                    value="{{ $alumni->user->phone_number ?? '' }}" required>
                                                @error('phone_number')
                                                    <div class="text-danger">{{ $message }}</div>
                                                @enderror
                                                <small class="text-muted">Please enter your active phone number</small>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Home Address</label>
                                                <textarea name="home_address" class="form-control"
                                                    required>{{ $alumni->home_address ?? '' }}</textarea>
                                                @error('home_address')
                                                    <div class="text-danger">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Current Address</label>
                                                <textarea name="current_address" class="form-control"
                                                    required>{{ $alumni->current_address ?? '' }}</textarea>
                                                @error('current_address')
                                                    <div class="text-danger">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label>Profile Photo</label>
                                        <input type="file" name="photo" class="form-control-file" id="profile-photo-input"
                                            {{ $alumni->photo ? 'disabled' : '' }}>
                                        @if($alumni->photo)
                                            <div class="warning-text">
                                                <i class="fas fa-exclamation-triangle"></i> Profile photo cannot be changed
                                                once
                                                uploaded.
                                            </div>
                                        @else
                                            <div class="warning-text">
                                                <i class="fas fa-exclamation-triangle"></i> Please upload your profile photo
                                                carefully. It cannot be changed later.
                                            </div>
                                        @endif

                                        @if($alumni && $alumni->photo)
                                            <div class="document-preview mt-2">
                                                <img src="{{ asset($alumni->photo) }}" alt="Profile" class="img-fluid"
                                                    id="profile-photo-preview">
                                            </div>
                                        @else
                                            <div class="document-preview mt-2" id="profile-photo-container"
                                                style="display:none">
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
                                                <input type="file" name="ktp_scan" class="form-control-file"
                                                    accept="image/*" id="ktp-scan-input" {{ $alumni->ktp_scan ? 'disabled' : '' }}>
                                                @if($alumni->ktp_scan)
                                                    <div class="warning-text">
                                                        <i class="fas fa-exclamation-triangle"></i> KTP document cannot be
                                                        changed once uploaded.
                                                    </div>
                                                    <div class="mt-2">
                                                        <a href="{{ asset($alumni->ktp_scan) }}" target="_blank"
                                                            class="btn btn-sm btn-info">View KTP Document</a>
                                                    </div>
                                                @else
                                                    <div class="warning-text">
                                                        <i class="fas fa-exclamation-triangle"></i> Please upload your KTP
                                                        carefully. It cannot be changed later.
                                                    </div>
                                                    <div class="document-preview mt-2" id="ktp-scan-container"
                                                        style="display:none">
                                                        <img src="" alt="KTP Preview" class="img-fluid" id="ktp-scan-preview">
                                                    </div>
                                                @endif
                                                @error('ktp_scan')
                                                    <div class="text-danger">{{ $message }}</div>
                                                @enderror
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
        document.getElementById('profile-photo-input')?.addEventListener('change', function (e) {
            const [file] = e.target.files;
            if (file && file.type.match('image.*')) {
                const reader = new FileReader();
                reader.onload = function (evt) {
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
        document.getElementById('ktp-scan-input')?.addEventListener('change', function (e) {
            const [file] = e.target.files;
            if (file && file.type.match('image.*')) {
                const reader = new FileReader();
                reader.onload = function (evt) {
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

        // Auto-hide alerts after 5 seconds
        setTimeout(function () {
            $('.alert').fadeOut('slow');
        }, 5000);
    </script>
@endpush