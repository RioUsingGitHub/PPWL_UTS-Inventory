@extends('layouts.app', ['class' => 'g-sidenav-show bg-gray-100'])

@section('content')
    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-12">
                <div class="card mb-4">
                    <div class="card-header pb-0">
                        <h6>Inventory Details</h6>
                    </div>
                    <div class="card-body px-0 pt-0 pb-2">
                        <div class="row p-4">
                            <div class="col-md-6">
                                <p><strong>Item:</strong> {{ $inventory->item->name }}</p>
                                <p><strong>On Hand Quantity:</strong> {{ $inventory->on_hand_quantity }}</p>
                                <p><strong>Off Hand Quantity:</strong> {{ $inventory->off_hand_quantity }}</p>
                                <p><strong>Location:</strong> {{ $inventory->location }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection