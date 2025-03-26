@extends('layouts.app', ['class' => 'g-sidenav-show bg-gray-100'])

@section('content')
    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-12">
                <div class="card mb-4">
                    <div class="card-header pb-0">
                        <h6>Transaction Details</h6>
                    </div>
                    <div class="card-body px-0 pt-0 pb-2">
                        <div class="row p-4">
                            <div class="col-md-6">
                                <p><strong>Item:</strong> {{ $transaction->item->name }}</p>
                                <p><strong>User:</strong> {{ $transaction->user->name }}</p>
                                <p><strong>Type:</strong> {{ $transaction->type }}</p>
                                <p><strong>Quantity:</strong> {{ $transaction->quantity }}</p>
                                <p><strong>Total Price:</strong> ${{ number_format($transaction->total_price, 2) }}</p>
                                <p><strong>Total Weight:</strong> {{ $transaction->total_weight }} kg</p>
                                <p><strong>Date:</strong> {{ $transaction->created_at->format('Y-m-d H:i') }}</p>
                                <p><strong>Notes:</strong> {{ $transaction->notes }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection