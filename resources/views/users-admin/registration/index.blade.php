@extends('layouts.app')

@section('title', 'Registration')

@push('style')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/jquery.dataTables.min.css">
    <style>
        #registrationForm {
            display: none;
        }

        #studentFields {
            display: none;
            padding-top: 10px;
            padding-bottom: 10px;
            background-color: #f8f9fa;
            border-radius: 5px;
            border-left: 3px solid #6777ef;
            margin-bottom: 15px;
            padding-left: 15px;
            padding-right: 15px;
        }

        #studentFields h6 {
            color: #6777ef;
            margin-bottom: 15px;
        }

        /* Custom validation styles */
        .validation-field.is-valid {
            border-color: #28a745;
            padding-right: calc(1.5em + 0.75rem);
            background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 8 8'%3e%3cpath fill='%2328a745' d='M2.3 6.73L.6 4.53c-.4-1.04.46-1.4 1.1-.8l1.1 1.4 3.4-3.8c.6-.63 1.6-.27 1.2.7l-4 4.6c-.43.5-.8.4-1.1.1z'/%3e%3c/svg%3e");
            background-repeat: no-repeat;
            background-position: right calc(0.375em + 0.1875rem) center;
            background-size: calc(0.75em + 0.375rem) calc(0.75em + 0.375rem);
        }

        .validation-field.is-invalid {
            border-color: #dc3545;
            padding-right: calc(1.5em + 0.75rem);
            background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' fill='%23dc3545' viewBox='-2 -2 7 7'%3e%3cpath stroke='%23dc3545' d='M0 0l3 3m0-3L0 3'/%3e%3ccircle r='.5'/%3e%3ccircle cx='3' r='.5'/%3e%3ccircle cy='3' r='.5'/%3e%3ccircle cx='3' cy='3' r='.5'/%3e%3c/svg%3E");
            background-repeat: no-repeat;
            background-position: right calc(0.375em + 0.1875rem) center;
            background-size: calc(0.75em + 0.375rem) calc(0.75em + 0.375rem);
        }

        .text-success {
            color: #28a745 !important;
        }

        .text-danger {
            color: #dc3545 !important;
        }
    </style>
@endpush

@section('main')
    <div class="main-content">
        <section class="section">
            <!-- Add proper section header with breadcrumb -->
            <div class="section-header">
                <h1>Registration</h1>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item active"><a href="{{ route('admin.dashboard') }}">Dashboard</a></div>
                    <div class="breadcrumb-item">Registration</div>
                </div>
            </div>

            <div class="section-body">
                <h2 class="section-title">Registration Account</h2>

                <!-- Add User Button -->
                <div class="mb-4">
                    <button type="button" class="btn btn-primary" id="addUserBtn">
                        <i class="fas fa-plus"></i> Add User
                    </button>
                </div>

                <!-- Registration Form Card -->
                <div class="card" id="registrationForm">
                    <div class="card-header">
                        <h4>Add New User</h4>
                    </div>
                    <div class="card-body">
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <form method="POST" action="{{ route('registration.store') }}">
                            @csrf
                            <div class="form-group">
                                <label for="name">Full Name</label>
                                <input type="text" class="form-control validation-field" id="name" name="name" required
                                    data-validation="name">
                                <small class="form-text text-muted validation-message" id="name-validation">
                                    <i class="fas fa-info-circle mr-1"></i> Must be at least 3 characters long
                                </small>
                            </div>
                            <div class="form-group">
                                <label for="role">Role</label>
                                <select class="form-control validation-field" id="role" name="role" required
                                    data-validation="required">
                                    <option value="">Select Role</option>
                                    @foreach (['student', 'lecturer', 'staff', 'alumni', 'admin'] as $role)
                                        <option value="{{ $role }}">{{ ucfirst($role) }}</option>
                                    @endforeach
                                </select>
                                <small class="form-text text-muted validation-message" id="role-validation">
                                    <i class="fas fa-info-circle mr-1"></i> Required field - selects user permissions
                                </small>
                            </div>
                            <div class="form-group">
                                <label for="identity_number">Identity Number</label>
                                <input type="text" class="form-control validation-field" id="identity_number"
                                    name="identity_number" required data-validation="identity">
                                <small class="form-text text-muted validation-message" id="identity_number-validation">
                                    <i class="fas fa-info-circle mr-1"></i> Enter NIM for students or employee ID for
                                    staff/lecturers
                                </small>
                            </div>

                            <!-- Student-specific fields - will be shown/hidden based on role selection -->
                            <div id="studentFields">
                                <h6><i class="fas fa-user-graduate mr-2"></i>Student Information</h6>
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="major">Major</label>
                                            <select class="form-control validation-field" id="major" name="major"
                                                data-validation="required">
                                                <option value="">Select Major</option>
                                                <option value="Teknik Elektro">Teknik Elektro</option>
                                                <option value="Teknik Sipil">Teknik Sipil</option>
                                                <option value="Teknik Mesin">Teknik Mesin</option>
                                                <option value="Teknik Kimia">Teknik Kimia</option>
                                                <option value="Akuntansi">Akuntansi</option>
                                                <option value="Administrasi Niaga">Administrasi Niaga</option>
                                                <option value="Teknologi Informasi">Teknologi Informasi</option>
                                            </select>
                                            <small class="form-text text-muted validation-message" id="major-validation">
                                                <i class="fas fa-info-circle mr-1"></i> Required for students
                                            </small>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="study_program">Study Program</label>
                                            <select class="form-control validation-field" id="study_program"
                                                name="study_program" data-validation="required">
                                                <option value="">Select Study Program</option>
                                                <!-- Options will be populated based on selected major -->
                                            </select>
                                            <small class="form-text text-muted validation-message"
                                                id="study_program-validation">
                                                <i class="fas fa-info-circle mr-1"></i> Will appear after selecting a major
                                            </small>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="campus">Campus</label>
                                            <select class="form-control validation-field" id="campus" name="campus"
                                                data-validation="required">
                                                <option value="">Select Campus</option>
                                                <option value="malang">Malang</option>
                                                <option value="psdku_kediri">PSDKU Kediri</option>
                                                <option value="psdku_lumajang">PSDKU Lumajang</option>
                                                <option value="psdku_pamekasan">PSDKU Pamekasan</option>
                                            </select>
                                            <small class="form-text text-muted validation-message" id="campus-validation">
                                                <i class="fas fa-info-circle mr-1"></i> Required for students
                                            </small>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="password">Password</label>
                                <input type="password" class="form-control validation-field" id="password" name="password"
                                    required data-validation="password">
                                <small class="form-text text-muted validation-message" id="password-validation">
                                    <i class="fas fa-lock mr-1"></i> Must be at least 8 characters with letters and numbers
                                </small>
                            </div>
                            <div class="form-group">
                                <label for="password_confirmation">Confirm Password</label>
                                <input type="password" class="form-control validation-field" id="password_confirmation"
                                    name="password_confirmation" required data-validation="password-match">
                                <small class="form-text text-muted validation-message"
                                    id="password_confirmation-validation">
                                    <i class="fas fa-check-circle mr-1"></i> Must match your password exactly
                                </small>
                            </div>
                            <div class="form-group text-right">
                                <button type="button" class="btn btn-secondary mr-1" id="cancelBtn">Cancel</button>
                                <button type="submit" class="btn btn-primary">Submit</button>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Users DataTable Card -->
                <div class="card">
                    <div class="card-header">
                        <h4>Registered Users</h4>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped" id="usersTable">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Role</th>
                                        <th>Identity Number</th>
                                        <th>Name</th>
                                        <th>Exam Status</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <!-- Table data will be loaded via AJAX -->
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>

    <!-- Modal for displaying user details, editing, and deletion -->
    <div id="myModal" class="modal fade animate shake" tabindex="-1" role="dialog" data-backdrop="static"
        data-keyboard="false" aria-hidden="true"></div>
@endsection

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
    <script>
        // Function to load modal content
        function modalAction(url = '') {
            $('#myModal').load(url, function () {
                $('#myModal').modal('show');
                // Initialize validation on modal forms after they're loaded
                initializeValidation();
            });
        }

        // Simplified validation functions
        function validateName(value) {
            return value.length >= 3;
        }

        function validateIdentity(value) {
            return value.length >= 5;
        }

        function validatePassword(value) {
            return value.length >= 8 && /[A-Za-z]/.test(value) && /[0-9]/.test(value);
        }

        function validateRequired(value) {
            return value !== "" && value !== null;
        }

        // Apply validation to a specific field
        function validateField(field) {
            const value = field.val();
            const validationType = field.data('validation');
            let isValid = false;

            // Don't validate empty fields immediately (except on form submit)
            if (value === "" && !field.hasClass('form-submitted')) {
                field.removeClass('is-valid is-invalid');
                return true;
            }

            switch (validationType) {
                case 'name':
                    isValid = validateName(value);
                    break;
                case 'identity':
                    isValid = validateIdentity(value);
                    break;
                case 'password':
                    isValid = validatePassword(value);
                    break;
                case 'password-match':
                    isValid = value === $('#password').val();
                    break;
                case 'required':
                    isValid = validateRequired(value);
                    break;
                default:
                    isValid = true;
            }

            // Apply visual feedback
            if (isValid) {
                field.removeClass('is-invalid').addClass('is-valid');
                const feedbackId = field.attr('id') + '-validation';
                const feedbackElement = $('#' + feedbackId);

                if (feedbackElement.length) {
                    feedbackElement.removeClass('text-danger text-muted').addClass('text-success');
                    const icon = feedbackElement.find('i');
                    if (icon.length) {
                        icon.removeClass('fa-info-circle fa-times-circle').addClass('fa-check-circle');
                    }
                }
            } else {
                field.removeClass('is-valid').addClass('is-invalid');
                const feedbackId = field.attr('id') + '-validation';
                const feedbackElement = $('#' + feedbackId);

                if (feedbackElement.length) {
                    feedbackElement.removeClass('text-success text-muted').addClass('text-danger');
                    const icon = feedbackElement.find('i');
                    if (icon.length) {
                        icon.removeClass('fa-info-circle fa-check-circle').addClass('fa-times-circle');
                    }
                }
            }

            return isValid;
        }

        // Initialize validation for all fields in the form
        function initializeValidation() {
            // Add event listeners for real-time validation
            $('.validation-field').off('input change').on('input change', function () {
                validateField($(this));
            });

            // Special case for password + confirmation
            $('#password').off('input change').on('input change', function () {
                validateField($(this));
                // Re-validate confirmation if it's not empty
                if ($('#password_confirmation').val() !== '') {
                    validateField($('#password_confirmation'));
                }
            });

            // Clear validation styling when a form is reset
            $('form').off('reset').on('reset', function () {
                $(this).find('.validation-field').removeClass('is-valid is-invalid');
                $(this).find('.validation-message')
                    .removeClass('text-success text-danger')
                    .addClass('text-muted');
                $(this).find('.validation-message i')
                    .removeClass('fa-check-circle fa-times-circle')
                    .addClass('fa-info-circle');
            });

            // Validate all fields on form submission
            $('form').off('submit').on('submit', function (e) {
                const form = $(this);

                // Mark all fields as submitted for validation
                form.find('.validation-field').addClass('form-submitted');

                // Validate all fields
                let isValid = true;
                form.find('.validation-field').each(function () {
                    if (!validateField($(this))) {
                        isValid = false;
                    }
                });

                if (!isValid) {
                    e.preventDefault();
                    Swal.fire({
                        icon: 'error',
                        title: 'Validation Error',
                        text: 'Please check all fields and try again.'
                    });
                    return false;
                }
            });
        }

        $(document).ready(function () {
            // Initialize validation on page load
            initializeValidation();

            // Initialize DataTable with custom search field
            var dataTable = $('#usersTable').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('users.data') }}",
                columns: [
                    { data: 'user_id', name: 'user_id' },
                    { data: 'role', name: 'role' },
                    { data: 'identity_number', name: 'identity_number' },
                    { data: 'name', name: 'name', searchable: true },
                    { data: 'exam_status', name: 'exam_status' },
                    { data: 'actions', name: 'actions', orderable: false, searchable: false }
                ],
                order: [[0, 'desc']],
                searching: true,
                responsive: true,
                lengthMenu: [[10, 25, 50, -1], [10, 25, 50, "All"]],
                // Remove the default search box
                dom: '<"row"<"col-sm-12 col-md-6"l><"col-sm-12 col-md-6"<"float-right"f>>>' +
                    '<"row"<"col-sm-12"tr>>' +
                    '<"row"<"col-sm-12 col-md-5"i><"col-sm-12 col-md-7"p>>',
                language: {
                    search: "Search by name: _INPUT_",
                    searchPlaceholder: "Enter name..."
                }
            });
            // Add custom search if needed
            $('#searchInput').on('keyup', function () {
                dataTable.search($(this).val()).draw();
            });

            // Define study programs for each major
            const studyPrograms = {
                'Teknik Elektro': [
                    'D-III Teknik Elektronika (Akreditasi Unggul)',
                    'D-III Teknik Listrik (Akreditasi Unggul)',
                    'D-III Teknik Telekomunikasi',
                    'D-IV Teknik Elektronika',
                    'D-IV Sistem Kelistrikan',
                    'D-IV Jaringan Telekomunikasi Digital',
                    'D-IV Teknik Elektronika (PSDKU Kediri)'
                ],
                'Teknik Sipil': [
                    'D-III Teknik Sipil',
                    'D-IV Teknik Sipil'
                ],
                'Teknik Mesin': [
                    'D-III Teknik Mesin',
                    'D-IV Teknik Mesin'
                ],
                'Teknik Kimia': [
                    'D-III Teknik Kimia',
                    'D-IV Teknik Kimia'
                ],
                'Akuntansi': [
                    'D-III Akuntansi',
                    'D-IV Akuntansi Manajemen'
                ],
                'Administrasi Niaga': [
                    'D-III Administrasi Bisnis',
                    'D-IV Manajemen Pemasaran'
                ],
                'Teknologi Informasi': [
                    'D-III Teknologi Informasi',
                    'D-IV Teknik Informatika'
                ]
            };

            // Toggle form visibility
            $('#addUserBtn').on('click', function () {
                $('#registrationForm').show();
                $(this).hide();

                // Reset form when showing
                $('form')[0].reset();
                $('.validation-field').removeClass('is-valid is-invalid form-submitted');
                $('.validation-message')
                    .removeClass('text-success text-danger')
                    .addClass('text-muted');
                $('.validation-message i')
                    .removeClass('fa-check-circle fa-times-circle')
                    .addClass('fa-info-circle');
            });

            // Cancel button
            $('#cancelBtn').on('click', function () {
                $('#registrationForm').hide();
                $('#addUserBtn').show();
                // Clear form inputs
                $('form')[0].reset();
                // Clear validation classes
                $('.validation-field').removeClass('is-valid is-invalid form-submitted');
                $('.validation-message')
                    .removeClass('text-success text-danger')
                    .addClass('text-muted');
                $('.validation-message i')
                    .removeClass('fa-check-circle fa-times-circle')
                    .addClass('fa-info-circle');
                // Hide student fields
                $('#studentFields').hide();
            });

            // Show/hide student fields based on role selection
            $('#role').on('change', function () {
                const studentFields = $('#studentFields');
                const majorField = $('#major');
                const studyProgramField = $('#study_program');
                const campusField = $('#campus');

                if ($(this).val() === 'student') {
                    studentFields.show();
                    // Make fields required when student role is selected
                    majorField.attr('required', '');
                    studyProgramField.attr('required', '');
                    campusField.attr('required', '');

                    // Use a subtle animation to draw attention
                    studentFields.css('opacity', '0');
                    setTimeout(() => {
                        studentFields.css({
                            'transition': 'opacity 0.3s',
                            'opacity': '1'
                        });
                    }, 10);
                } else {
                    studentFields.hide();
                    // Remove required attribute for non-student roles
                    majorField.removeAttr('required');
                    studyProgramField.removeAttr('required');
                    campusField.removeAttr('required');

                    // Clear validation states for hidden fields
                    majorField.removeClass('is-valid is-invalid');
                    studyProgramField.removeClass('is-valid is-invalid');
                    campusField.removeClass('is-valid is-invalid');
                }
            });

            // Populate study program dropdown based on selected major
            $('#major').on('change', function () {
                const studyProgramSelect = $('#study_program');
                const selectedMajor = $(this).val();

                // Clear existing options
                studyProgramSelect.html('<option value="">Select Study Program</option>');

                // If a major is selected, populate its study programs
                if (selectedMajor && studyPrograms[selectedMajor]) {
                    studyPrograms[selectedMajor].forEach(program => {
                        studyProgramSelect.append(`<option value="${program}">${program}</option>`);
                    });
                }

                // Revalidate the field if it was already validated
                if ($(this).hasClass('is-valid') || $(this).hasClass('is-invalid')) {
                    validateField($(this));
                }
            });

            // Event handler for form submissions in modal
            $(document).on('submit', '#form-edit, #form-delete', function (e) {
                e.preventDefault();

                // For edit forms, validate fields before submission
                if ($(this).attr('id') === 'form-edit') {
                    let isValid = true;

                    // Mark all fields as submitted for validation
                    $(this).find('.validation-field').addClass('form-submitted');

                    // Validate all fields
                    $(this).find('.validation-field').each(function () {
                        if (!validateField($(this))) {
                            isValid = false;
                        }
                    });

                    if (!isValid) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Validation Error',
                            text: 'Please check all fields and try again.'
                        });
                        return false;
                    }
                }

                $.ajax({
                    url: $(this).attr('action'),
                    type: 'POST',
                    data: new FormData(this),
                    contentType: false,
                    processData: false,
                    success: function (response) {
                        if (response.status === true) {
                            $('#myModal').modal('hide');

                            Swal.fire({
                                icon: 'success',
                                title: 'Success!',
                                text: response.message,
                                timer: 2000,
                                showConfirmButton: false
                            }).then(() => {
                                // Refresh the DataTable
                                dataTable.ajax.reload();
                            });
                        } else {
                            if (response.msgField) {
                                // Apply error classes to fields with errors
                                $.each(response.msgField, function (key, value) {
                                    const errorField = $('#' + key);
                                    errorField.removeClass('is-valid').addClass('is-invalid');

                                    // Update validation message if it exists
                                    const feedbackId = key + '-validation';
                                    const feedbackElement = $('#' + feedbackId);

                                    if (feedbackElement.length) {
                                        feedbackElement.removeClass('text-success text-muted').addClass('text-danger');
                                        feedbackElement.html(`<i class="fas fa-times-circle mr-1"></i> ${value[0]}`);
                                    } else {
                                        // If no validation message container exists, create error message element
                                        const errorMsg = $(`<div id="error-${key}" class="text-danger mt-1"><i class="fas fa-times-circle mr-1"></i> ${value[0]}</div>`);
                                        errorField.after(errorMsg);
                                    }
                                });
                            } else {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Error',
                                    text: response.message || 'An error occurred'
                                });
                            }
                        }
                    },
                    error: function (xhr) {
                        console.error('AJAX Error:', xhr.responseText);
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: 'An error occurred while processing your request'
                        });
                    }
                });
            });
        });

        // SweetAlert notifications for server-side responses
        @if (session('success'))
            Swal.fire({
                icon: 'success',
                title: 'Success!',
                text: '{{ session('success') }}',
                confirmButtonText: 'OK'
            });
        @endif

        @if (session('error'))
            Swal.fire({
                icon: 'error',
                title: 'Error!',
                text: '{{ session('error') }}',
                confirmButtonText: 'OK'
            });
        @endif
    </script>
@endpush