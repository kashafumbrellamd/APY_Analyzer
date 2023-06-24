<!-- Sidebar -->
<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.html">
        <div class="sidebar-brand-icon rotate-n-15">
            <i class="fas fa-laugh-wink"></i>
        </div>
        <div class="sidebar-brand-text mx-3">SB Admin <sup>2</sup></div>
    </a>

    <hr class="sidebar-divider">
    <!-- Nav Item - Dashboard -->
    <li class="nav-item active">
        <a class="nav-link" href="{{ route('home') }}">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Dashboard</span></a>
    </li>

    <!-- Divider -->
    @if(auth()->user()->hasRole('admin'))
    <hr class="sidebar-divider">
    <li class="nav-item active">
        <a class="nav-link" href="{{ url('/role') }}">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Roles</span></a>
    </li>

    <hr class="sidebar-divider">

    <li class="nav-item active">
        <a class="nav-link" href="{{ url('/role/permissions') }}">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Role Permissions</span></a>
    </li>

    <hr class="sidebar-divider">

    <!-- Nav Item - Pages Collapse Menu -->
    <li class="nav-item active">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseThree"
            aria-expanded="true" aria-controls="collapseThree">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Users Management</span>
        </a>
        <div id="collapseThree" class="collapse" aria-labelledby="headingThree" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">User Management:</h6>
                <a class="collapse-item" href="{{ url('/add/users') }}">Add Users</a>
                <a class="collapse-item" href="{{ url('/manage/users') }}">Manage Users</a>
            </div>
        </div>
    </li>
    @endif


    @if(auth()->user()->hasRole('admin'))
    <hr class="sidebar-divider">
    <li class="nav-item active">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseFour"
            aria-expanded="true" aria-controls="collapseFour">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Customer Bank</span>
        </a>
        <div id="collapseFour" class="collapse" aria-labelledby="headingFour" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <small class="collapse-header">Customer Bank :</small>
                <a class="collapse-item" href="{{ url('/add/customer/bank') }}">Manage Customer Bank</a>
                <a class="collapse-item" href="{{ url('/view/customer/bank/admin') }}">Bank Admin</a>
            </div>
        </div>
    </li>
    @endif


    @if(auth()->user()->hasRole('admin') || auth()->user()->hasRole('data-entry-operator'))
    <hr class="sidebar-divider">
    <li class="nav-item active">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseFive"
            aria-expanded="true" aria-controls="collapseFive">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Data Management</span>
        </a>
        <div id="collapseFive" class="collapse" aria-labelledby="headingFive" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">Data Management:</h6>
                @if(auth()->user()->hasRole('admin'))
                    <a class="collapse-item" href="{{ url('/manage/banks') }}">Manage Banks</a>
                    <a class="collapse-item" href="{{ url('/manage/rate/types') }}">Manage Rate Types</a>
                @endif
                <a class="collapse-item" href="{{ url('/add/bank/rates') }}">Add Bank Rates</a>
            </div>
        </div>
    </li>
    @endif
    @if(auth()->user()->hasRole('data-verification-operator'))
    <li class="nav-item active">
        <a class="nav-link" href="{{ url('/add/bank/rates') }}">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Check Bank Rates</span></a>
    </li>
    @endif
    @if(auth()->user()->hasRole('bank-admin'))
    <li class="nav-item active">
        <a class="nav-link" href="{{ url('/customer/bank/user') }}">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Bank Users Management</span></a>
    </li>
    <li class="nav-item active">
        <a class="nav-link" href="{{ url('/view/bank/reports') }}">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>View Bank Reports</span></a>
    </li>
    @endif
</ul>
<!-- End of Sidebar -->
