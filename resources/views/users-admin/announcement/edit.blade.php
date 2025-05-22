@extends('layouts.app')

@section('title', 'Edit Announcements')

@section('main')
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Edit Announcements</h1>
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
                            <label>Judul</label>
                            <input type="text" name="title" class="form-control @error('title') is-invalid @enderror" placeholder="Judul singkat" value="{{ old('title') }}">
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
                            <label>Tanggal Pengumuman</label>
                            <input type="date" name="announcement_date" class="form-control @error('announcement_date') is-invalid @enderror" value="{{ old('announcement_date') }}">
                            @error('announcement_date')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label>Konten</label>
                            <textarea name="content" class="form-control @error('content') is-invalid @enderror" rows="5" placeholder="Masukkan konten pengumuman">{{ old('content') }}</textarea>
                            @error('content')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <button type="submit" class="btn btn-primary">Publish</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection