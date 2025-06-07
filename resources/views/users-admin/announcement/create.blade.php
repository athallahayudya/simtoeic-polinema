@extends('layouts.app')

@section('title', 'Create Announcement')

@section('main')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Create Announcements</h1>
            </div>

            <div class="section-body">
                @if(session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif

                <div class="card">
                    <div class="card-body">
                        <form action="{{ url('announcements/store') }}" method="POST">
                            @csrf
                            <div class="form-group">
                                <label>Title</label>
                                <input type="text" name="title" class="form-control @error('title') is-invalid @enderror"
                                    placeholder="Descriptive title" value="{{ old('title') }}">
                                @error('title')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label>Status</label>
                                <select name="announcement_status"
                                    class="form-control @error('announcement_status') is-invalid @enderror">
                                    <option value="draft" {{ old('announcement_status') == 'draft' ? 'selected' : '' }}>Draft
                                    </option>
                                    <option value="published" {{ old('announcement_status') == 'published' ? 'selected' : '' }}>Published</option>
                                </select>
                                @error('announcement_status')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label>Date</label>
                                <input type="date" name="announcement_date"
                                    class="form-control @error('announcement_date') is-invalid @enderror"
                                    value="{{ old('announcement_date') }}">
                                @error('announcement_date')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label>Content</label>
                                <textarea name="content" class="form-control @error('content') is-invalid @enderror"
                                    rows="5" placeholder="Enter announcement content">{{ old('content') }}</textarea>
                                @error('content')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label>Visible To</label>
                                <div class="form-text text-muted mb-2">Select user types who can see this announcement.
                                    Leave empty to make visible to all users.</div>
                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input" id="visible_student"
                                                name="visible_to[]" value="student" {{ in_array('student', old('visible_to', [])) ? 'checked' : '' }}>
                                            <label class="custom-control-label" for="visible_student">Students</label>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input" id="visible_staff"
                                                name="visible_to[]" value="staff" {{ in_array('staff', old('visible_to', [])) ? 'checked' : '' }}>
                                            <label class="custom-control-label" for="visible_staff">Staff</label>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input" id="visible_alumni"
                                                name="visible_to[]" value="alumni" {{ in_array('alumni', old('visible_to', [])) ? 'checked' : '' }}>
                                            <label class="custom-control-label" for="visible_alumni">Alumni</label>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input" id="visible_lecturer"
                                                name="visible_to[]" value="lecturer" {{ in_array('lecturer', old('visible_to', [])) ? 'checked' : '' }}>
                                            <label class="custom-control-label" for="visible_lecturer">Lecturers</label>
                                        </div>
                                    </div>
                                </div>
                                @error('visible_to')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <a href="{{ url('announcements') }}" class="btn btn-secondary">Cancel</a>
                                <button type="submit" class="btn btn-primary">Publish</button>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection