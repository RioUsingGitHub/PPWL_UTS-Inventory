<aside class="sidenav bg-white navbar navbar-vertical navbar-expand-xs border-0 border-radius-xl my-3 fixed-start ms-4" id="sidenav-main">
    <div class="sidenav-header">
        <i class="fas fa-times p-3 cursor-pointer text-secondary opacity-5 position-absolute end-0 top-0 d-none d-xl-none" aria-hidden="true" id="iconSidenav"></i>
        <a class="navbar-brand m-0" href="{{ route('home') }}">
            <img src="{{ asset('img/logo-ct-dark.png') }}" class="navbar-brand-img h-100" alt="main_logo">
            <span class="ms-1 font-weight-bold">Inventory System</span>
        </a>
    </div>
    <hr class="horizontal dark mt-0">
    <div class="collapse navbar-collapse w-auto" id="sidenav-collapse-main">
        <ul class="navbar-nav">
            <!-- Dashboard -->
            <li class="nav-item">
                <a class="nav-link {{ Route::currentRouteName() == 'home' ? 'active' : '' }}" href="{{ route('home') }}">
                    <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="fa-solid fa-house text-primary text-sm opacity-10"></i>
                    </div>
                    <span class="nav-link-text ms-1">Dashboard</span>
                </a>
            </li>

            <!-- Profile -->
            <li class="nav-item">
                <a class="nav-link {{ Route::currentRouteName() == 'profile.show' ? 'active' : '' }}" href="{{ route('profile.show') }}">
                    <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="fa-solid fa-user text-dark text-sm opacity-10"></i>
                    </div>
                    <span class="nav-link-text ms-1">Profile</span>
                </a>
            </li>

            @canany(['view-users', 'view-roles'])
            <!-- Administration Section -->
            <li class="nav-item mt-3">
                <h6 class="ps-4 ms-2 text-uppercase text-xs font-weight-bolder opacity-6">Administration</h6>
            </li>

            @can('view-roles')
            <!-- Role Management -->
            <li class="nav-item">
                <a class="nav-link {{ Route::currentRouteName() == 'roles.index' ? 'active' : '' }}" href="{{ route('roles.index') }}">
                    <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="fa-solid fa-user-tie text-dark text-sm opacity-10"></i>
                    </div>
                    <span class="nav-link-text ms-1">Role Management</span>
                </a>
            </li>
            @endcan

            @can('view-users')
            <!-- User Management -->
            <li class="nav-item">
                <a class="nav-link {{ Route::currentRouteName() == 'users.index' ? 'active' : '' }}" href="{{ route('users.index') }}">
                    <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="fa fa-users text-dark text-sm opacity-10"></i>
                    </div>
                    <span class="nav-link-text ms-1">User Management</span>
                </a>
            </li>
            @endcan
            @endcanany

            @canany(['view-items', 'view-inventory', 'view-transactions'])
            <!-- Inventory Management Section -->
            <li class="nav-item mt-3">
                <h6 class="ps-4 ms-2 text-uppercase text-xs font-weight-bolder opacity-6">Inventory Management</h6>
            </li>

            @can('view-items')
            <!-- Items Management -->
            <li class="nav-item">
                <a class="nav-link {{ Route::currentRouteName() == 'items.index' ? 'active' : '' }}" href="{{ route('items.index') }}">
                    <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="fa-solid fa-cube text-dark text-sm opacity-10"></i>
                    </div>
                    <span class="nav-link-text ms-1">Items Management</span>
                </a>
            </li>
            @endcan

            @can('view-inventory')
            <!-- Inventory Management -->
            <li class="nav-item">
                <a class="nav-link {{ Route::currentRouteName() == 'inventory.index' ? 'active' : '' }}" href="{{ route('inventory.index') }}">
                    <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="fa-solid fa-warehouse text-dark text-sm opacity-10"></i>
                    </div>
                    <span class="nav-link-text ms-1">Inventory Management</span>
                </a>
            </li>
            @endcan

            @can('view-transactions')
            <!-- Transactions Management -->
            <li class="nav-item">
                <a class="nav-link {{ Route::currentRouteName() == 'transactions.index' ? 'active' : '' }}" href="{{ route('transactions.index') }}">
                    <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="fa-solid fa-handshake text-dark text-sm opacity-10"></i>
                    </div>
                    <span class="nav-link-text ms-1">Transactions</span>
                </a>
            </li>
            @endcan
            @endcanany
        </ul>
    </div>
</aside>