@extends('layouts.app')

@section('title', 'FAQs')

@push('styles')
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.2/css/buttons.dataTables.min.css">
    <style>
        /* Make search input width match button width */
        .dataTables_filter input {
            width: 120px !important;
            display: inline-block;
        }

        /* Ensure button and search input have consistent styling */
        .dt-buttons .btn {
            width: 120px;
        }
    </style>
@endpush

@section('main')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1 style="font-size: 21px;">Frequency Answer Questions</h1>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item active"><a href="{{ url('/dashboard-admin') }}">Dashboard</a></div>
                    <div class="breadcrumb-item">FAQ</div>
                </div>
            </div>
            <div class="section-body">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h4>FAQs List</h4>
                            </div>
                            <div class="card-body">
                                @if (session('success'))
                                    <div class="alert alert-success">{{ session('success') }}</div>
                                @endif
                                @if (session('error'))
                                    <div class="alert alert-danger">{{ session('error') }}</div>
                                @endif
                                <div class="table-responsive">
                                    <table class="table table-bordered table-striped table-hover table-sm" id="table_faq"
                                        style="width: 100%;">
                                        <thead>
                                            <tr>
                                                <th>ID</th>
                                                <th>Question</th>
                                                <th>Answer</th>
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
    <script src="https://cdn.datatables.net/buttons/2.4.2/js/dataTables.buttons.min.js"></script>
    <script>
        function modalAction(url = '') {
            $('#myModal').load(url, function () {
                $('#myModal').modal('show');
            });
        }

        $(document).ready(function () {
            var dataFaq = $('#table_faq').DataTable({
                serverSide: true,
                ajax: {
                    url: "{{ url('faqs/list') }}",
                    type: "POST",
                    dataType: "json",
                    data: function (d) {
                        d._token = $('meta[name="csrf-token"]').attr('content');
                    }
                },
                dom: '<"row"<"col-md-6"l><"col-md-6"<"d-flex justify-content-end"B<"ml-2"f>>>>rtip',
                buttons: [
                    {
                        text: '+ Add FAQ',
                        className: 'btn btn-success',
                        action: function (e, dt, node, config) {
                            window.location.href = "{{ url('faqs/create') }}";
                        }
                    }
                ],
                columns: [{
                    data: "faq_id",
                    className: "text-center",
                    width: "3%",
                    orderable: true,
                    searchable: false
                },
                {
                    data: "question",
                    className: "",
                    width: "35%",
                    orderable: false,
                    searchable: true // Only this column is searchable
                },
                {
                    data: "answer",
                    className: "",
                    width: "45%",
                    orderable: false,
                    searchable: false // Changed to false to prevent searching in answer text
                },
                {
                    data: "action",
                    className: "",
                    width: "11%", // Reduced width for better layout
                    orderable: false,
                    searchable: false
                }
                ],
                order: [[0, 'desc']], // Sort by first column (faq_id) in descending order
                language: {
                    search: "",
                    searchPlaceholder: "Search by question..."
                }
            });
        });
    </script>
@endpush