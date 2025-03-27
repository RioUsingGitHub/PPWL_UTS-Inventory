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
                                <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#createTransactionModal">
                                    New Transaction
                                </button>
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

    <!-- Create Transaction Modal -->
    <div class="modal fade" id="createTransactionModal" tabindex="-1" role="dialog" aria-labelledby="createTransactionModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="createTransactionModalLabel">Create New Transaction</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form method="POST" action="{{ route('transactions.store') }}">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="item_id" class="form-control-label">Item</label>
                            <select class="form-control" id="item_id" name="item_id" required>
                                <option value="">Select an item</option>
                                @foreach($items as $item)
                                    <option value="{{ $item->id }}" data-stock="{{ $item->inventory->on_hand_quantity }}">
                                        {{ $item->name }} (Stock: {{ $item->inventory->on_hand_quantity }})
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="type" class="form-control-label">Type</label>
                            <select class="form-control" id="type" name="type" required>
                                <option value="on_hand">Add to Stock</option>
                                <option value="off_hand">Remove from Stock</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="quantity" class="form-control-label">Quantity</label>
                            <input type="number" class="form-control" id="quantity" name="quantity" required min="1">
                            <small class="text-muted" id="stock-info"></small>
                        </div>

                        <div class="form-group">
                            <label for="notes" class="form-control-label">Notes</label>
                            <textarea class="form-control" id="notes" name="notes" rows="3"></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Create Transaction</button>
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

        // Transaction modal functionality
        const itemSelect = document.getElementById('item_id');
        const typeSelect = document.getElementById('type');
        const quantityInput = document.getElementById('quantity');
        const stockInfo = document.getElementById('stock-info');

        function updateStockInfo() {
            const selectedOption = itemSelect.options[itemSelect.selectedIndex];
            const currentStock = selectedOption.dataset.stock;
            const isOffHand = typeSelect.value === 'off_hand';

            if (selectedOption.value) {
                stockInfo.textContent = `Available stock: ${currentStock}`;
                if (isOffHand) {
                    quantityInput.max = currentStock;
                } else {
                    quantityInput.removeAttribute('max');
                }
            } else {
                stockInfo.textContent = '';
                quantityInput.removeAttribute('max');
            }
        }

        itemSelect.addEventListener('change', updateStockInfo);
        typeSelect.addEventListener('change', updateStockInfo);
    });
</script>
@endpush