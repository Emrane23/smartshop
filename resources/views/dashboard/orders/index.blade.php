@extends('layouts.admin')

@section('content')
    <div class="container-fluid px-4">
        <h1 class="mt-4">Orders List</h1>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item active">Orders</li>
        </ol>

        <div class="card mb-4">
            <div class="card-header">
                <i class="fas fa-table me-1"></i>
                Orders List
            </div>
            <div class="card-body">
                <table id="datatablesSimple" class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Customer</th>
                            <th>Total</th>
                            <th>Products</th>
                            <th>Ordered At</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th>Customer</th>
                            <th>Total</th>
                            <th>Products</th>
                            <th>Ordered At</th>
                        </tr>
                    </tfoot>
                    <tbody>
                        @foreach ($orders as $order)
                            <tr>
                                <td>{{ $order->customer->name }}</td> 
                                <td>{{ number_format($order->total, 2) }} DT</td>
                                <td>
                                    <ul>
                                        @foreach ($order->products as $product)
                                            <li><a href="{{ route('products.show', ['product' => $product]) }}">{{ $product->name }}</a></li>
                                        @endforeach
                                    </ul>
                                </td>
                                <td>{{ $order->created_at->format('d M Y H:i') }}</td>
                            </tr>
                        @endforeach
                    </tbody>

                </table>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            $(document).ready(function() {
                $('#datatablesSimple').DataTable();
            });
        </script>
    @endpush
@endsection
