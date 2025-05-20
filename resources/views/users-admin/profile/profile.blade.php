@extends('layouts.app')

@section('title', 'Admin Profile')

@section('main')
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Admin Profile</h1>
        </div>
        <div class="section-body">
            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif
            <form method="POST" action="{{ route('admin.profile.update') }}" enctype="multipart/form-data">
                @csrf
                <div class="form-group">
                    <label>ID Admin</label>
                    <input type="text" class="form-control" value="{{ $admin->admin_id }}" readonly>
                </div>
                <div class="form-group">
                    <label>Name</label>
                    <input type="text" name="name" class="form-control" value="{{ $admin->name }}" required>
                </div>
                <div class="form-group">
                    <label>Profile Photo</label><br>
                    <img src="{{ asset('storage/' . $lecturer->photo) }}" alt="Profile Photo">
                    <input type="file" name="photo" class="form-control-file">
                </div>
                <button type="submit" class="btn btn-primary">Update Profile</button>
            </form>
        </div>
    </section>
</div>


