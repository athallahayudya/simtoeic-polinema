@extends('layouts.app')

@section('title', 'Create Faq')

@section('main')
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Create FAQs</h1>
        </div>

        <div class="section-body">
            @if(session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

            <div class="card">
                <div class="card-body">
                    <form action="{{ url('faqs/store') }}" method="POST">
                        @csrf
                        <div class="form-group">
                            <label>Question</label>
                            <input type="text" name="question" class="form-control @error('question') is-invalid @enderror" placeholder="Enter The Question" value="{{ old('question') }}">
                            @error('title')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label>Answer</label>
                            <input type="text" name="answer" class="form-control @error('answer') is-invalid @enderror" placeholder="Enter The Answer" value="{{ old('answer') }}">
                            @error('answer')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <a href="{{ url('faqs') }}" class="btn btn-secondary">Cancel</a>   
                            <button type="submit" class="btn btn-primary">Create</button>
                        </div>
                        
                    </form>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection