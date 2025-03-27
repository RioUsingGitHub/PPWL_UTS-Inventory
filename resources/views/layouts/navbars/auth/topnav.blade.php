<!-- Navbar -->
<nav class="navbar navbar-main navbar-expand-lg px-0 mx-4 shadow-none border-radius-xl
        {{ str_contains(Request::url(), 'virtual-reality') == true ? ' mt-3 mx-3 bg-primary' : '' }}" id="navbarBlur"
        data-scroll="false">
    <div class="container-fluid py-1 px-3">
        @php
            $routeName = Route::currentRouteName();
            $title = match($routeName) {
                'home' => 'Dashboard',
                'profile' => 'Profile',
                'users.index' => 'User Management',
                'users.create' => 'User Create',
                'roles.index' => 'Role Management',
                'items.index' => 'Items Management',
                'items.create' => 'Item Create',
                'inventory.index' => 'Inventory Management',
                'transactions.index' => 'Transactions',
                default => 'Dashboard'
            };
        @endphp
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb bg-transparent mb-0 pb-0 pt-1 px-0 me-sm-6 me-5">
                <li class="breadcrumb-item text-sm"><a class="opacity-5 text-black" href="javascript:;">Pages</a></li>
                <li class="breadcrumb-item text-sm text-black active" aria-current="page">{{ $title }}</li>
            </ol>
            <h6 class="font-weight-bolder text-black mb-0">{{ $title }}</h6>
        </nav>
        <div class="collapse navbar-collapse mt-sm-0 mt-2 me-md-0 me-sm-4" id="navbar">
            <div class="ms-md-auto pe-md-3 d-flex align-items-center">
                <div class="nav-item dropdown">
                    <a href="javascript:;" class="nav-link text-black p-0" id="navbarDropdownQuickAccess"
                        data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="fas fa-th-large me-sm-1"></i>
                        <span class="d-sm-inline d-none">Quick Access</span>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end p-2 me-sm-n4" aria-labelledby="navbarDropdownQuickAccess">
                        @can('view-items')
                        <li class="mb-2">
                            <a class="dropdown-item border-radius-md" href="{{ route('items.index') }}">
                                <div class="d-flex align-items-center py-1">
                                    <div class="icon icon-shape icon-sm bg-gradient-primary shadow text-center me-2">
                                        <i class="fas fa-box fa-fw text-white"></i>
                                    </div>
                                    <div class="d-flex flex-column justify-content-center">
                                        <h6 class="text-sm font-weight-normal mb-1">Items</h6>
                                        <p class="text-xs text-secondary mb-0">View all items in inventory</p>
                                    </div>
                                </div>
                            </a>
                        </li>
                        @endcan
                        @can('view-inventory')
                        <li class="mb-2">
                            <a class="dropdown-item border-radius-md" href="{{ route('inventory.index') }}">
                                <div class="d-flex align-items-center py-1">
                                    <div class="icon icon-shape icon-sm bg-gradient-success shadow text-center me-2">
                                        <i class="fas fa-warehouse fa-fw text-white"></i>
                                    </div>
                                    <div class="d-flex flex-column justify-content-center">
                                        <h6 class="text-sm font-weight-normal mb-1">Inventory</h6>
                                        <p class="text-xs text-secondary mb-0">Manage stock and locations</p>
                                    </div>
                                </div>
                            </a>
                        </li>
                        @endcan
                        @can('view-transactions')
                        <li class="mb-2">
                            <a class="dropdown-item border-radius-md" href="{{ route('transactions.index') }}">
                                <div class="d-flex align-items-center py-1">
                                    <div class="icon icon-shape icon-sm bg-gradient-warning shadow text-center me-2">
                                        <i class="fas fa-exchange-alt fa-fw text-white"></i>
                                    </div>
                                    <div class="d-flex flex-column justify-content-center">
                                        <h6 class="text-sm font-weight-normal mb-1">Transactions</h6>
                                        <p class="text-xs text-secondary mb-0">View recent transactions</p>
                                    </div>
                                </div>
                            </a>
                        </li>
                        @endcan
                        @can('view-users')
                        <li class="mb-2">
                            <a class="dropdown-item border-radius-md" href="{{ route('users.index') }}">
                                <div class="d-flex align-items-center py-1">
                                    <div class="icon icon-shape icon-sm bg-gradient-info shadow text-center me-2">
                                        <i class="fas fa-users fa-fw text-white"></i>
                                    </div>
                                    <div class="d-flex flex-column justify-content-center">
                                        <h6 class="text-sm font-weight-normal mb-1">Users</h6>
                                        <p class="text-xs text-secondary mb-0">Manage system users</p>
                                    </div>
                                </div>
                            </a>
                        </li>
                        @endcan
                    </ul>
                </div>
            </div>
            <ul class="navbar-nav justify-content-end">
                <li class="nav-item d-flex align-items-center">
                    <a href="{{ route('profile.show') }}" class="nav-link text-black font-weight-bold px-0">
                        <i class="fa fa-user me-sm-1"></i>
                        <span class="d-sm-inline d-none">Profile</span>
                    </a>
                </li>
                <li class="nav-item px-3 d-flex align-items-center">
                    <div class="nav-item dropdown">
                        <a href="javascript:;" class="nav-link text-black p-0" id="dropdownSettings"
                            data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="fa fa-cog fixed-plugin-button-nav cursor-pointer"></i>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end px-2 py-3 me-sm-n4" aria-labelledby="dropdownSettings">
                            <li class="mb-2">
                                <a class="dropdown-item border-radius-md" href="{{ route('profile.show') }}">
                                    <div class="d-flex py-1">
                                        <div class="icon icon-shape icon-sm bg-gradient-secondary shadow text-center me-2">
                                            <i class="fas fa-user-cog fa-fw text-white"></i>
                                        </div>
                                        <div class="d-flex flex-column justify-content-center">
                                            <h6 class="text-sm font-weight-normal mb-1">Account Settings</h6>
                                            <p class="text-xs text-secondary mb-0">Update your profile and preferences</p>
                                        </div>
                                    </div>
                                </a>                                                               
                            </li>
                            <li>
                                <form method="POST" action="{{ route('logout') }}" id="logout-form">
                                    @csrf
                                    <a class="dropdown-item border-radius-md" href="{{ route('logout') }}"
                                        onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                        <div class="d-flex py-1">
                                            <div class="icon icon-shape icon-sm bg-gradient-danger shadow text-center me-2">
                                                <i class="fas fa-sign-out-alt fa-fw text-white"></i>
                                            </div>
                                            <div class="d-flex flex-column justify-content-center">
                                                <h6 class="text-sm font-weight-normal mb-1">Logout</h6>
                                                <p class="text-xs text-secondary mb-0">Sign out of your account</p>
                                            </div>
                                        </div>
                                    </a>
                                </form>
                            </li>
                        </ul>
                    </div>
                </li>
                <li class="nav-item dropdown pe-2 d-flex align-items-center">
                    <a href="javascript:;" class="nav-link text-black p-0" id="dropdownMenuButton"
                        data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="fa fa-bell cursor-pointer"></i>
                        <span class="badge badge-md badge-circle badge-floating badge-danger border-white">3</span>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end px-2 py-3 me-sm-n4" aria-labelledby="dropdownMenuButton">
                        <li class="mb-2">
                            <a class="dropdown-item border-radius-md" href="javascript:;">
                                <div class="d-flex py-1">
                                    <div class="icon icon-shape icon-sm bg-gradient-warning shadow text-center me-2">
                                        <i class="fas fa-exclamation-triangle fa-fw text-white"></i>
                                    </div>
                                    <div class="d-flex flex-column justify-content-center">
                                        <h6 class="text-sm font-weight-normal mb-1">Low Stock Alert</h6>
                                        <p class="text-xs text-secondary mb-0">
                                            <i class="fa fa-clock me-1"></i>
                                            5 items are running low on stock
                                        </p>
                                    </div>
                                </div>
                            </a>
                        </li>
                        <li class="mb-2">
                            <a class="dropdown-item border-radius-md" href="javascript:;">
                                <div class="d-flex py-1">
                                    <div class="icon icon-shape icon-sm bg-gradient-success shadow text-center me-2">
                                        <i class="fas fa-check fa-fw text-white"></i>
                                    </div>
                                    <div class="d-flex flex-column justify-content-center">
                                        <h6 class="text-sm font-weight-normal mb-1">Inventory Updated</h6>
                                        <p class="text-xs text-secondary mb-0">
                                            <i class="fa fa-clock me-1"></i>
                                            13 minutes ago
                                        </p>
                                    </div>
                                </div>
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item border-radius-md" href="javascript:;">
                                <div class="d-flex py-1">
                                    <div class="icon icon-shape icon-sm bg-gradient-info shadow text-center me-2">
                                        <i class="fas fa-user-plus fa-fw text-white"></i>
                                    </div>
                                    <div class="d-flex flex-column justify-content-center">
                                        <h6 class="text-sm font-weight-normal mb-1">New User Added</h6>
                                        <p class="text-xs text-secondary mb-0">
                                            <i class="fa fa-clock me-1"></i>
                                            1 day ago
                                        </p>
                                    </div>
                                </div>
                            </a>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</nav>
<!-- End Navbar -->

@push('styles')
<style>
.badge-floating {
    position: absolute;
    top: 0;
    right: 0;
    transform: translate(25%, -25%);
}

.icon-shape {
    width: 32px;
    height: 32px;
    display: inline-flex;
    align-items: center;
    justify-content: center;
}

.dropdown-menu {
    min-width: 16rem;
    box-shadow: 0 8px 26px -4px rgb(20 20 20 / 15%), 0 8px 9px -5px rgb(20 20 20 / 6%);
}

.dropdown-item:hover {
    background-color: #f6f9fc;
}

.dropdown-item:active {
    background-color: #5e72e4;
}

.nav-link {
    font-weight: 500;
}

.nav-link:hover {
    color: rgba(255, 255, 255, 0.8) !important;
}
</style>
@endpush

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.getElementById('globalSearch');
    const searchResults = document.getElementById('searchResults');
    let searchTimeout;

    searchInput.addEventListener('focus', function() {
        if (searchResults.children.length > 0) {
            searchResults.style.display = 'block';
        }
    });

    document.addEventListener('click', function(e) {
        if (!searchInput.contains(e.target) && !searchResults.contains(e.target)) {
            searchResults.style.display = 'none';
        }
    });

    searchInput.addEventListener('input', function() {
        clearTimeout(searchTimeout);
        const query = this.value.trim();
        
        if (query.length < 2) {
            searchResults.style.display = 'none';
            return;
        }

        searchTimeout = setTimeout(() => {
            fetch(`{{ route('search') }}?query=${encodeURIComponent(query)}`)
                .then(response => response.json())
                .then(data => {
                    searchResults.innerHTML = '';
                    
                    if (data.length === 0) {
                        searchResults.innerHTML = '<div class="search-result">No results found</div>';
                        searchResults.style.display = 'block';
                        return;
                    }

                    data.forEach(result => {
                        const div = document.createElement('div');
                        div.className = 'search-result';
                        div.innerHTML = `
                            <div class="search-result-title">
                                <span class="search-result-type">${result.type}</span>
                                ${result.title}
                            </div>
                            <div class="search-result-subtitle">${result.subtitle}</div>
                        `;
                        div.addEventListener('click', () => {
                            window.location.href = result.url;
                        });
                        searchResults.appendChild(div);
                    });

                    searchResults.style.display = 'block';
                })
                .catch(error => {
                    console.error('Error:', error);
                });
        }, 300);
    });
});
</script>
@endpush
