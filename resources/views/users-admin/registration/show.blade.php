@extends('layouts.app')

@section('title', 'Detail User')

@section('main')
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>User Detail</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item"><a href="{{ route('registration') }}">Registration</a></div>
                <div class="breadcrumb-item active">Detail</div>
            </div>
        </div>
        <div class="section-body">
            <div class="card">
                <div class="card-header"><h4>User Information</h4></div>
                <div class="card-body">
                    <div class="form-group">
                        <label>Name</label>
                        <input type="text" class="form-control" value="{{ $user->name ?? '-' }}" readonly>
                    </div>
                    <div class="form-group">
                        <label>Role</label>
                        <input type="text" class="form-control" value="{{ ucfirst($user->role ?? '-') }}" readonly>
                    </div>
                    <div class="form-group">
                        <label>Identity Number</label>
                        <input type="text" class="form-control" value="{{ $user->identity_number ?? '-' }}" readonly>
                    </div>
                    <div class="form-group">
                        <label>Status</label>
                        <input type="text" class="form-control" value="{{ $user->exam_status ?? '-' }}" readonly>
                    </div>
                    <a href="{{ route('registration') }}" class="btn btn-secondary">Back</a>
                    <a href="{{ url('/registration/'.$user->user_id.'/edit') }}" class="btn btn-primary">Edit</a>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection