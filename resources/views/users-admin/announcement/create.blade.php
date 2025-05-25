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
                            <input type="text" name="title" class="form-control @error('title') is-invalid @enderror" placeholder="Descriptive title" value="{{ old('title') }}">
                            @error('title')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label>Status</label>
                            <select name="announcement_status" class="form-control @error('announcement_status') is-invalid @enderror">
                                <option value="draft" {{ old('announcement_status') == 'draft' ? 'selected' : '' }}>Draft</option>
                                <option value="published" {{ old('announcement_status') == 'published' ? 'selected' : '' }}>Published</option>
                            </select>
                            @error('announcement_status')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label>Date</label>
                            <input type="date" name="announcement_date" class="form-control @error('announcement_date') is-invalid @enderror" value="{{ old('announcement_date') }}">
                            @error('announcement_date')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label>Content</label>
                            <textarea name="content" class="form-control @error('content') is-invalid @enderror" rows="5" placeholder="Enter announcement content">{{ old('content') }}</textarea>
                            @error('content')
                                <div class="invalid-feedback">{{ $message }}</div>
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