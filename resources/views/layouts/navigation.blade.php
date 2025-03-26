<nav class="sidenav navbar navbar-vertical navbar-expand-xs border-0 border-radius-xl my-3 fixed-start ms-3 bg-gradient-dark" id="sidenav-main">
    <div class="sidenav-header">
        <i class="fas fa-times p-3 cursor-pointer text-white opacity-5 position-absolute end-0 top-0 d-none d-xl-none" aria-hidden="true" id="iconSidenav"></i>
        <a class="navbar-brand m-0" href="{{ route('dashboard') }}">
            <span class="ms-1 font-weight-bold text-white">Inventory System</span>
        </a>
    </div>
    <hr class="horizontal light mt-0 mb-2">
    <div class="collapse navbar-collapse w-auto max-height-vh-100" id="sidenav-collapse-main">
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link text-white {{ request()->routeIs('dashboard') ? 'active bg-gradient-primary' : '' }}" href="{{ route('dashboard') }}">
                    <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="material-icons opacity-10">dashboard</i>
                    </div>
                    <span class="nav-link-text ms-1">Dashboard</span>
                </a>
            </li>

            @canany(['view-users', 'view-roles'])
            <li class="nav-item mt-3">
                <h6 class="ps-4 ms-2 text-uppercase text-xs text-white font-weight-bolder opacity-8">Administration</h6>
            </li>
            @endcanany

            @can('view-users')
            <li class="nav-item">
                <a class="nav-link text-white {{ request()->routeIs('users.*') ? 'active bg-gradient-primary' : '' }}" href="{{ route('users.index') }}">
                    <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="material-icons opacity-10">people</i>
                    </div>
                    <span class="nav-link-text ms-1">Users</span>
                </a>
            </li>
            @endcan

            @can('view-roles')
            <li class="nav-item">
                <a class="nav-link text-white {{ request()->routeIs('roles.*') ? 'active bg-gradient-primary' : '' }}" href="{{ route('roles.index') }}">
                    <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="material-icons opacity-10">security</i>
                    </div>
                    <span class="nav-link-text ms-1">Roles</span>
                </a>
            </li>
            @endcan

            @canany(['view-items', 'view-inventory', 'view-transactions'])
            <li class="nav-item mt-3">
                <h6 class="ps-4 ms-2 text-uppercase text-xs text-white font-weight-bolder opacity-8">Inventory Management</h6>
            </li>
            @endcanany

            @can('view-items')
            <li class="nav-item">
                <a class="nav-link text-white {{ request()->routeIs('items.*') ? 'active bg-gradient-primary' : '' }}" href="{{ route('items.index') }}">
                    <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="material-icons opacity-10">inventory_2</i>
                    </div>
                    <span class="nav-link-text ms-1">Items</span>
                </a>
            </li>
            @endcan

            @can('view-inventory')
            <li class="nav-item">
                <a class="nav-link text-white {{ request()->routeIs('inventory.*') ? 'active bg-gradient-primary' : '' }}" href="{{ route('inventory.index') }}">
                    <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="material-icons opacity-10">warehouse</i>
                    </div>
                    <span class="nav-link-text ms-1">Inventory</span>
                </a>
            </li>
            @endcan

            @can('view-transactions')
            <li class="nav-item">
                <a class="nav-link text-white {{ request()->routeIs('transactions.*') ? 'active bg-gradient-primary' : '' }}" href="{{ route('transactions.index') }}">
                    <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="material-icons opacity-10">swap_horiz</i>
                    </div>
                    <span class="nav-link-text ms-1">Transactions</span>
                </a>
            </li>
            @endcan
        </ul>
    </div>
    <div class="sidenav-footer position-absolute w-100 bottom-0">
        <div class="mx-3">
            <a class="btn bg-gradient-primary mt-4 w-100" href="{{ route('users.profile') }}">
                <i class="material-icons opacity-10">person</i>
                <span class="ms-1">My Profile</span>
            </a>
        </div>
    </div>
</nav> 