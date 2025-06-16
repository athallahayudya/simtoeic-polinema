@extends('layouts.app')

@section('title', 'Exam Results')

@push('style')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.2.9/css/responsive.bootstrap4.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.2.2/css/buttons.bootstrap4.min.css">
    <style>
        .btn {
            cursor: pointer;
            z-index: 1;
            position: relative;
        }

        .btn:disabled {
            cursor: not-allowed;
            opacity: 0.6;
        }

        .import-section {
            border: 2px dashed #e9ecef;
            padding: 20px;
            border-radius: 10px;
            margin-bottom: 20px;
            transition: all 0.3s ease;
            position: relative;
            z-index: 1;
        }

        .custom-file-label::after {
            content: "Browse";
        }

        .dataTables_filter {
            margin-bottom: 15px;
        }

        .score-badge {
            padding: 5px 10px;
            border-radius: 30px;
            font-weight: 600;
        }

        .score-low {
            background-color: #fc544b;
            color: white;
        }

        .score-high {
            background-color: #47c363;
            color: white;
        }

        .import-section {
            border: 2px dashed #e9ecef;
            padding: 20px;
            border-radius: 10px;
            margin-bottom: 20px;
            transition: all 0.3s ease;
        }

        .import-section:hover {
            border-color: #6777ef;
        }

        .filter-group {
            margin-bottom: 10px;
        }

        .alert-danger {
            border-left: 4px solid #dc3545;
        }

        .alert-success {
            border-left: 4px solid #28a745;
        }

        .alert-dismissible .close {
            top: 50%;
            transform: translateY(-50%);
        }
    </style>
@endpush

@section('main')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1 style="font-size: 21px;">Exam Results</h1>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item active"><a href="{{ route('admin.dashboard') }}">Dashboard</a></div>
                    <div class="breadcrumb-item">Exam Results</div>
                </div>
            </div>

            <div class="section-body">
                <h2 class="section-title">TOEIC Exam Results Management</h2>

                <!-- Import Section -->
                <div class="card">
                    <div class="card-header">
                        <h4><i class="fas fa-file-import mr-2"></i>Import Exam Results</h4>
                    </div>
                    <div class="card-body">
                        <div class="import-section">
                            <form id="importForm" action="{{ route('exam-results.import.store') }}" method="POST"
                                enctype="multipart/form-data">
                                @csrf
                                <div class="form-group">
                                    <label>Upload TOEIC Results PDF</label>
                                    <div class="custom-file">
                                        <input type="file" class="custom-file-input" id="importFile" name="file"
                                            accept=".pdf" required>
                                        <label class="custom-file-label" for="importFile">Choose PDF file...</label>
                                        <small class="form-text text-muted">Supported format: .pdf (max
                                            10MB)</small>
                                    </div>
                                    @error('file')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="text-center">
                                    <button type="submit" class="btn btn-primary" id="importButton">
                                        <i class="fas fa-upload mr-1"></i> Import Results
                                    </button>
                                </div>
                            </form>
                        </div>

                        <!-- Format Error Alert -->
                        @if(session('format_error'))
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <div class="d-flex align-items-start">
                                    <i class="fas fa-exclamation-circle fa-lg mr-3 mt-1"></i>
                                    <div>
                                        <strong>Import Format Error!</strong>
                                        <p class="mb-0 mt-1">{{ session('format_error') }}</p>
                                        <small class="mt-2 d-block">
                                            Please check the Import Format Guide below and ensure your PDF contains the exact
                                            column names:
                                            <strong>result</strong>, <strong>name</strong>, <strong>id</strong>,
                                            <strong>L</strong>, <strong>R</strong>, and <strong>tot</strong>.
                                        </small>
                                    </div>
                                </div>
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                        @endif

                        <!-- General Error Alert -->
                        @if(session('error'))
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <div class="d-flex align-items-start">
                                    <i class="fas fa-exclamation-triangle fa-lg mr-3 mt-1"></i>
                                    <div>
                                        <strong>Import Error!</strong>
                                        <p class="mb-0 mt-1">{{ session('error') }}</p>
                                    </div>
                                </div>
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                        @endif

                        <!-- Success Alert -->
                        @if(session('success'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                <div class="d-flex align-items-start">
                                    <i class="fas fa-check-circle fa-lg mr-3 mt-1"></i>
                                    <div>
                                        <strong>Import Successful!</strong>
                                        <p class="mb-0 mt-1">{{ session('success') }}</p>
                                    </div>
                                </div>
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                        @endif

                        <div class="alert alert-danger">
                            <div class="d-flex align-items-start">
                                <i class="fas fa-exclamation-triangle fa-lg mr-3 mt-1 text-white"></i>
                                <div class="text-white">
                                    <strong>Import Format Guide</strong>
                                    <p class="mb-2">
                                        Upload the official TOEIC results PDF. Make sure your PDF table contains
                                        these columns:
                                    </p>
                                    <div class="row text-center mb-2">
                                        <div class="col-2">
                                            <div class="border p-2 rounded mb-1 bg-white">
                                                <small class="text-dark"><strong>result</strong></small>
                                            </div>
                                            <small class="text-white"><strong>Exam ID</strong></small>
                                        </div>
                                        <div class="col-2">
                                            <div class="border p-2 rounded mb-1 bg-white">
                                                <small class="text-dark"><strong>name</strong></small>
                                            </div>
                                            <small class="text-white"><strong>Name</strong></small>
                                        </div>
                                        <div class="col-2">
                                            <div class="border p-2 rounded mb-1 bg-white">
                                                <small class="text-dark"><strong>id</strong></small>
                                            </div>
                                            <small class="text-white"><strong>NIM</strong></small>
                                        </div>
                                        <div class="col-2">
                                            <div class="border p-2 rounded mb-1 bg-white">
                                                <small class="text-dark"><strong>L</strong></small>
                                            </div>
                                            <small class="text-white"><strong>Listening</strong></small>
                                        </div>
                                        <div class="col-2">
                                            <div class="border p-2 rounded mb-1 bg-white">
                                                <small class="text-dark"><strong>R</strong></small>
                                            </div>
                                            <small class="text-white"><strong>Reading</strong></small>
                                        </div>
                                        <div class="col-2">
                                            <div class="border p-2 rounded mb-1 bg-white">
                                                <small class="text-dark"><strong>tot</strong></small>
                                            </div>
                                            <small class="text-white"><strong>Score</strong></small>
                                        </div>
                                    </div>
                                    <p class="mb-0">
                                        <small><strong>Note:</strong> System will automatically create student
                                            accounts and calculate pass/fail status.</small>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Exam Results and Filter Card -->
                <div class="card">
                    <div class="card-header">
                        <h4><i class="fas fa-table mr-2"></i>Exam Results</h4>
                    </div>
                    <div class="card-body">
                        <!-- Filter Section -->
                        <div class="row mb-3">
                            <div class="col-md-3">
                                <div class="filter-group">
                                    <label>Status</label>
                                    <select id="status-filter" class="form-control">
                                        <option value="">All</option>
                                        <option value="pass">Pass</option>
                                        <option value="fail">Fail</option>
                                        <option value="on_process">On Process</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="filter-group">
                                    <label>Level CEFR</label>
                                    <select id="score-filter" class="form-control">
                                        <option value="">All Levels</option>
                                        <option value="0-250">0-250 (A1) Beginner</option>
                                        <option value="255-400">255-400 (A1 - A2) Elementary</option>
                                        <option value="405-600">405-600 (A2 - B1) Lower Intermediate</option>
                                        <option value="605-780">605-780 (B1 - B2) Mid Intermediate</option>
                                        <option value="785-900">785-900 (B2 - C1) Upper Intermediate</option>
                                        <option value="905-990">905-990 (C2) Advanced</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <!-- Table Section -->
                        <div class="table-responsive">
                            <table id="exam-results-table" class="table table-striped table-bordered dt-responsive nowrap"
                                style="width:100%">
                                <thead>
                                    <tr>
                                        <th>ID Exam</th>
                                        <th>NIM</th>
                                        <th>Name</th>
                                        <th>Listening Score</th>
                                        <th>Reading Score</th>
                                        <th>Total Score</th>
                                        <th>Exam Date</th>
                                        <th>Status</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($examResults as $result)
                                        <tr>
                                            <td>{{ $result->id_exam }}</td>
                                            <td>{{ $result->nim }}</td>
                                            <td>{{ $result->name }}</td>
                                            <td>{{ $result->listening_score }}</td>
                                            <td>{{ $result->reading_score }}</td>
                                            <td>
                                                <span
                                                    class="score-badge {{ $result->total_score < 500 ? 'score-low' : 'score-high' }}">
                                                    {{ $result->total_score }}
                                                </span>
                                            </td>
                                            <td>{{ $result->exam_date ? $result->exam_date->format('Y-m-d') : ($result->created_at ? $result->created_at->format('Y-m-d') : 'N/A') }}
                                            </td>
                                            <td>
                                                @if($result->total_score == 0)
                                                    <span class="badge badge-warning">On Process</span>
                                                @elseif($result->status == 'pass' || $result->total_score >= 500)
                                                    <span class="badge badge-success">Pass</span>
                                                @else
                                                    <span class="badge badge-danger">Fail</span>
                                                @endif
                                            </td>
                                            <td>
                                                <button class="btn btn-sm btn-info view-details"
                                                    data-id="{{ $result->result_id }}">
                                                    <i class="fas fa-eye"></i>
                                                </button>
                                                <button class="btn btn-sm btn-danger delete-result"
                                                    data-id="{{ $result->result_id }}">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>

    <!-- Details Modal -->
    <div class="modal fade" id="detailsModal" tabindex="-1" role="dialog" aria-labelledby="detailsModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="detailsModalLabel">Exam Result Details</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="text-center mb-3">
                        <span id="modal-score-badge" class="score-badge"></span>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <tr>
                                <th>NIM</th>
                                <td id="modal-nim"></td>
                            </tr>
                            <tr>
                                <th>Name</th>
                                <td id="modal-name"></td>
                            </tr>
                            <tr>
                                <th>Exam Date</th>
                                <td id="modal-exam-date"></td>
                            </tr>
                            <tr>
                                <th>Status</th>
                                <td id="modal-status"></td>
                            </tr>
                            <tr>
                                <th>Imported At</th>
                                <td id="modal-imported-at"></td>
                            </tr>
                            <tr>
                                <th>Imported By</th>
                                <td id="modal-imported-by"></td>
                            </tr>
                        </table>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Alert Message Modal -->
    <div class="modal fade" id="messageModal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="messageModalTitle">Notification</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" id="messageModalBody">
                    <!-- Message will be inserted here -->
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap4.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.2.9/js/dataTables.responsive.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.2.9/js/responsive.bootstrap4.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.2.2/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.2.2/js/buttons.bootstrap4.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.2.2/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.2.2/js/buttons.print.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js"></script>
    <script src="{{ asset('js/admin/exam-results.js') }}"></script>
    <script>
        $(document).ready(function () {

            // Function to show message modal
            function showMessageModal(message, isSuccess) {
                $('#messageModalTitle').text(isSuccess ? 'Success' : 'Error');
                $('#messageModalBody').html(message);

                // Set header color based on message type
                $('.modal-header').removeClass('bg-success bg-danger')
                    .addClass(isSuccess ? 'bg-success' : 'bg-danger');
                $('.modal-header').css('color', 'white');

                $('#messageModal').modal('show');

                // If success, reload after closing
                if (isSuccess) {
                    $('#messageModal').on('hidden.bs.modal', function () {
                        location.reload();
                    });
                }
            }

            // Form submission validation
            $('#importForm').on('submit', function (e) {
                // Check if file is selected
                var fileInput = $('#importFile')[0];
                if (!fileInput.files.length) {
                    e.preventDefault();
                    alert('Please select a PDF file to import.');
                    return false;
                }

                // Check file type
                var fileName = fileInput.files[0].name;
                var fileExtension = fileName.split('.').pop().toLowerCase();
                if (fileExtension !== 'pdf') {
                    e.preventDefault();
                    alert('Please select a PDF file.');
                    return false;
                }

                // Disable button to prevent multiple submissions
                $('#importButton').prop('disabled', true).html('<i class="fas fa-spinner fa-spin mr-1"></i> Importing...');

                // Form will submit normally - no need to prevent default
                return true;
            });

            // Initialize custom file input
            $('.custom-file-input').on('change', function () {
                let fileName = $(this).val().split('\\').pop();
                $(this).next('.custom-file-label').addClass("selected").html(fileName);
            });

            // Initialize DataTable
            var table = $('#exam-results-table').DataTable({
                responsive: true,
                dom: 'Bfrtip',
                buttons: [
                    {
                        extend: 'copy',
                        exportOptions: {
                            columns: ':not(:last-child)'
                        }
                    },
                    {
                        extend: 'csv',
                        exportOptions: {
                            columns: ':not(:last-child)'
                        }
                    },
                    {
                        extend: 'excel',
                        exportOptions: {
                            columns: ':not(:last-child)'
                        }
                    },
                    {
                        extend: 'pdf',
                        exportOptions: {
                            columns: ':not(:last-child)'
                        }
                    },
                    {
                        extend: 'print',
                        exportOptions: {
                            columns: ':not(:last-child)'
                        }
                    }
                ],
                order: [[6, 'desc']], // Sort by exam date descending
                lengthMenu: [[10, 25, 50, -1], [10, 25, 50, "All"]]
            });

            // Apply filters on change
            $('#status-filter, #score-filter').on('change', function () {
                applyFilters();
            });

            // View details handler
            $(document).on('click', '.view-details', function () {
                var id = $(this).data('id');
                var row = $(this).closest('tr');

                // Get data from the correct columns
                var exam = row.find('td:eq(0)').text();
                var nim = row.find('td:eq(1)').text();
                var name = row.find('td:eq(2)').text();
                var listening = row.find('td:eq(3)').text();
                var reading = row.find('td:eq(4)').text();
                var total = row.find('td:eq(5)').text().trim();
                var examDate = row.find('td:eq(6)').text();
                var status = row.find('td:eq(7)').text().trim().toLowerCase();

                // Populate modal with data
                $('#modal-nim').text(nim);
                $('#modal-name').text(name);
                $('#modal-exam-date').text(examDate);
                // Determine status based on total score
                var scoreValue = total.replace(/[^\d]/g, '');
                var statusHtml;
                if (parseInt(scoreValue) == 0) {
                    statusHtml = '<span class="badge badge-warning">On Process</span>';
                } else if (status === 'pass' || parseInt(scoreValue) >= 500) {
                    statusHtml = '<span class="badge badge-success">Pass</span>';
                } else {
                    statusHtml = '<span class="badge badge-danger">Fail</span>';
                }
                $('#modal-status').html(statusHtml);
                $('#modal-imported-at').text('N/A');
                $('#modal-imported-by').text('System');

                // Score badge - extract numeric value from the total score badge
                var scoreValue = total.replace(/[^\d]/g, '');
                $('#modal-score-badge').text(scoreValue).removeClass('score-high score-low')
                    .addClass(parseInt(scoreValue) < 500 ? 'score-low' : 'score-high');

                $('#detailsModal').modal('show');
            });

            // Function to apply filters
            function applyFilters() {
                var statusFilter = $('#status-filter').val().toLowerCase();
                var scoreFilter = $('#score-filter').val();

                // Custom status filter for ON PROCESS
                if (statusFilter) {
                    $.fn.dataTable.ext.search.push(
                        function (settings, data, dataIndex) {
                            var statusText = data[7].toLowerCase(); // Status column
                            var score = parseFloat(data[5].replace(/[^\d.-]/g, '')) || 0; // Total score

                            if (statusFilter === 'on_process') {
                                return score === 0 || statusText.includes('on process');
                            } else if (statusFilter === 'pass') {
                                return statusText.includes('pass');
                            } else if (statusFilter === 'fail') {
                                return statusText.includes('fail');
                            }
                            return true;
                        }
                    );
                } else {
                    // Clear status filter
                    table.column(7).search('', true, false);
                }

                if (scoreFilter) {
                    var scoreRange = scoreFilter.split('-');
                    var minScore = parseInt(scoreRange[0]);
                    var maxScore = parseInt(scoreRange[1]);

                    $.fn.dataTable.ext.search.push(
                        function (settings, data, dataIndex) {
                            var score = parseFloat(data[5].replace(/[^\d.-]/g, '')) || 0; // Total score is column 5
                            return minScore <= score && score <= maxScore;
                        }
                    );
                }

                table.draw();

                // Clear all custom filters
                while ($.fn.dataTable.ext.search.length > 0) {
                    $.fn.dataTable.ext.search.pop();
                }
            }

            // Delete single result handler
            $(document).on('click', '.delete-result', function () {
                var id = $(this).data('id');
                if (confirm('Are you sure you want to delete this exam result?')) {
                    $.ajax({
                        url: '/exam-results/' + id,
                        type: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        success: function (response) {
                            showMessageModal('Exam result deleted successfully!', true);
                        },
                        error: function (xhr) {
                            let errorMsg = 'Error deleting exam result';
                            if (xhr.responseJSON && xhr.responseJSON.message) {
                                errorMsg = xhr.responseJSON.message;
                            }
                            showMessageModal(errorMsg, false);
                        }
                    });
                }
            });
        });
    </script>
@endpush