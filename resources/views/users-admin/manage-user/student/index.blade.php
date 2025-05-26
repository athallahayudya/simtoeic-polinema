@extends('layouts.app')

@section('title', 'Student List')

@section('main')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Student List</h1>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item active"><a href="{{ url('/users') }}">Users</a></div>
                    <div class="breadcrumb-item">Students</div>
                </div>
            </div>
            <div class="section-body">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h4>Student Data</h4>
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
                                            <label class="col-1 control-label col-form-label">Filter:</label>
                                            <div class="col-3">
                                                <select class="form-control" id="campus" name="campus" required>
                                                    <option value="">- Semua</option>
                                                    <option value="malang">Politeknik Negeri Malang</option>
                                                    <option value="psdku_kediri">PSDKU Kediri</option>
                                                    <option value="psdku_lumajang">PSDKU Lumajang</option>
                                                    <option value="psdku_pamekasan">PSDKU Pamekasan</option>
                                                </select>
                                                <small class="form-text text-muted">Campus</small>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="table-responsive">
                                    <table class="table table-bordered table-striped table-hover table-sm"
                                        id="table_student">
                                        <thead>
                                            <tr>
                                                <th>ID</th>
                                                <th>Exam Status</th>
                                                <th>Name</th>
                                                <th>NIM</th>
                                                <th>Major</th>
                                                <th>Study Program</th>
                                                <th>Campus</th>
                                                <th>Scan KTP</th>
                                                <th>Scan KTM</th>
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

@push('scripts')
    <script>

        function modalAction(url = '') {
            $('#myModal').load(url, function () {
                $('#myModal').modal('show');
            });
        }

        $(document).ready(function () {
            var dataStudent = $('#table_student').DataTable({
                serverSide: true,
                ajax: {
                    url: "{{ url('manage-users/student/list') }}",
                    type: "POST",
                    dataType: "json",
                    data: function (d) {
                        d._token = $('meta[name="csrf-token"]').attr('content');
                        d.campus = $('#campus').val();
                    }
                },
                columns: [
                    {
                        data: "student_id",
                        className: "text-center",
                        orderable: true,
                        searchable: false
                    },
                    {
                        data: "user.exam_status",
                        className: "",
                        orderable: true,
                        searchable: true
                    },
                    {
                        data: "name",
                        className: "",
                        width: "12%",
                        orderable: false,
                        searchable: true
                    },
                    {
                        data: "nim",
                        className: "",
                        orderable: true,
                        searchable: true
                    },
                    {
                        data: "major",
                        className: "",
                        orderable: true,
                        searchable: true,
                        render: function (data, type, row) {
                            return data || '-';
                        }
                    },
                    {
                        data: "study_program",
                        className: "",
                        orderable: true,
                        searchable: true,
                        render: function (data, type, row) {
                            return data || '-';
                        }
                    },
                    {
                        data: "campus",
                        className: "",
                        orderable: true,
                        searchable: true,
                        render: function (data, type, row) {
                            return data || '-';
                        }
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
                        data: "ktm_scan",
                        className: "",
                        orderable: false,
                        searchable: false,
                        render: function (data, type, row) {
                                return data && data !== '-' ? '<a href="' + data + '" target="_blank">KTM</a>' : '-';
                        }
                    },
                    {
                        data: "photo",
                        className: "",
                        width: "7%",
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
                        width: "18%",
                        orderable: false,
                        searchable: false
                    }
                ],
                order: [[0, 'desc']]
            });
            $('#campus').on('change', function () {
                dataStudent.ajax.reload();
            });
        });
    </script>
@endpush