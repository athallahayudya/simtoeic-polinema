<div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">

        @empty($announcements)
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
            <a href="{{ url('announcements/') }}" class="btn btn-warning">Back</a>
        </div>
        @else
        <div class="modal-header">
            <h5 class="modal-title">Detail Data Announcement</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <div class="form-group">
                <label>Title</label>
                <input type="text" class="form-control" value="{{ $announcements->title }}" readonly>
            </div>
            <div class="form-group">
                <label>Content</label>
                <input type="text" class="form-control" value="{{ $announcements->content }}" readonly>
            </div>
            <div class="form-group">
                <label>Announcement Status</label>
                <input type="text" class="form-control" value="{{ $announcements->announcement_status }}" readonly>
            </div>
            <div class="form-group">
                <label>Announcement Date</label>
                <input type="text" class="form-control" value="{{ \Carbon\Carbon::parse($announcements->announcement_date)->setTimezone('Asia/Jakarta')->format('d-m-Y') }}" readonly>
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-warning" data-dismiss="modal">Back</button>
        </div>
        @endempty
    </div>
</div>