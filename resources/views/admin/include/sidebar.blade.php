<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.html">
        <div class="sidebar-brand-icon ">
            <img class="normal" src="{{asset('wide-logo.png')}}" alt="" class="h-100 w-100">
            <img class="minimized" src="{{asset('logo.png')}}" alt="" class="h-100 w-100">
        </div>
        {{-- <div class="sidebar-brand-text mx-3">My Portfolio</div> --}}
    </a>

    <!-- Divider -->
    <hr class="sidebar-divider my-0">

    <!-- Nav Item - Dashboard -->
    <li class="nav-item @if (\Request::is('home*')) active @endif">
        <a class="nav-link" href="{{ route('admin.home.index') }}">
            <i class="fas fa-fw fa-home"></i>
            <span>Home</span></a>
    </li>
    
    <?php $role = strtolower(auth()->user()->role->name); ?>
    @if( $role == 'superadmin')
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
    @endif

    <!-- Nav Item - Charts -->
    <li class="nav-item @if (\Request::is('about*')) active @endif">
        <a class="nav-link" href="{{ route('admin.about.index') }}">
            <i class="fas fa-fw fa-user"></i>
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
    <li class="nav-item @if (\Request::is('portfolios*')) active @endif">
        <a class="nav-link" href="{{ route('admin.portfolios.index') }}">
            <i class="fa fa-fw fa-book"></i>
            <span>Portfolios</span></a>
    </li>
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
    <!-- Divider -->
    <hr class="sidebar-divider d-none d-md-block">

    <!-- Sidebar Toggler (Sidebar) -->
    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>
</ul>
