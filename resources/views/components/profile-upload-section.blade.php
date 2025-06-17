{{-- Profile Upload Section Component --}}
{{-- Usage: @include('components.profile-upload-section', ['user' => $student, 'userType' => 'student']) --}}

@php
    $userVar = $user ?? (isset(${$userType}) ? ${$userType} : null);
@endphp

<!-- Profile Photo Section -->
<div class="form-group">
    <label>Profile Photo</label>
    <input type="file" name="photo" class="form-control-file" id="profile-photo-input" accept="image/*">
    <small class="form-text text-muted">
        <i class="fas fa-info-circle"></i>
        Supported formats: JPG, JPEG, PNG. Maximum size: 2MB.
        <br>Please ensure the photo is clear and shows your face properly.
    </small>

    @if(isset($userVar) && $userVar && $userVar->photo)
        <div class="alert alert-info mt-2">
            <i class="fas fa-check-circle"></i> Current photo uploaded. You can upload a new one to replace it.
        </div>
        <div class="document-preview mt-2">
            <img src="{{ asset($userVar->photo) }}" alt="Current Profile Photo" class="img-fluid">
        </div>
    @endif

    <div class="document-preview mt-2" id="profile-photo-container" style="display:none">
        <strong>New Photo Preview:</strong>
        <img src="" alt="Profile Preview" class="img-fluid" id="profile-photo-preview">
    </div>

    @error('photo')
        <div class="text-danger mt-1">{{ $message }}</div>
    @enderror
</div>

<!-- KTP and KTM Upload Row -->
<div class="row">
    <div class="col-md-6">
        <div class="form-group">
            <label>KTP Scan (ID Card)</label>
            <input type="file" name="ktp_scan" class="form-control-file" accept="image/*" id="ktp-scan-input">
            <small class="form-text text-muted">
                <i class="fas fa-info-circle"></i>
                Supported formats: JPG, JPEG, PNG. Maximum size: 5MB.
                <br>Please ensure the KTP is clear and all text is readable.
            </small>

            @if(isset($userVar) && $userVar && $userVar->ktp_scan)
                <div class="alert alert-info mt-2">
                    <i class="fas fa-check-circle"></i> Current KTP uploaded. You can upload a new one to replace it.
                </div>
                <div class="mt-2">
                    <a href="{{ isset($userVar) && $userVar && $userVar->ktp_scan ? asset($userVar->ktp_scan) : '#' }}"
                        target="_blank" class="btn btn-sm btn-info">
                        <i class="fas fa-eye"></i> View Current KTP
                    </a>
                </div>
            @endif

            <div class="document-preview mt-2" id="ktp-scan-container" style="display:none">
                <strong>New KTP Preview:</strong>
                <img src="" alt="KTP Preview" class="img-fluid" id="ktp-scan-preview">
            </div>

            @error('ktp_scan')
                <div class="text-danger mt-1">{{ $message }}</div>
            @enderror
        </div>
    </div>

    <div class="col-md-6">
        <div class="form-group">
            <label>{{ $userType === 'student' ? 'KTM Scan (Student Card)' : 'ID Card Scan (Employee Card)' }}</label>
            <input type="file" name="ktm_scan" class="form-control-file" accept="image/*" id="ktm-scan-input">
            <small class="form-text text-muted">
                <i class="fas fa-info-circle"></i>
                Supported formats: JPG, JPEG, PNG. Maximum size: 5MB.
                <br>Please ensure the {{ $userType === 'student' ? 'KTM' : 'ID card' }} is clear and all text is
                readable.
            </small>

            @if(isset($userVar) && $userVar && $userVar->ktm_scan)
                <div class="alert alert-info mt-2">
                    <i class="fas fa-check-circle"></i> Current {{ $userType === 'student' ? 'KTM' : 'ID card' }} uploaded.
                    You can upload a new one to replace it.
                </div>
                <div class="mt-2">
                    <a href="{{ isset($userVar) && $userVar && $userVar->ktm_scan ? asset($userVar->ktm_scan) : '#' }}"
                        target="_blank" class="btn btn-sm btn-info">
                        <i class="fas fa-eye"></i> View Current {{ $userType === 'student' ? 'KTM' : 'ID Card' }}
                    </a>
                </div>
            @endif

            <div class="document-preview mt-2" id="ktm-scan-container" style="display:none">
                <strong>New {{ $userType === 'student' ? 'KTM' : 'ID Card' }} Preview:</strong>
                <img src="" alt="{{ $userType === 'student' ? 'KTM' : 'ID Card' }} Preview" class="img-fluid"
                    id="ktm-scan-preview">
            </div>

            @error('ktm_scan')
                <div class="text-danger mt-1">{{ $message }}</div>
            @enderror
        </div>
    </div>
</div>

{{-- JavaScript for file validation and preview --}}
@push('scripts')
    <script>
        // File size validation function
        function validateFileSize(file, maxSizeMB, inputElement) {
            const maxSizeBytes = maxSizeMB * 1024 * 1024;
            if (file.size > maxSizeBytes) {
                alert(`File size too large! Maximum allowed size is ${maxSizeMB}MB. Your file is ${(file.size / 1024 / 1024).toFixed(2)}MB.`);
                inputElement.value = '';
                return false;
            }
            return true;
        }

        // For profile photo preview
        document.getElementById('profile-photo-input')?.addEventListener('change', function (e) {
            const [file] = e.target.files;
            if (file) {
                if (!file.type.match('image.*')) {
                    alert('Please select a valid image file (JPG, JPEG, PNG).');
                    this.value = '';
                    return;
                }

                if (!validateFileSize(file, 2, this)) return;

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
            if (file) {
                if (!file.type.match('image.*')) {
                    alert('Please select a valid image file (JPG, JPEG, PNG).');
                    this.value = '';
                    return;
                }

                if (!validateFileSize(file, 5, this)) return;

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

        // For KTM scan preview
        document.getElementById('ktm-scan-input')?.addEventListener('change', function (e) {
            const [file] = e.target.files;
            if (file) {
                if (!file.type.match('image.*')) {
                    alert('Please select a valid image file (JPG, JPEG, PNG).');
                    this.value = '';
                    return;
                }

                if (!validateFileSize(file, 5, this)) return;

                const reader = new FileReader();
                reader.onload = function (evt) {
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
    </script>
@endpush