<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="{{ route('web.play.index') }}" class="brand-link">
        <img src="{{ asset('assets/logo/logo.png') . '?v=' . filemtime(public_path('assets/logo/logo.png')) }}" alt="Logo" class="brand-image img-circle elevation-3"
            style="opacity: .8">
        <span class="brand-text font-weight-light">Codeworm</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user panel (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
                <img src="{{ !is_null(Auth::user()->profile_picture) ? asset(Auth::user()->profile_picture) : 'https://ui-avatars.com/api/?name=' . Auth::user()->f_name . '+' . Auth::user()->l_name }}"
                    class="img-circle elevation-2" style="height: 30px; width: 30px" alt="User Image">
            </div>
            <div class="info">
                <a href="#" class="d-block">{{ Auth::user()->f_name . ' ' . Auth::user()->l_name }}</a>
            </div>
        </div>

        <!-- SidebarSearch Form -->
        {{-- <div class="form-inline">
            <div class="input-group" data-widget="sidebar-search">
                <input class="form-control form-control-sidebar" type="search" placeholder="Search"
                    aria-label="Search">
                <div class="input-group-append">
                    <button class="btn btn-sidebar">
                        <i class="fas fa-search fa-fw"></i>
                    </button>
                </div>
            </div>
        </div> --}}

        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                data-accordion="false">
                <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
                <li class="nav-item">
                    <a href="/announcements" class="nav-link {{ request()->is('announcements*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-scroll"></i>
                        <p>
                            Announcements <span class="right badge badge-danger">!</span>
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="/play" class="nav-link {{ request()->is('play*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-gamepad"></i>
                        <p>
                            Play
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="/stories" class="nav-link {{ request()->is('stories*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-book"></i>
                        <p>
                            Stories
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="/leaderboard" class="nav-link {{ request()->is('leaderboard*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-id-badge"></i>
                        <p>
                            Leaderboards
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('web.help') }}" class="nav-link {{ request()->is('help*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-question"></i>
                        <p>
                            How to Play
                        </p>
                    </a>
                </li>
                {{-- <li class="nav-item">
                    <a href="{{ route('public_profile.index') }}"
                        class="nav-link {{ request()->is('public_profile*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-search fa-fw"></i>
                        <p>
                            Stalk
                        </p>
                    </a>
                </li> --}}
                <li class="nav-item">
                    <a href="{{ route('web.profile') }}"
                        class="nav-link {{ request()->is('profile*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-wrench"></i>
                        <p>
                            Profile
                        </p>
                    </a>
                </li>
                <hr class="border border-primary w-100">
                <li class="nav-item">
                    <form method="POST" action="{{ route('web.logout') }}">
                        @csrf
                        <button type="submit" class="btn btn-danger w-100"><i
                                class="nav-icon fa-arrow-alt-circle-right"></i>
                            <span class="logout-text ">
                                Logout
                            </span>
                        </button>
                    </form>
                </li>
            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>
