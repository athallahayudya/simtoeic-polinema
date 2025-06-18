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
      <!-- Verification Request Form -->
      <div class="row">
      <div class="col-lg-8 col-md-10 mx-auto">
        <div class="card shadow-sm">
        <div class="card-header bg-gradient-primary py-3">
          <h4 class="mb-0 text-white"><i class="fas fa-certificate mr-2 text-white"></i>New Verification Request
          </h4>
        </div>
        <div class="card-body p-4">
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
          enctype="multipart/form-data" id="verificationForm" class="needs-validation" novalidate>
          @csrf

          <!-- Reason for Request -->
          <div class="form-group">
            <label for="comment" class="font-weight-bold">
            <i class="fas fa-comment-alt mr-1 text-primary"></i>Reason for Request <span
              class="text-danger">*</span>
            </label>
            <textarea class="form-control @error('comment') is-invalid @enderror" id="comment" name="comment"
            rows="4" placeholder="Please describe why you need this verification document..."
            required>{{ old('comment') }}</textarea>
            <div class="d-flex justify-content-between mt-1">
            <small class="text-muted"><i class="fas fa-info-circle mr-1"></i>Min 20 characters</small>
            <small class="text-muted"><span id="charCount"
              class="font-weight-bold text-danger">0</span>/1000</small>
            </div>
            @error('comment')
        <div class="invalid-feedback">{{ $message }}</div>
        @enderror
          </div>

          <!-- Upload File -->
          <div class="form-group">
            <label for="certificate_file" class="font-weight-bold">
            <i class="fas fa-file-upload mr-1 text-primary"></i>Supporting Document <span
              class="text-danger">*</span>
            </label>
            <div class="input-group">
            <div class="custom-file">
              <input type="file" class="custom-file-input @error('certificate_file') is-invalid @enderror"
              id="certificate_file" name="certificate_file" accept=".pdf,.jpg,.jpeg,.png" required>
              <label class="custom-file-label" for="certificate_file">Choose file...</label>
            </div>
            </div>
            <small class="form-text text-muted"><i class="fas fa-info-circle mr-1"></i>Allowed: PDF, JPG, PNG (max
            5MB)</small>
            @error('certificate_file')
        <div class="invalid-feedback">{{ $message }}</div>
        @enderror

            <!-- File preview area -->
            <div id="filePreview" class="mt-3" style="display: none;">
            <div class="card border-light shadow-sm">
              <div class="card-body p-3 text-center">
              <div id="previewContent"></div>
              </div>
            </div>
            </div>
          </div>

          <!-- Additional Documents Section -->
          <div class="form-group mb-4">
            <!-- Container for additional documents -->
            <div id="additionalDocuments" class="mt-3">
            <!-- Additional document fields will be added here dynamically -->
            </div>
            <div class="d-flex justify-content-center mt-3">
            <button type="button" id="addDocumentBtn" class="btn btn-outline-primary btn-rounded">
              <i class="fas fa-plus-circle mr-1"></i> Add Another Document
            </button>
            </div>
            <small class="text-center d-block mt-2 text-muted"><i class="fas fa-info-circle mr-1"></i>One document
            is sufficient, additional documents are optional</small>
          </div>

          <!-- Submit Button -->
          <div class="form-group mb-0">
            <div class="d-flex justify-content-between align-items-center">
            <a href="{{ route('student.request.index') }}" class="btn btn-outline-secondary btn-rounded">
              <i class="fas fa-arrow-left mr-1"></i> Back
            </a>
            <button type="submit" class="btn btn-primary btn-rounded" id="submitBtn">
              <i class="fas fa-paper-plane mr-1"></i> Submit Request
            </button>
            </div>
          </div>
          </form>

          <!-- Hidden template for additional documents -->
          <template id="documentTemplate">
          <div class="additional-document mt-3 p-3 border rounded">
            <div class="d-flex align-items-center mb-2">
            <label class="font-weight-bold mb-0">
              <i class="fas fa-file-upload mr-1 text-primary"></i>Supporting Document (Optional)
            </label>
            <button type="button" class="btn btn-sm btn-danger ml-auto remove-document rounded-circle">
              <i class="fas fa-times"></i>
            </button>
            </div>

            <div class="input-group">
            <div class="custom-file">
              <input type="file" class="custom-file-input document-file" name="additional_documents[]"
              accept=".pdf,.jpg,.jpeg,.png">
              <label class="custom-file-label">Choose file...</label>
            </div>
            </div>
            <small class="form-text text-muted mb-2"><i class="fas fa-info-circle mr-1"></i>Allowed: PDF, JPG, PNG
            (max 5MB)</small>

            <!-- File preview area -->
            <div class="file-preview mt-2" style="display: none;">
            <div class="card border-light shadow-sm">
              <div class="card-body p-2 text-center preview-content"></div>
            </div>
            </div>
          </div>
          </template>
        </div>
        </div>
      </div>
      </div>
    </div>
    </section>
  </div>
@endsection

@push('style')
  <!-- Additional CSS -->
  <style>
    .bg-gradient-primary {
    background: linear-gradient(135deg, #4e73df 0%, #224abe 100%);
    }

    .btn-rounded {
    border-radius: 30px;
    padding-left: 20px;
    padding-right: 20px;
    }

    .form-control:focus {
    border-color: #4e73df;
    box-shadow: 0 0 0 0.2rem rgba(78, 115, 223, 0.25);
    }

    .custom-file-input:focus~.custom-file-label {
    border-color: #4e73df;
    box-shadow: 0 0 0 0.2rem rgba(78, 115, 223, 0.25);
    }

    .card {
    border-radius: 8px;
    }

    .card-header {
    border-top-left-radius: 8px;
    border-top-right-radius: 8px;
    }

    .btn-primary {
    background-color: #4e73df;
    border-color: #4e73df;
    }

    .btn-primary:hover {
    background-color: #2e59d9;
    border-color: #2653d4;
    }

    .shadow-sm {
    box-shadow: 0 .125rem .25rem rgba(0, 0, 0, .075) !important;
    }

    #addDocumentBtn {
    transition: all 0.3s ease;
    box-shadow: 0 2px 5px rgba(0, 0, 0, 0.05);
    }

    #addDocumentBtn:hover {
    transform: translateY(-2px);
    box-shadow: 0 5px 15px rgba(0, 0, 0, .1);
    background-color: #4e73df;
    color: white;
    }

    .additional-document {
    border: 1px solid #e3e6f0;
    border-radius: 8px;
    padding: 15px;
    position: relative;
    background-color: #ffffff;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.03);
    transition: all 0.3s ease;
    }

    .additional-document:hover {
    box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
    }

    .remove-document {
    padding: 0.25rem 0.35rem;
    font-size: 0.8rem;
    line-height: 1;
    border-radius: 50%;
    margin-left: 10px;
    width: 28px;
    height: 28px;
    display: flex;
    align-items: center;
    justify-content: center;
    }

    .file-preview {
    border-radius: 8px;
    overflow: hidden;
    transition: all 0.3s ease;
    }

    /* Styles for embedded PDF preview */
    .embed-responsive {
    max-height: 300px;
    border: 1px solid #e3e6f0;
    border-radius: 5px;
    overflow: hidden;
    }

    .embed-responsive iframe {
    background-color: #f8f9fc;
    }

    #submitBtn {
    transition: all 0.3s ease;
    /* Using the same btn-rounded style as the Back button */
    }

    #submitBtn:hover {
    transform: translateY(-2px);
    box-shadow: 0 5px 15px rgba(0, 0, 0, .1) !important;
    }
  </style>
@endpush

@push('scripts')
  <!-- JS Libraries -->
  <script src="{{ asset('assets/modules/sweetalert/sweetalert2.all.min.js') }}"></script>

  <script>
    $(document).ready(function () {
    // Document counter for generating unique IDs
    let documentCounter = 0;

    // Add additional document field
    $('#addDocumentBtn').on('click', function () {
      // Clone the template content
      const template = document.getElementById('documentTemplate');
      const documentId = 'doc_' + (++documentCounter);

      // Create document element from template
      const documentElement = template.content.cloneNode(true);

      // Add unique IDs to elements
      const fileInput = $(documentElement).find('.document-file');
      fileInput.attr('id', documentId);
      $(documentElement).find('.custom-file-label').attr('for', documentId);

      // Add the new document to the container with fade-in animation
      const newDocument = $(documentElement);
      newDocument.hide();
      $('#additionalDocuments').append(newDocument);
      newDocument.slideDown(300);

      // Scroll to the new element
      $('html, body').animate({
      scrollTop: $('#additionalDocuments').offset().top + $('#additionalDocuments').height() - 80
      }, 500);

      // Initialize file input behavior
      initializeFileInput(documentId);
    });

    // Initialize character counter on page load
    const updateCharCount = function () {
      const length = $('#comment').val().length;
      $('#charCount').text(length);

      // Update validation styling based on character count
      if (length < 20) {
      $('#charCount').removeClass('text-success').addClass('text-danger');
      $('#comment').removeClass('is-valid').addClass('is-invalid');
      } else {
      $('#charCount').removeClass('text-danger').addClass('text-success');
      $('#comment').removeClass('is-invalid').addClass('is-valid');
      }
    };

    // Run on page load
    updateCharCount();

    // Character counter for comment - update on each keystroke
    $('#comment').on('input keyup keydown keypress change blur focus', function () {
      updateCharCount();
    });    // Improved file upload handling for first file
    $('#certificate_file').on('change', function () {
      const file = this.files[0];
      const label = $(this).next('.custom-file-label');

      // Hide preview initially (will show only if valid file is selected)
      $('#filePreview').hide();

      if (file) {
      const fileSize = file.size / 1024 / 1024; // Convert to MB
      const allowedTypes = ['application/pdf', 'image/jpeg', 'image/jpg', 'image/png'];

      // Validate file size
      if (fileSize > 5) {
        Swal.fire({
        icon: 'error',
        title: 'File Too Large',
        text: 'Please upload a file smaller than 5MB',
        confirmButtonColor: '#4e73df'
        });
        this.value = '';
        label.text('Choose file...');
        return;
      }

      // Validate file type
      if (!allowedTypes.includes(file.type)) {
        Swal.fire({
        icon: 'error',
        title: 'Invalid File Format',
        html: '<p>Please upload files in these formats:</p><ul style="text-align: left; display: inline-block;"><li>PDF</li><li>JPG/JPEG</li><li>PNG</li></ul>',
        confirmButtonColor: '#4e73df'
        });
        this.value = '';
        label.text('Choose file...');
        return;
      }

      // Update label with filename
      label.text(file.name);

      // Show file preview
      showFilePreview(file, 'previewContent', 'filePreview');
      } else {
      label.text('Choose file...');
      $('#filePreview').hide();
      }
    });

    // Event delegation for document removal with animation
    $(document).on('click', '.remove-document', function () {
      const documentEl = $(this).closest('.additional-document');
      documentEl.addClass('border-danger');

      // Animate removal with fade effect
      documentEl.animate({ opacity: 0.5 }, 200, function () {
      documentEl.slideUp(300, function () {
        documentEl.remove();
      });
      });
    });

    // Function to initialize file input behavior
    function initializeFileInput(inputId) {
      $('#' + inputId).on('change', function () {
      const file = this.files[0];
      const label = $(this).next('.custom-file-label');
      const previewEl = $(this).closest('.additional-document').find('.file-preview');
      const previewContent = $(this).closest('.additional-document').find('.preview-content');

      // Always hide preview initially
      previewEl.hide();

      if (file) {
        const fileSize = file.size / 1024 / 1024; // Convert to MB
        const allowedTypes = ['application/pdf', 'image/jpeg', 'image/jpg', 'image/png'];

        // Validate file size
        if (fileSize > 5) {
        Swal.fire({
          icon: 'error',
          title: 'File Too Large',
          text: 'Please upload a file smaller than 5MB',
          confirmButtonColor: '#4e73df'
        });
        this.value = '';
        label.text('Choose file...');
        return;
        }

        // Validate file type
        if (!allowedTypes.includes(file.type)) {
        Swal.fire({
          icon: 'error',
          title: 'Invalid File Format',
          html: '<p>Please upload files in these formats:</p><ul style="text-align: left; display: inline-block;"><li>PDF</li><li>JPG/JPEG</li><li>PNG</li></ul>',
          confirmButtonColor: '#4e73df'
        });
        this.value = '';
        label.text('Choose file...');
        return;
        }

        // Update label with filename
        label.text(file.name);

        // Show file preview with animation
        showDynamicFilePreview(file, previewContent, previewEl);
      } else {
        label.text('Choose file...');
        previewEl.hide();
      }
      });
    }

    // Enhanced form submission with animations and better UX
    $('#verificationForm').on('submit', function (e) {
      const comment = $('#comment').val().trim();
      const mainFile = $('#certificate_file')[0].files[0];
      const additionalFiles = $('.document-file').filter(function () {
      return this.files.length > 0;
      }).length;
      const totalFiles = (mainFile ? 1 : 0) + additionalFiles;

      // Validate comment length
      if (comment.length < 20) {
      e.preventDefault();
      Swal.fire({
        icon: 'warning',
        title: 'Description Too Short',
        text: 'Please provide at least 20 characters in your request description',
        confirmButtonColor: '#4e73df',
        confirmButtonText: 'OK, I\'ll Add More'
      });
      $('#comment').focus();
      return;
      }      // Validate file upload - main document (only requirement)
      if (!mainFile) {
      e.preventDefault();
      Swal.fire({
        icon: 'warning',
        title: 'Document Required',
        text: 'Please upload at least one supporting document',
        confirmButtonColor: '#4e73df'
      });
      $('#certificate_file').focus();
      return;
      }

      // Show number of files in confirmation
      const fileText = totalFiles > 1 ?
      `You are submitting ${totalFiles} documents with this request.` :
      'You are submitting 1 document with this request.';

      // Show loading state with animation
      $('#submitBtn').prop('disabled', true)
      .html('<span class="spinner-border spinner-border-sm mr-2" role="status" aria-hidden="true"></span> Submitting...')
      .addClass('disabled');

      // Show confirmation with improved UI and file count
      e.preventDefault();
      Swal.fire({
      title: 'Submit Verification Request?',
      html: `<p>${fileText}</p><p>Your request will be reviewed by our staff.</p><p class="text-muted">You\'ll receive a notification once processed.</p>`,
      icon: 'question',
      showCancelButton: true,
      confirmButtonColor: '#4e73df',
      cancelButtonColor: '#6c757d',
      confirmButtonText: '<i class="fas fa-check mr-1"></i> Submit',
      cancelButtonText: '<i class="fas fa-times mr-1"></i> Cancel',
      buttonsStyling: true,
      showClass: {
        popup: 'animate__animated animate__fadeInDown'
      },
      hideClass: {
        popup: 'animate__animated animate__fadeOutUp'
      }
      }).then((result) => {
      if (result.isConfirmed) {
        // Actually submit the form
        this.submit();
      } else {
        // Reset button state with animation
        $('#submitBtn').prop('disabled', false)
        .html('<i class="fas fa-paper-plane mr-1"></i> Submit Request')
        .removeClass('disabled');
      }
      });
    });    // Initialize document counter on page load (optional counter for information only)
    function updateDocumentCounter() {
      const mainFile = $('#certificate_file')[0].files.length > 0 ? 1 : 0;
      const additionalFiles = $('.document-file').filter(function () {
      return this.files.length > 0;
      }).length;

      const totalFiles = mainFile + additionalFiles;

      // Update document counter if element exists (optional display feature)
      if ($('#documentCounter').length) {
      $('#documentCounter').text(totalFiles);
      // Always show green since 1 document is sufficient
      $('#documentCounter').removeClass('text-danger').addClass('text-success');
      }
    }

    // Call updateDocumentCounter whenever files change
    $('#certificate_file').on('change', function () {
      updateDocumentCounter();
    });

    // Event delegation for document file changes
    $(document).on('change', '.document-file', function () {
      updateDocumentCounter();
    });

    // Update counter on document removal
    $(document).on('click', '.remove-document', function () {
      setTimeout(updateDocumentCounter, 500); // Update after animation completes
    });

    // Initialize counter on document ready
    updateDocumentCounter();

    // Enhanced file preview function with better styling and interactive preview
    function showFilePreview(file, previewContentId, previewContainerId) {
      const reader = new FileReader();
      const previewContent = $('#' + previewContentId);
      const previewContainer = $('#' + previewContainerId);

      reader.onload = function (e) {
      let content = '';

      if (file.type.startsWith('image/')) {
        content = `
        <div class="mb-2">
        <img src="${e.target.result}" class="img-fluid shadow-sm" style="max-height: 180px; border-radius: 5px;">
        </div>
        <div>
        <span class="badge badge-light p-2">
          <i class="fas fa-image mr-1 text-primary"></i> ${file.name}
        </span>
        </div>
        <div class="mt-2">
        <a href="${e.target.result}" target="_blank" class="btn btn-sm btn-outline-primary">
          <i class="fas fa-eye mr-1"></i> View Full Image
        </a>
        </div>
        <small class="text-muted d-block mt-1">${(file.size / 1024 / 1024).toFixed(1)} MB</small>
        `;
      } else if (file.type === 'application/pdf') {
        // For PDFs, create an embedded PDF viewer
        content = `
        <div class="mb-2">
        <i class="fas fa-file-pdf fa-3x text-danger mb-2"></i>
        <div class="embed-responsive embed-responsive-16by9 mt-2">
          <iframe class="embed-responsive-item" src="${e.target.result}" allowfullscreen></iframe>
        </div>
        </div>
        <div>
        <span class="badge badge-light p-2">
          <i class="fas fa-file-pdf mr-1 text-danger"></i> ${file.name}
        </span>
        </div>
        <div class="mt-2">
        <a href="${e.target.result}" target="_blank" class="btn btn-sm btn-outline-primary">
          <i class="fas fa-external-link-alt mr-1"></i> Open in New Tab
        </a>
        </div>
        <small class="text-muted d-block mt-1">${(file.size / 1024 / 1024).toFixed(1)} MB</small>
        `;
      }

      // Set content and make sure preview is visible
      previewContent.html(content);
      previewContainer.slideDown(300);
      };

      reader.readAsDataURL(file);
    }

    // Function to show dynamic file previews for additional documents
    function showDynamicFilePreview(file, previewContentEl, previewContainerEl) {
      const reader = new FileReader();

      reader.onload = function (e) {
      let content = '';

      if (file.type.startsWith('image/')) {
        content = `
        <div class="mb-2">
        <img src="${e.target.result}" class="img-fluid shadow-sm" style="max-height: 150px; border-radius: 5px;">
        </div>
        <div>
        <span class="badge badge-light p-2">
          <i class="fas fa-image mr-1 text-primary"></i> ${file.name}
        </span>
        </div>
        <div class="mt-2">
        <a href="${e.target.result}" target="_blank" class="btn btn-sm btn-outline-primary">
          <i class="fas fa-eye mr-1"></i> View Full Image
        </a>
        </div>
        <small class="text-muted d-block mt-1">${(file.size / 1024 / 1024).toFixed(1)} MB</small>
        `;
      } else if (file.type === 'application/pdf') {
        // For PDFs, create an embedded PDF viewer
        content = `
        <div class="mb-2">
        <i class="fas fa-file-pdf fa-3x text-danger mb-2"></i>
        <div class="embed-responsive embed-responsive-16by9 mt-2">
          <iframe class="embed-responsive-item" src="${e.target.result}" allowfullscreen></iframe>
        </div>
        </div>
        <div>
        <span class="badge badge-light p-2">
          <i class="fas fa-file-pdf mr-1 text-danger"></i> ${file.name}
        </span>
        </div>
        <div class="mt-2">
        <a href="${e.target.result}" target="_blank" class="btn btn-sm btn-outline-primary">
          <i class="fas fa-external-link-alt mr-1"></i> Open in New Tab
        </a>
        </div>
        <small class="text-muted d-block mt-1">${(file.size / 1024 / 1024).toFixed(1)} MB</small>
        `;
      }

      // Set content and ensure it's visible with animation
      previewContentEl.html(content);
      previewContainerEl.slideDown(300);
      };

      reader.readAsDataURL(file);
    }
    });
  </script>
@endpush