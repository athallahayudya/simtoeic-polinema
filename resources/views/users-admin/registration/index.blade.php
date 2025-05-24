@extends('layouts.app')

@section('title', 'Registration')

@push('style')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/jquery.dataTables.min.css">
    <style>
        #registrationForm {
            display: none;
        }
    </style>
@endpush

@section('main')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Users Registration</h1>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item active"><a href="{{ url('/dashboard-admin') }}">Dashboard</a></div>
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
                                <input type="text" class="form-control" id="name" name="name" required>
                            </div>
                            <div class="form-group">
                                <label for="role">Role</label>
                                <select class="form-control" id="role" name="role" required>
                                    <option value="">Select Role</option>
                                    @foreach (['student', 'lecturer', 'staff', 'alumni', 'admin'] as $role)
                                        <option value="{{ $role }}">{{ ucfirst($role) }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="identity_number">Identity Number</label>
                                <input type="text" class="form-control" id="identity_number" name="identity_number" required>
                            </div>
                            <div class="form-group">
                                <label for="password">Password</label>
                                <input type="password" class="form-control" id="password" name="password" required>
                            </div>
                            <div class="form-group">
                                <label for="password_confirmation">Confirm Password</label>
                                <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" required>
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
                        <h4>Users List</h4>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="usersTable" class="table table-striped">
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
                                    <!-- DataTables will fill this -->
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
        });

        // Initialize DataTable
        $(document).ready(function () {
            var table = $('#usersTable').DataTable({
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
                order: [[0, 'desc']]
            });

            // meambahkan placeholder pada kolom search
            $('#usersTable_filter input[type="search"]').attr('placeholder', 'Input identity number');

            // View User
            $('#usersTable').on('click', '.view-btn', function () {
                let userId = $(this).data('id');
                $.get('/registration/' + userId + '/show', function(res) {
                    Swal.fire({
                        title: 'User Detail',
                        html: `<b>Name:</b> ${res.name}<br>
                               <b>Role:</b> ${res.role}<br>
                               <b>Identity Number:</b> ${res.identity_number}<br>
                               <b>Status:</b> ${res.exam_status}`,
                        icon: 'info'
                    });
                });
            });

            // Edit User
            $('#usersTable').on('click', '.edit-btn', function () {
                let userId = $(this).data('id');
                $.get('/registration/' + userId + '/edit', function(res) {
                    Swal.fire({
                        title: 'Edit User',
                        html:
                            `<input id="swal-name" class="swal2-input" placeholder="Name" value="${res.name}">
                             <input id="swal-identity" class="swal2-input" placeholder="Identity Number" value="${res.identity_number}">
                             <input id="swal-role" class="swal2-input" placeholder="Role" value="${res.role}">`,
                        showCancelButton: true,
                        confirmButtonText: 'Save',
                        preConfirm: () => {
                            return {
                                name: $('#swal-name').val(),
                                identity_number: $('#swal-identity').val(),
                                role: $('#swal-role').val()
                            }
                        }
                    }).then((result) => {
                        if (result.isConfirmed) {
                            $.post({
                                url: '/registration/' + userId + '/update',
                                data: {
                                    _token: '{{ csrf_token() }}',
                                    name: result.value.name,
                                    identity_number: result.value.identity_number,
                                    role: result.value.role
                                },
                                success: function(resp) {
                                    if (resp.status) {
                                        Swal.fire('Updated!', resp.message, 'success');
                                        table.ajax.reload();
                                    }
                                }
                            });
                        }
                    });
                });
            });

            // Delete User
            $('#usersTable').on('click', '.delete-btn', function () {
                let userId = $(this).data('id');
                Swal.fire({
                    title: 'Are you sure?',
                    text: "This user will be deleted!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: '/registration/' + userId + '/delete',
                            type: 'DELETE',
                            data: { _token: '{{ csrf_token() }}' },
                            success: function(resp) {
                                if (resp.status) {
                                    Swal.fire('Deleted!', resp.message, 'success');
                                    table.ajax.reload();
                                }
                            }
                        });
                    }
                });
            });
        });

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