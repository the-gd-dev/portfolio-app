<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <?php $role = strtolower(auth()->user()->role->name); ?>
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.html">
        <div class="sidebar-brand-icon mx-3 mx-md-2">
            <img class="normal" src="{{ asset('wide-logo-w.png') }}" alt="" style="padding:25px 15px;">
            <img class="minimized" src="{{ asset('logo.png') }}" alt="" class="h-md-50 w-md-50 ">
        </div>
        {{-- <div class="sidebar-brand-text mx-3">My Portfolio</div> --}}
    </a>

    <!-- Divider -->
    <hr class="sidebar-divider my-0">


    @if ($role == 'superadmin')
        <!-- Nav Item - Charts -->
        <li class="nav-item @if (\Request::is('profiles*')) active @endif">
            <a class="nav-link" href="{{ route('admin.profiles.index') }}">
                <i class="fas fa-fw fa-suitcase"></i>
                <span>Profiles</span></a>
        </li>
        <!-- Nav Item - Charts -->
        <li class="nav-item @if (\Request::is('skills*')) active @endif">
            <a class="nav-link" href="{{ route('admin.skills.index') }}">
                <i class="fa fa-fw fa-angle-double-right"></i>
                <span>Skils</span></a>
        </li>
        <li class="nav-item @if (\Request::is('users*')) active @endif">
            <a class="nav-link" href="{{ route('admin.users.index') }}">
                <i class="fa fa-fw fa-users"></i>
                <span>Users</span></a>
        </li>

    @else
        <li class="nav-item @if (\Request::is('my-profile')) active @endif">
            <a class="nav-link" href="{{ route('admin.my.profile') }}">
                <i class="fa fa-fw fa-user"></i>
                <span>My Profile</span></a>
        </li>
    @endif
    @if ($role == 'user')
        <!-- Nav Item - Charts -->
        <li class="nav-item @if (\Request::is('about*')) active @endif">
            <a class="nav-link" href="{{ route('admin.about.index') }}">
                <i class="fas fa-fw fa-list"></i>
                <span>About me</span></a>
        </li>

        <!-- Nav Item - Tables -->
        <li class="nav-item @if (\Request::is('resume*')) active @endif">
            <a class="nav-link" href="{{ route('admin.resume.index') }}">
                <i class="fa fa-fw fa-file"></i>
                <span>Resume</span></a>
        </li>
        <li class="nav-item @if (\Request::is('portfolio-categories*')) active @endif">
            <a class="nav-link" href="{{ route('admin.portfolio-categories.index') }}">
                <i class="fa fa-fw fa-book"></i>
                <span>Portfolio Categories</span></a>
        </li>
    @endif
    <li class="nav-item @if (\Request::is('portfolios*')) active @endif">
        <a class="nav-link" href="{{ route('admin.portfolios.index') }}">
            <i class="fa fa-fw fa-book"></i>
            <span>Portfolios</span></a>
    </li>

    @if ($role == 'user')
        <li class="nav-item @if (\Request::is('services*')) active @endif">
            <a class="nav-link" href="{{ route('admin.services.index') }}">
                <i class="fa fa-fw fa-server"></i>
                <span>Services</span></a>
        </li>
        <li class="nav-item @if (\Request::is('contact-form*')) active @endif">
            <a class="nav-link" href="{{ route('admin.contact-form.index') }}">
                <i class="fa fa-fw fa-envelope"></i>
                <span>Contacts</span></a>
        </li>
    @endif
    <li class="nav-item @if (\Request::is('activities*')) active @endif">
        <a class="nav-link" href="{{ route('activities.index') }}">
            <i class="fa fa-fw fa-star"></i>
            <span>Activities</span></a>
    </li>
    <!-- Divider -->
    <hr class="sidebar-divider d-none d-md-block">

    <!-- Sidebar Toggler (Sidebar) -->
    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>
</ul>
