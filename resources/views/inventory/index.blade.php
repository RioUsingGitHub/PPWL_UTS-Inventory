@extends('layouts.app', ['class' => 'g-sidenav-show bg-gray-100'])

@section('content')
    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-xl-3 col-sm-6 mb-4">
                <div class="card">
                    <div class="card-body p-3">
                        <div class="row">
                            <div class="col-8">
                                <div class="numbers">
                                    <p class="text-sm mb-0 text-uppercase font-weight-bold">Total Items</p>
                                    <h5 class="font-weight-bolder mb-0">
                                        {{ $totalItems }}
                                    </h5>
                                </div>
                            </div>
                            <div class="col-4 text-end">
                                <div class="icon icon-shape bg-gradient-primary shadow text-center border-radius-md">
                                    <i class="fa-solid fa-cube text-lg opacity-10" aria-hidden="true"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-sm-6 mb-4">
                <div class="card">
                    <div class="card-body p-3">
                        <div class="row">
                            <div class="col-8">
                                <div class="numbers">
                                    <p class="text-sm mb-0 text-uppercase font-weight-bold">Total Stock Value</p>
                                    <h5 class="font-weight-bolder mb-0">
                                        ${{ number_format($totalValue, 2) }}
                                    </h5>
                                </div>
                            </div>
                            <div class="col-4 text-end">
                                <div class="icon icon-shape bg-gradient-success shadow text-center border-radius-md">
                                    <i class="fa-solid fa-receipt text-lg opacity-10" aria-hidden="true"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-sm-6 mb-4">
                <div class="card">
                    <div class="card-body p-3">
                        <div class="row">
                            <div class="col-8">
                                <div class="numbers">
                                    <p class="text-sm mb-0 text-uppercase font-weight-bold">Low Stock Items</p>
                                    <h5 class="font-weight-bolder mb-0">
                                        {{ $lowStockCount }}
                                    </h5>
                                </div>
                            </div>
                            <div class="col-4 text-end">
                                <div class="icon icon-shape bg-gradient-warning shadow text-center border-radius-md">
                                    <i class="fa-solid fa-arrow-trend-down text-lg opacity-10" aria-hidden="true"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-sm-6 mb-4">
                <div class="card">
                    <div class="card-body p-3">
                        <div class="row">
                            <div class="col-8">
                                <div class="numbers">
                                    <p class="text-sm mb-0 text-uppercase font-weight-bold">Locations</p>
                                    <h5 class="font-weight-bolder mb-0">
                                        {{ $locationCount }}
                                    </h5>
                                </div>
                            </div>
                            <div class="col-4 text-end">
                                <div class="icon icon-shape bg-gradient-info shadow text-center border-radius-md">
                                    <i class="fa-solid fa-location-dot text-lg opacity-10" aria-hidden="true"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <div class="card mb-4">
                    <div class="card-header pb-0">
                        <div class="d-flex justify-content-between align-items-center">
                            <h6>Inventory</h6>
                            <div>
                                <a href="{{ route('inventory.export') }}" class="btn btn-success btn-sm me-2">Export</a>
                                @can('create-transactions')
                                    <button type="button" class="btn btn-info btn-sm me-2" data-bs-toggle="modal" data-bs-target="#importModal">
                                        Import
                                    </button>
                                @endcan
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <input type="text" class="form-control" id="search" placeholder="Search items...">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <select class="form-control" id="location-filter">
                                        <option value="">All Locations</option>
                                        @foreach($locations as $location)
                                            <option value="{{ $location }}">{{ $location }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <select class="form-control" id="stock-filter">
                                        <option value="">All Stock Levels</option>
                                        <option value="low">Low Stock</option>
                                        <option value="out">Out of Stock</option>
                                        <option value="normal">Normal Stock</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <button class="btn btn-secondary btn-sm" id="reset-filters">Reset Filters</button>
                            </div>
                        </div>
                    </div>
                    <div class="card-body px-0 pt-0 pb-2">
                        <div class="table-responsive p-0">
                            <table class="table align-items-center mb-0">
                                <thead>
                                    <tr>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Item</th>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">On Hand</th>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Off Hand</th>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Location</th>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Value</th>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Status</th>
                                        <th class="text-secondary opacity-7"></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($inventory as $inv)
                                        <tr>
                                            <td>
                                                <div class="d-flex px-2 py-1">
                                                    <div class="d-flex flex-column justify-content-center">
                                                        <h6 class="mb-0 text-sm">{{ $inv->item->name }}</h6>
                                                        <p class="text-xs text-secondary mb-0">{{ $inv->item->sku }}</p>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <p class="text-xs font-weight-bold mb-0">{{ $inv->on_hand_quantity }}</p>
                                            </td>
                                            <td>
                                                <p class="text-xs font-weight-bold mb-0">{{ $inv->off_hand_quantity }}</p>
                                            </td>
                                            <td>
                                                <p class="text-xs font-weight-bold mb-0">{{ $inv->location }}</p>
                                            </td>
                                            <td>
                                                <p class="text-xs font-weight-bold mb-0">${{ number_format($inv->on_hand_quantity * $inv->item->unit_price, 2) }}</p>
                                            </td>
                                            <td>
                                                @php
                                                    $status = 'normal';
                                                    $statusClass = 'success';
                                                    if ($inv->on_hand_quantity <= 0) {
                                                        $status = 'out of stock';
                                                        $statusClass = 'danger';
                                                    } elseif ($inv->on_hand_quantity <= $inv->reorder_point) {
                                                        $status = 'low stock';
                                                        $statusClass = 'warning';
                                                    }
                                                @endphp
                                                <span class="badge badge-sm bg-gradient-{{ $statusClass }}">
                                                    {{ ucfirst($status) }}
                                                </span>
                                            </td>
                                            <td class="align-middle">
                                                <a href="{{ route('inventory.show', $inv->id) }}" class="text-secondary font-weight-bold text-xs me-2">
                                                    View
                                                </a>
                                                @can('edit-inventory', $inv)
                                                    <a href="{{ route('inventory.edit', $inv->id) }}" class="text-info font-weight-bold text-xs me-2">
                                                        Edit
                                                    </a>
                                                @endcan
                                                @can('delete-inventory', $inv)
                                                    <a href="{{ route('inventory.destroy', $inv->id) }}" class="text-danger font-weight-bold text-xs">
                                                        Delete
                                                    </a>
                                                @endcan
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="px-4 pt-4">
                            {{ $inventory->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Import Modal -->
    <div class="modal fade" id="importModal" tabindex="-1" aria-labelledby="importModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="importModalLabel">Import Inventory</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('inventory.import') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="csvFile" class="form-label">CSV File</label>
                            <input type="file" class="form-control" id="csvFile" name="csv_file" accept=".csv" required>
                            <div class="form-text">
                                Please upload a CSV file with columns: item_id, quantity, location
                            </div>
                            <div class="mt-2">
                                <a href="{{ route('inventory.template') }}" class="btn btn-info btn-sm">
                                    <i class="fas fa-download me-1"></i> Download Template
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Import</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const searchInput = document.getElementById('search');
        const locationFilter = document.getElementById('location-filter');
        const stockFilter = document.getElementById('stock-filter');
        const resetButton = document.getElementById('reset-filters');
        
        function applyFilters() {
            const searchParams = new URLSearchParams(window.location.search);
            
            if (searchInput.value) searchParams.set('search', searchInput.value);
            if (locationFilter.value) searchParams.set('location', locationFilter.value);
            if (stockFilter.value) searchParams.set('stock', stockFilter.value);
            
            window.location.search = searchParams.toString();
        }
        
        searchInput.addEventListener('keyup', function(e) {
            if (e.key === 'Enter') applyFilters();
        });
        
        locationFilter.addEventListener('change', applyFilters);
        stockFilter.addEventListener('change', applyFilters);
        
        resetButton.addEventListener('click', function() {
            window.location.href = window.location.pathname;
        });
        
        // Set initial values from URL params
        const urlParams = new URLSearchParams(window.location.search);
        if (urlParams.has('search')) searchInput.value = urlParams.get('search');
        if (urlParams.has('location')) locationFilter.value = urlParams.get('location');
        if (urlParams.has('stock')) stockFilter.value = urlParams.get('stock');
    });
</script>
@endpush