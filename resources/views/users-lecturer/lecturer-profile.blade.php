@extends('layouts.app')

@section('title', 'Lecturer Profile')

@section('main')
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Lecturer Profile</h1>
        </div>

        <div class="section-body">
            <div class="row">
                {{-- Kartu Informasi Profil di Kiri --}}
                <div class="col-12 col-md-5 col-lg-4">
                    <div class="card profile-widget text-center p-4">
                        <div class="profile-widget-header justify-content-center">
                           <img src="{{ asset('storage/' . $lecturer->photo) }}" class="rounded-circle" width="120">

                        </div>

                        <div class="mt-3">
                            <h5 class="mb-0">{{ $lecturer->name }}</h5>
                            <span class="text-muted">Lecturer</span>
                        </div>

                        <div class="mt-4 text-left px-3">
                            <div class="mb-2">
                                <strong>NIDN:</strong><br>
                                <span>{{ $lecturer->nidn }}</span>
                            </div>
                            <div class="mb-2">
                                <strong>Phone Number:</strong><br>
                                <span>{{ $lecturer->user->phone_number ?? '-' }}</span>
                            </div>
                            <div class="mb-2">
                                <strong>Home Address:</strong><br>
                                <span>{{ $lecturer->home_address }}</span>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Form Edit di Kanan --}}
                <div class="col-12 col-md-7 col-lg-8">
                    <div class="card">
                        <div class="card-header">
                            <h4>Profile</h4>
                        </div>
                        <div class="card-body">
                            @if(session('success'))
                                <div class="alert alert-success">{{ session('success') }}</div>
                            @endif

                            <form method="POST" action="{{ route('lecturer.profile.update') }}" enctype="multipart/form-data">
                                @csrf

                                <div class="form-row">
                                    <div class="form-group col-md-6">
                                        <label>ID Lecturer</label>
                                        <input type="text" class="form-control" value="{{ $lecturer->lecturer_id }}" readonly>
                                    </div>

                                    <div class="form-group col-md-6">
                                        <label>Name</label>
                                        <input type="text" class="form-control" value="{{ $lecturer->name }}" readonly>
                                    </div>
                                </div>

                                <div class="form-row">
                                    <div class="form-group col-md-6">
                                        <label>NIDN</label>
                                        <input type="text" class="form-control" value="{{ $lecturer->nidn }}" readonly>
                                    </div>

                                    <div class="form-group col-md-6">
                                        <label>Phone Number</label>
                                        <input type="text" name="phone_number" class="form-control" value="{{ $lecturer->user->phone_number ?? '' }}">
                                        @error('phone_number') <div class="text-danger">{{ $message }}</div> @enderror
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label>Home Address</label>
                                    <input type="text" class="form-control" value="{{ $lecturer->home_address }}" readonly>
                                </div>

                                <div class="form-row">
    <div class="form-group col-md-6">
        <label>Scan KTP (PDF / JPG / PNG)</label>
        @if($lecturer->ktp_scan)
            <div class="mb-2">
                <a href="{{ asset('storage/' . $lecturer->ktp_scan) }}" target="_blank">Lihat KTP</a>
            </div>
        @endif
        <input type="file" name="ktp_scan" class="form-control-file">
        @error('ktp_scan') <div class="text-danger">{{ $message }}</div> @enderror
    </div>

    <div class="form-group col-md-6">
        <label>Photo Profile (JPG / PNG)</label>
        @if($lecturer->photo && Str::startsWith($lecturer->photo, 'profile_photos/'))
            <div class="mb-2">
                <a href="{{ asset('storage/' . $lecturer->photo) }}" target="_blank">Lihat Foto</a>
            </div>
        @endif
        <input type="file" name="photo" class="form-control-file">
        @error('photo') <div class="text-danger">{{ $message }}</div> @enderror
    </div>
</div>


                                <button type="submit" class="btn btn-primary mt-3">Save Changes</button>
                            </form>
                        </div>
                    </div>
                </div> {{-- end column --}}
            </div>
        </div>
    </section>
</div>
@endsection
