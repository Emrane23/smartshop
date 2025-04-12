@extends('layouts.admin')

@section('content')
    <main class="app-main">
        <!--begin::App Content Header-->
        <div class="app-content-header">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-sm-6">
                        <h3 class="mb-0">Dashboard</h3>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-end">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Dashboard</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>

        <!--begin::App Content-->
        <div class="app-content">
            <div class="container-fluid">
                <div class="row">
                    <!-- Loyalty Points Chart -->
                    <div class="col-lg-6">
                        <div class="card mb-4">
                            <div class="card-header d-flex justify-content-between">
                                <h3 class="card-title">Loyalty Points of Customers</h3>
                                {{-- <a href="#" class="link-primary">View Report</a> --}}
                            </div>
                            <div class="card-body">
                                <div id="pointsChart"></div>
                            </div>
                        </div>
                    </div>

                    <!-- Sales Prediction Chart -->
                    <div class="col-lg-6">
                        <div class="card mb-4">
                            <div class="card-header d-flex justify-content-between">
                                <h3 class="card-title">Sales Prediction</h3>
                                <a href="{{ route('sales.report.download') }}" class="btn btn-sm btn-success">
                                    <i class="bi bi-download me-1"></i> Download Sales Report
                                </a>
                            </div>
                            <div class="card-body">
                                <div id="salesChart"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- ApexCharts -->
        <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
        <script>
            // Loyalty Points Bar Chart
            var pointsOptions = {
                chart: {
                    type: 'bar',
                    height: 300
                },
                series: [{
                    name: 'Points',
                    data: @json($customers->pluck('points'))
                }],
                xaxis: {
                    categories: @json($customers->pluck('name')),
                    labels: {
                        rotate: -45
                    }
                },
                colors: ['#0d6efd'],
                title: {
                    text: 'Customer Points',
                    align: 'left'
                }
            };
            var pointsChart = new ApexCharts(document.querySelector("#pointsChart"), pointsOptions);
            pointsChart.render();

            // Sales Prediction Line Chart
            var salesOptions = {
                chart: {
                    type: 'line',
                    height: 300
                },
                series: [{
                        name: 'Past Sales',
                        data: @json($sales->pluck('total_sales')->map(fn($val) => round($val, 2)))
                    },
                    {
                        name: 'Prediction',
                        data: @json($predictions->pluck('predicted_sales')->map(fn($val) => round($val, 2)))
                    }
                ],
                xaxis: {
                    categories: @json($sales->pluck('product_name'))
                },
                colors: ['#198754', '#dc3545'],
                title: {
                    text: 'Sales Forecast',
                    align: 'left'
                },
                tooltip: {
                    y: {
                        formatter: function(val) {
                            return val.toFixed(2); // max 2 décimales
                        }
                    }
                },
                dataLabels: {
                    enabled: false,
                }
            };
            var salesChart = new ApexCharts(document.querySelector("#salesChart"), salesOptions);
            salesChart.render();
        </script>
    </main>
@endsection
