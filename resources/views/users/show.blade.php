@extends('layouts.app', ['class' => 'g-sidenav-show bg-gray-100'])

@section('content')
    @include('layouts.navbars.auth.topnav', ['title' => 'User Details'])
    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-12">
                <div class="card mb-4">
                    <div class="card-header pb-0">
                        <h6>User Details</h6>
                    </div>
                    <div class="card-body px-0 pt-0 pb-2">
                        <div class="row p-4">
                            <div class="col-md-6">
                                <p><strong>Name:</strong> {{ $user->name }}</p>
                                <p><strong>Email:</strong> {{ $user->email }}</p>
                                <p><strong>Department:</strong> {{ $user->department }}</p>
                                <p><strong>Employee ID:</strong> {{ $user->employee_id }}</p>
                                <p><strong>Roles:</strong> {{ $user->roles->pluck('name')->join(', ') }}</p>
                            </div>
                        </div>
                        <div class="row p-4">
                            <div class="col-12">
                                <h6>Transactions</h6>
                                <div class="table-responsive">
                                    <table class="table align-items-center mb-0">
                                        <thead>
                                            <tr>
                                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Item</th>
                                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Type</th>
                                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Quantity</th>
                                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Total Price</th>
                                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Date</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($user->transactions as $transaction)
                                                <tr>
                                                    <td>
                                                        <div class="d-flex px-2 py-1">
                                                            <div class="d-flex flex-column justify-content-center">
                                                                <h6 class="mb-0 text-sm">{{ $transaction->item->name }}</h6>
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
        @include('layouts.footers.auth.footer')
    </div>
@endsection