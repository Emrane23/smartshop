@extends('layouts.base')

@section('content')
    <div class="container">
        <h1>Welcome, {{ $customer->name }}</h1>
        <p>Number of points : <strong>{{ $customer->points }}</strong></p>

        <h2 class="mt-4">My orders</h2>

        @if ($orders->isEmpty())
            <p>No orders placed yet.</p>
        @else
            <table class="table table-bordered mt-3">
                <thead class="thead-dark">
                    <tr>
                        <th>#</th>
                        <th>Date</th>
                        <th>Total</th>
                        <th>Products</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($orders as $order)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $order->created_at->format('d/m/Y H:i') }}</td>
                            <td>{{ number_format($order->total, 2) }} DT</td>
                            <td>
                                @foreach ($order->products as $product)
                                    <li>{{ $product->name }}</li>
                                @endforeach
                            </td>
                            <td>
                                <a href="#" class="btn btn-sm btn-primary">Voir</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    </div>
@endsection
