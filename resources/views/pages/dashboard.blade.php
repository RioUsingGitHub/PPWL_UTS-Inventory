@extends('layouts.app', ['class' => 'g-sidenav-show bg-gray-100'])

@section('content')
    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
                <div class="card">
                    <div class="card-body p-3">
                        <div class="row">
                            <div class="col-8">
                                <div class="numbers">
                                    <p class="text-sm mb-0 text-uppercase font-weight-bold">Total Inventory Value</p>
                                    <h5 class="font-weight-bolder">
                                        ${{ number_format($currentInventoryValue, 2) }}
                                    </h5>
                                    <p class="mb-0">
                                        <span class="text-{{ $inventoryGrowth >= 0 ? 'success' : 'danger' }} text-sm font-weight-bolder">
                                            {{ $inventoryGrowth >= 0 ? '+' : '' }}{{ $inventoryGrowth }}%
                                        </span>
                                        since last month
                                    </p>
                                </div>
                            </div>
                            <div class="col-4 text-end">
                                <div class="icon icon-shape bg-gradient-primary shadow-primary text-center rounded-circle">
                                    <i class="fa-solid fa-receipt text-lg opacity-10" aria-hidden="true"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
                <div class="card">
                    <div class="card-body p-3">
                        <div class="row">
                            <div class="col-8">
                                <div class="numbers">
                                    <p class="text-sm mb-0 text-uppercase font-weight-bold">Total Items</p>
                                    <h5 class="font-weight-bolder">
                                        {{ number_format($currentItemsCount) }}
                                    </h5>
                                    <p class="mb-0">
                                        <span class="text-{{ $itemsGrowth >= 0 ? 'success' : 'danger' }} text-sm font-weight-bolder">
                                            {{ $itemsGrowth >= 0 ? '+' : '' }}{{ $itemsGrowth }}%
                                        </span>
                                        since last month
                                    </p>
                                </div>
                            </div>
                            <div class="col-4 text-end">
                                <div class="icon icon-shape bg-gradient-danger shadow-danger text-center rounded-circle">
                                    <i class="fa-solid fa-cube text-lg opacity-10" aria-hidden="true"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
                <div class="card">
                    <div class="card-body p-3">
                        <div class="row">
                            <div class="col-8">
                                <div class="numbers">
                                    <p class="text-sm mb-0 text-uppercase font-weight-bold">Transactions</p>
                                    <h5 class="font-weight-bolder">
                                        {{ number_format($currentMonthTransactions) }}
                                    </h5>
                                    <p class="mb-0">
                                        <span class="text-{{ $transactionQuarterGrowth >= 0 ? 'success' : 'danger' }} text-sm font-weight-bolder">
                                            {{ $transactionQuarterGrowth >= 0 ? '+' : '' }}{{ $transactionQuarterGrowth }}%
                                        </span>
                                        vs. last quarter
                                    </p>
                                </div>
                            </div>
                            <div class="col-4 text-end">
                                <div class="icon icon-shape bg-gradient-success shadow-success text-center rounded-circle">
                                    <i class="fa-solid fa-handshake text-lg opacity-10" aria-hidden="true"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-sm-6">
                <div class="card">
                    <div class="card-body p-3">
                        <div class="row">
                            <div class="col-8">
                                <div class="numbers">
                                    <p class="text-sm mb-0 text-uppercase font-weight-bold">Monthly Sales</p>
                                    <h5 class="font-weight-bolder">
                                        ${{ number_format($currentMonthSales, 2) }}
                                    </h5>
                                    <p class="mb-0">
                                        <span class="text-{{ $salesGrowth >= 0 ? 'success' : 'danger' }} text-sm font-weight-bolder">
                                            {{ $salesGrowth >= 0 ? '+' : '' }}{{ $salesGrowth }}%
                                        </span>
                                        since last month
                                    </p>
                                </div>
                            </div>
                            <div class="col-4 text-end">
                                <div class="icon icon-shape bg-gradient-warning shadow-warning text-center rounded-circle">
                                    <i class="fa-solid fa-dollar-sign text-lg opacity-10" aria-hidden="true"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row mt-4">
            <div class="col-lg-7 mb-lg-0 mb-4">
                <div class="card z-index-2 h-100">
                    <div class="card-header pb-0 pt-3 bg-transparent">
                        <h6 class="text-capitalize">Monthly Transactions</h6>
                        <p class="text-sm mb-0">
                            <i class="fa fa-arrow-{{ $transactionMonthGrowth >= 0 ? 'up' : 'down' }} text-{{ $transactionMonthGrowth >= 0 ? 'success' : 'danger' }}"></i>
                            <span class="font-weight-bold">{{ abs($transactionMonthGrowth) }}% {{ $transactionMonthGrowth >= 0 ? 'more' : 'less' }}</span> than last month
                        </p>
                    </div>
                    <div class="card-body p-3">
                        <div class="chart">
                            <canvas id="chart-line" class="chart-canvas" height="300"></canvas>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-5">
                <div class="card">
                    <div class="card-header pb-0 p-3">
                        <h6 class="mb-0">Top Categories</h6>
                    </div>
                    <div class="card-body p-3">
                        <ul class="list-group">
                            @foreach($topCategories as $category)
                                <li class="list-group-item border-0 d-flex justify-content-between ps-0 mb-2 border-radius-lg">
                                    <div class="d-flex align-items-center">
                                        <div class="icon icon-shape icon-sm me-3 bg-gradient-dark shadow text-center">
                                            <i class="ni ni-mobile-button text-white opacity-10"></i>
                                        </div>
                                        <div class="d-flex flex-column">
                                            <h6 class="mb-1 text-dark text-sm">{{ $category->category }}</h6>
                                            <span class="text-xs">{{ $category->transaction_count }} transactions, <span class="font-weight-bold">${{ number_format($category->total_value, 2) }}</span></span>
                                        </div>
                                    </div>
                                    <div class="d-flex">
                                        <button class="btn btn-link btn-icon-only btn-rounded btn-sm text-dark icon-move-right my-auto"><i class="ni ni-bold-right" aria-hidden="true"></i></button>
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="{{ asset('assets/js/plugins/chartjs.min.js') }}"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var ctx1 = document.getElementById("chart-line").getContext("2d");

            var gradientStroke1 = ctx1.createLinearGradient(0, 230, 0, 50);

            gradientStroke1.addColorStop(1, 'rgba(251, 99, 64, 0.2)');
            gradientStroke1.addColorStop(0.2, 'rgba(251, 99, 64, 0.0)');
            gradientStroke1.addColorStop(0, 'rgba(251, 99, 64, 0)');

            // Ensure data is numeric
            var chartData = @json($chartData).map(Number);

            new Chart(ctx1, {
                type: "line",
                data: {
                    labels: @json($chartLabels),
                    datasets: [{
                        label: "Monthly Transaction Value",
                        tension: 0.4,
                        borderWidth: 0,
                        pointRadius: 5,
                        pointBackgroundColor: "#fb6340",
                        pointBorderColor: "#fb6340",
                        borderColor: "#fb6340",
                        backgroundColor: gradientStroke1,
                        borderWidth: 3,
                        fill: true,
                        data: chartData,
                        maxBarThickness: 6
                    }],
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            display: true,
                            position: 'top',
                            labels: {
                                color: '#666',
                                font: {
                                    size: 12
                                }
                            }
                        }
                    },
                    interaction: {
                        intersect: false,
                        mode: 'index',
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            grid: {
                                drawBorder: false,
                                display: true,
                                drawOnChartArea: true,
                                drawTicks: false,
                                borderDash: [5, 5]
                            },
                            ticks: {
                                display: true,
                                padding: 10,
                                color: '#666',
                                font: {
                                    size: 11,
                                    family: "Open Sans",
                                    style: 'normal',
                                    lineHeight: 2
                                },
                                callback: function(value) {
                                    return '$' + value.toLocaleString();
                                }
                            }
                        },
                        x: {
                            grid: {
                                drawBorder: false,
                                display: false,
                                drawOnChartArea: false,
                                drawTicks: false,
                                borderDash: [5, 5]
                            },
                            ticks: {
                                display: true,
                                color: '#666',
                                padding: 20,
                                font: {
                                    size: 11,
                                    family: "Open Sans",
                                    style: 'normal',
                                    lineHeight: 2
                                },
                            }
                        },
                    },
                },
            });
        });
    </script>
@endpush