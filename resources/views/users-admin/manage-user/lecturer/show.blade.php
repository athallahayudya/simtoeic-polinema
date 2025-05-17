<div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">

        @empty($lecturer)
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
            <a href="{{ url('/manage-users/lecturer/') }}" class="btn btn-warning">Back</a>
        </div>
        @else
        <div class="modal-header">
            <h5 class="modal-title">Detail Lecturer Data</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <div class="form-group">
                <label>Name</label>
                <input type="text" class="form-control" value="{{ $lecturer->name }}" readonly>
            </div>
            <div class="form-group">
                <label>NIDN</label>
                <input type="text" class="form-control" value="{{ $lecturer->nidn }}" readonly>
            </div>
            <div class="form-group">
                <label>Exam Status</label>
                <input type="text" class="form-control" value="{{ $lecturer->user->exam_status }}" readonly>
            </div>
            <div class="form-group">
                <label>Home Address</label>
                <input type="text" class="form-control" value="{{ $lecturer->home_address }}" readonly>
            </div>
            <div class="form-group">
                <label>Current Address</label>
                <input type="text" class="form-control" value="{{ $lecturer->current_address }}" readonly>
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-warning" data-dismiss="modal">Back</button>
        </div>
        @endempty

    </div>
</div>