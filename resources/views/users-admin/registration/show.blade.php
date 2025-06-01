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
            <h5 class="modal-title">User Details</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <table class="table table-bordered">
                <tr>
                    <th width="30%">User ID</th>
                    <td>{{ $user->user_id }}</td>
                </tr>
                <tr>
                    <th>Identity Number</th>
                    <td>{{ $user->identity_number }}</td>
                </tr>
                <tr>
                    <th>Role</th>
                    <td>{{ ucfirst($user->role) }}</td>
                </tr>
                <tr>
                    <th>Name</th>
                    <td>{{ $profile->name ?? 'N/A' }}</td>
                </tr>
                <tr>
                    <th>Exam Status</th>
                    <td>
                        @if($user->exam_status == 'not_yet')
                            <span class="badge badge-warning">Not Yet</span>
                        @elseif($user->exam_status == 'success')
                            <span class="badge badge-success">Success</span>
                        @elseif($user->exam_status == 'fail')
                            <span class="badge badge-danger">Failed</span>
                        @else
                            <span class="badge badge-secondary">Unknown</span>
                        @endif
                    </td>
                </tr>
                <tr>
                    <th>Phone Number</th>
                    <td>{{ $user->phone_number ?? 'N/A' }}</td>
                </tr>
                <tr>
                    <th>Created At</th>
                    <td>{{ $user->created_at }}</td>
                </tr>
            </table>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        </div>
        @endif
    </div>
</div>