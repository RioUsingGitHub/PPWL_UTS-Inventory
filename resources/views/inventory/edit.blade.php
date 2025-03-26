@extends('layouts.app', ['class' => 'g-sidenav-show bg-gray-100'])

@section('content')
    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-12">
                <div class="card mb-4">
                    <div class="card-header pb-0">
                        <h6>Edit Inventory</h6>
                    </div>
                    <div class="card-body px-0 pt-0 pb-2">
                        <div class="row p-4">
                            <div class="col-md-6">
                                <form action="{{ route('inventory.update', $inventory->id) }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <div class="form-group">
                                        <label for="on_hand_quantity">On Hand Quantity</label>
                                        <input type="number" class="form-control" id="on_hand_quantity" name="on_hand_quantity" value="{{ $inventory->on_hand_quantity }}" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="location">Location</label>
                                        <input type="text" class="form-control" id="location" name="location" value="{{ $inventory->location }}">
                                    </div>
                                    <button type="submit" class="btn btn-primary">Submit</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection