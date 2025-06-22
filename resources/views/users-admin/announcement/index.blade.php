@extends('layouts.app')

@section('title', 'Announcement History')

@push('styles')
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.2/css/buttons.dataTables.min.css">
    <style>
        /* Make search input width match button width */
        .dataTables_filter input {
            width: 150px !important;
            display: inline-block;
        }

        /* Ensure buttons have consistent styling */
        .dt-buttons .btn {
            width: 120px;
            margin-right: 5px;
        }

        /* Custom styling for filter dropdown */
        #announcement_status {
            width: 150px;
        }

        /* Add spacing between filter and datatable */
        .table-responsive {
            margin-top: 20px;
        }

        /* Add spacing for datatable wrapper */
        .dataTables_wrapper {
            margin-top: 15px;
        }

        /* Add spacing between datatable controls and table content */
        .dataTables_wrapper .row:first-child {
            margin-bottom: 20px;
        }

        /* Additional spacing for table */
        .dataTables_wrapper table {
            margin-top: 15px;
        }
    </style>
@endpush

@section('main')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1 style="font-size: 21px;">Announcement List</h1>
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
                                    <div class="col-md-3">
                                        <div class="form-group mb-0">
                                            <label class="control-label">Filter:</label>
                                            <select class="form-control" id="announcement_status"
                                                name="announcement_status">
                                                <option value="">- Semua</option>
                                                <option value="published">Published</option>
                                                <option value="draft">Draft</option>
                                            </select>
                                            <small class="form-text text-muted">Announcement Status</small>
                                        </div>
                                    </div>
                                </div>
                                <div class="table-responsive">
                                    <table class="table table-bordered table-striped table-hover table-sm"
                                        id="table_announcement" style="width: 100%;">
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

    <!-- Upload Announcement Modal -->
    <div class="modal fade" id="uploadModal" tabindex="-1" role="dialog" aria-labelledby="uploadModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="uploadModalLabel">
                        Added New Announcement
                    </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="uploadForm" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="title">Title <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="title" name="title" required>
                        </div>

                        <div class="form-group">
                            <label for="description">Description</label>
                            <textarea class="form-control" id="description" name="description" rows="3"
                            placeholder="Brief description of the announcement..."></textarea>
                        </div>

                        <div class="form-group">
                            <label>Status</label>
                            <select name="announcement_status"
                                class="form-control @error('announcement_status') is-invalid @enderror">
                                <option value="draft" {{ old('announcement_status') == 'draft' ? 'selected' : '' }}>Draft
                                </option>
                                <option value="published" {{ old('announcement_status') == 'published' ? 'selected' : '' }}>Published</option>
                            </select>
                            @error('announcement_status')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div id="documentFields" style="display: none;">
                            <!-- Document fields will be added here by JavaScript if needed -->
                        </div>
                        <button type="button" id="addDocument" class="mt-2">+ Add Document</button>

                        <div class="form-group">
                            <label>Visible To</label>
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox" class="custom-control-input" id="visible_student"
                                            name="visible_to[]" value="student">
                                        <label class="custom-control-label" for="visible_student">Students</label>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox" class="custom-control-input" id="visible_staff"
                                            name="visible_to[]" value="staff">
                                        <label class="custom-control-label" for="visible_staff">Staff</label>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox" class="custom-control-input" id="visible_alumni"
                                            name="visible_to[]" value="alumni">
                                        <label class="custom-control-label" for="visible_alumni">Alumni</label>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox" class="custom-control-input" id="visible_lecturer"
                                            name="visible_to[]" value="lecturer">
                                        <label class="custom-control-label" for="visible_lecturer">Lecturers</label>
                                    </div>
                                </div>
                            </div>
                            <small class="form-text text-muted">Leave unchecked to make visible to all user types.</small>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-upload mr-1"></i> Upload
                        </button>
                    </div>
                </form>
            </div>
        </div>
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
                dom: '<"row"<"col-md-6"l><"col-md-6"<"d-flex justify-content-end"B<"ml-2"f>>>>rtip',
                buttons: [
                    {
                        text: '+ Add Announcement',
                        className: 'btn btn-success',
                        action: function (e, dt, node, config) {
                            $('#uploadModal').modal('show');
                            $('#documentFields').hide(); // Hide document fields by default
                            $('#addDocument').show(); // Ensure Add Document button is visible
                        }
                    }
                ],
                language: {
                    search: "",
                    searchPlaceholder: "Search announcements..."
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
                        width: "7%",
                        orderable: false,
                        searchable: false
                    }
                ],
                order: [[4, 'desc']]
            });
            $('#announcement_status').on('change', function () {
                dataAnnouncement.ajax.reload();
            });

            // Handle dynamic document fields
            let documentAdded = false;
            function addDocumentField() {
                if (!documentAdded) {
                    const fieldHtml = `
                        <div class="form-group document-field">
                            <div class="form-group">
                                <label for="announcement_file"> PDF File</label>
                                <div class="custom-file">
                                    <input type="file" class="custom-file-input" id="announcement_file" name="announcement_file" accept=".pdf">
                                    <label class="custom-file-label" for="announcement_file">Choose PDF file...</label>
                                </div>
                                <small class="form-text text-muted">Maximum file size: 20MB. Only PDF files are allowed.</small>
                            </div>

                            <div class="form-group">
                                <label for="photo">Image</label>
                                <div class="custom-file">
                                    <input type="file" class="custom-file-input" id="photo" name="photo" accept=".jpg,.jpeg,.png">
                                    <label class="custom-file-label" for="photo">Choose image...</label>
                                </div>
                                <small class="form-text text-muted">Maximum file size: 20MB. Allowed image types: JPG, JPEG, PNG.</small>
                            </div>
                            <button type="button" class="btn btn-danger mt-2" id="removeDocument">Remove</button>
                        </div>
                    `;
                    $('#documentFields').html(fieldHtml).show(); // Show document fields when added
                    $('#addDocument').hide(); // Hide Add Document button
                    documentAdded = true;
                    updateFileInputLabels();
                }
            }

            $('#addDocument').on('click', function () {
                addDocumentField();
            });

            $(document).on('click', '#removeDocument', function () {
                $('#documentFields').html('').hide(); // Remove and hide document fields
                $('#addDocument').show(); // Show Add Document button again
                documentAdded = false;
            });

            function updateFileInputLabels() {
                $('.custom-file-input').on('change', function () {
                    var fileName = $(this).val().split('\\').pop();
                    var file = this.files[0];
                    var fileLabel = $(this).next('.custom-file-label');
                    var id = $(this).attr('id');

                    if (file) {
                        var fileSize = file.size;
                        var maxSize = 20 * 1024 * 1024; // 20MB
                        var validTypes = id.includes('announcement_file') ? ['application/pdf'] : ['image/jpeg', 'image/jpg', 'image/png'];

                        if (fileSize > maxSize) {
                            fileLabel.text('File too large (max 20MB)').addClass('text-danger');
                            $(this).val(''); // Clear the input
                        } else if (!validTypes.includes(file.type)) {
                            fileLabel.text('Invalid file type').addClass('text-danger');
                            $(this).val(''); // Clear the input
                        } else {
                            fileLabel.text(fileName).removeClass('text-danger');
                        }
                    } else {
                        fileLabel.text(id.includes('announcement_file') ? 'Choose PDF file...' : 'Choose image...').removeClass('text-danger');
                    }
                });
            }

            // Handle upload form submission
            $('#uploadForm').on('submit', function (e) {
                e.preventDefault();
                console.log('Upload form submitted!');

                var formData = new FormData(this);
                var submitBtn = $(this).find('button[type="submit"]');
                var originalText = submitBtn.html();

                // Debug form data
                console.log('Form data being sent:');
                console.log('Title:', $('#title').val());
                console.log('Description:', $('#description').val());
                for (var pair of formData.entries()) {
                    console.log(pair[0] + ': ' + pair[1]);
                }

                // Show progress and disable submit button
                submitBtn.prop('disabled', true).html('<i class="fas fa-spinner fa-spin mr-1"></i> Uploading...');

                // Add progress indicator
                var progressHtml = '<div class="progress mt-2" id="uploadProgress" style="height: 20px;"><div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" style="width: 0%"></div></div>';
                if ($('#uploadProgress').length === 0) {
                    $(progressHtml).insertAfter('#documentFields');
                }

                $.ajax({
                    url: "{{ route('announcements.upload') }}",
                    type: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    xhr: function () {
                        var xhr = new window.XMLHttpRequest();
                        xhr.upload.addEventListener("progress", function (evt) {
                            if (evt.lengthComputable) {
                                var percentComplete = (evt.loaded / evt.total) * 100;
                                $('#uploadProgress .progress-bar').css('width', percentComplete + '%');
                            }
                        }, false);
                        return xhr;
                    },
                    success: function (response) {
                        if (response.status) {
                            $('#uploadProgress .progress-bar').css('width', '100%');
                            setTimeout(function () {
                                Swal.fire('Success!', response.message, 'success');
                                $('#uploadModal').modal('hide');
                                $('#uploadForm')[0].reset();
                                $('#documentFields').html('').hide();
                                $('#addDocument').show();
                                $('#uploadProgress').remove();
                                dataAnnouncement.ajax.reload();
                            }, 500);
                        } else {
                            Swal.fire('Error!', response.message, 'error');
                        }
                    },
                    error: function (xhr, status, error) {
                        console.log('Upload error:', xhr);
                        console.log('Status:', status);
                        console.log('Error:', error);
                        console.log('Response:', xhr.responseText);

                        var errorMessage = 'An error occurred while uploading.';
                        if (xhr.status === 422) {
                            var errors = xhr.responseJSON.errors;
                            if (errors) {
                                errorMessage = Object.values(errors).flat().join('\n');
                            }
                        } else if (xhr.status === 500) {
                            errorMessage = 'Server error. Please try again later.';
                        }
                        Swal.fire('Error!', errorMessage, 'error');
                    },
                    complete: function () {
                        submitBtn.prop('disabled', false).html(originalText);
                        setTimeout(function () {
                            $('#uploadProgress').remove();
                        }, 1000);
                    }
                });
            });
        });
    </script>
@endpush

@push('style')
    <link rel="stylesheet" href="{{ asset('css/announcement.css') }}">
@endpush