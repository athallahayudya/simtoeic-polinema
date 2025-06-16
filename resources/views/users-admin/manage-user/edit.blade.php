@empty($user)
    <div id="modal-master" class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Failed</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="alert alert-danger">
                    <h5><i class="icon fas fa-ban"></i> Failed!!!</h5>
                    Data not found.
                </div>
                <a href="{{ url('/users/') }}" class="btn btn-warning">Back</a>
            </div>
        </div>
    </div>
@else
    <form action="{{ url('/users/' . $user->user_id . '/update_ajax') }}" method="POST" id="form-edit"
        enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div id="modal-master" class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Edit User Data</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label>Role</label>
                        <select name="role" id="role" class="form-control" required>
                            <option value="">Select Role</option>
                            <option value="admin" {{ ($user->role ?? old('role')) == 'admin' ? 'selected' : '' }}>Admin
                            </option>
                            <option value="student" {{ ($user->role ?? old('role')) == 'student' ? 'selected' : '' }}>Student
                            </option>
                            <option value="lecturer" {{ ($user->role ?? old('role')) == 'lecturer' ? 'selected' : '' }}>
                                Lecturer</option>
                            <option value="staff" {{ ($user->role ?? old('role')) == 'staff' ? 'selected' : '' }}>Staff
                            </option>
                            <option value="alumni" {{ ($user->role ?? old('role')) == 'alumni' ? 'selected' : '' }}>Alumni
                            </option>
                        </select>
                        <small id="error-role" class="error-text form-text text-danger"></small>
                    </div>
                    <div class="form-group">
                        <label>Identity Number</label>
                        <input type="text" name="identity_number" id="identity_number" class="form-control"
                            value="{{ $user->identity_number ?? old('identity_number') }}" required>
                        <small class="form-text text-muted">NIM for students, employee ID for staff/lecturer, etc.</small>
                        <small id="error-identity_number" class="error-text form-text text-danger"
                            style="display: block; color: red; font-weight: bold;"></small>
                    </div>
                    <div class="form-group">
                        <label>Name</label>
                        <input type="text" name="name" id="name" class="form-control"
                            value="{{ $profile->name ?? old('name') }}" required>
                        <small id="error-name" class="error-text form-text text-danger"></small>
                    </div>
                    <div class="form-group">
                        <label>Home Address <span class="text-muted">(Optional)</span></label>
                        <input type="text" name="home_address" id="home_address" class="form-control"
                            value="{{ $profile->home_address ?? old('home_address') }}">
                        <small id="error-home_address" class="error-text form-text text-danger"></small>
                    </div>
                    <div class="form-group">
                        <label>Current Address <span class="text-muted">(Optional)</span></label>
                        <input type="text" name="current_address" id="current_address" class="form-control"
                            value="{{ $profile->current_address ?? old('current_address') }}">
                        <small id="error-current_address" class="error-text form-text text-danger"></small>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" data-dismiss="modal" class="btn btn-warning">Cancel</button>
                    <button type="submit" class="btn btn-primary">Save</button>
                </div>
            </div>
        </div>
    </form>

    <script>
        $(document).ready(function () {
            $('#form-edit').on('submit', function (e) {
                e.preventDefault();
                $.ajax({
                    url: $(this).attr('action'),
                    type: 'POST',
                    data: new FormData(this),
                    contentType: false,
                    processData: false,
                    success: function (response) {
                        if (response.status === true) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Success!',
                                text: response.message,
                                timer: 2000,
                                showConfirmButton: false
                            }).then(() => {
                                $('#modal-master').modal('hide');
                                location.reload();
                            });
                        } else {
                            // Clear previous errors
                            $('.error-text').text('');

                            // Display new errors
                            $.each(response.msgField, function (key, value) {
                                $('#error-' + key).text(value[0]);
                            });

                            // Log errors for debugging
                            console.log('Validation errors:', response.msgField);
                        }
                    },
                    error: function (xhr) {
                        console.log('Error response:', xhr.responseJSON);

                        // Handle validation errors (422)
                        if (xhr.status === 422 && xhr.responseJSON && xhr.responseJSON.msgField) {
                            // Clear previous errors
                            $('.error-text').text('');

                            // Display validation errors
                            $.each(xhr.responseJSON.msgField, function (key, value) {
                                console.log('Setting error for field:', key, 'value:', value[0]);
                                var errorElement = $('#error-' + key);
                                console.log('Error element found:', errorElement.length > 0);
                                errorElement.text(value[0]);
                                console.log('Error element text set to:', errorElement.text());
                            });

                            console.log('Validation errors:', xhr.responseJSON.msgField);

                            Swal.fire({
                                icon: 'error',
                                title: 'Validation Failed!',
                                text: 'Please check the form for errors.',
                            });
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Error!',
                                text: 'An error occurred while processing your request.',
                            });
                        }
                    }
                });
            });
        }); 
    </script>
@endempty