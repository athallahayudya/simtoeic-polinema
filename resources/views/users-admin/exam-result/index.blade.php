@extends('layouts.app')

@section('title', 'Exam Results')

@push('style')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.2.9/css/responsive.bootstrap4.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.2.2/css/buttons.bootstrap4.min.css">
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css">
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

        .filter-card {
            margin-bottom: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.05);
        }

        .filter-card .card-header {
            background-color: #f8f9fa;
            border-bottom: 1px solid #e9ecef;
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
    </style>
@endpush

@section('main')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Exam Results</h1>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item active"><a href="{{ route('admin.dashboard') }}">Dashboard</a></div>
                    <div class="breadcrumb-item">Exam Results</div>
                </div>
            </div>

            <div class="section-body">
                <h2 class="section-title">TOEIC Exam Results Management</h2>

                <div class="row">
                    <div class="col-12">
                        @if (session('success'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                <strong>Success!</strong> {{ session('success') }}
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                        @endif

                        @if (session('error'))
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <strong>Error!</strong> {{ session('error') }}
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                        @endif

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
                                            <label>Select File to Import (Excel/CSV)</label>
                                            <div class="custom-file">
                                                <input type="file" class="custom-file-input" id="importFile" name="file"
                                                    required>
                                                <label class="custom-file-label" for="importFile">Choose file...</label>
                                                <small class="form-text text-muted">Supported formats: .xlsx, .xls, .csv
                                                    (max 10MB)</small>
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

                                <div class="alert alert-info">
                                    <div class="d-flex align-items-center">
                                        <i class="fas fa-info-circle fa-2x mr-3"></i>
                                        <div>
                                            <strong>Import Format Guide</strong>
                                            <p class="mb-0">
                                                Your Excel file should match the exact structure of the TOEIC results
                                                sheet:<br>
                                                <code>RESULT_#</code> (Exam ID)<br>
                                                <code>NAME</code> (Student Name)<br>
                                                <code>ID</code> (Student NIM - Required)<br>
                                                <code>L</code> (Listening Score)<br>
                                                <code>R</code> (Reading Score)<br>
                                                <code>TOT</code> (Total Score)<br>
                                                <code>TEST DATE</code> (Optional, date of exam)<br>
                                                Note: Excel column names are case-insensitive when importing.
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Filters Card -->
                        <div class="card filter-card">
                            <div class="card-header">
                                <h4><i class="fas fa-filter mr-2"></i>Filter Results</h4>
                                <div class="card-header-action">
                                    <a data-collapse="#filter-collapse" class="btn btn-icon btn-info" href="#"><i
                                            class="fas fa-minus"></i></a>
                                </div>
                            </div>
                            <div class="collapse show" id="filter-collapse">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label>Status</label>
                                                <select id="status-filter" class="form-control">
                                                    <option value="">All</option>
                                                    <option value="pass">Pass</option>
                                                    <option value="fail">Fail</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label>Score Range</label>
                                                <select id="score-filter" class="form-control">
                                                    <option value="">All</option>
                                                    <option value="0-399">0-399</option>
                                                    <option value="400-499">400-499</option>
                                                    <option value="500-699">500-699</option>
                                                    <option value="700-990">700-990</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label>From Date</label>
                                                <input type="text" id="date-from" class="form-control datepicker"
                                                    placeholder="YYYY-MM-DD">
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label>To Date</label>
                                                <input type="text" id="date-to" class="form-control datepicker"
                                                    placeholder="YYYY-MM-DD">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="text-center">
                                        <button id="apply-filters" class="btn btn-primary mr-2">
                                            <i class="fas fa-check mr-1"></i> Apply Filters
                                        </button>
                                        <button id="reset-filters" class="btn btn-light">
                                            <i class="fas fa-redo mr-1"></i> Reset
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Results Card -->
                        <div class="card">
                            <div class="card-header">
                                <h4><i class="fas fa-table mr-2"></i>Exam Results</h4>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table id="exam-results-table"
                                        class="table table-striped table-bordered dt-responsive nowrap">
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
                                                    <td>{{ $result->exam_date ? $result->exam_date->format('Y-m-d') : 'N/A' }}
                                                    </td>
                                                    <td>
                                                        @if($result->status == 'pass')
                                                            <span class="badge badge-success">Pass</span>
                                                        @else
                                                            <span class="badge badge-danger">Fail</span>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        <button class="btn btn-sm btn-info view-details"
                                                            data-id="{{ $result->id }}">
                                                            <i class="fas fa-eye"></i>
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

            // Form submission with AJAX
            $('#importForm').on('submit', function (e) {
                e.preventDefault();

                var formData = new FormData(this);

                $.ajax({
                    url: $(this).attr('action'),
                    type: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function (response) {
                        // Show success message
                        toastr.success('Exam results imported successfully!');

                        // Reload the page to show new data
                        setTimeout(function () {
                            window.location.reload();
                        }, 1500);
                    },
                    error: function (xhr) {
                        // Show error message
                        toastr.error('Error importing file: ' + xhr.responseText);
                    }
                });
            });
            // Initialize custom file input
            $('.custom-file-input').on('change', function () {
                let fileName = $(this).val().split('\\').pop();
                $(this).next('.custom-file-label').addClass("selected").html(fileName);
            });

            // Form submission with validation
            $('#importForm').on('submit', function (e) {
                e.preventDefault();

                // Check if file is selected
                var fileInput = $('#importFile')[0];
                if (!fileInput.files.length) {
                    alert('Please select a file to import.');
                    return false;
                }

                // Disable button to prevent multiple submissions
                $('#importButton').prop('disabled', true).text('Importing...');

                var formData = new FormData(this);

                $.ajax({
                    url: $(this).attr('action'),
                    type: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function (response) {
                        // Show success message
                        if (typeof toastr !== 'undefined') {
                            toastr.success('Exam results imported successfully!');
                        } else {
                            alert('Exam results imported successfully!');
                        }

                        // Reload the page to show new data
                        setTimeout(function () {
                            window.location.reload();
                        }, 1500);
                    },
                    error: function (xhr) {
                        // Re-enable button
                        $('#importButton').prop('disabled', false).html('<i class="fas fa-upload mr-1"></i> Import Results');

                        // Show error message
                        if (typeof toastr !== 'undefined') {
                            toastr.error('Error importing file: ' + xhr.responseText);
                        } else {
                            alert('Error importing file: ' + xhr.responseText);
                        }
                    }
                });
            });

            // Initialize datepicker
            $('.datepicker').datepicker({
                format: 'yyyy-mm-dd',
                autoclose: true,
                todayHighlight: true
            });

            // Initialize DataTable
            var table = $('#exam-results-table').DataTable({
                responsive: true,
                dom: 'Bfrtip',
                buttons: [
                    'copy', 'csv', 'excel', 'pdf', 'print'
                ],
                order: [[6, 'desc']], // Sort by exam date descending
                lengthMenu: [[10, 25, 50, -1], [10, 25, 50, "All"]]
            });

            // Apply filters
            $('#apply-filters').on('click', function () {
                applyFilters();
            });

            // Reset filters
            $('#reset-filters').on('click', function () {
                $('#status-filter').val('');
                $('#score-filter').val('');
                $('#date-from').val('');
                $('#date-to').val('');
                table.search('').columns().search('').draw();
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
                var status = row.find('td:eq(7)').text().trim();

                // Populate modal with data
                $('#modal-nim').text(nim);
                $('#modal-name').text(name);
                $('#modal-exam-date').text(examDate);
                $('#modal-status').html(status.includes('Pass') ?
                    '<span class="badge badge-success">Pass</span>' :
                    '<span class="badge badge-danger">Fail</span>');
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
                var statusFilter = $('#status-filter').val();
                var scoreFilter = $('#score-filter').val();
                var dateFrom = $('#date-from').val();
                var dateTo = $('#date-to').val();

                // Clear existing filters
                table.search('').columns().search('').draw();

                // Apply status filter
                if (statusFilter) {
                    table.column(7).search(statusFilter, true, false).draw(); // Status is column 7
                }

                // Apply score filter
                if (scoreFilter) {
                    var scoreRange = scoreFilter.split('-');
                    var minScore = parseInt(scoreRange[0]);
                    var maxScore = parseInt(scoreRange[1]);

                    $.fn.dataTable.ext.search.push(
                        function (settings, data, dataIndex) {
                            var score = parseFloat(data[5].replace(/[^\d.-]/g, '')) || 0; // Total score is column 5
                            if (minScore <= score && score <= maxScore) {
                                return true;
                            }
                            return false;
                        }
                    );
                    table.draw();
                    $.fn.dataTable.ext.search.pop();
                }

                // Apply date range filter
                if (dateFrom || dateTo) {
                    $.fn.dataTable.ext.search.push(
                        function (settings, data, dataIndex) {
                            var examDate = new Date(data[6]); // Exam date is column 6
                            var fromDate = dateFrom ? new Date(dateFrom) : new Date(0);
                            var toDate = dateTo ? new Date(dateTo) : new Date(9999, 11, 31);

                            if ((fromDate <= examDate) && (examDate <= toDate)) {
                                return true;
                            }
                            return false;
                        }
                    );
                    table.draw();
                    $.fn.dataTable.ext.search.pop();
                }
            }
        });
    </script>
@endpush