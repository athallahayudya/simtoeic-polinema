@if(empty($announcements))
    <div class="alert alert-danger">
        <h5><i class="icon fas fa-ban"></i> Failed!!!</h5>
        Data not found.
    </div>
    <a href="{{ url('announcements/') }}" class="btn btn-warning">Back</a>
@else
    <style>
        /* Ensure form elements are interactive */
        #announcementEditForm input,
        #announcementEditForm select,
        #announcementEditForm textarea {
            pointer-events: auto !important;
            user-select: auto !important;
            -webkit-user-select: auto !important;
            -moz-user-select: auto !important;
            -ms-user-select: auto !important;
            position: relative !important;
            z-index: 1 !important;
        }

        #announcementEditForm .custom-control-input {
            pointer-events: auto !important;
            position: relative !important;
            z-index: 2 !important;
        }

        #announcementEditForm .custom-control-label {
            pointer-events: auto !important;
            cursor: pointer !important;
        }
    </style>

    <form id="announcementEditForm" action="{{ url('announcements/' . $announcements->announcement_id . '/update') }}"
        method="POST" style="position: relative; z-index: 1;">
        @csrf
        @method('PUT')

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
            <div class="form-text text-muted mb-2">Select user types who can see this announcement. Leave empty to make
                visible to all users.</div>
            @php
                $currentVisibleTo = old('visible_to', $announcements->visible_to ?? []);
                if (is_string($currentVisibleTo)) {
                    $currentVisibleTo = json_decode($currentVisibleTo, true) ?? [];
                }
            @endphp
            <div class="row">
                <div class="col-md-3">
                    <div class="custom-control custom-checkbox">
                        <input type="checkbox" class="custom-control-input" id="dashboard_visible_student"
                            name="visible_to[]" value="student" {{ in_array('student', $currentVisibleTo) ? 'checked' : '' }}>
                        <label class="custom-control-label" for="dashboard_visible_student">Students</label>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="custom-control custom-checkbox">
                        <input type="checkbox" class="custom-control-input" id="dashboard_visible_staff" name="visible_to[]"
                            value="staff" {{ in_array('staff', $currentVisibleTo) ? 'checked' : '' }}>
                        <label class="custom-control-label" for="dashboard_visible_staff">Staff</label>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="custom-control custom-checkbox">
                        <input type="checkbox" class="custom-control-input" id="dashboard_visible_alumni"
                            name="visible_to[]" value="alumni" {{ in_array('alumni', $currentVisibleTo) ? 'checked' : '' }}>
                        <label class="custom-control-label" for="dashboard_visible_alumni">Alumni</label>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="custom-control custom-checkbox">
                        <input type="checkbox" class="custom-control-input" id="dashboard_visible_lecturer"
                            name="visible_to[]" value="lecturer" {{ in_array('lecturer', $currentVisibleTo) ? 'checked' : '' }}>
                        <label class="custom-control-label" for="dashboard_visible_lecturer">Lecturers</label>
                    </div>
                </div>
            </div>
            @error('visible_to')
                <div class="invalid-feedback d-block">{{ $message }}</div>
            @enderror
        </div>
    </form>

    <script>
        // Ensure form elements are interactive after loading
        $(document).ready(function () {
            console.log('Dashboard edit form loaded');

            // Force enable all form elements
            $('#announcementEditForm input, #announcementEditForm select, #announcementEditForm textarea').each(function () {
                console.log('Enabling element:', this);
                $(this).prop('disabled', false);
                $(this).prop('readonly', false);
                $(this).removeAttr('disabled');
                $(this).removeAttr('readonly');
                $(this).css({
                    'pointer-events': 'auto !important',
                    'user-select': 'auto !important',
                    'position': 'relative !important',
                    'z-index': '10 !important',
                    'background-color': 'white !important'
                });
            });

            // Enable checkboxes specifically
            $('#announcementEditForm input[type="checkbox"]').each(function () {
                console.log('Enabling checkbox:', this);
                $(this).prop('disabled', false);
                $(this).removeAttr('disabled');
                $(this).css({
                    'pointer-events': 'auto !important',
                    'position': 'relative !important',
                    'z-index': '20 !important'
                });
            });

            // Enable labels
            $('#announcementEditForm label').css({
                'pointer-events': 'auto !important',
                'cursor': 'pointer !important'
            });

            // Remove any overlay or blocking elements
            $('.modal-backdrop, .overlay').remove();

            // Focus on first input to test
            setTimeout(function () {
                var titleInput = $('#announcementEditForm input[name="title"]');
                console.log('Focusing on title input:', titleInput);
                titleInput.focus();
                titleInput.click();
            }, 300);
        });
    </script>
@endif