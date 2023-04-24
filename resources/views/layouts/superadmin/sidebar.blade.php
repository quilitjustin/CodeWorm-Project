<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="/dashboard" class="brand-link">
        <img src="{{ asset('assets/logo/logo.png') }}" alt="Logo" class="brand-image img-circle elevation-3"
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
        <div class="form-inline">
            <div class="input-group" data-widget="sidebar-search">
                <input class="form-control form-control-sidebar" type="search" placeholder="Search"
                    aria-label="Search">
                <div class="input-group-append">
                    <button class="btn btn-sidebar">
                        <i class="fas fa-search fa-fw"></i>
                    </button>
                </div>
            </div>
        </div>

        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                data-accordion="false">
                <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
                <li class="nav-item">
                    <a href="/dashboard" class="nav-link {{ request()->is('dashboard*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>
                            Dashboard
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="/announcements" class="nav-link {{ request()->is('announcements*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-box-open"></i>
                        <p>
                            Announcements
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="/users" class="nav-link {{ request()->is('users*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-users"></i>
                        <p>
                            Users
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="/splash" class="nav-link {{ request()->is('splash*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-box-open"></i>
                        <p>
                            Splash Page
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
                    <a href="#" class="nav-link {{ request()->is('cms*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-folder"></i>
                        <p>
                            CMS
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="#" class="nav-link {{ request()->is('cms/bgim*') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>
                                    Background Image
                                    <i class="right fas fa-angle-left"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="{{ route('super.cms.bgim.splash.index') }}"
                                        class="nav-link {{ request()->is('cms/bgim/splash*') ? 'active' : '' }}">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Splash</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('super.cms.bgim.login.index') }}"
                                        class="nav-link {{ request()->is('cms/bgim/login*') ? 'active' : '' }}">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Login</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('super.cms.bgim.leaderboards.index') }}"
                                        class="nav-link {{ request()->is('cms/bgim/leaderboards*') ? 'active' : '' }}">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Leaderboards</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('super.cms.bgim.play.index') }}"
                                        class="nav-link {{ request()->is('cms/bgim/play*') ? 'active' : '' }}">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Play</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('super.cms.bgim.announcement.index') }}"
                                        class="nav-link {{ request()->is('cms/bgim/announcement*') ? 'active' : '' }}">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Announcement</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('super.cms.bgim.stalk.index') }}"
                                        class="nav-link {{ request()->is('cms/bgim/stalk*') ? 'active' : '' }}">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Stalk</p>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('super.cms.logo.index') }}"
                                class="nav-link {{ request()->is('cms/logo*') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Logo</p>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link {{ request()->is('game*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-gamepad"></i>
                        <p>
                            Game
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="#"
                                class="nav-link {{ request()->is('game/programming*') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>
                                    Programming
                                    <i class="right fas fa-angle-left"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="{{ route('proglangs.index') }}"
                                        class="nav-link {{ request()->is('game/programming/proglang*') ? 'active' : '' }}">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Programming Language</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('stages.index') }}"
                                        class="nav-link {{ request()->is('game/programming/stages*') ? 'active' : '' }}">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Stages</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('tasks.index') }}"
                                        class="nav-link {{ request()->is('game/programming/tasks*') ? 'active' : '' }}">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Tasks</p>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('badges.index') }}" class="nav-link {{ request()->is('game/badges*') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>
                                    Badges
                                </p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('bgims.index') }}"
                                class="nav-link {{ request()->is('game/bgims*') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>BG Image</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('bgms.index') }}"
                                class="nav-link {{ request()->is('game/bgms*') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>BGM</p>
                            </a>
                        </li>
                        {{-- <li class="nav-item">
                            <a href="#" class="nav-link {{ request()->is('game/effects*') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>
                                    Effects
                                    <i class="right fas fa-angle-left"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="{{ route('sfxs.index') }}"
                                        class="nav-link {{ request()->is('game/effects/sfxs*') ? 'active' : '' }}">
                                        <i class="far fa-dot-circle nav-icon"></i>
                                        <p>Sound</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('vfxs.index') }}"
                                        class="nav-link {{ request()->is('game/effects/vfxs*') ? 'active' : '' }}">
                                        <i class="far fa-dot-circle nav-icon"></i>
                                        <p>Visual</p>
                                    </a>
                                </li>
                            </ul>
                        </li> --}}
                    </ul>
                </li>
                <li class="nav-item">
                    <a href="{{ route('super.inquiries.index') }}"
                        class="nav-link {{ request()->is('inquiries*') ? 'active' : '' }}">
                        <i class="nav-icon far fa-comments"></i>
                        <p>
                            Inquiries
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('super.export.index') }}"
                        class="nav-link {{ request()->is('export*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-wrench"></i>
                        <p>
                            Export
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('super.profile') }}"
                        class="nav-link {{ request()->is('profile*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-wrench"></i>
                        <p>
                            Profile
                        </p>
                    </a>
                </li>
                <hr class="border border-primary w-100">
                <li class="nav-item">
                    <form method="POST" action="{{ route('super.logout') }}">
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
