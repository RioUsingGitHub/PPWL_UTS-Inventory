@extends('layouts.app', ['class' => 'g-sidenav-show bg-gray-100'])

@section('content')
    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-12">
                <div class="card mb-4">
                    <div class="card-header pb-0">
                        <div class="d-flex justify-content-between align-items-center">
                            <h6>Transactions</h6>
                            @can('create-transactions')
                                <a href="{{ route('transactions.create') }}" class="btn btn-primary btn-sm">New Transaction</a>
                            @endcan
                        </div>
                        <div class="row mt-3">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <input type="text" class="form-control" id="search" placeholder="Search...">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <select class="form-control" id="type-filter">
                                        <option value="">All Types</option>
                                        <option value="in">In</option>
                                        <option value="out">Out</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <input type="date" class="form-control" id="date-filter">
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
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">User</th>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Type</th>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Quantity</th>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Total Price</th>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Date</th>
                                        <th class="text-secondary opacity-7"></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($transactions as $transaction)
                                        <tr>
                                            <td>
                                                <div class="d-flex px-2 py-1">
                                                    <div class="d-flex flex-column justify-content-center">
                                                        <h6 class="mb-0 text-sm">{{ $transaction->item->name }}</h6>
                                                        <p class="text-xs text-secondary mb-0">{{ $transaction->item->sku }}</p>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <p class="text-xs font-weight-bold mb-0">{{ $transaction->user->name }}</p>
                                                <p class="text-xs text-secondary mb-0">{{ $transaction->user->department }}</p>
                                            </td>
                                            <td>
                                                <span class="badge badge-sm bg-gradient-{{ $transaction->type === 'in' ? 'success' : 'warning' }}">
                                                    {{ ucfirst($transaction->type) }}
                                                </span>
                                            </td>
                                            <td>
                                                <p class="text-xs font-weight-bold mb-0">{{ $transaction->quantity }}</p>
                                            </td>
                                            <td>
                                                <p class="text-xs font-weight-bold mb-0">${{ number_format($transaction->total_price, 2) }}</p>
                                            </td>
                                            <td>
                                                <p class="text-xs font-weight-bold mb-0">{{ $transaction->created_at->format('Y-m-d') }}</p>
                                                <p class="text-xs text-secondary mb-0">{{ $transaction->created_at->format('H:i') }}</p>
                                            </td>
                                            <td class="align-middle">
                                                <a href="{{ route('transactions.show', $transaction->id) }}" class="text-secondary font-weight-bold text-xs" data-toggle="tooltip" data-original-title="View transaction">
                                                    View
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="px-4 pt-4">
                            {{ $transactions->links() }}
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
        const typeFilter = document.getElementById('type-filter');
        const dateFilter = document.getElementById('date-filter');
        const resetButton = document.getElementById('reset-filters');
        
        function applyFilters() {
            const searchParams = new URLSearchParams(window.location.search);
            
            if (searchInput.value) searchParams.set('search', searchInput.value);
            if (typeFilter.value) searchParams.set('type', typeFilter.value);
            if (dateFilter.value) searchParams.set('date', dateFilter.value);
            
            window.location.search = searchParams.toString();
        }
        
        searchInput.addEventListener('keyup', function(e) {
            if (e.key === 'Enter') applyFilters();
        });
        
        typeFilter.addEventListener('change', applyFilters);
        dateFilter.addEventListener('change', applyFilters);
        
        resetButton.addEventListener('click', function() {
            window.location.href = window.location.pathname;
        });
        
        // Set initial values from URL params
        const urlParams = new URLSearchParams(window.location.search);
        if (urlParams.has('search')) searchInput.value = urlParams.get('search');
        if (urlParams.has('type')) typeFilter.value = urlParams.get('type');
        if (urlParams.has('date')) dateFilter.value = urlParams.get('date');
    });
</script>
@endpush