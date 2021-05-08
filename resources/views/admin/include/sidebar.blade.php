<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.html">
        <div class="sidebar-brand-text mx-3">My Portfolio</div>
    </a>

    <!-- Divider -->
    <hr class="sidebar-divider my-0">

    <!-- Nav Item - Dashboard -->
    <li class="nav-item @if (\Request::is('admin/home*')) active @endif">
        <a class="nav-link" href="{{ route('admin.home.index') }}">
            <i class="fas fa-fw fa-home"></i>
            <span>Home</span></a>
    </li>
    
    <?php $role = strtolower(auth()->user()->role->name); ?>
    @if( $role == 'superadmin')
        <!-- Nav Item - Charts -->
        <li class="nav-item @if (\Request::is('admin/profiles*')) active @endif">
            <a class="nav-link" href="{{ route('admin.profiles.index') }}">
                <i class="fas fa-fw fa-suitcase"></i>
                <span>Profiles</span></a>
        </li>
        <!-- Nav Item - Charts -->
        <li class="nav-item @if (\Request::is('admin/skills*')) active @endif">
            <a class="nav-link" href="{{ route('admin.skills.index') }}">
                <i class="fa fa-fw fa-angle-double-right"></i>
                <span>Skils</span></a>
        </li>
    @endif

    <!-- Nav Item - Charts -->
    <li class="nav-item @if (\Request::is('admin/about*')) active @endif">
        <a class="nav-link" href="{{ route('admin.about.index') }}">
            <i class="fas fa-fw fa-user"></i>
            <span>About me</span></a>
    </li>

    <!-- Nav Item - Tables -->
    <li class="nav-item">
        <a class="nav-link" href="tables.html">
            <i class="fas fa-fw fa-file"></i>
            <span>Resume</span></a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="tables.html">
            <i class="fas fa-fw fa-book"></i>
            <span>Portfolio</span></a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="tables.html">
            <i class="fas fa-fw fa-server"></i>
            <span>Services</span></a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="tables.html">
            <i class="fas fa-fw fa-envelope"></i>
            <span>Contact</span></a>
    </li>
    <!-- Divider -->
    <hr class="sidebar-divider d-none d-md-block">

    <!-- Sidebar Toggler (Sidebar) -->
    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>
</ul>
