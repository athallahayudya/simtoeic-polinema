<div class="navbar-bg"></div>
<div class="navbar-bg"></div>
<nav class="navbar navbar-expand-lg main-navbar">
    <form class="form-inline mr-auto">
        <ul class="navbar-nav mr-3">
            <li><a href="#" data-toggle="sidebar" class="nav-link nav-link-lg"><i class="fas fa-bars"></i></a></li>
            <li><a href="#" data-toggle="search" class="nav-link nav-link-lg d-sm-none"><i
                        class="fas fa-search"></i></a></li>
        </ul>
        <div class="search-element">
            <input class="form-control" type="search" placeholder="Search" aria-label="Search" data-width="250">
            <button class="btn" type="submit"><i class="fas fa-search"></i></button>
        </div>
    </form>
    <ul class="navbar-nav navbar-right">
        <li>
            <a href="@if(Auth::check())
                @if(Auth::user()->role === 'admin')
                    {{ route('admin.profile') }}
                @elseif(Auth::user()->role === 'student')
                    {{ route('student.profile') }}
                @elseif(Auth::user()->role === 'lecturer')
                    {{ route('lecturer.profile') }}
                @elseif(Auth::user()->role === 'staff')
                    {{ route('staff.profile') }}
                @elseif(Auth::user()->role === 'alumni')
                    {{ route('alumni.profile') }}
                @else
                    #
                @endif
            @else
                        #
                    @endif" class="nav-link nav-link-lg nav-link-user">
                <img alt="image" src="
                    @if(Auth::check())
                        @php
                            $profilePicture = null;
                            if (Auth::user()->role === 'student' && Auth::user()->student && Auth::user()->student->photo) {
                                $profilePicture = Auth::user()->student->photo;
                            } elseif (Auth::user()->role === 'lecturer' && Auth::user()->lecturer && Auth::user()->lecturer->photo) {
                                $profilePicture = Auth::user()->lecturer->photo;
                            } elseif (Auth::user()->role === 'staff' && Auth::user()->staff && Auth::user()->staff->photo) {
                                $profilePicture = Auth::user()->staff->photo;
                            } elseif (Auth::user()->role === 'alumni' && Auth::user()->alumni && Auth::user()->alumni->photo) {
                                $profilePicture = Auth::user()->alumni->photo;
                            }
                            // Remove 'storage/' prefix if it exists, as asset('storage/') will add it
                            if ($profilePicture && str_starts_with($profilePicture, 'storage/')) {
                                $profilePicture = substr($profilePicture, 8);
                            }
                        @endphp
                        {{ $profilePicture ? asset('storage/' . $profilePicture) : asset('img/avatar/avatar-1.png') }}
                    @else
                        {{ asset('img/avatar/avatar-1.png') }}
                    @endif
                " class="rounded-circle mr-1" style="width: 30px; height: 30px; object-fit: cover;">
                <div class="d-sm-none d-lg-inline-block">
                    Hi,
                    @if(Auth::check())
                        @if(Auth::user()->role === 'student' && Auth::user()->student)
                            {{ Auth::user()->student->name }}
                        @elseif(Auth::user()->role === 'lecturer' && Auth::user()->lecturer)
                            {{ Auth::user()->lecturer->name }}
                        @elseif(Auth::user()->role === 'staff' && Auth::user()->staff)
                            {{ Auth::user()->staff->name }}
                        @elseif(Auth::user()->role === 'alumni' && Auth::user()->alumni)
                            {{ Auth::user()->alumni->name }}
                        @else
                            {{ Auth::user()->name ?? Auth::user()->identity_number }}
                        @endif
                    @else
                        Guest
                    @endif
                </div>
            </a>
        </li>
    </ul>
</nav>