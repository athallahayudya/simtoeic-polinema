<div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
        @empty($staff)
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
            <a href="{{ url('/manage-users/staff/') }}" class="btn btn-warning">Back</a>
        </div>
        @else
        <div class="modal-header">
            <h5 class="modal-title">Detail Staff Data</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <div class="form-group">
                <label>Name</label>
                <input type="text" class="form-control" value="{{ $staff->name }}" readonly>
            </div>
            <div class="form-group">
                <label>NIP</label>
                <input type="text" class="form-control" value="{{ $staff->nip }}" readonly>
            </div>
            <div class="form-group">
                <label>Exam Status</label>
                <input type="text" class="form-control" value="{{ $staff->user->exam_status }}" readonly>
            </div>
            <div class="form-group">
                <label>Home Address</label>
                <input type="text" class="form-control" value="{{ $staff->home_address }}" readonly>
            </div>
            <div class="form-group">
                <label>Current Address</label>
                <input type="text" class="form-control" value="{{ $staff->current_address }}" readonly>
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-warning" data-dismiss="modal">Back</button>
        </div>
        @endempty
    </div>
</div>