@extends('layouts.app')

@section('title', 'Admin Profile')

@push('style')
    <!-- CSS Libraries -->
    <link rel="stylesheet" href="{{ asset('library/summernote/dist/summernote-bs4.css') }}">
    <link rel="stylesheet" href="{{ asset('library/bootstrap-social/assets/css/bootstrap.css') }}">
    <style>
        /* Clean layout fixes */
        .main-content {
            padding: 20px;
        }

        .section {
            margin: 0;
            padding: 0;
        }

        .section-header {
            margin-bottom: 20px;
            padding-bottom: 0;
        }

        .section-body {
            margin: 0;
            padding: 0;
        }

        .section-title {
            margin: 0 0 20px 0;
            font-size: 1.5rem;
            font-weight: 600;
        }

        .admin-profile-card {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border: none;
            border-radius: 15px;
            color: white;
            margin-bottom: 20px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        }

        .profile-avatar {
            width: 100px;
            height: 100px;
            border: 3px solid rgba(255, 255, 255, 0.3);
            border-radius: 50%;
            object-fit: cover;
            margin: 0 auto 15px;
        }

        .admin-badge {
            background: rgba(255, 255, 255, 0.2);
            border: 1px solid rgba(255, 255, 255, 0.3);
            border-radius: 20px;
            padding: 5px 15px;
            font-size: 12px;
            font-weight: 600;
            display: inline-block;
            margin-top: 10px;
        }

        .edit-form-card {
            border: none;
            border-radius: 15px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-group label {
            font-weight: 600;
            color: #495057;
            margin-bottom: 8px;
            display: block;
        }

        .form-control {
            border-radius: 8px;
            border: 1px solid #e9ecef;
            padding: 10px 15px;
            font-size: 14px;
            transition: border-color 0.3s ease;
        }

        .form-control:focus {
            border-color: #667eea;
            box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.15);
        }

        .readonly-field {
            background-color: #f8f9fa;
            border-color: #dee2e6;
        }

        .photo-upload-section {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border-radius: 10px;
            padding: 20px;
            color: white;
            text-align: center;
        }

        .photo-preview {
            max-width: 150px;
            max-height: 150px;
            border-radius: 10px;
            object-fit: cover;
            border: 2px solid rgba(255, 255, 255, 0.3);
            margin-bottom: 15px;
        }

        .upload-btn {
            background: rgba(255, 255, 255, 0.2);
            border: 1px solid rgba(255, 255, 255, 0.3);
            border-radius: 25px;
            color: white;
            padding: 8px 20px;
            font-size: 14px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .upload-btn:hover {
            background: rgba(255, 255, 255, 0.3);
            color: white;
        }

        .save-btn {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border: none;
            border-radius: 25px;
            padding: 10px 30px;
            font-weight: 600;
            color: white;
            font-size: 14px;
            transition: all 0.3s ease;
        }

        .save-btn:hover {
            box-shadow: 0 4px 15px rgba(102, 126, 234, 0.3);
            color: white;
        }

        .stat-card {
            background: linear-gradient(135deg, #ffecd2 0%, #fcb69f 100%);
            border-radius: 10px;
            padding: 15px;
            text-align: center;
            border: none;
            margin-bottom: 20px;
        }

        .stat-number {
            font-size: 1.5rem;
            font-weight: 700;
            color: #d35400;
        }

        .stat-label {
            color: #8e44ad;
            font-weight: 600;
            font-size: 14px;
        }

        /* Photo Display Section for uploaded photos */
        .photo-display-section {
            background: linear-gradient(135deg, #a8e6cf 0%, #88d8a3 100%);
            border-radius: 10px;
            padding: 20px;
            text-align: center;
        }

        .current-photo {
            max-width: 150px;
            max-height: 150px;
            border-radius: 10px;
            object-fit: cover;
            border: 2px solid rgba(255, 255, 255, 0.5);
            margin-bottom: 15px;
        }

        .status-badge {
            background: rgba(255, 255, 255, 0.9);
            border-radius: 20px;
            padding: 5px 15px;
            margin: 10px 0;
            display: inline-block;
            font-weight: 600;
            color: #27ae60;
            font-size: 12px;
        }

        .status-text {
            color: #2c3e50;
            margin: 10px 0 0 0;
            line-height: 1.5;
            font-size: 14px;
        }

        .upload-info {
            background: rgba(255, 255, 255, 0.1);
            border-radius: 8px;
            padding: 10px;
            margin-top: 10px;
        }

        /* Enhanced form styling */
        .form-group label {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 8px;
        }

        .badge {
            font-size: 0.75rem;
            padding: 4px 8px;
        }

        .card-header {
            border-bottom: 1px solid #e9ecef;
            padding: 15px 20px;
        }

        .card-body {
            padding: 20px;
        }

        .card-footer {
            border-top: 1px solid #e9ecef;
            padding: 15px 20px;
        }

        /* Loading state */
        .loading-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            display: none;
            justify-content: center;
            align-items: center;
            z-index: 9999;
        }

        .loading-spinner {
            background: white;
            padding: 30px;
            border-radius: 15px;
            text-align: center;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3);
        }

        .spinner {
            border: 4px solid #f3f3f3;
            border-top: 4px solid #667eea;
            border-radius: 50%;
            width: 40px;
            height: 40px;
            animation: spin 1s linear infinite;
            margin: 0 auto 15px;
        }

        @keyframes spin {
            0% {
                transform: rotate(0deg);
            }

            100% {
                transform: rotate(360deg);
            }
        }
    </style>
@endpush

@section('main')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <div class="d-flex align-items-center">
                    <div>
                        <h1>Admin Profile</h1>
                    </div>
                </div>
            </div>

            <div class="section-body">
                @if (session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <strong><i class="fas fa-check-circle"></i> Success!</strong> {{ session('success') }}
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                @endif

                @if (session('error'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <strong><i class="fas fa-exclamation-triangle"></i> Error!</strong> {{ session('error') }}
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                @endif

                @if (isset($message))
                    <div class="alert alert-warning">{{ $message }}</div>
                @else
                    <div class="mb-1">
                        <h2 class="section-title">Welcome back, {{ $admin->name }}!</h2>
                        <p class="text-muted mb-4 ">Manage your admin profile and account settings</p>
                    </div>

                    <div class="row">
                        <!-- Profile Info Card -->
                        <div class="col-12 col-lg-4 mb-4">
                            <div class="card admin-profile-card">
                                <div class="card-body text-center">
                                    <img src="{{ $admin->photo && !str_contains($admin->photo, 'img/avatar/') ? asset('storage/' . $admin->photo) : asset($admin->photo) }}"
                                        alt="Admin Photo" class="profile-avatar">
                                    <div class="admin-info">
                                        <h4 class="mb-2">{{ $admin->name }}</h4>
                                        <div class="admin-badge">
                                            <i class="fas fa-crown mr-1"></i> System Administrator
                                        </div>
                                        <p class="mt-3 mb-0" style="opacity: 0.9; font-size: 14px;">
                                            Full access and control over the SIMTOEIC platform
                                        </p>
                                    </div>
                                </div>
                            </div>

                            <!-- Quick Stats -->
                            <div class="stat-card">
                                <div class="stat-number">{{ $admin->admin_id ?? 'N/A' }}</div>
                                <div class="stat-label">Admin ID</div>
                            </div>
                        </div>

                        <!-- Edit Form Card -->
                        <div class="col-12 col-lg-8 mb-4">
                            <div class="card edit-form-card">
                                <form method="POST" action="{{ route('admin.profile.update') }}" enctype="multipart/form-data">
                                    @csrf
                                    <div class="card-header">
                                        <h5 class="mb-0">
                                            <i class="fas fa-edit mr-2"></i>Edit Profile Information
                                        </h5>
                                    </div>

                                    <div class="card-body">
                                        <div class="row">
                                            <!-- Admin ID (Read-only) -->
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>
                                                        <span><i class="fas fa-id-badge mr-2"></i>Admin ID</span>
                                                    </label>
                                                    <input type="text" class="form-control readonly-field"
                                                        value="{{ $admin->admin_id ?? 'Auto-generated' }}" readonly>
                                                </div>
                                            </div>

                                            <!-- Name -->
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>
                                                        <span><i class="fas fa-user mr-2"></i>Full Name</span>
                                                    </label>
                                                    <input type="text" name="name" class="form-control"
                                                        value="{{ $admin->name }}" required>
                                                    @error('name')
                                                        <div class="text-danger mt-1">
                                                            <i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}
                                                        </div>
                                                    @enderror
                                                </div>
                                            </div>

                                            <!-- NIDN -->
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>
                                                        <span><i class="fas fa-id-card mr-2"></i>NIDN (Lecturer ID)</span>
                                                    </label>
                                                    <input type="text" name="nidn" class="form-control"
                                                        value="{{ $admin->user->identity_number ?? '' }}"
                                                        placeholder="Enter your NIDN">
                                                    @error('nidn')
                                                        <div class="text-danger mt-1">
                                                            <i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}
                                                        </div>
                                                    @enderror
                                                    <small class="text-muted">
                                                        <i class="fas fa-info-circle mr-1"></i>National Lecturer ID Number
                                                    </small>
                                                </div>
                                            </div>

                                            <!-- Profile Photo Upload -->
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>
                                                        <span><i class="fas fa-camera mr-2"></i>Profile Photo</span>
                                                        @if($hasCustomPhoto)
                                                            <span class="badge badge-success">
                                                                <i class="fas fa-check"></i> Uploaded
                                                            </span>
                                                        @else
                                                            <span class="badge badge-warning">
                                                                <i class="fas fa-clock"></i> Not Set
                                                            </span>
                                                        @endif
                                                    </label>

                                                    @if($hasCustomPhoto)
                                                        <!-- Photo already uploaded - show current photo -->
                                                        <div class="photo-display-section">
                                                            <div class="current-photo-container">
                                                                <img src="{{ asset('storage/' . $admin->photo) }}"
                                                                    alt="Current Profile Photo" class="current-photo mb-3">
                                                                <div class="photo-status">
                                                                    <div class="status-badge success">
                                                                        <i class="fas fa-check-circle mr-2"></i>
                                                                        Photo Successfully Set
                                                                    </div>
                                                                    <p class="status-text">
                                                                        Your profile photo has been uploaded and is now active
                                                                        across the system.
                                                                        <br><small class="text-muted">
                                                                            <i class="fas fa-info-circle mr-1"></i>
                                                                            For security reasons, profile photos can only be set
                                                                            once.
                                                                        </small>
                                                                    </p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    @else
                                                        <!-- Photo upload section -->
                                                        <div class="photo-upload-section">
                                                            <div style="position: relative; z-index: 2;">
                                                                <img id="profile-photo-preview" src="{{ asset($admin->photo) }}"
                                                                    alt="Profile Preview" class="photo-preview mb-3">
                                                                <br>
                                                                <label for="profile-photo-input" class="upload-btn mb-0">
                                                                    <i class="fas fa-upload mr-2"></i>Choose Profile Photo
                                                                </label>
                                                                <input type="file" name="photo" class="d-none"
                                                                    id="profile-photo-input" accept="image/*" required>
                                                                <div class="upload-info mt-3">
                                                                    <small class="text-white">
                                                                        <i class="fas fa-exclamation-triangle mr-1"></i>
                                                                        <strong>Important:</strong> You can only upload your profile
                                                                        photo once!
                                                                    </small>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        @error('photo')
                                                            <div class="text-danger mt-2">
                                                                <i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}
                                                            </div>
                                                        @enderror
                                                        <small class="text-muted mt-2 d-block">
                                                            <i class="fas fa-info-circle mr-1"></i>JPG, PNG, GIF max 2MB. Choose
                                                            carefully as this cannot be changed later.
                                                        </small>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Submit Button Section -->
                                        <div class="row mt-4">
                                            <div class="col-12">
                                                <div class="text-right">
                                                    @if($hasCustomPhoto)
                                                        <button type="submit" class="save-btn">
                                                            <i class="fas fa-save mr-2"></i>Update Information
                                                        </button>
                                                        <div class="mt-2">
                                                            <small class="text-muted">
                                                                <i class="fas fa-info-circle mr-1"></i>
                                                                Only name and NIDN can be updated
                                                            </small>
                                                        </div>
                                                    @else
                                                        <button type="submit" class="save-btn">
                                                            <i class="fas fa-save mr-2"></i>Save Profile & Upload Photo
                                                        </button>
                                                        <div class="mt-2">
                                                            <small class="text-muted">
                                                                <i class="fas fa-exclamation-triangle mr-1"></i>
                                                                Remember: Photo upload is permanent and cannot be changed
                                                            </small>
                                                        </div>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </section>
    </div>

    <!-- Loading Overlay -->
    <div class="loading-overlay" id="loadingOverlay">
        <div class="loading-spinner">
            <div class="spinner"></div>
            <h5>Updating Profile...</h5>
            <p class="text-muted">Please wait while we save your changes.</p>
        </div>
    </div>
@endsection

@push('scripts')
    <!-- JS Libraries -->
    <script src="{{ asset('library/summernote/dist/summernote-bs4.js') }}"></script>
    <script>
        // Initialize page
        document.addEventListener('DOMContentLoaded', function () {
            console.log('Admin profile page loaded');
        });

        // Profile photo preview with confirmation
        document.getElementById('profile-photo-input')?.addEventListener('change', function (e) {
            const [file] = e.target.files;
            if (file && file.type.match('image.*')) {
                // Show confirmation dialog
                const confirmed = confirm(
                    'Are you sure you want to upload this photo?\n\n' +
                    'Important: Once uploaded, you cannot change your profile photo again.\n' +
                    'Please make sure this is the photo you want to use permanently.'
                );

                if (!confirmed) {
                    // Reset file input
                    this.value = '';
                    return;
                }

                const reader = new FileReader();
                reader.onload = function (evt) {
                    const preview = document.getElementById('profile-photo-preview');
                    if (preview) {
                        preview.src = evt.target.result;

                        // Add a subtle animation
                        preview.style.transform = 'scale(0.9)';
                        setTimeout(() => {
                            preview.style.transform = 'scale(1)';
                        }, 150);

                        // Show upload info
                        const uploadInfo = document.querySelector('.upload-info');
                        if (uploadInfo) {
                            uploadInfo.innerHTML = `
                                                                                                                <small class="text-white">
                                                                                                                    <i class="fas fa-check mr-1"></i>
                                                                                                                    <strong>Photo Selected!</strong> Click "Save Changes" to upload permanently.
                                                                                                                </small>
                                                                                                            `;
                            uploadInfo.style.background = 'rgba(46, 204, 113, 0.3)';
                        }
                    }
                };
                reader.readAsDataURL(file);
            }
        });

        // Simple form enhancements
        document.querySelectorAll('.form-control').forEach(input => {
            input.addEventListener('focus', function () {
                this.style.borderColor = '#667eea';
            });

            input.addEventListener('blur', function () {
                this.style.borderColor = '#e9ecef';
            });
        });

        // Form submission with loading state
        document.querySelector('form')?.addEventListener('submit', function (e) {
            const photoInput = document.getElementById('profile-photo-input');
            const hasCustomPhoto = {{ $hasCustomPhoto ? 'true' : 'false' }};

            // If trying to upload photo when already has one
            if (!hasCustomPhoto && photoInput && photoInput.files.length > 0) {
                const finalConfirm = confirm(
                    'FINAL CONFIRMATION\n\n' +
                    'You are about to upload your profile photo.\n' +
                    'This action CANNOT be undone or changed later.\n\n' +
                    'Are you absolutely sure you want to proceed?'
                );

                if (!finalConfirm) {
                    e.preventDefault();
                    return false;
                }
            }

            // Show loading overlay
            const loadingOverlay = document.getElementById('loadingOverlay');
            if (loadingOverlay) {
                loadingOverlay.style.display = 'flex';
            }

            // Disable submit button
            const submitBtn = document.querySelector('.save-btn');
            if (submitBtn) {
                submitBtn.disabled = true;
                submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Saving...';
            }
        });

        // Auto-hide alerts after 5 seconds
        setTimeout(function () {
            $('.alert').fadeOut('slow');
        }, 5000);
    </script>
@endpush