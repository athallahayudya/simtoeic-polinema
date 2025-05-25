<div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
        @if(empty($announcements))
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
        <form action="{{ url('announcements/' . $announcements->announcement_id. '/update') }}" method="POST">
            @csrf
            @method('PUT')
            <div class="modal-header">
                <h5 class="modal-title">Edit Announcement</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label>Title</label>
                    <input type="text" class="form-control @error('title') is-invalid @enderror" name="title" value="{{ old('title', $announcements->title) }}">
                    @error('title')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="form-group">
                    <label>Announcement Status</label>
                    <select class="form-control @error('announcement_status') is-invalid @enderror" name="announcement_status">
                        <option value="published" {{ old('announcement_status', $announcements->announcement_status) == 'published' ? 'selected' : '' }}>Published</option>
                        <option value="draft" {{ old('announcement_status', $announcements->announcement_status) == 'draft' ? 'selected' : '' }}>Draft</option>
                    </select>
                    @error('announcement_status')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="form-group">
                    <label>Announcement Date</label>
                    <input type="date" class="form-control @error('announcement_date') is-invalid @enderror" name="announcement_date" value="{{ old('announcement_date', $announcements->announcement_date) }}">
                    @error('announcement_date')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="form-group">
                    <label>Content</label>
                    <textarea class="form-control @error('content') is-invalid @enderror" name="content">{{ old('content', $announcements->content) }}</textarea>
                    @error('content')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                <button type="submit" class="btn btn-primary">Save Changes</button>
            </div>
        </form>
        @endif
    </div>
</div>