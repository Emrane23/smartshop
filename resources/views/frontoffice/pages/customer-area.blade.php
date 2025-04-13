@extends('layouts.base')

@section('content')
<div class="container py-5">
    <!-- Welcome Header -->
    <div class="text-center py-4 mb-5 bg-light rounded shadow-sm">
        <h4>Hello, {{ $customer->name }} 👋</h4>
        <p class="lead text-muted">Welcome back to your space.</p>
    </div>

    <!-- Account Info Section -->
    <div class="row justify-content-center mb-5">
        <div class="col-md-6">
            <div class="card shadow-sm border-0 text-center p-4">
                <div class="card-body">
                    <h4 class="fw-bold mb-3">🎁 Loyalty Points</h4>
                    <p class="fs-1 fw-bold text-primary">{{ $customer->points }}</p>
                    <p class="text-muted">Use your points to earn rewards and discounts!</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Orders Section -->
    @php
        $statusClasses = [
            'pending' => 'bg-warning text-dark',
            'confirmed' => 'bg-primary',
            'completed' => 'bg-success',
            'canceled' => 'bg-danger',
        ];
    @endphp

    <div class="row justify-content-center">
        <div class="col-lg-10">
            <h2 class="fw-bold text-center mb-4">🛒 My Orders</h2>

            @if ($orders->isEmpty())
                <div class="alert alert-info text-center py-4">
                    <p class="mb-1 fs-5">You haven't placed any orders yet.</p>
                    <p class="text-muted">Ready to discover amazing deals?</p>
                    <a href="{{ route('home') }}" class="btn btn-outline-primary mt-2">
                        Start Shopping
                    </a>
                </div>
            @else
                <div class="row g-4">
                    @foreach ($orders as $order)
                        <div class="col-md-6">
                            <div class="card shadow-sm border-0">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between align-items-center mb-3">
                                        <h5 class="fw-bold mb-0">Order #{{ $loop->iteration }}</h5>
                                        <span class="badge {{ $statusClasses[$order->status] ?? 'bg-secondary' }}">
                                            {{ ucfirst($order->status) }}
                                        </span>
                                    </div>
                                    <p class="mb-1"><i class="fa fa-calendar-alt me-2 text-muted"></i><strong>Date:</strong> {{ $order->created_at->format('d/m/Y H:i') }}</p>
                                    <p class="mb-2"><i class="fa fa-money-bill-wave me-2 text-muted"></i><strong>Total:</strong> <span class="text-success fw-bold">{{ number_format($order->total, 2) }} DT</span></p>
                                    <div>
                                        <p class="fw-bold mb-1"><i class="fa fa-box-open me-2 text-muted"></i>Products:</p>
                                        <ul class="list-unstyled ms-3">
                                            @foreach ($order->products as $product)
                                                <li>
                                                    ✔ <a href="{{ route('frontoffice.products.show', ['id' => $product->id]) }}" class="text-decoration-none text-dark">
                                                        {{ $product->name }}
                                                    </a>
                                                </li>
                                            @endforeach
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
