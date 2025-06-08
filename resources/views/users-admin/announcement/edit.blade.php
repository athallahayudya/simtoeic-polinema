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
            <div class="modal-header">
                <h5 class="modal-title">Edit Announcement</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ url('announcements/' . $announcements->announcement_id . '/update') }}" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="form-group">
                        <label>Title</label>
                        <input type="text" class="form-control @error('title') is-invalid @enderror" name="title"
                            value="{{ old('title', $announcements->title) }}">
                        @error('title')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label>Announcement Status</label>
                        <select class="form-control @error('announcement_status') is-invalid @enderror"
                            name="announcement_status">
                            <option value="published" {{ old('announcement_status', $announcements->announcement_status) == 'published' ? 'selected' : '' }}>Published</option>
                            <option value="draft" {{ old('announcement_status', $announcements->announcement_status) == 'draft' ? 'selected' : '' }}>Draft</option>
                        </select>
                        @error('announcement_status')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label>Announcement Date</label>
                        <input type="date" class="form-control @error('announcement_date') is-invalid @enderror"
                            name="announcement_date"
                            value="{{ old('announcement_date', \Carbon\Carbon::parse($announcements->announcement_date)->format('Y-m-d')) }}">
                        @error('announcement_date')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label>Content</label>
                        <textarea class="form-control @error('content') is-invalid @enderror" name="content"
                            rows="4">{{ old('content', $announcements->content) }}</textarea>
                        @error('content')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label>Visible To</label>
                        <div class="form-text text-muted mb-2">Select user types who can see this announcement. Leave empty
                            to make visible to all users.</div>
                        @php
                            $currentVisibleTo = old('visible_to', $announcements->visible_to ?? []);
                            if (is_string($currentVisibleTo)) {
                                $currentVisibleTo = json_decode($currentVisibleTo, true) ?? [];
                            }
                        @endphp
                        <div class="row">
                            <div class="col-md-3">
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input" id="visible_student"
                                        name="visible_to[]" value="student" {{ in_array('student', $currentVisibleTo) ? 'checked' : '' }}>
                                    <label class="custom-control-label" for="visible_student">Students</label>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input" id="visible_staff"
                                        name="visible_to[]" value="staff" {{ in_array('staff', $currentVisibleTo) ? 'checked' : '' }}>
                                    <label class="custom-control-label" for="visible_staff">Staff</label>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input" id="visible_alumni"
                                        name="visible_to[]" value="alumni" {{ in_array('alumni', $currentVisibleTo) ? 'checked' : '' }}>
                                    <label class="custom-control-label" for="visible_alumni">Alumni</label>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input" id="visible_lecturer"
                                        name="visible_to[]" value="lecturer" {{ in_array('lecturer', $currentVisibleTo) ? 'checked' : '' }}>
                                    <label class="custom-control-label" for="visible_lecturer">Lecturers</label>
                                </div>
                            </div>
                        </div>
                        @error('visible_to')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
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