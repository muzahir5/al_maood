<!-- Sidebar -->
<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

<!-- Sidebar - Brand -->
<a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{url('admin/dashboard')}}">
    <div class="sidebar-brand-icon rotate-n-15">
        <i class="fas fa-laugh-wink"></i>
    </div>
    <div class="sidebar-brand-text mx-3">A M<sup>5</sup></div>
</a>

<!-- Divider -->
<hr class="sidebar-divider my-0">

<!-- Nav Item - Dashboard -->
<li class="nav-item active">
    <a class="nav-link" href="{{url('admin/dashboard')}}">
        <i class="fas fa-fw fa-tachometer-alt"></i>
        <span>Dashboard</span></a>
</li>

@if(Auth::guard('admin')->check())
    <!-- Divider -->
    <hr class="sidebar-divider">

    <!-- Heading -->
    <div class="sidebar-heading">
        Links
    </div>

    <!-- Nav Item - Pages Collapse Menu -->
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo"
            aria-expanded="true" aria-controls="collapseTwo">
            <i class="fas fa-fw fa-cog"></i>
            <span>Audio & Videos</span>
        </a>
        <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">Pages Links</h6>
                <?php if(! auth()->check() ){ ?>
                <a class="collapse-item" href="{{ url('admin/register') }}">Register</a>
                <?php }?>
                <?php if( auth()->check() ){ ?>
                <!-- <a class="collapse-item" href="{{ url('/admin/product')}}">Products</a> -->
                <a class="collapse-item" href="{{ url('/admin/audio')}}">Audios</a>
                <a class="collapse-item" href="{{ url('/admin/video')}}">Videos</a>
                <a class="collapse-item" href="{{ url('admin/users') }}">Users</a>
                <?php }else{ ?>
                <a href="{{ url('admin/login') }}">Login</a>
                <?php }?>
            </div>
        </div>
    </li>
    <!-- Nav Item - Utilities Collapse Menu -->
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseNarrators"
            aria-expanded="true" aria-controls="collapseNarrators">
            <i class="fas fa-fw fa-list"></i>
            <span>Sources</span>
        </a>
        <div id="collapseNarrators" class="collapse" aria-labelledby="headingUtilities"
            data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">collapseNarrators:</h6>
                <a class="collapse-item" href="{{ url('admin/narrators') }}">Narrators</a>
                <a class="collapse-item" href="{{ url('admin/categories') }}">Categories</a>
                <a class="collapse-item" href="{{ url('admin/languages') }}">Languages</a>
                <a class="collapse-item" href="{{ url('admin/locations') }}">Locations</a>
            </div>
        </div>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider">

    <!-- Heading -->
    <div class="sidebar-heading">
        Addons
    </div>

    <!-- Nav Item - Pages Collapse Menu -->
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapsePages"
            aria-expanded="true" aria-controls="collapsePages">
            <i class="fas fa-fw fa-folder"></i>
            <span>Pages</span>
        </a>
        <div id="collapsePages" class="collapse" aria-labelledby="headingPages" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">Login Screens:</h6>
                <a class="collapse-item" href="login.html">Login</a>
                <div class="collapse-divider"></div>
                <h6 class="collapse-header">Other Pages:</h6>
                <a class="collapse-item" href="404.html">404 Page</a>
            </div>
        </div>
    </li>
    
    <!-- Nav Item - Tables -->
    <li class="nav-item">
        <a class="nav-link" href="{{ url('admin/logout') }}">
            <i class="fas fa-fw fa-sign-out-alt"></i>
            <span>Logout</span></a>
    </li>

@endif



<!-- Divider -->
<hr class="sidebar-divider d-none d-md-block">

<!-- Sidebar Toggler (Sidebar) -->
<div class="text-center d-none d-md-inline">
    <button class="rounded-circle border-0" id="sidebarToggle"></button>
</div>

</ul>
<!-- End of Sidebar -->