@extends('layouts.app', ['class' => 'g-sidenav-show bg-gray-100'])

@section('content')
    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-12">
                <div class="card mb-4">
                    <div class="card-header pb-0">
                        <h6>Create Item</h6>
                    </div>
                    <div class="card-body px-0 pt-0 pb-2">
                        <div class="row p-4">
                            <div class="col-md-6">
                                <form action="{{ route('items.store') }}" method="POST">
                                    @csrf
                                    <div class="form-group">
                                        <label for="name">Name</label>
                                        <input type="text" class="form-control" id="name" name="name" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="sku">SKU</label>
                                        <input type="text" class="form-control" id="sku" name="sku" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="description">Description</label>
                                        <textarea class="form-control" id="description" name="description"></textarea>
                                    </div>
                                    <div class="form-group">
                                        <label for="unit_price">Unit Price</label>
                                        <input type="number" step="0.01" class="form-control" id="unit_price" name="unit_price" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="unit_weight">Unit Weight</label>
                                        <input type="number" step="0.01" class="form-control" id="unit_weight" name="unit_weight" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="category">Category</label>
                                        <input type="text" class="form-control" id="category" name="category">
                                    </div>
                                    <div class="form-group">
                                        <label for="initial_quantity">Initial Quantity</label>
                                        <input type="number" class="form-control" id="initial_quantity" name="initial_quantity">
                                    </div>
                                    <div class="form-group">
                                        <label for="location">Location</label>
                                        <input type="text" class="form-control" id="location" name="location">
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