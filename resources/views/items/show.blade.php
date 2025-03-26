@extends('layouts.app', ['class' => 'g-sidenav-show bg-gray-100'])

@section('content')
    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-12">
                <div class="card mb-4">
                    <div class="card-header pb-0">
                        <h6>Item Details</h6>
                    </div>
                    <div class="card-body px-0 pt-0 pb-2">
                        <div class="row p-4">
                            <div class="col-md-6">
                                <p><strong>Name:</strong> {{ $item->name }}</p>
                                <p><strong>SKU:</strong> {{ $item->sku }}</p>
                                <p><strong>Description:</strong> {{ $item->description }}</p>
                                <p><strong>Unit Price:</strong> ${{ number_format($item->unit_price, 2) }}</p>
                                <p><strong>Unit Weight:</strong> {{ $item->unit_weight }} kg</p>
                                <p><strong>Category:</strong> {{ $item->category }}</p>
                            </div>
                            <div class="col-md-6">
                                <p><strong>On Hand Quantity:</strong> {{ $item->inventory->on_hand_quantity ?? 0 }}</p>
                                <p><strong>Off Hand Quantity:</strong> {{ $item->inventory->off_hand_quantity ?? 0 }}</p>
                                <p><strong>Location:</strong> {{ $item->inventory->location ?? 'N/A' }}</p>
                            </div>
                        </div>
                        <div class="row p-4">
                            <div class="col-12">
                                <h6>Transactions</h6>
                                <div class="table-responsive">
                                    <table class="table align-items-center mb-0">
                                        <thead>
                                            <tr>
                                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">User</th>
                                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Type</th>
                                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Quantity</th>
                                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Total Price</th>
                                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Date</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($item->transactions as $transaction)
                                                <tr>
                                                    <td>
                                                        <div class="d-flex px-2 py-1">
                                                            <div class="d-flex flex-column justify-content-center">
                                                                <h6 class="mb-0 text-sm">{{ $transaction->user->name }}</h6>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <p class="text-xs font-weight-bold mb-0">{{ $transaction->type }}</p>
                                                    </td>
                                                    <td>
                                                        <p class="text-xs font-weight-bold mb-0">{{ $transaction->quantity }}</p>
                                                    </td>
                                                    <td>
                                                        <p class="text-xs font-weight-bold mb-0">${{ number_format($transaction->total_price, 2) }}</p>
                                                    </td>
                                                    <td>
                                                        <p class="text-xs font-weight-bold mb-0">{{ $transaction->created_at->format('Y-m-d H:i') }}</p>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection