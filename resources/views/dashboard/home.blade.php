@extends('layouts.admin')
@section('content')
    <div class="container-fluid px-4">
        <div class="d-flex justify-content-between align-items-center mt-4 mb-4">
            <div>
                <h1>Dashboard</h1>
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item active">Dashboard</li>
                </ol>
            </div>
            <a href="{{ route('sales.report.download') }}" class="btn btn-primary shadow-sm d-flex align-items-center">
                <i class="fas fa-download me-2"></i> Download Sales Report
            </a>
        </div>
        
        
        <div class="row">
            <div class="col-xl-6">
                <div class="card mb-4">
                    <div class="card-header">
                        <i class="fas fa-chart-area me-1"></i>
                        Loyalty points Of Customers
                    </div>
                    <div class="card-body"><canvas id="pointsChart" width="100%" height="40"></canvas></div>
                </div>
            </div>
            <div class="col-xl-6">
                <div class="card mb-4">
                    <div class="card-header">
                        <i class="fas fa-chart-bar me-1"></i>
                        Sales Prediction
                    </div>
                    <div class="card-body"><canvas id="salesChart" width="100%" height="40"></canvas></div>
                </div>
            </div>
        </div>
        <div class="card mb-4">
            <div class="card-header">
                <i class="fas fa-table me-1"></i>
                List Of Our Customers
            </div>
            <div class="card-body">
                <table id="datatablesSimple">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>email</th>
                            {{-- <th>Office</th>
                            <th>Age</th>
                            <th>Start date</th>
                            <th>Salary</th> --}}
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th>Name</th>
                            <th>Email</th>
                            {{-- <th>Office</th>
                            <th>Age</th>
                            <th>Start date</th>
                            <th>Salary</th> --}}
                        </tr>
                    </tfoot>
                    <tbody>
                        @foreach ($customers as $customer)
                            <tr>
                                <td>{{ $customer->name }}</td>
                                <td>{{ $customer->email }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script>
        var ctx = document.getElementById('pointsChart').getContext('2d');
        var chart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: @json($customers->pluck('name')),
                datasets: [{
                    label: 'Loyalty points',
                    data: @json($customers->pluck('points')),
                    backgroundColor: "rgba(2,117,216,1)"
                }]
            }
        });
        var ctxsales = document.getElementById('salesChart').getContext('2d');
        var sales = new Chart(ctxsales, {
            type: 'line',
            data: {
                labels: @json($sales->pluck('product_name')),
                datasets: [{
                    label: 'Past Sales',
                    data: @json($sales->pluck('total_sales')),
                    borderColor: "rgba(2,117,216,1)",
                    fill: false
                }, {
                    label: 'Prediction',
                    data: @json($predictions->pluck('predicted_sales')),
                    borderColor: 'red',
                    fill: false
                }]
            }
        });
    </script>
@endsection
