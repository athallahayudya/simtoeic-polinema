@extends('layouts.app')

@section('title', 'Lecturer List')

@section('main')
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Lecturer List</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="{{ url('/manage-users') }}">Manage Users</a></div>
                <div class="breadcrumb-item">Lecturer</div>
            </div>
        </div>
        <div class="section-body">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h4>Lecturer Data</h4>
                        </div>
                        <div class="card-body">
                            @if (session('success'))
                                <div class="alert alert-success">{{ session('success') }}</div>
                            @endif
                            @if (session('error'))
                                <div class="alert alert-danger">{{ session('error') }}</div>
                            @endif
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped table-hover table-sm" id="table_lecturer">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Exam Status</th>
                                            <th>Name</th>
                                            <th>NIDN</th>
                                            <th>Scan KTP</th>
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

<div id="myModal" class="modal fade animate shake" tabindex="-1" role="dialog" data-backdrop="static" data-keyboard="false" data-width="75%" aria-hidden="true"></div>
@endsection

@push('scripts')
<script>

    function modalAction(url = '') {
        $('#myModal').load(url, function() {
            $('#myModal').modal('show'); 
        });
    }

    $(document).ready(function() {
        var dataLecturer = $('#table_lecturer').DataTable({
            serverSide: true,
            ajax: {
                url: "{{ url('manage-users/lecturer/list') }}",
                type: "POST",
                dataType: "json",
                data: function (d) {
                    d._token = $('meta[name="csrf-token"]').attr('content');
                }
            },
            columns: [
                {
                    data: "DT_RowIndex",
                    className: "text-center",
                    orderable: false,
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
                    orderable: true,
                    searchable: true
                },
                {
                    data: "nidn",
                    className: "",
                    orderable: true,
                    searchable: true
                },
                {
                    data: "ktp_scan",
                    className: "",
                    width: "3%",
                    orderable: false,
                    searchable: false,
                    render: function(data, type, row) {
                        return data ? '<a href="' + data + '" target="_blank">KTP</a>' : '-';
                    }
                },
                {
                    data: "photo",
                    className: "",
                    orderable: false,
                    searchable: false,
                    render: function(data, type, row) {
                        return data ? '<img src="' + data + '" alt="Foto" width="50" height="50">' : '-';
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
                    width: "15%",
                    orderable: false,
                    searchable: false
                }
            ]
        });
    });
</script>
@endpush