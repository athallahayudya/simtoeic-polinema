@extends('layouts.app')

@section('title', 'Verification Request')

@push('style')
  <!-- CSS Libraries -->
  <link rel="stylesheet" href="{{ asset('assets/modules/datatables/datatables.min.css') }}">
  <link rel="stylesheet"
    href="{{ asset('assets/modules/datatables/DataTables-1.10.16/css/dataTables.bootstrap4.min.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/modules/datatables/Select-1.2.4/css/select.bootstrap4.min.css') }}">
@endpush

@section('main')
  <div class="main-content">
    <section class="section">
    <div class="section-header">
      <h1>Verification Request</h1>
      <div class="section-header-breadcrumb">
      <div class="breadcrumb-item active"><a href="{{ route('student.dashboard') }}">Dashboard</a></div>
      <div class="breadcrumb-item">Verification Request</div>
      </div>
    </div>

    <div class="section-body">
      <!-- Information Card -->
      <div class="row">
      <div class="col-12">
        <div class="card">
        <div class="card-header">
          <h4><i class="fas fa-info-circle mr-2"></i>Request Information</h4>
        </div>
        <div class="card-body">
          <div class="alert alert-info">
          <h5><i class="fas fa-info-circle mr-2"></i>Verification Request Guidelines:</h5>
          <p class="mb-2">You can submit a verification request for various purposes. Common examples include:</p>
          <ul class="mb-3">
            <li><strong>TOEIC Exam Participation:</strong> Verification of exam attempts and scores</li>
            <li><strong>Special Conditions:</strong> Medical conditions, disabilities, or other circumstances</li>
            <li><strong>Academic Requirements:</strong> Documentation for academic purposes</li>
            <li><strong>Administrative Needs:</strong> Other official documentation requirements</li>
          </ul>
          <div class="alert alert-warning mb-0">
            <strong><i class="fas fa-edit mr-1"></i>Important:</strong> Write your own detailed description
            explaining your specific situation and needs. Include supporting documents relevant to your request.
          </div>
          </div>
        </div>
        </div>
      </div>
      </div>

      <!-- Exam History -->
      <div class="row">
      <div class="col-12">
        <div class="card">
        <div class="card-header">
          <h4><i class="fas fa-history mr-2"></i>Your Exam History</h4>
        </div>
        <div class="card-body">
          <div class="table-responsive">
          <table class="table table-striped">
            <thead>
            <tr>
              <th>Exam ID</th>
              <th>Type</th>
              <th>Listening</th>
              <th>Reading</th>
              <th>Total</th>
              <th>Status</th>
              <th>Date</th>
            </tr>
            </thead>
            <tbody>
            @foreach($examScores as $result)
          <tr>
            <td><strong class="text-primary">{{ $result->exam_id ?? 'N/A' }}</strong></td>
            <td>{!! $result->exam_type_badge !!}</td>
            <td><span class="badge badge-info">{{ $result->listening_score ?? 0 }}</span></td>
            <td><span class="badge badge-info">{{ $result->reading_score ?? 0 }}</span></td>
            <td>
            <span class="badge {{ ($result->total_score ?? 0) >= 500 ? 'badge-success' : 'badge-danger' }}">
            {{ $result->total_score ?? 0 }}
            </span>
            </td>
            <td>
            @if(($result->total_score ?? 0) >= 500)
          <span class="badge badge-success"><i class="fas fa-check mr-1"></i> PASS</span>
        @else
          <span class="badge badge-danger"><i class="fas fa-times mr-1"></i> FAIL</span>
        @endif
            </td>
            <td>
            <small class="text-muted">
            {{ $result->exam_date ? $result->exam_date->format('d M Y') : ($result->created_at ? $result->created_at->format('d M Y') : 'N/A') }}
            </small>
            </td>
          </tr>
        @endforeach
            </tbody>
          </table>
          </div>
        </div>
        </div>
      </div>
      </div>

      <!-- Request Form -->
      <div class="row">
      <div class="col-12">
        <div class="card">
        <div class="card-header bg-primary text-white">
          <h4><i class="fas fa-file-alt mr-2"></i>Verification Request Form</h4>
        </div>
        <div class="card-body">
          @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
        <i class="fas fa-check-circle mr-2"></i>{{ session('success') }}
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
        </button>
        </div>
      @endif

          @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <i class="fas fa-exclamation-circle mr-2"></i>{{ session('error') }}
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
        </button>
        </div>
      @endif

          <form action="{{ route('student.verification.request.submit') }}" method="POST"
          enctype="multipart/form-data" id="verificationForm">
          @csrf

          <div class="row">
            <div class="col-md-12">
            <div class="form-group">
              <label for="comment">
              <i class="fas fa-comment mr-1"></i>Description/Reason for Request
              <span class="text-danger">*</span>
              </label>
              <textarea class="form-control @error('comment') is-invalid @enderror" id="comment" name="comment"
              rows="6"
              placeholder="Write your own detailed explanation here...&#10;&#10;Describe your specific situation and why you need this verification letter. Be clear and specific about your circumstances, condition, or requirements."
              required>{{ old('comment') }}</textarea>
              <small class="form-text text-muted">
              <i class="fas fa-info-circle mr-1"></i>Minimum 50 characters required. Write your own
              description - be specific about your personal situation and needs.
              </small>
              @error('comment')
          <div class="invalid-feedback">{{ $message }}</div>
        @enderror
              <div class="text-right">
              <small class="text-muted">
                <span id="charCount">0</span>/1000 characters
              </small>
              </div>
            </div>
            </div>
          </div>

          <div class="row">
            <div class="col-md-12">
            <div class="form-group">
              <label for="certificate_file">
              <i class="fas fa-upload mr-1"></i>Upload Supporting Evidence (File 1)
              <span class="text-danger">*</span>
              </label>
              <div class="custom-file">
              <input type="file" class="custom-file-input @error('certificate_file') is-invalid @enderror"
                id="certificate_file" name="certificate_file" accept=".pdf,.jpg,.jpeg,.png" required>
              <label class="custom-file-label" for="certificate_file">Choose first file...</label>
              </div>
              <small class="form-text text-muted">
              <i class="fas fa-file mr-1"></i>Upload supporting documents (medical certificates, TOEIC
              certificates, academic documents, etc.)
              <br><strong>Allowed formats:</strong> PDF, JPG, JPEG, PNG | <strong>Maximum size:</strong> 5MB
              </small>
              @error('certificate_file')
          <div class="invalid-feedback">{{ $message }}</div>
        @enderror

              <!-- File preview area -->
              <div id="filePreview" class="mt-3" style="display: none;">
              <div class="card">
                <div class="card-body p-3">
                <h6 class="card-title mb-2">
                  <i class="fas fa-eye mr-1"></i>File 1 Preview
                </h6>
                <div id="previewContent"></div>
                </div>
              </div>
              </div>
            </div>
            </div>
          </div>

          <div class="row">
            <div class="col-md-12">
            <div class="form-group">
              <label for="certificate_file_2">
              <i class="fas fa-upload mr-1"></i>Upload Supporting Evidence (File 2)
              <span class="text-muted">(Optional)</span>
              </label>
              <div class="custom-file">
              <input type="file" class="custom-file-input @error('certificate_file_2') is-invalid @enderror"
                id="certificate_file_2" name="certificate_file_2" accept=".pdf,.jpg,.jpeg,.png">
              <label class="custom-file-label" for="certificate_file_2">Choose second file...</label>
              </div>
              <small class="form-text text-muted">
              <i class="fas fa-file mr-1"></i>Upload additional supporting documents if needed
              <br><strong>Allowed formats:</strong> PDF, JPG, JPEG, PNG | <strong>Maximum size:</strong> 5MB
              </small>
              @error('certificate_file_2')
          <div class="invalid-feedback">{{ $message }}</div>
        @enderror

              <!-- File preview area for second file -->
              <div id="filePreview2" class="mt-3" style="display: none;">
              <div class="card">
                <div class="card-body p-3">
                <h6 class="card-title mb-2">
                  <i class="fas fa-eye mr-1"></i>File 2 Preview
                </h6>
                <div id="previewContent2"></div>
                </div>
              </div>
              </div>
            </div>
            </div>
          </div>

          <hr>

          <div class="row">
            <div class="col-12">
            <div class="form-group mb-0">
              <div class="d-flex justify-content-between align-items-center">
              <a href="{{ route('student.request.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left mr-1"></i> Back to Request
              </a>
              <button type="submit" class="btn btn-primary btn-lg" id="submitBtn">
                <i class="fas fa-paper-plane mr-1"></i> Submit Verification Request
              </button>
              </div>
            </div>
            </div>
          </div>
          </form>
        </div>
        </div>
      </div>
      </div>
    </div>
    </section>
  </div>
@endsection

@push('scripts')
  <!-- JS Libraries -->
  <script src="{{ asset('assets/modules/datatables/datatables.min.js') }}"></script>
  <script src="{{ asset('assets/modules/sweetalert/sweetalert2.all.min.js') }}"></script>

  <script>
    $(document).ready(function () {
    // Character counter for comment
    $('#comment').on('input', function () {
      const length = $(this).val().length;
      $('#charCount').text(length);

      if (length < 50) {
      $('#charCount').removeClass('text-success').addClass('text-danger');
      } else {
      $('#charCount').removeClass('text-danger').addClass('text-success');
      }
    });

    // File upload handling for first file
    $('#certificate_file').on('change', function () {
      const file = this.files[0];
      const label = $(this).next('.custom-file-label');

      if (file) {
      const fileSize = file.size / 1024 / 1024; // Convert to MB
      const allowedTypes = ['application/pdf', 'image/jpeg', 'image/jpg', 'image/png'];

      // Validate file size
      if (fileSize > 5) {
        Swal.fire({
        icon: 'error',
        title: 'File Too Large',
        text: 'File size must be less than 5MB.',
        confirmButtonColor: '#dc3545'
        });
        this.value = '';
        label.text('Choose first file...');
        $('#filePreview').hide();
        return;
      }

      // Validate file type
      if (!allowedTypes.includes(file.type)) {
        Swal.fire({
        icon: 'error',
        title: 'Invalid File Format',
        text: 'Please upload PDF, JPG, JPEG, or PNG files only.',
        confirmButtonColor: '#dc3545'
        });
        this.value = '';
        label.text('Choose first file...');
        $('#filePreview').hide();
        return;
      }

      // Update label with filename
      label.text(file.name);

      // Show file preview
      showFilePreview(file, 'previewContent', 'filePreview');
      } else {
      label.text('Choose first file...');
      $('#filePreview').hide();
      }
    });

    // File upload handling for second file
    $('#certificate_file_2').on('change', function () {
      const file = this.files[0];
      const label = $(this).next('.custom-file-label');

      if (file) {
      const fileSize = file.size / 1024 / 1024; // Convert to MB
      const allowedTypes = ['application/pdf', 'image/jpeg', 'image/jpg', 'image/png'];

      // Validate file size
      if (fileSize > 5) {
        Swal.fire({
        icon: 'error',
        title: 'File Too Large',
        text: 'File size must be less than 5MB.',
        confirmButtonColor: '#dc3545'
        });
        this.value = '';
        label.text('Choose second file...');
        $('#filePreview2').hide();
        return;
      }

      // Validate file type
      if (!allowedTypes.includes(file.type)) {
        Swal.fire({
        icon: 'error',
        title: 'Invalid File Format',
        text: 'Please upload PDF, JPG, JPEG, or PNG files only.',
        confirmButtonColor: '#dc3545'
        });
        this.value = '';
        label.text('Choose second file...');
        $('#filePreview2').hide();
        return;
      }

      // Update label with filename
      label.text(file.name);

      // Show file preview
      showFilePreview(file, 'previewContent2', 'filePreview2');
      } else {
      label.text('Choose second file...');
      $('#filePreview2').hide();
      }
    });

    // Form submission
    $('#verificationForm').on('submit', function (e) {
      const comment = $('#comment').val().trim();
      const file = $('#certificate_file')[0].files[0];

      // Validate comment length
      if (comment.length < 50) {
      e.preventDefault();
      Swal.fire({
        icon: 'warning',
        title: 'Comment Too Short',
        text: 'Please provide at least 50 characters in your comment.',
        confirmButtonColor: '#ffc107'
      });
      $('#comment').focus();
      return;
      }

      // Validate file upload
      if (!file) {
      e.preventDefault();
      Swal.fire({
        icon: 'warning',
        title: 'File Required',
        text: 'Please upload a supporting document.',
        confirmButtonColor: '#ffc107'
      });
      $('#certificate_file').focus();
      return;
      }

      // Show loading state
      $('#submitBtn').prop('disabled', true).html('<i class="fas fa-spinner fa-spin mr-1"></i> Submitting...');

      // Show confirmation
      e.preventDefault();
      Swal.fire({
      title: 'Submit Verification Request?',
      text: 'Are you sure you want to submit this verification request?',
      icon: 'question',
      showCancelButton: true,
      confirmButtonColor: '#007bff',
      cancelButtonColor: '#6c757d',
      confirmButtonText: 'Yes, Submit',
      cancelButtonText: 'Cancel'
      }).then((result) => {
      if (result.isConfirmed) {
        // Actually submit the form
        this.submit();
      } else {
        // Reset button state
        $('#submitBtn').prop('disabled', false).html('<i class="fas fa-paper-plane mr-1"></i> Submit Verification Request');
      }
      });
    });
    });

    // File preview function
    function showFilePreview(file, previewContentId, previewContainerId) {
    const reader = new FileReader();
    const previewContent = $('#' + previewContentId);

    reader.onload = function (e) {
      let content = '';

      if (file.type.startsWith('image/')) {
      content = `
      <div class="text-center">
      <img src="${e.target.result}" class="img-fluid" style="max-height: 200px; border-radius: 5px;">
      <p class="mt-2 mb-0"><strong>${file.name}</strong></p>
      <small class="text-muted">${(file.size / 1024 / 1024).toFixed(2)} MB</small>
      </div>
      `;
      } else if (file.type === 'application/pdf') {
      content = `
      <div class="text-center">
      <i class="fas fa-file-pdf fa-4x text-danger mb-2"></i>
      <p class="mb-0"><strong>${file.name}</strong></p>
      <small class="text-muted">${(file.size / 1024 / 1024).toFixed(2)} MB</small>
      </div>
      `;
      }

      previewContent.html(content);
      $('#' + previewContainerId).fadeIn();
    };

    if (file.type.startsWith('image/')) {
      reader.readAsDataURL(file);
    } else {
      reader.readAsDataURL(file);
    }
    }
  </script>
@endpush