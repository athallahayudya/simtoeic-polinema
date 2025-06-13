@extends('layouts.app')

@section('title', 'Users List')

@section('main')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1 style="font-size: 21px;">Users List</h1>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item active"><a href="{{ route('admin.dashboard') }}">Dashboard</a></div>
                    <div class="breadcrumb-item">Users</div>
                </div>
            </div>
            <div class="section-body">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h4>Users Data</h4>
                            </div>
                            <div class="card-body">
                                @if (session('success'))
                                    <div class="alert alert-success">{{ session('success') }}</div>
                                @endif
                                @if (session('error'))
                                    <div class="alert alert-danger">{{ session('error') }}</div>
                                @endif
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group row">
                                            <label class="col-1 control-label col-form-label">Filter by Role:</label>
                                            <div class="col-3">
                                                <select class="form-control" id="filter_role" name="role">
                                                    <option value="">- All Roles -</option>
                                                    <option value="student">Student</option>
                                                    <option value="lecturer">Lecturer</option>
                                                    <option value="staff">Staff</option>
                                                    <option value="alumni">Alumni</option>
                                                </select>
                                                <small class="form-text text-muted">Select Role</small>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="table-responsive">
                                    <table class="table table-bordered table-striped table-hover table-sm" id="table_user">
                                        <thead>
                                            <tr>
                                                <th>ID</th>
                                                <th>Role</th>
                                                <th>Identity Number</th>
                                                <th>Name</th>
                                                <th>Exam Status</th>
                                                <th>KTP</th>
                                                <th>Photo</th>
                                                <th>Home Address</th>
                                                <th>Current Address</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>

    <div id="myModal" class="modal fade animate shake" tabindex="-1" role="dialog" aria-hidden="true"></div>
@endsection

@push('style')
    <link rel="stylesheet" href="{{ asset('css/user-management.css') }}">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.2.9/css/responsive.bootstrap4.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.2.2/css/buttons.bootstrap4.min.css">
@endpush

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
    <script>
        function modalAction(url = '') {
            $('#myModal').load(url, function () {
                $('#myModal').modal('show');
            });
        }

        $(document).ready(function () {
            var dataUser = $('#table_user').DataTable({
                serverSide: true,
                ajax: {
                    url: "{{ url('users/list') }}",
                    type: "POST",
                    dataType: "json",
                    data: function (d) {
                        d._token = $('meta[name="csrf-token"]').attr('content');
                        d.role = $('#filter_role').val();
                    }
                },
                columns: [
                    {
                        data: "user_id",
                        className: "text-center",
                        orderable: true,
                        searchable: false
                    },
                    {
                        data: "role",
                        className: "",
                        orderable: true,
                        searchable: true
                    },
                    {
                        data: "identity_number",
                        className: "",
                        width: "12%",
                        orderable: false,
                        searchable: true
                    },
                    {
                        data: "name",
                        className: "",
                        orderable: true,
                        searchable: true
                    },
                    {
                        data: "exam_status",
                        className: "",
                        orderable: true,
                        searchable: true
                    },
                    {
                        data: "ktp_scan",
                        className: "",
                        orderable: false,
                        searchable: false,
                        render: function (data, type, row) {
                            return data && data !== '-' ? '<a href="' + data + '" target="_blank">KTP</a>' : '-';
                        }
                    },
                    {
                        data: "photo",
                        className: "",
                        width: "5%",
                        orderable: false,
                        searchable: false,
                        render: function (data, type, row) {
                            return data && data !== '-' ? '<a href="' + data + '" target="_blank">Photo</a>' : '-';
                        }
                    },
                    {
                        data: "home_address",
                        className: "",
                        orderable: false,
                        searchable: true
                    },
                    {
                        data: "current_address",
                        className: "",
                        orderable: false,
                        searchable: true
                    },
                    {
                        data: "action",
                        className: "",
                        width: "10%",
                        orderable: false,
                        searchable: false
                    }
                ],
                order: [[0, 'desc']],
                dom: 'Bfrtip',
                buttons: [
                    {
                        extend: 'copy',
                        exportOptions: {
                            columns: ':not(:last-child)' // Exclude the Action column
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
                lengthMenu: [[10, 25, 50, -1], [10, 25, 50, "All"]]
            });

            $('#filter_role').on('change', function () {
                dataUser.ajax.reload(); 
            });
        });
    </script>
@endpush