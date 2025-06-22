@extends('layouts.app')

@section('title', 'Admin Profile')

@push('style')
    <style>
        .card-profile-widget .profile-widget-picture {
            width: 120px;
            height: 120px;
            object-fit: cover;
            flex-shrink: 0;
        }
        .form-group label {
            font-weight: 600;
        }
    </style>
@endpush

@section('main')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Admin Profile</h1>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item active"><a href="{{ url('/dashboard') }}">Dashboard</a></div>
                    <div class="breadcrumb-item">Profile</div>
                </div>
            </div>

            <div class="section-body">
                <h2 class="section-title">Hi, {{ $admin->name }}!</h2>
                <p class="section-lead">
                    You can change your profile information on this page.
                </p>

                @if (session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('success') }}
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                @endif
                @if (session('error'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        {{ session('error') }}
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                @endif

                <div class="row mt-sm-4">
                    <div class="col-12">
                        <div class="card profile-card">
                            <form method="POST" action="{{ route('admin.profile.update') }}" enctype="multipart/form-data">
                                @csrf
                                <div class="card-header">
                                    <h4>Edit Profile</h4>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-lg-3 text-center d-flex flex-column align-items-center">
                                            <div class="mb-3">
                                                <img id="profile-photo-preview"
                                                     src="{{ asset($admin->photo) }}"
                                                     alt="Profile Preview" class="rounded-circle" style="width: 150px; height: 150px; object-fit: cover; border: 2px solid #eee;">
                                            </div>
                                            <label for="profile-photo-input" class="btn btn-primary btn-sm w-75">
                                                <i class="fas fa-upload mr-1"></i> Change Photo
                                            </label>
                                            <input type="file" name="photo" class="d-none" id="profile-photo-input" accept="image/*">
                                             <small class="form-text text-muted mt-2">Max 2MB</small>
                                             @error('photo')
                                                <div class="text-danger mt-1" style="font-size: 12px;">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="col-lg-9">
                                            <div class="row">
                                                <div class="form-group col-md-6 col-12">
                                                    <label>Full Name</label>
                                                    <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name', $admin->name) }}" required>
                                                    @error('name')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                                <div class="form-group col-md-6 col-12">
                                                    <label>NIDN (Lecturer ID)</label>
                                                    <input type="text" name="nidn" class="form-control @error('nidn') is-invalid @enderror" value="{{ old('nidn', $admin->user->identity_number) }}" placeholder="Enter NIDN">
                                                    @error('nidn')
                                                         <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="row">
                                                 <div class="form-group col-12">
                                                    <label>Role</label>
                                                    <input type="text" class="form-control" value="{{ ucfirst($user->role) }}" disabled>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-footer text-right">
                                    <button type="submit" class="btn btn-primary"><i class="fas fa-save mr-1"></i> Save Changes</button>
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
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Script for profile photo preview
            const photoInput = document.getElementById('profile-photo-input');
            if (photoInput) {
                photoInput.addEventListener('change', function (e) {
                    const [file] = e.target.files;
                    if (file) {
                        const preview = document.getElementById('profile-photo-preview');
                        preview.src = URL.createObjectURL(file);
                    }
                });
            }

            // Auto-hide alerts after 5 seconds
            setTimeout(function () {
                $('.alert-dismissible').fadeOut('slow');
            }, 5000);
        });
    </script>
@endpush