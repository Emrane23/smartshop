@extends('layouts.base')

@section('content')
    <div class="container py-5">
        <!-- Header -->
        <div class="text-center py-4 rounded">
            <h1 class="fw-bold">Welcome, {{ $customer->name }} 👋</h1>
            <p class="lead">You currently have <span class="fw-bold">{{ $customer->points }}</span> points.</p>
        </div>

        <!-- Section Commandes -->
        @php
            $statusClasses = [
                'pending' => 'badge bg-warning text-dark',
                'confirmed' => 'badge bg-primary',
                'completed' => 'badge bg-success',
                'canceled' => 'badge bg-danger',
            ];
        @endphp
        <div class="row mt-5">
            <div class="col-lg-10 mx-auto">
                <h2 class="fw-bold text-center mb-4">My Orders</h2>

                @if ($orders->isEmpty())
                    <div class="alert alert-warning text-center">
                        <p>No orders placed yet. Start shopping now! 🛍️</p>
                    </div>
                @else
                    <div class="table-responsive">
                        <table class="table align-middle">
                            <thead class="table-light">
                                <tr class="text-center">
                                    <th>#</th>
                                    <th>Date</th>
                                    <th>Total</th>
                                    <th>Status</th>
                                    <th>Products</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($orders as $order)
                                    <tr>
                                        <td class="text-center">{{ $loop->iteration }}</td>
                                        <td class="text-center">{{ $order->created_at->format('d/m/Y H:i') }}</td>
                                        <td class="text-center text-success fw-bold">
                                            {{ number_format($order->total, 2) }} DT
                                        </td>
                                        <td class="text-center">
                                            <span
                                                class="order-status-badge {{ $statusClasses[$order->status] ?? 'badge bg-secondary' }}">
                                                {{ ucfirst($order->status) }}
                                            </span>
                                        </td>
                                        <td>
                                            <table class="table table-borderless mb-0">
                                                <tbody>
                                                    @foreach ($order->products as $product)
                                                        <tr>
                                                            <td>✔
                                                                <a
                                                                    class="text-decoration-none" href="{{ route('frontoffice.products.show', ['id' => $product->id]) }}">
                                                                    {{ $product->name }}
                                                                </a>
                                                            </td>
                                                            <td class="text-end">
                                                                @if ($product->canRate(auth()->guard('customer')->user()->id))
                                                                    <button class="btn btn-sm btn-link btn-rate-product"
                                                                        data-product-id="{{ $product->id }}"
                                                                        data-order-id="{{ $order->id }}"
                                                                        data-product-name="{{ $product->name }}">
                                                                        Rate <i class="fa fa-star text-warning"></i>
                                                                    </button>
                                                                @endif
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
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

    @include('frontoffice.partials.rating_modal')

    @push('scripts')
        <script src="{{ asset('assets/js/rating.js') }}"></script>
    @endpush
@endsection
