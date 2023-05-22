<!-- Navbar -->
<nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
        <li class="nav-item">
            <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
    </ul>

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
        <!-- Notifications Dropdown Menu -->
        <li class="nav-item dropdown">
            <a class="nav-link" data-toggle="dropdown" href="#">
                <i class="far fa-bell"></i>
                {{-- This will be updated with ajax inside app.blade.php --}}
                <span id="total-notification" class="badge badge-warning navbar-badge">0</span>
            </a>
            <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                <span class="dropdown-item dropdown-header">Notifications</span>
                {{-- <div class="dropdown-divider"></div>
        <a href="#" class="dropdown-item">
            <i class="fas fa-envelope mr-2"></i> 4 new messages
            <span class="float-right text-muted text-sm">3 mins</span>
        </a> --}}
                <div class="dropdown-divider"></div>
                <a href="{{ route('web.announcements.index') }}" class="dropdown-item">
                    {{-- This will be updated with ajax inside app.blade.php --}}
                    <i class="fas fa-scroll mr-2"></i> <span id="user-reg-count"></span> New Announcement
                    <span class="float-right text-muted text-sm">{{ \Carbon\Carbon::parse(now())->diffForHumans() }}</span>
                </a>
                <div class="dropdown-divider"></div>
                {{-- <a href="#" class="dropdown-item dropdown-footer">See All Notifications</a> --}}
            </div>
        </li>
    </ul>
</nav>
<!-- /.navbar -->
