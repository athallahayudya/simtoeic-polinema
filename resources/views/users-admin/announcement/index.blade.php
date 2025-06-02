@extends('layouts.app')

@section('title', 'Announcement History')

@section('main')
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Announcement List</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="{{ url('/dashboard-admin') }}">Dashboard</a></div>
                <div class="breadcrumb-item">Announcement</div>
            </div>
        </div>
        <div class="section-body">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h4>Announcement History</h4>
                        </div>
                        <div class="card-body">
                            @if (session('success'))
                                <div class="alert alert-success">{{ session('success') }}</div>
                            @endif
                            @if (session('error'))
                                <div class="alert alert-danger">{{ session('error') }}</div>
                            @endif
                            <div class="row mb-3">
                                <div class="col-md-12">
                                    <div class="d-flex justify-content-between align-items-end">
                                        <div class="form-group mb-0">
                                            <label class="control-label">Filter:</label>
                                                <select class="form-control" id="announcement_status" name="announcement_status">
                                                    <option value="">- Semua</option>
                                                    <option value="published">Published</option>
                                                    <option value="draft">Draft</option>
                                                </select>
                                                <small class="form-text text-muted">Announcement Status</small>
                                        </div>
                                        <a href="{{ url('announcements/create') }}" class="btn btn-success">+ Add Announcement</a>
                                    </div>
                                </div>
                            </div>
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped table-hover table-sm" id="table_announcement" style="width: 100%;">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Tittle</th>
                                            <th>Content</th>
                                            <th>Announcement Status</th>
                                            <th>Announcement Date</th>
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
        $('#myModal').load(url, function() {
            $('#myModal').modal('show'); 
        });
    }

    $(document).ready(function() {
        var dataAnnouncement = $('#table_announcement').DataTable({
            serverSide: true,
            ajax: {
                url: "{{ url('announcements/list') }}",
                type: "POST",
                dataType: "json",
                data: function (d) {
                    d._token = $('meta[name="csrf-token"]').attr('content');
                    d.announcement_status = $('#announcement_status').val();
                }
            },
            columns: [
                {
                    data: "announcement_id",
                    className: "text-center",
                    width: "3%",
                    orderable: true,
                    searchable: false
                },
                {
                    data: "title",
                    className: "",
                    width: "15%",
                    orderable: false,
                    searchable: true
                },
                {
                    data: "content",
                    className: "",
                    width: "25%",
                    orderable: false,
                    searchable: true
                },
                {
                    data: "announcement_status",
                    className: "",
                    width: "5%",
                    orderable: true,
                    searchable: true
                },
                {
                    data: "announcement_date",
                    className: "",
                    width: "10%",
                    orderable: true,
                    searchable: false
                },
                {
                    data: "action",
                    className: "",
                    width: "12%",
                    orderable: false,
                    searchable: false
                }
            ],
            order: [[0, 'desc']]
        });
        $('#announcement_status').on('change', function(){
            dataAnnouncement.ajax.reload();
        });
    });
</script>
@endpush