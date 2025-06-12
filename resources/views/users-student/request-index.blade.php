@extends('layouts.app')

@section('title', 'Request')

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

      <!-- Request Action Card -->
      <div class="row">
      <div class="col-12">
        <div class="card">
        <div class="card-header bg-primary text-white">
          <h4><i class="fas fa-certificate mr-2"></i>Verification Letter Request</h4>
        </div>
        <div class="card-body">
          @if($canRequestCertificate)
        <div class="alert alert-success">
        <h5><i class="fas fa-check-circle mr-2"></i>You can submit a verification request!</h5>
        <p class="mb-3">Submit a verification request for various purposes such as:</p>
        <ul class="mb-3">
        <li>TOEIC exam participation verification</li>
        <li>Special conditions documentation (medical, disability, etc.)</li>
        <li>Academic requirement fulfillment</li>
        <li>Other administrative purposes</li>
        </ul>
        <a href="{{ route('student.verification.request.form') }}" class="btn btn-success btn-lg">
        <i class="fas fa-plus mr-1"></i> Create New Request
        </a>
        </div>
      @else
        <div class="alert alert-warning">
        <h5><i class="fas fa-exclamation-triangle mr-2"></i>Request Not Available</h5>
        <p class="mb-0">You already have a pending or approved verification request. Please wait for the current
        request to be processed or contact admin for assistance.</p>
        </div>
      @endif
        </div>
        </div>
      </div>
      </div>

      <!-- Exam History -->
      @if(count($allExamScores) > 0)
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
        @foreach($allExamScores as $result)
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
    @endif

      <!-- Verification Requests History -->
      <div class="row">
      <div class="col-12">
        <div class="card">
        <div class="card-header">
          <h4><i class="fas fa-list mr-2"></i>My Verification Requests</h4>
        </div>
        <div class="card-body">
          @if(count($verificationRequests) > 0)
        <div class="table-responsive">
        <table class="table table-hover" id="requests-table">
          <thead class="thead-light">
          <tr>
          <th>No</th>
          <th>Request Date</th>
          <th>Status</th>
          <th>Comment</th>
          <th>Supporting Evidence</th>
          </tr>
          </thead>
          <tbody>
          @foreach($verificationRequests as $index => $request)
        <tr>
          <td>{{ $index + 1 }}</td>
          <td>
          <small class="text-muted">
          {{ $request->created_at->format('d M Y H:i') }}
          </small>
          </td>
          <td>
          {!! $request->status_badge !!}
          </td>
          <td>
          <span title="{{ $request->comment }}">
          {{ Str::limit($request->comment, 50) }}
          </span>
          </td>          <td>
          @if($request->certificate_file)
        <a href="{{ asset('storage/' . $request->certificate_file) }}" target="_blank"
        class="btn btn-info btn-sm mb-1">
        <i class="fas fa-eye mr-1"></i>View File 1
        </a>
        @endif
        
          @if($request->certificate_file_2)
        <a href="{{ asset('storage/' . $request->certificate_file_2) }}" target="_blank"
        class="btn btn-info btn-sm mb-1">
        <i class="fas fa-eye mr-1"></i>View File 2
        </a>
        @endif

          @if($request->status === 'approved' && $request->generated_certificate_path)
        <br>
        <a href="{{ asset('storage/' . $request->generated_certificate_path) }}" target="_blank"
        class="btn btn-success btn-sm">
        <i class="fas fa-download mr-1"></i>Download Letter
        </a>
        @endif

          @if(!$request->certificate_file && !$request->certificate_file_2 && (!$request->generated_certificate_path || $request->status !== 'approved'))
        <span class="text-muted">-</span>
        @endif
          </td>

        </tr>
        @endforeach
          </tbody>
        </table>
        </div>
      @else
        <div class="text-center py-5">
        <i class="fas fa-inbox fa-3x text-muted mb-3"></i>
        <h5 class="text-muted">No Verification Requests Yet</h5>
        <p class="text-muted mb-0">
          You haven't submitted any verification requests yet.
          @if($canRequestCertificate)
        <a href="{{ route('student.verification.request.form') }}">Create your first request</a>
        @else
        Complete the requirements above to submit a request.
        @endif
        </p>
        </div>
      @endif
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

  <script>
    $(document).ready(function () {
    // Initialize DataTable if there are requests
    @if(count($verificationRequests) > 0)
    $('#requests-table').DataTable({
      responsive: true,
      order: [[1, 'desc']], // Sort by date
      pageLength: 10,
      language: {
      emptyTable: "No verification requests found",
      zeroRecords: "No matching requests found"
      }
    });
    @endif
    });
  </script>
@endpush