@extends('layouts.app')

@section('title', 'Request')

@push('style')
  <!-- CSS Libraries -->
  <link rel="stylesheet" href="{{ asset('assets/modules/datatables/datatables.min.css') }}">
  <link rel="stylesheet"
    href="{{ asset('assets/modules/datatables/DataTables-1.10.16/css/dataTables.bootstrap4.min.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/modules/datatables/Select-1.2.4/css/select.bootstrap4.min.css') }}">
  <style>
    .main-card {
    border-radius: 8px;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
    margin-bottom: 20px;
    }

    .quick-info {
    display: flex;
    align-items: flex-start;
    padding: 15px;
    background: #f8f9fa;
    border-radius: 8px;
    margin-bottom: 15px;
    }

    .quick-info i {
    font-size: 24px;
    margin-right: 15px;
    color: #6777ef;
    }

    .table-simple {
    margin-bottom: 0;
    }

    .table-simple th {
    background-color: #f8f9fa;
    }

    .empty-placeholder {
    text-align: center;
    padding: 30px 15px;
    }

    .empty-placeholder i {
    font-size: 40px;
    color: #cdd3d8;
    margin-bottom: 15px;
    }
  </style>
@endpush

@section('main')
  <div class="main-content">
    <section class="section">
    <div class="section-header">
      <h1>Verification Request</h1>
      <div class="section-header-breadcrumb">
      <div class="breadcrumb-item active"><a href="{{ route('student.dashboard') }}">Dashboard</a></div>
      <div class="breadcrumb-item">Request</div>
      </div>
    </div>

    <div class="section-body">
      <!-- Alert Messages -->
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

      <!-- Main Action Card -->
      <div class="card main-card">
      <div class="card-body p-0">
        <div class="row no-gutters">
        <!-- Request Information & Button -->
        <div class="col-lg-12">
          <div class="p-4"> @if($canRequestCertificate)
      <div class="quick-info mb-3">
        <i class="fas fa-info-circle"></i>
        <div>
        <h6 class="mb-1">Request verification for:</h6>
        <ul class="mb-0 pl-3">
        <li>TOEIC exam participation verification</li>
        <li>Special conditions documentation</li>
        <li>Academic requirement fulfillment</li>
        <li>Other administrative purposes</li>
        </ul>
        </div>
      </div>

      <div class="text-center pt-1 pb-3">
        <a href="{{ route('student.verification.request.form') }}" class="btn btn-primary">
        + Create New Request
        </a>
      </div>
      @else
        <div class="alert alert-warning">
        <div class="d-flex">
        <div class="mr-3">
          <i class="fas fa-exclamation-triangle fa-2x text-warning"></i>
        </div>
        <div>
          <h5>Request Not Available</h5>
          <p class="mb-0">You already have a pending or approved verification request. Please wait for the
          current request to be processed or contact admin for assistance.</p>
        </div>
        </div>
        </div>
      @endif
          </div>
        </div>
        </div>
      </div>
      </div>

      <!-- Verification Requests History -->
      <div class="card main-card">
      <div class="card-header">
        <h4><i class="fas fa-list-alt mr-2"></i>My Verification Requests</h4>
      </div>
      <div class="card-body">
        @if(count($verificationRequests) > 0)
      <div class="table-responsive">
      <table class="table table-hover table-simple" id="requests-table">
        <thead>
        <tr>
        <th>Date</th>
        <th>Status</th>
        <th>Comment</th>
        <th>Files</th>
        <th>Action</th>
        </tr>
        </thead>
        <tbody>
        @foreach($verificationRequests as $request)
        <tr>
        <td>{{ $request->created_at->format('d M Y') }}</td>
        <td>{!! $request->status_badge !!}</td>
        <td>
        <span title="{{ $request->comment }}">
        {{ Str::limit($request->comment, 40) }}
        </span>
        </td>
        <td>
        @if($request->certificate_file || $request->certificate_file_2)
        <div class="btn-group">
        <button type="button" class="btn btn-sm btn-info dropdown-toggle" data-toggle="dropdown">
        <i class="fas fa-file mr-1"></i> Files
        </button>
        <div class="dropdown-menu">
        @if($request->certificate_file)
        <a href="{{ asset('storage/' . $request->certificate_file) }}" class="dropdown-item"
        target="_blank">
        <i class="fas fa-file-alt mr-1"></i> View File 1
        </a>
      @endif
        @if($request->certificate_file_2)
        <a href="{{ asset('storage/' . $request->certificate_file_2) }}" class="dropdown-item"
        target="_blank">
        <i class="fas fa-file-alt mr-1"></i> View File 2
        </a>
      @endif
        </div>
        </div>
      @endif

        @if($request->status === 'approved' && $request->generated_certificate_path)
      <a href="{{ asset('storage/' . $request->generated_certificate_path) }}" target="_blank"
        class="btn btn-success btn-sm ml-1">
        <i class="fas fa-download mr-1"></i> Letter
      </a>
      @endif
        </td>
        <td>
        @if($request->status === 'approved' || $request->status === 'rejected')
      <button class="btn btn-info btn-sm" onclick="showRequestDetail({{ $request->request_id }})">
        <i class="fas fa-info-circle"></i>
      </button>
      @else
      <span class="text-muted">-</span>
      @endif
        </td>
        </tr>
      @endforeach
        </tbody>
      </table>
      </div>
      @else
        <div class="empty-placeholder">
        <i class="fas fa-inbox"></i>
        <h5>No Verification Requests Yet</h5> @if($canRequestCertificate)
      <a href="{{ route('student.verification.request.form') }}" class="btn btn-outline-primary mt-3">
        Create First Request
      </a>
      @endif
        </div>
      @endif
      </div>
      </div>

      <!-- Simplified Exam History (Conditional Display) -->
      @if(count($allExamScores) > 0)
      <div class="card main-card">
      <div class="card-header">
      <h4><i class="fas fa-history mr-2"></i>Exam Results</h4>
      </div>
      <div class="card-body p-0">
      <div class="table-responsive">
      <table class="table table-simple">
        <thead>
        <tr>
        <th>Exam ID</th>
        <th>Total Score</th>
        <th>Status</th>
        <th>Date</th>
        </tr>
        </thead>
        <tbody>
        @foreach($allExamScores as $result)
        <tr>
        <td class="text-primary">{{ $result->exam_id ?? 'N/A' }}</td>
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
        {{ $result->exam_date ? $result->exam_date->format('d M Y') : ($result->created_at ? $result->created_at->format('d M Y') : 'N/A') }}
        </td>
        </tr>
      @endforeach
        </tbody>
      </table>
      </div>
      </div>
      </div>
    @endif
    </div>
    </section>
  </div>

  <!-- Simplified Modal for Request Details -->
  <div class="modal fade" id="requestDetailModal" tabindex="-1" role="dialog" aria-labelledby="requestDetailModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
      <h5 class="modal-title" id="requestDetailModalLabel">Request Detail</h5>
      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
      </button>
      </div>
      <div class="modal-body">
      <dl class="row">
        <dt class="col-sm-4">Request Date:</dt>
        <dd class="col-sm-8" id="detail-request-date"></dd>

        <dt class="col-sm-4">Status:</dt>
        <dd class="col-sm-8" id="detail-status"></dd>

        <dt class="col-sm-4">Processed Date:</dt>
        <dd class="col-sm-8" id="detail-processed-date"></dd>

        <dt class="col-sm-4">Processed By:</dt>
        <dd class="col-sm-8" id="detail-processed-by"></dd>
      </dl>

      <hr>

      <h6><strong>Your Comment:</strong></h6>
      <p id="detail-user-comment" class="p-2 bg-light rounded mb-3"></p>

      <h6><strong>Admin Message:</strong></h6>
      <div class="alert" id="detail-admin-message-container">
        <p id="detail-admin-message" class="mb-0"></p>
      </div>
      </div>
      <div class="modal-footer">
      <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
    </div>
  </div>
@endsection

@push('scripts')
  <!-- JS Libraries -->
  <script src="{{ asset('assets/modules/datatables/datatables.min.js') }}"></script>

  <script>
    $(document).ready(function () {
    // Initialize DataTable if there are requests
    @if(count($verificationRequests) > 0)
    $('#requests-table').DataTable({
      responsive: true,
      order: [[0, 'desc']], // Sort by date
      pageLength: 5,
      lengthMenu: [[5, 10, 25], [5, 10, 25]],
      language: {
      emptyTable: "No verification requests found",
      zeroRecords: "No matching requests found"
      }
    });
    @endif
    });

    // Function untuk menampilkan detail request
    function showRequestDetail(requestId) {
    $.ajax({
      url: '/student/request/detail/' + requestId,
      type: 'GET',
      success: function (response) {
      if (response.success) {
        const data = response.data;

        // Populate modal with data
        $('#detail-request-date').text(data.created_at || '-');
        $('#detail-processed-date').text(data.approved_at || '-');
        $('#detail-processed-by').text(data.approved_by || '-');
        $('#detail-user-comment').text(data.comment || 'No comment provided');

        // Set status badge
        let statusClass = 'alert-secondary';
        if (data.status === 'approved') {
        statusClass = 'alert-success';
        $('#detail-status').html('<span class="badge badge-success"><i class="fas fa-check mr-1"></i>Approved</span>');
        } else if (data.status === 'rejected') {
        statusClass = 'alert-danger';
        $('#detail-status').html('<span class="badge badge-danger"><i class="fas fa-times mr-1"></i>Rejected</span>');
        } else {
        $('#detail-status').html('<span class="badge badge-warning"><i class="fas fa-clock mr-1"></i>Pending</span>');
        }

        // Set admin message
        $('#detail-admin-message-container').removeClass('alert-success alert-danger alert-secondary').addClass(statusClass);
        if (data.admin_notes && data.admin_notes.trim() !== '') {
        $('#detail-admin-message').text(data.admin_notes);
        } else {
        $('#detail-admin-message').text('No message from admin.');
        }

        // Show modal
        $('#requestDetailModal').modal('show');
      }
      },
      error: function (xhr) {
      Swal.fire({
        icon: 'error',
        title: 'Error!',
        text: 'Failed to load request details.',
      });
      }
    });
    }
  </script>
@endpush