@extends('layouts.app')

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
                                    <p class="text-sm mb-0 text-uppercase font-weight-bold">Categories</p>
                                    <h5 class="font-weight-bolder mb-0">
                                        {{ $categoryCount }}
                                    </h5>
                                </div>
                            </div>
                            <div class="col-4 text-end">
                                <div class="icon icon-shape bg-gradient-success shadow text-center border-radius-md">
                                    <i class="fa-solid fa-list text-lg opacity-10" aria-hidden="true"></i>
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
                                    <p class="text-sm mb-0 text-uppercase font-weight-bold">Average Price</p>
                                    <h5 class="font-weight-bolder mb-0">
                                        ${{ number_format($averagePrice, 2) }}
                                    </h5>
                                </div>
                            </div>
                            <div class="col-4 text-end">
                                <div class="icon icon-shape bg-gradient-warning shadow text-center border-radius-md">
                                    <i class="fa-solid fa-coins text-lg opacity-10" aria-hidden="true"></i>
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
                                    <p class="text-sm mb-0 text-uppercase font-weight-bold">Total Value</p>
                                    <h5 class="font-weight-bolder mb-0">
                                        ${{ number_format($totalValue, 2) }}
                                    </h5>
                                </div>
                            </div>
                            <div class="col-4 text-end">
                                <div class="icon icon-shape bg-gradient-info shadow text-center border-radius-md">
                                    <i class="fa-solid fa-receipt text-lg opacity-10" aria-hidden="true"></i>
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
                            <h6>Items</h6>
                            <div>
                                <a href="{{ route('items.export') }}" class="btn btn-success btn-sm me-2">Export</a>
                                @can('create-items')
                                    <a href="{{ route('items.create') }}" class="btn btn-primary btn-sm">Add Item</a>
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
                                    <select class="form-control" id="category-filter">
                                        <option value="">All Categories</option>
                                        @foreach($categories as $category)
                                            <option value="{{ $category }}">{{ $category }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <select class="form-control" id="price-filter">
                                        <option value="">All Prices</option>
                                        <option value="0-10">$0 - $10</option>
                                        <option value="10-50">$10 - $50</option>
                                        <option value="50-100">$50 - $100</option>
                                        <option value="100+">$100+</option>
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
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Name</th>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">SKU</th>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Category</th>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Unit Price</th>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Stock</th>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Status</th>
                                        <th class="text-secondary opacity-7"></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($items as $item)
                                        <tr>
                                            <td>
                                                <div class="d-flex px-2 py-1">
                                                    <div class="d-flex flex-column justify-content-center">
                                                        <h6 class="mb-0 text-sm">{{ $item->name }}</h6>
                                                        <p class="text-xs text-secondary mb-0">{{ Str::limit($item->description, 50) }}</p>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <p class="text-xs font-weight-bold mb-0">{{ $item->sku }}</p>
                                            </td>
                                            <td>
                                                <span class="badge badge-sm bg-gradient-info">{{ $item->category }}</span>
                                            </td>
                                            <td>
                                                <p class="text-xs font-weight-bold mb-0">${{ number_format($item->unit_price, 2) }}</p>
                                                <p class="text-xs text-secondary mb-0">{{ $item->unit_weight }}kg</p>
                                            </td>
                                            <td>
                                                <p class="text-xs font-weight-bold mb-0">{{ $item->inventory->on_hand_quantity ?? 0 }}</p>
                                                <p class="text-xs text-secondary mb-0">On Hand</p>
                                            </td>
                                            <td>
                                                @php
                                                    $status = 'Active';
                                                    $statusClass = 'success';
                                                    if (!isset($item->inventory) || $item->inventory->on_hand_quantity <= 0) {
                                                        $status = 'Out of Stock';
                                                        $statusClass = 'danger';
                                                    } elseif ($item->inventory->on_hand_quantity <= $item->inventory->reorder_point) {
                                                        $status = 'Low Stock';
                                                        $statusClass = 'warning';
                                                    }
                                                @endphp
                                                <span class="badge badge-sm bg-gradient-{{ $statusClass }}">
                                                    {{ $status }}
                                                </span>
                                            </td>
                                            <td class="align-middle">
                                                <a href="{{ route('items.show', $item->id) }}" class="text-secondary font-weight-bold text-xs me-2">
                                                    View
                                                </a>
                                                @can('edit-items')
                                                    <a href="{{ route('items.edit', $item->id) }}" class="text-info font-weight-bold text-xs me-2">
                                                        Edit
                                                    </a>
                                                @endcan
                                                @can('delete-items')
                                                    <a href="{{ route('items.destroy', $item->id) }}" class="text-danger font-weight-bold text-xs">
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
                            {{ $items->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const searchInput = document.getElementById('search');
        const categoryFilter = document.getElementById('category-filter');
        const priceFilter = document.getElementById('price-filter');
        const resetButton = document.getElementById('reset-filters');
        
        function applyFilters() {
            const searchParams = new URLSearchParams(window.location.search);
            
            if (searchInput.value) searchParams.set('search', searchInput.value);
            if (categoryFilter.value) searchParams.set('category', categoryFilter.value);
            if (priceFilter.value) searchParams.set('price', priceFilter.value);
            
            window.location.search = searchParams.toString();
        }
        
        searchInput.addEventListener('keyup', function(e) {
            if (e.key === 'Enter') applyFilters();
        });
        
        categoryFilter.addEventListener('change', applyFilters);
        priceFilter.addEventListener('change', applyFilters);
        
        resetButton.addEventListener('click', function() {
            window.location.href = window.location.pathname;
        });
        
        // Set initial values from URL params
        const urlParams = new URLSearchParams(window.location.search);
        if (urlParams.has('search')) searchInput.value = urlParams.get('search');
        if (urlParams.has('category')) categoryFilter.value = urlParams.get('category');
        if (urlParams.has('price')) priceFilter.value = urlParams.get('price');
    });
</script>
@endpush