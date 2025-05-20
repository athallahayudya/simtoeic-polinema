@extends('layouts.app')

@section('title', 'Admin Profile')

@push('style')
    <!-- CSS Libraries -->
    <link rel="stylesheet" href="{{ asset('library/summernote/dist/summernote-bs4.css') }}">
    <link rel="stylesheet" href="{{ asset('library/bootstrap-social/assets/css/bootstrap.css') }}">
@endpush

@section('main')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Admin Profile</h1>
            </div>
            <div class="section-body">
                @if (session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif

                @if (isset($message))
                    <div class="alert alert-warning">{{ $message }}</div>
                @else
                    <h2 class="section-title">Hi, {{ $admin->name }}!</h2>
                    <p class="section-lead">
                        Change information about yourself on this page.
                    </p>

                    <div class="row mt-sm-4">
                        <div class="col-12 col-md-12 col-lg-5">
                            <div class="card profile-widget">
                                <div class="profile-widget-header text-center">
                                    <img alt="image" src="{{ asset($admin->photo) }}"
                                        class="rounded-circle profile-widget-picture"
                                        style="width:120px;height:120px;object-fit:cover;">
                                </div>
                                <div class="profile-widget-description">
                                    <div class="profile-widget-name">{{ $admin->name }}
                                        <div class="text-muted d-inline font-weight-normal">
                                            <div class="slash"></div> Administrator
                                        </div>
                                    </div>
                                    <p>System administrator with full access and control over the SIMTOEIC platform.
                                        <br> A Ph.D. in Educational Technology from Universitas Negeri Malang, a Master’s
                                        degree in Computer Science from Institut Teknologi Bandung,
                                        and a Bachelor’s degree in Information Systems from Universitas Brawijaya.
                                    </p>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-md-12 col-lg-7">
                            <div class="card">
                                <form method="POST" action="{{ route('admin.profile.update') }}" class="needs-validation"
                                    enctype="multipart/form-data" novalidate="">
                                    @csrf
                                    <div class="card-header">
                                        <h4>Edit Profile</h4>
                                    </div>
                                    <div class="card-body">
                                        <div class="form-group">
                                            <label>ID Admin</label>
                                            <input type="text" class="form-control" value="{{ $admin->admin_id ?? '-' }}"
                                                readonly>
                                        </div>
                                        <div class="form-group">
                                            <label>Name</label>
                                            <input type="text" name="name" class="form-control"
                                                value="{{ $admin->name }}" required>
                                            @error('name')
                                                <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                            <div class="invalid-feedback">
                                                Please fill in your name
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label>Phone Number</label>
                                            <input type="text" name="phone_number" class="form-control"
                                                value="{{ $admin->user->phone_number ?? '' }}" required>
                                            @error('phone_number')
                                                <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                            <div class="invalid-feedback">
                                                Please fill in your phone number
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label>NIDN</label>
                                            <input type="text" name="nidn" class="form-control"
                                                value="{{ $admin->nidn }}" required>
                                            @error('nidn')
                                                <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                            <div class="invalid-feedback">
                                                Please fill in your NIDN
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label>Home Address</label>
                                            <input type="text" name="home_address" class="form-control"
                                                value="{{ $admin->home_address }}" required>
                                            @error('home_address')
                                                <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                            <div class="invalid-feedback">
                                                Please fill in your home address
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label>Current Address</label>
                                            <input type="text" name="current_address" class="form-control"
                                                value="{{ $admin->current_address }}" required>
                                            @error('current_address')
                                                <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                            <div class="invalid-feedback">
                                                Please fill in your current address
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <div class="col-md-6">
                                                <label>Profile Photo (JPG/PNG)</label><br>
                                                <img id="profile-photo-preview" src="{{ asset($admin->photo) }}"
                                                    alt="profile" class="mb-3 img-fluid"
                                                    style="max-width:100%;max-height:200px;object-fit:contain;">
                                                <input type="file" name="photo" class="form-control-file"
                                                    id="profile-photo-input">
                                                @error('photo')
                                                    <div class="text-danger">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            <div class="col-md-6">
                                                <label>KTP Scan (PDF/JPG/PNG)</label><br>
                                                @if ($admin->ktp_scan)
                                                    <a href="{{ asset($admin->ktp_scan) }}" target="_blank">View
                                                        KTP</a><br>
                                                    @php
                                                        $ext = strtolower(
                                                            pathinfo($admin->ktp_scan, PATHINFO_EXTENSION),
                                                        );
                                                    @endphp
                                                    @if (in_array($ext, ['jpg', 'jpeg', 'png', 'gif', 'bmp', 'webp']))
                                                        <img id="ktp-scan-preview" src="{{ asset($admin->ktp_scan) }}"
                                                            alt="KTP Scan" class="mt-2 mb-3 img-fluid"
                                                            style="max-width:100%;max-height:200px;object-fit:contain;border-radius:8px;">
                                                    @endif
                                                @endif
                                                <input type="file" name="ktp_scan" class="form-control-file"
                                                    id="ktp-scan-input">
                                                @error('ktp_scan')
                                                    <div class="text-danger">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-footer text-right">
                                        <button class="btn btn-primary">Save Changes</button>
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
        document.getElementById('profile-photo-input')?.addEventListener('change', function(e) {
            const [file] = e.target.files;
            if (file && file.type.match('image.*')) {
                const reader = new FileReader();
                reader.onload = function(evt) {
                    let img = document.getElementById('profile-photo-preview');
                    if (!img) {
                        img = document.createElement('img');
                        img.id = 'profile-photo-preview';
                        img.className = 'mb-3 img-fluid';
                        img.style.maxWidth = '100%';
                        img.style.maxHeight = '200px';
                        img.style.objectFit = 'contain';
                        e.target.parentNode.insertBefore(img, e.target);
                    }
                    img.src = evt.target.result;
                };
                reader.readAsDataURL(file);
            }
        });

        document.getElementById('ktp-scan-input')?.addEventListener('change', function(e) {
            const [file] = e.target.files;
            if (file && file.type.match('image.*')) {
                const reader = new FileReader();
                reader.onload = function(evt) {
                    let img = document.getElementById('ktp-scan-preview');
                    if (!img) {
                        img = document.createElement('img');
                        img.id = 'ktp-scan-preview';
                        img.className = 'mt-2 mb-3 img-fluid';
                        img.style.maxWidth = '100%';
                        img.style.maxHeight = '200px';
                        img.style.objectFit = 'contain';
                        e.target.parentNode.insertBefore(img, e.target);
                    }
                    img.src = evt.target.result;
                };
                reader.readAsDataURL(file);
            }
        });
    </script>
@endpush
