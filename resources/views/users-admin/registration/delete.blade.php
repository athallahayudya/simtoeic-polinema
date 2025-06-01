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
            <h5 class="modal-title">Delete User</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <form id="form-delete" action="{{ url('registration/'.$user->user_id.'/delete_ajax') }}" method="POST">
                @csrf
                <div class="alert alert-danger">
                    <p>Are you sure you want to delete this user?</p>
                    <p><strong>User ID:</strong> {{ $user->user_id }}</p>
                    <p><strong>Identity Number:</strong> {{ $user->identity_number }}</p>
                    <p><strong>Role:</strong> {{ ucfirst($user->role) }}</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-danger">Confirm Delete</button>
                </div>
            </form>
        </div>
        @endif
    </div>
</div>