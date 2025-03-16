@extends('layouts.base')

@section('content')
<div class="container py-5">
    <!-- Header -->
    <div class="text-center py-4 rounded ">
        <h1 class="fw-bold">Welcome, {{ $customer->name }} 👋</h1>
        <p class="lead">You currently have <span class="fw-bold">{{ $customer->points }}</span> points.</p>
    </div>

    <!-- Section commandes -->
    <div class="row mt-5">
        <div class="col-lg-10 mx-auto">
            <h2 class="fw-bold text-center mb-4">My Orders</h2>

            @if ($orders->isEmpty())
                <div class="alert alert-warning text-center">
                    <p>No orders placed yet. Start shopping now! 🛍️</p>
                </div>
            @else
                <div class="table-responsive">
                    <table class="table table-hover align-middle shadow-sm">
                        <thead class="table-light">
                            <tr class="text-center">
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
                                    <td class="text-center">{{ $loop->iteration }}</td>
                                    <td class="text-center">{{ $order->created_at->format('d/m/Y H:i') }}</td>
                                    <td class="text-center text-success fw-bold">{{ number_format($order->total, 2) }} DT</td>
                                    <td>
                                        <ul class="list-unstyled">
                                            @foreach ($order->products as $product)
                                                <li>✔ <a href="{{ route('products.show', ['product' => $product]) }}">{{ $product->name }}</a></li>
                                            @endforeach
                                        </ul>
                                    </td>
                                    <td class="text-center">
                                        <a href="#" class="btn btn-sm btn-primary rounded-pill px-3">View Order</a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
