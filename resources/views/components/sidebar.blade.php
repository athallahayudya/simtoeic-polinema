<div class="main-sidebar sidebar-style-2">
    <aside id="sidebar-wrapper">
        <div class="sidebar-brand">
            <a href="{{ url('dashboard-admin') }}">SIMTOEIC</a>
        </div>
        <div class="sidebar-brand sidebar-brand-sm">
            <a href="{{ url('dashboard-admin') }}">StP</a>
        </div>
        <ul class="sidebar-menu">
            <!-- Dashboard -->
            <li class="{{ Request::is('dashboard-admin') ? 'active' : '' }}">
                <a class="nav-link" href="{{ url('dashboard-admin') }}">
                    <i class="fas fa-fire"></i><span>Dashboard</span>
                </a>
            </li>
            
            <!-- Management Dropdown -->
            <li class="nav-item dropdown {{ in_array(Request::segment(1), ['registration', 'exam-results', 'users']) ? 'active' : '' }}">
                <a href="#" class="nav-link has-dropdown">
                    <i class="fas fa-cogs"></i> <span>Management</span>
                </a>
                <ul class="dropdown-menu">
                    <li class="{{ Request::is('registration*') ? 'active' : '' }}">
                        <a class="nav-link" href="{{ url('registration') }}">Registration</a>
                    </li>
                    <li class="{{ Request::is('exam-results*') ? 'active' : '' }}">
                        <a class="nav-link" href="{{ url('exam-results') }}">Exam Results</a>
                    </li>
                    <li class="{{ Request::is('users*') ? 'active' : '' }}">
                        <a class="nav-link" href="{{ url('manage-users') }}">Users</a>
                    </li>
                </ul>
            </li>
            
            <!-- Notices Dropdown -->
            <li class="nav-item dropdown {{ in_array(Request::segment(1), ['announcements', 'faq']) ? 'active' : '' }}">
                <a href="#" class="nav-link has-dropdown">
                    <i class="fas fa-bullhorn"></i> <span>Notices</span>
                </a>
                <ul class="dropdown-menu">
                    <li class="{{ Request::is('announcements*') ? 'active' : '' }}">
                        <a class="nav-link" href="{{ url('announcements') }}">Announcements</a>
                    </li>
                    <li class="{{ Request::is('faq*') ? 'active' : '' }}">
                        <a class="nav-link" href="{{ url('faq') }}">FAQ</a>
                    </li>
                </ul>
            </li>
            
            <!-- Profile -->
            <li class="{{ Request::is('admin/profile') ? 'active' : '' }}">
                <a class="nav-link" href="{{ url('admin/profile') }}">
                    <i class="fas fa-user"></i> <span>Profile</span>
                </a>
            </li>
            
            <!-- Logout -->
            <li>
                <a class="nav-link text-danger" href="{{ route('auth.logout') }}"
                onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                    <i class="fas fa-sign-out-alt"></i> <span>Logout</span>
                </a>
                <form id="logout-form" action="{{ route('auth.logout') }}" method="POST" class="d-none">
                    @csrf
                </form>
            </li>
        </ul>
    </aside>
</div>