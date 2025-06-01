<div class="modal-dialog" role="document">
    <div class="modal-content">
        @if(empty($user))
        <div class="modal-header">
            <h5 class="modal-title">Error</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <div class="alert alert-danger">
                <h5><i class="icon fas fa-ban"></i> Failed!</h5>
                User data not found.
            </div>
            <button type="button" class="btn btn-warning" data-dismiss="modal">Back</button>
        </div>
        @else
        <div class="modal-header">
            <h5 class="modal-title">Edit User</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <form id="form-edit" action="{{ url('registration/'.$user->user_id.'/update_ajax') }}" method="POST" class="needs-validation" novalidate>
            @csrf
            <input type="hidden" name="_method" value="POST">
            <div class="modal-body">
                <div class="form-group">
                    <label for="identity_number">Identity Number</label>
                    <input type="text" class="form-control" id="identity_number" name="identity_number" value="{{ $user->identity_number }}" required>
                    <div class="invalid-feedback" id="error-identity_number">
                        Please enter a valid identity number.
                    </div>
                </div>
                <div class="form-group">
                    <label for="role">Role</label>
                    <select class="form-control" id="role" name="role" required>
                        <option value="student" {{ $user->role == 'student' ? 'selected' : '' }}>Student</option>
                        <option value="lecturer" {{ $user->role == 'lecturer' ? 'selected' : '' }}>Lecturer</option>
                        <option value="staff" {{ $user->role == 'staff' ? 'selected' : '' }}>Staff</option>
                        <option value="alumni" {{ $user->role == 'alumni' ? 'selected' : '' }}>Alumni</option>
                        <option value="admin" {{ $user->role == 'admin' ? 'selected' : '' }}>Admin</option>
                    </select>
                    <div class="invalid-feedback" id="error-role">
                        Please select a role.
                    </div>
                </div>
                <div class="form-group">
                    <label for="password">Password (leave empty to keep current)</label>
                    <input type="password" class="form-control" id="password" name="password">
                    <div class="invalid-feedback" id="error-password">
                        Password must be at least 8 characters.
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                <button type="submit" class="btn btn-primary" id="saveChangesBtn" onclick="submitEditForm(event)">Save Changes</button>
            </div>
        </form>
        @endif
    </div>
</div>

<script>
// Add this script to ensure the form submits correctly
function submitEditForm(e) {
    e.preventDefault();
    
    // Get form data
    var formData = new FormData(document.getElementById('form-edit'));
    
    // Add CSRF token
    formData.append('_token', '{{ csrf_token() }}');
    
    // Submit via AJAX
    $.ajax({
        url: $('#form-edit').attr('action'),
        type: 'POST',
        data: formData,
        contentType: false,
        processData: false,
        beforeSend: function() {
            // Disable button to prevent double submit
            $('#saveChangesBtn').prop('disabled', true).html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Saving...');
        },
        success: function(response) {
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
                    $('#usersTable').DataTable().ajax.reload();
                });
            } else {
                // Re-enable button
                $('#saveChangesBtn').prop('disabled', false).text('Save Changes');
                
                if (response.msgField) {
                    $.each(response.msgField, function(key, value) {
                        $('#error-' + key).text(value[0]).show();
                        $('#' + key).addClass('is-invalid');
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
        error: function(xhr) {
            // Re-enable button
            $('#saveChangesBtn').prop('disabled', false).text('Save Changes');
            
            console.error('AJAX Error:', xhr.responseText);
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'An error occurred while processing your request'
            });
        }
    });
}
</script>