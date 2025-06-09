<div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
        @empty($user)
        <div class="modal-header">
            <h5 class="modal-title">Failed</h5>
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
        @else
        <div class="modal-header">
            <h5 class="modal-title">Detail User Data</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <div class="form-group">
                <label>Name</label>
                <input type="text" class="form-control" value="{{ $profile->name ?? 'N/A' }}" readonly>
            </div>
            <div class="form-group">
                <label>Identity Number</label>
                <input type="text" class="form-control" value="{{ $user->identity_number ?? '-' }}" readonly>
            </div>
            <div class="form-group">
                <label>Role</label>
                <input type="text" class="form-control" value="{{ $user->role ?? '-' }}" readonly>
            </div>
            <div class="form-group">
                <label>Exam Status</label>
                <input type="text" class="form-control" value="{{ $user->exam_status ?? '-' }}" readonly>
            </div>
            @if($user->role === 'student')
            <div class="form-group">
                <label>Campus</label>
                <input type="text" class="form-control" value="{{ $user->student->campus ?? '-' }}" readonly>
            </div>
            <div class="form-group">
                <label>Major</label>
                <input type="text" class="form-control" value="{{ $user->student->major ?? '-' }}" readonly>
            </div>
            <div class="form-group">
                <label>Study Program</label>
                <input type="text" class="form-control" value="{{ $user->student->study_program ?? '-' }}" readonly>
            </div>
            @endif
            <div class="form-group">
                <label>Home Address</label>
                <input type="text" class="form-control" value="{{ $profile->home_address ?? '-' }}" readonly>
            </div>
            <div class="form-group">
                <label>Current Address</label>
                <input type="text" class="form-control" value="{{ $profile->current_address ?? '-' }}" readonly>
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-warning" data-dismiss="modal">Back</button>
        </div>
        @endempty

    </div>
</div>