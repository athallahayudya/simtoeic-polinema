@extends('layouts.app')

@section('title', 'Admin Profile')

@push('style')
    <!-- CSS Libraries -->
    <link rel="stylesheet" href="{{ asset('library/summernote/dist/summernote-bs4.css') }}">
    <link rel="stylesheet" href="{{ asset('library/bootstrap-social/assets/css/bootstrap.css') }}">
    <style>
        /* Force immediate application of spacing fixes */
        .main-content .section {
            margin-top: 0 !important;
            padding-top: 0 !important;
        }
        
        .main-content .section .section-header {
            margin-bottom: 10px !important;
            padding-bottom: 10px !important;
        }
        
        .main-content .section .section-body {
            margin-top: 0 !important;
            padding-top: 0 !important;
        }
        
        .section-title {
            margin-top: 0 !important;
            margin-bottom: 10px !important;
        }

        /* Override any existing margins */
        .section-header + .section-body {
            margin-top: 0 !important;
        }

        .admin-profile-card {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border: none;
            border-radius: 20px;
            color: white;
            position: relative;
            overflow: hidden;
        }

        .admin-profile-card::before {
            content: '';
            position: absolute;
            top: -50%;
            right: -50%;
            width: 100%;
            height: 100%;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 50%;
            transform: rotate(45deg);
        }

        .profile-avatar {
            width: 120px;
            height: 120px;
            border: 5px solid rgba(255, 255, 255, 0.3);
            border-radius: 50%;
            object-fit: cover;
            transition: transform 0.3s ease;
            position: relative;
            z-index: 2;
        }

        .profile-avatar:hover {
            transform: scale(1.05);
        }

        .admin-info {
            position: relative;
            z-index: 2;
        }

        .admin-badge {
            background: rgba(255, 255, 255, 0.2);
            border: 1px solid rgba(255, 255, 255, 0.3);
            border-radius: 50px;
            padding: 8px 20px;
            font-size: 14px;
            font-weight: 600;
            display: inline-block;
            margin-top: 10px;
        }

        .edit-form-card {
            border: none;
            border-radius: 20px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease;
        }

        .edit-form-card:hover {
            transform: translateY(-5px);
        }

        .form-group label {
            font-weight: 600;
            color: #495057;
            margin-bottom: 8px;
        }

        .form-control {
            border-radius: 12px;
            border: 2px solid #e9ecef;
            padding: 12px 16px;
            transition: all 0.3s ease;
        }

        .form-control:focus {
            border-color: #667eea;
            box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.25);
        }

        .readonly-field {
            background-color: #f8f9fa;
            border-color: #dee2e6;
        }

        .photo-upload-section {
            background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
            border-radius: 15px;
            padding: 20px;
            color: white;
            text-align: center;
            position: relative;
            overflow: hidden;
        }

        .photo-upload-section::before {
            content: '';
            position: absolute;
            top: -50%;
            left: -50%;
            width: 100%;
            height: 100%;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 50%;
        }

        .photo-preview {
            max-width: 200px;
            max-height: 200px;
            border-radius: 15px;
            object-fit: cover;
            border: 3px solid rgba(255, 255, 255, 0.3);
            position: relative;
            z-index: 2;
        }

        .upload-btn {
            background: rgba(255, 255, 255, 0.2);
            border: 2px solid rgba(255, 255, 255, 0.3);
            border-radius: 50px;
            color: white;
            padding: 10px 20px;
            font-weight: 600;
            transition: all 0.3s ease;
            position: relative;
            z-index: 2;
            margin-top: 15px;
        }

        .upload-btn:hover {
            background: rgba(255, 255, 255, 0.3);
            color: white;
            transform: translateY(-2px);
        }

        .save-btn {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border: none;
            border-radius: 50px;
            padding: 12px 40px;
            font-weight: 600;
            color: white;
            transition: all 0.3s ease;
        }

        .save-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 20px rgba(102, 126, 234, 0.3);
            color: white;
        }

        .section-title {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            font-weight: 700;
        }

        .icon-decoration {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border-radius: 50%;
            width: 40px;
            height: 40px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            margin-right: 15px;
        }

        .stat-card {
            background: linear-gradient(135deg, #ffecd2 0%, #fcb69f 100%);
            border-radius: 15px;
            padding: 20px;
            text-align: center;
            border: none;
            margin-bottom: 20px;
        }

        .stat-number {
            font-size: 2rem;
            font-weight: 700;
            color: #d35400;
        }

        .stat-label {
            color: #8e44ad;
            font-weight: 600;
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

                @if (isset($message))
                    <div class="alert alert-warning">{{ $message }}</div>
                @else
                    <h2 class="section-title mb-2">Welcome back, {{ $admin->name }}!</h2>
                    <div class="row">
                        <!-- Profile Info Card -->
                        <div class="col-12 col-lg-4">
                            <div class="card admin-profile-card">
                                <div class="card-body text-center p-4">
                                    <img src="{{ asset($admin->photo) }}" alt="Admin Photo" class="profile-avatar mb-3">
                                    <div class="admin-info">
                                        <h4 class="mb-1">{{ $admin->name }}</h4>
                                        <div class="admin-badge">
                                            <i class="fas fa-crown mr-1"></i> System Administrator
                                        </div>
                                        <p class="mt-3 mb-0" style="opacity: 0.9;">
                                            Full access and control over the SIMTOEIC platform with comprehensive system management capabilities.
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
                        <div class="col-12 col-lg-8">
                            <div class="card edit-form-card">
                                <form method="POST" action="{{ route('admin.profile.update') }}" class="needs-validation"
                                    enctype="multipart/form-data" novalidate="">
                                    @csrf
                                    <div class="card-header bg-transparent">
                                        <h4 class="mb-0">
                                            <i class="fas fa-edit mr-2"></i>Edit Profile Information
                                        </h4>
                                    </div>
                                    
                                    <div class="card-body p-4">
                                        <div class="row">
                                            <!-- Admin ID (Read-only) -->
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>
                                                        <i class="fas fa-id-badge mr-2"></i>Admin ID
                                                    </label>
                                                    <input type="text" class="form-control readonly-field" 
                                                        value="{{ $admin->admin_id ?? 'Auto-generated' }}" readonly>
                                                </div>
                                            </div>

                                            <!-- Name -->
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>
                                                        <i class="fas fa-user mr-2"></i>Full Name
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
                                                        <i class="fas fa-id-card mr-2"></i>NIDN (Lecturer ID)
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
                                                        <i class="fas fa-camera mr-2"></i>Profile Photo
                                                    </label>
                                                    <div class="photo-upload-section">
                                                        <div style="position: relative; z-index: 2;">
                                                            <img id="profile-photo-preview" src="{{ asset($admin->photo) }}"
                                                                alt="Profile Preview" class="photo-preview mb-3">
                                                            <br>
                                                            <label for="profile-photo-input" class="upload-btn mb-0">
                                                                <i class="fas fa-upload mr-2"></i>Choose New Photo
                                                            </label>
                                                            <input type="file" name="photo" class="d-none"
                                                                id="profile-photo-input" accept="image/*">
                                                        </div>
                                                    </div>
                                                    @error('photo')
                                                        <div class="text-danger mt-2">
                                                            <i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}
                                                        </div>
                                                    @enderror
                                                    <small class="text-muted mt-2 d-block">
                                                        <i class="fas fa-info-circle mr-1"></i>JPG, PNG max 2MB
                                                    </small>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="card-footer bg-transparent text-right">
                                        <button type="submit" class="save-btn">
                                            <i class="fas fa-save mr-2"></i>Save Changes
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </section>
    </div>
@endsection

@push('scripts')
    <!-- JS Libraries -->
    <script src="{{ asset('library/summernote/dist/summernote-bs4.js') }}"></script>
    <script>
        // Force layout adjustments on page load
        document.addEventListener('DOMContentLoaded', function() {
            // Apply spacing fixes immediately
            const section = document.querySelector('.main-content .section');
            const sectionHeader = document.querySelector('.section-header');
            const sectionBody = document.querySelector('.section-body');
            const sectionTitle = document.querySelector('.section-title');
            
            if (section) {
                section.style.marginTop = '0';
                section.style.paddingTop = '0';
            }
            
            if (sectionHeader) {
                sectionHeader.style.marginBottom = '10px';
                sectionHeader.style.paddingBottom = '10px';
            }
            
            if (sectionBody) {
                sectionBody.style.marginTop = '0';
                sectionBody.style.paddingTop = '0';
            }
            
            if (sectionTitle) {
                sectionTitle.style.marginTop = '0';
                sectionTitle.style.marginBottom = '10px';
            }
        });

        // Profile photo preview
        document.getElementById('profile-photo-input')?.addEventListener('change', function(e) {
            const [file] = e.target.files;
            if (file && file.type.match('image.*')) {
                const reader = new FileReader();
                reader.onload = function(evt) {
                    const preview = document.getElementById('profile-photo-preview');
                    if (preview) {
                        preview.src = evt.target.result;
                        
                        // Add a subtle animation
                        preview.style.transform = 'scale(0.9)';
                        setTimeout(() => {
                            preview.style.transform = 'scale(1)';
                        }, 150);
                    }
                };
                reader.readAsDataURL(file);
            }
        });

        // Add smooth transitions to form elements
        document.querySelectorAll('.form-control').forEach(input => {
            input.addEventListener('focus', function() {
                this.style.transform = 'translateY(-2px)';
            });
            
            input.addEventListener('blur', function() {
                this.style.transform = 'translateY(0)';
            });
        });

        // Auto-hide alerts after 5 seconds
        setTimeout(function() {
            $('.alert').fadeOut('slow');
        }, 5000);
    </script>
@endpush