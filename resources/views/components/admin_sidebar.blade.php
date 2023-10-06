<!-- Sidebar -->
<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark toggled" id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{ url('/') }}">
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
    @if (auth()->user()->hasRole('admin'))
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

        <li class="nav-item active">
            <a class="nav-link" href="{{ url('/view/registered/bank') }}">
                <i class="fas fa-fw fa-tachometer-alt"></i>
                <span>Registered Banks Approval</span></a>
        </li>

        <hr class="sidebar-divider">

        <li class="nav-item active">
            <a class="nav-link" href="{{ url('/view/customization/requests') }}">
                <i class="fas fa-fw fa-tachometer-alt"></i>
                <span>View Customization Request</span></a>
        </li>

        <hr class="sidebar-divider">

        <li class="nav-item active">
            <a class="nav-link" href="{{ url('/view/bank/request') }}">
                <i class="fas fa-fw fa-tachometer-alt"></i>
                <span>Bank Request</span></a>
        </li>

        <hr class="sidebar-divider">

        <li class="nav-item active">
            <a class="nav-link" href="{{ url('/bank/type') }}">
                <i class="fas fa-fw fa-tachometer-alt"></i>
                <span>Bank Type</span></a>
        </li>

        <hr class="sidebar-divider">

        <li class="nav-item active">
            <a class="nav-link" href="{{ url('/manage/stories') }}">
                <i class="fas fa-fw fa-tachometer-alt"></i>
                <span>Interesting Stories</span></a>
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
        <hr class="sidebar-divider">

        <li class="nav-item active">
            <a class="nav-link" href="{{ url('/manage/charity') }}">
                <i class="fas fa-fw fa-tachometer-alt"></i>
                <span>Manage Charity</span></a>
        </li>
        <hr class="sidebar-divider">

        <li class="nav-item active">
            <a class="nav-link" href="{{ url('/manage/packages') }}">
                <i class="fas fa-fw fa-tachometer-alt"></i>
                <span>Manage Packages</span></a>
        </li>
    @endif


    @if (auth()->user()->hasRole('admin') ||
            auth()->user()->hasRole('data-entry-operator'))
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
                    @if (auth()->user()->hasRole('admin'))
                        <a class="collapse-item" href="{{ url('/manage/banks') }}">Manage Banks</a>
                        <a class="collapse-item" href="{{ url('/manage/rate/types') }}">Manage Rate Types</a>
                    @endif
                    <a class="collapse-item" href="{{ url('/add/bank/rates') }}">Add Bank Rates</a>
                </div>
            </div>
        </li>
    @endif
    @if (auth()->user()->hasRole('data-verification-operator'))
        <hr class="sidebar-divider">
        <li class="nav-item active">
            <a class="nav-link" href="{{ url('/add/bank/rates') }}">
                <i class="fas fa-fw fa-tachometer-alt"></i>
                <span>Check Bank Rates</span></a>
        </li>
    @endif
    @if (auth()->user()->hasRole('bank-admin'))
        <hr class="sidebar-divider">
        <li class="nav-item active">
            <a class="nav-link" href="{{ url('/customer/bank/user') }}">
                <i class="fas fa-fw fa-tachometer-alt"></i>
                <span>Bank Users Management</span></a>
        </li>
        <hr class="sidebar-divider">
        <li class="nav-item active">
            <a class="nav-link" href="{{ url('/customize/packages') }}">
                <i class="fas fa-fw fa-tachometer-alt"></i>
                <span>Customize My Package</span></a>
        </li>
        <hr class="sidebar-divider">
        <li class="nav-item active">
            <a class="nav-link" href="{{ url('/view/bank/request') }}">
                <i class="fas fa-fw fa-tachometer-alt"></i>
                <span>Bank Request</span></a>
        </li>
        {{-- <hr class="sidebar-divider">
        <li class="nav-item active">
            <a class="nav-link" href="{{ url('/view/bank/reports') }}">
                <i class="fas fa-fw fa-tachometer-alt"></i>
                <span>View Bank Reports</span></a>
        </li>
        <hr class="sidebar-divider">
        <li class="nav-item active">
            <a class="nav-link" href="{{ url('/view/detailed/reports') }}">
                <i class="fas fa-fw fa-tachometer-alt"></i>
                <span>View Detailed Reports</span></a>
        </li> --}}
        <hr class="sidebar-divider">
        <li class="nav-item active">
            <a class="nav-link" href="{{ url('/view/special/reports') }}">
                <i class="fas fa-fw fa-tachometer-alt"></i>
                <span>View Special Reports</span></a>
        </li>
        <hr class="sidebar-divider">
        <li class="nav-item active">
            <a class="nav-link" href="{{ url('/view/seperate/reports') }}">
                <i class="fas fa-fw fa-tachometer-alt"></i>
                <span>View Seperate Reports</span></a>
        </li>
        <hr class="sidebar-divider">
        <li class="nav-item active">
            <a class="nav-link" href="{{ url('/view/summary/reports') }}">
                <i class="fas fa-fw fa-tachometer-alt"></i>
                <span>View Summary Reports</span></a>
        </li>
    @endif
</ul>
<!-- End of Sidebar -->
