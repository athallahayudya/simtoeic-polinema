@extends('layouts.app')

@section('title', 'FAQs')

@section('main')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Frequency Answer Questions</h1>
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
                                <div class="row mb-3">
                                    <div class="col-md-12">
                                        <div class="d-flex justify-content-end">
                                            <a href="{{ url('faqs/create') }}" class="btn btn-success">+ Add FAQ</a>
                                        </div>
                                    </div>
                                </div>
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
                    width: "17%", // Reduced width for better layout
                    orderable: false,
                    searchable: false
                }
                ],
                order: [[0, 'desc']], // Sort by first column (faq_id) in descending order
                language: {
                    search: "Search by question: "
                }
            });
        });
    </script>
@endpush