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

                        <form method="POST" action="{{ url('/registration') }}">
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
@endsection

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
    <script>
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
                'D-III Teknik Sipil (Akreditasi Unggul)',
                'D-III Teknologi Pertambangan',
                'D-IV Konstruksi Gedung',
                'D-IV Konstruksi Jalan dan Jembatan'
            ],
            'Teknik Mesin': [
                'D-III Teknik Mesin',
                'D-IV Teknik Mesin Produksi dan Perawatan',
                'D-IV Teknik Otomotif Elektronik'
            ],
            'Teknik Kimia': [
                'D-III Teknik Kimia',
                'D-IV Teknik Kimia Industri'
            ],
            'Akuntansi': [
                'D-III Akuntansi (Akreditasi A, Akreditasi Internasional ASIC 2022)',
                'D-IV Akuntansi Manajemen'
            ],
            'Administrasi Niaga': [
                'D-III Administrasi Bisnis',
                'D-IV Manajemen Pemasaran',
                'D-IV Pengelolaan Arsip dan Rekaman Informasi',
                'D-IV Bahasa Inggris untuk Komunikasi Bisnis dan Profesional',
                'D-IV Bahasa Inggris untuk Industri Pariwisata',
                'D-IV Usaha Perjalanan Wisata'
            ],
            'Teknologi Informasi': [
                'D-III Manajemen Informatika',
                'D-IV Teknik Informatika',
                'D-IV Sistem Informasi Bisnis'
            ]
        };

        // Populate study program dropdown based on selected major
        document.getElementById('major').addEventListener('change', function () {
            const studyProgramSelect = document.getElementById('study_program');
            const selectedMajor = this.value;

            // Clear existing options
            studyProgramSelect.innerHTML = '<option value="">Select Study Program</option>';

            // If a major is selected, populate its study programs
            if (selectedMajor && studyPrograms[selectedMajor]) {
                studyPrograms[selectedMajor].forEach(program => {
                    const option = document.createElement('option');
                    option.value = program;
                    option.textContent = program;
                    studyProgramSelect.appendChild(option);
                });
            }
        });

        // Toggle form visibility
        document.getElementById('addUserBtn').addEventListener('click', function () {
            document.getElementById('registrationForm').style.display = 'block';
            this.style.display = 'none';
        });

        // Cancel button
        document.getElementById('cancelBtn').addEventListener('click', function () {
            document.getElementById('registrationForm').style.display = 'none';
            document.getElementById('addUserBtn').style.display = 'inline-block';
            // Clear form inputs
            document.querySelector('form').reset();
            // Hide student fields
            document.getElementById('studentFields').style.display = 'none';
        });

        // Show/hide student fields based on role selection
        document.getElementById('role').addEventListener('change', function () {
            const studentFields = document.getElementById('studentFields');
            const majorField = document.getElementById('major');
            const studyProgramField = document.getElementById('study_program');
            const campusField = document.getElementById('campus');

            if (this.value === 'student') {
                studentFields.style.display = 'block';
                // Make fields required when student role is selected
                majorField.setAttribute('required', '');
                studyProgramField.setAttribute('required', '');
                campusField.setAttribute('required', '');

                // Use a subtle animation to draw attention
                studentFields.style.opacity = '0';
                setTimeout(() => {
                    studentFields.style.transition = 'opacity 0.3s';
                    studentFields.style.opacity = '1';
                }, 10);
            } else {
                studentFields.style.display = 'none';
                // Remove required attribute for non-student roles
                majorField.removeAttribute('required');
                studyProgramField.removeAttribute('required');
                campusField.removeAttribute('required');
            }
        });

        // Enhanced form validation and submission
        document.querySelector('form').addEventListener('submit', function (e) {
            e.preventDefault();

            // Form validation
            const errors = [];

            // Basic field validation
            const name = document.getElementById('name').value.trim();
            const role = document.getElementById('role').value;
            const identityNumber = document.getElementById('identity_number').value.trim();
            const password = document.getElementById('password').value;
            const passwordConfirmation = document.getElementById('password_confirmation').value;

            // Validation rules
            if (name.length < 3) {
                errors.push('Name must be at least 3 characters long');
            }

            if (role === '') {
                errors.push('You must select a role');
            }

            if (identityNumber === '') {
                errors.push('Identity number is required');
            }

            // Password validation
            if (password.length < 8) {
                errors.push('Password must be at least 8 characters long');
            }

            if (password !== passwordConfirmation) {
                errors.push('Password confirmation does not match');
            }

            // Student-specific validation
            if (role === 'student') {
                const major = document.getElementById('major').value.trim();
                const studyProgram = document.getElementById('study_program').value.trim();
                const campus = document.getElementById('campus').value;

                if (studyProgram === '') {
                    errors.push('Study program is required for students');
                }

                if (major === '') {
                    errors.push('Major is required for students');
                }

                if (campus === '') {
                    errors.push('Campus selection is required for students');
                }
            }

            // Show validation errors or submit the form
            if (errors.length > 0) {
                // Build error list HTML
                const errorListHtml = errors.map(error => `<li>${error}</li>`).join('');

                // Show error modal
                Swal.fire({
                    icon: 'error',
                    title: 'Account Creation Failed',
                    html: `
                                                        <div class="text-left">
                                                            <p>Please fix the following issues:</p>
                                                            <ul class="text-danger">${errorListHtml}</ul>
                                                        </div>
                                                    `,
                    confirmButtonText: 'Fix Issues',
                    confirmButtonColor: '#3085d6'
                });
            } else {
                // No errors, submit the form
                this.submit();
            }
        });

        // Real-time field validation with visual feedback
        document.addEventListener('DOMContentLoaded', function () {
            const validationFields = document.querySelectorAll('.validation-field');

            // Validation functions for different field types
            const validationFunctions = {
                'name': (value) => value.trim().length >= 3,
                'required': (value) => value && value.trim() !== '',
                'identity': (value) => {
                    // Add specific identity validation rules (e.g., numeric, certain length)
                    return value.trim().length > 0 && /^\d+$/.test(value);
                },
                'password': (value) => value.length >= 8 && /[A-Za-z]/.test(value) && /[0-9]/.test(value),
                'password-match': (value) => value === document.getElementById('password').value && value !== ''
            };

            // Messages to show when validation succeeds
            const successMessages = {
                'name': '<i class="fas fa-check-circle mr-1"></i> Valid name entered',
                'role': '<i class="fas fa-check-circle mr-1"></i> Role selected',
                'identity_number': '<i class="fas fa-check-circle mr-1"></i> Identity number provided',
                'major': '<i class="fas fa-check-circle mr-1"></i> Major selected',
                'study_program': '<i class="fas fa-check-circle mr-1"></i> Study program selected',
                'campus': '<i class="fas fa-check-circle mr-1"></i> Campus selected',
                'password': '<i class="fas fa-check-circle mr-1"></i> Password meets requirements',
                'password_confirmation': '<i class="fas fa-check-circle mr-1"></i> Passwords match'
            };

            // Default messages to restore when validation fails
            const defaultMessages = {
                'name': '<i class="fas fa-info-circle mr-1"></i> Must be at least 3 characters long',
                'role': '<i class="fas fa-info-circle mr-1"></i> Required field - selects user permissions',
                'identity_number': '<i class="fas fa-info-circle mr-1"></i> Enter NIM for students or employee ID for staff/lecturers',
                'major': '<i class="fas fa-info-circle mr-1"></i> Required for students',
                'study_program': '<i class="fas fa-info-circle mr-1"></i> Will appear after selecting a major',
                'campus': '<i class="fas fa-info-circle mr-1"></i> Required for students',
                'password': '<i class="fas fa-lock mr-1"></i> Must be at least 8 characters with letters and numbers',
                'password_confirmation': '<i class="fas fa-check-circle mr-1"></i> Must match your password exactly'
            };

            // Error messages for specific validation failures
            const errorMessages = {
                'name': '<i class="fas fa-exclamation-circle mr-1"></i> Name must be at least 3 characters',
                'identity_number': '<i class="fas fa-exclamation-circle mr-1"></i> Please enter a valid numeric ID',
                'password': '<i class="fas fa-exclamation-circle mr-1"></i> Password must have 8+ characters with letters and numbers',
                'password_confirmation': '<i class="fas fa-exclamation-circle mr-1"></i> The password confirmation does not match'
            };

            // Add event listeners to all validation fields
            validationFields.forEach(field => {
                const validationType = field.dataset.validation;
                const validationMessageElement = document.getElementById(`${field.id}-validation`);

                if (!validationMessageElement) return; // Skip if no message element found

                // Function to validate this field
                const validateField = () => {
                    const value = field.value;

                    // Only validate if there's a value or the field has been touched
                    if (value || field.dataset.touched === 'true') {
                        field.dataset.touched = 'true'; // Mark field as touched
                        const isValid = validationFunctions[validationType](value);

                        if (isValid) {
                            // Show success state
                            validationMessageElement.classList.remove('text-muted', 'text-danger');
                            validationMessageElement.classList.add('text-success');
                            validationMessageElement.innerHTML = successMessages[field.id];
                            field.classList.remove('is-invalid');
                            field.classList.add('is-valid');
                        } else {
                            // Show error state
                            validationMessageElement.classList.remove('text-success', 'text-muted');
                            validationMessageElement.classList.add('text-danger');

                            // Use specific error message if available
                            if (errorMessages[field.id]) {
                                validationMessageElement.innerHTML = errorMessages[field.id];
                            } else {
                                validationMessageElement.innerHTML = defaultMessages[field.id];
                            }

                            field.classList.remove('is-valid');
                            field.classList.add('is-invalid');
                        }
                    }
                };

                // Validate on input change and blur
                field.addEventListener('input', validateField);
                field.addEventListener('change', validateField);
                field.addEventListener('blur', function () {
                    this.dataset.touched = 'true'; // Mark as touched on blur
                    validateField();
                });

                // Special case for password confirmation - validate when either password field changes
                if (field.id === 'password_confirmation' || field.id === 'password') {
                    const otherField = field.id === 'password'
                        ? document.getElementById('password_confirmation')
                        : document.getElementById('password');

                    field.addEventListener('input', function () {
                        // Only validate confirmation if both fields have values
                        if (document.getElementById('password').value &&
                            document.getElementById('password_confirmation').value) {

                            const confirmField = document.getElementById('password_confirmation');
                            const confirmMsg = document.getElementById('password_confirmation-validation');

                            if (confirmField.value === document.getElementById('password').value) {
                                confirmMsg.classList.remove('text-danger', 'text-muted');
                                confirmMsg.classList.add('text-success');
                                confirmMsg.innerHTML = successMessages['password_confirmation'];
                                confirmField.classList.remove('is-invalid');
                                confirmField.classList.add('is-valid');
                            } else {
                                confirmMsg.classList.remove('text-success', 'text-muted');
                                confirmMsg.classList.add('text-danger');
                                confirmMsg.innerHTML = errorMessages['password_confirmation'];
                                confirmField.classList.remove('is-valid');
                                confirmField.classList.add('is-invalid');
                            }
                        }
                    });
                }
            });

            // Initialize validation on page load for fields with values
            validationFields.forEach(field => {
                if (field.value) {
                    field.dataset.touched = 'true';
                    field.dispatchEvent(new Event('change'));
                }
            });
        });

        // Initialize DataTable
        $(document).ready(function () {
            $('#usersTable').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('users.data') }}",
                columns: [
                    { data: 'user_id', name: 'user_id' },
                    { data: 'role', name: 'role' },
                    { data: 'identity_number', name: 'identity_number' },
                    { data: 'name', name: 'name' },
                    { data: 'exam_status', name: 'exam_status' },
                    { data: 'actions', name: 'actions', orderable: false, searchable: false }
                ],
                order: [[0, 'desc']],
                // Add search functionality parameters
                searching: true,
                language: {
                    search: "Search:",
                    searchPlaceholder: "Name, ID or Role..."
                },
                // Improve responsive behavior
                responsive: true,
                // Increase entries per page options
                lengthMenu: [[10, 25, 50, -1], [10, 25, 50, "All"]]
            });

            // Handle delete user action
            $(document).on('click', '.delete-btn', function () {
                const userId = $(this).data('id');

                Swal.fire({
                    title: 'Are you sure?',
                    text: "This action cannot be undone!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: `/registration/${userId}`,
                            type: 'DELETE',
                            data: {
                                _token: '{{ csrf_token() }}'
                            },
                            success: function (response) {
                                Swal.fire(
                                    'Deleted!',
                                    response.message,
                                    'success'
                                );

                                // Refresh the DataTable
                                $('#usersTable').DataTable().ajax.reload();
                            },
                            error: function (xhr) {
                                Swal.fire(
                                    'Error!',
                                    'There was an error deleting the user.',
                                    'error'
                                );
                            }
                        });
                    }
                });
            });
        });

        // Handle view user action
        $(document).on('click', '.view-btn', function () {
            const userId = $(this).data('id');

            // Show loading state
            Swal.fire({
                title: 'Loading user details',
                text: 'Please wait...',
                allowOutsideClick: false,
                didOpen: () => {
                    Swal.showLoading();
                }
            });

            // Fetch user details
            $.ajax({
                url: `/registration/${userId}/details`,
                type: 'GET',
                success: function (response) {
                    Swal.close();

                    // Generate user details HTML
                    let detailsHtml = `
                    <div class="user-details text-left">
                        <div class="mb-3">
                            <h6 class="font-weight-bold">Personal Information</h6>
                            <div class="row">
                                <div class="col-5 text-muted">Name:</div>
                                <div class="col-7">${response.user.name}</div>
                            </div>
                            <div class="row">
                                <div class="col-5 text-muted">Role:</div>
                                <div class="col-7">${response.user.role}</div>
                            </div>
                            <div class="row">
                                <div class="col-5 text-muted">Identity Number:</div>
                                <div class="col-7">${response.user.identity_number}</div>
                            </div>
                            <div class="row">
                                <div class="col-5 text-muted">Exam Status:</div>
                                <div class="col-7">${response.user.exam_status}</div>
                            </div>
                        </div>`;

                    // Add student-specific information if available
                    if (response.student) {
                        detailsHtml += `
                        <div class="mb-3">
                            <h6 class="font-weight-bold">Student Information</h6>
                            <div class="row">
                                <div class="col-5 text-muted">Major:</div>
                                <div class="col-7">${response.student.major || 'Not available'}</div>
                            </div>
                            <div class="row">
                                <div class="col-5 text-muted">Study Program:</div>
                                <div class="col-7">${response.student.study_program || 'Not available'}</div>
                            </div>
                            <div class="row">
                                <div class="col-5 text-muted">Campus:</div>
                                <div class="col-7">${response.student.campus || 'Not available'}</div>
                            </div>
                        </div>`;
                    }

                    detailsHtml += `</div>`;

                    Swal.fire({
                        title: 'User Details',
                        html: detailsHtml,
                        width: '600px',
                        confirmButtonText: 'Close',
                        confirmButtonColor: '#3085d6'
                    });
                },
                error: function (xhr) {
                    Swal.fire(
                        'Error!',
                        'Unable to load user details.',
                        'error'
                    );
                }
            });
        });

        // Handle edit user action
        $(document).on('click', '.edit-btn', function () {
            const userId = $(this).data('id');

            // Redirect to edit page
            window.location.href = `/registration/${userId}/edit`;
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