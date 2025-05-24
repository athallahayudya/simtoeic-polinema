@extends('layouts.app')

@section('title', 'Edit User')

@section('main')
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Edit User</h1>
        </div>
        <div class="section-body">
            <div class="card">
                <div class="card-header"><h4>Edit User</h4></div>
                <div class="card-body">
                    <form method="POST" action="{{ url('/registration/'.$user->user_id.'/update') }}">
                        @csrf
                        <div class="form-group">
                            <label>Name</label>
                            <input type="text" name="name" class="form-control" value="{{ $user->name }}" required>
                        </div>
                        <div class="form-group">
                            <label>Role</label>
                            <input type="text" name="role" class="form-control" value="{{ $user->role }}" required>
                        </div>
                        <div class="form-group">
                            <label>Identity Number</label>
                            <input type="text" name="identity_number" class="form-control" value="{{ $user->identity_number }}" required>
                        </div>
                        <div class="form-group">
                            <label>Status</label>
                            <input type="text" name="exam_status" class="form-control" value="{{ $user->exam_status }}">
                        </div>
                        <button type="submit" class="btn btn-primary">Save</button>
                        <a href="{{ route('registration') }}" class="btn btn-secondary">Cancel</a>
                    </form>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection