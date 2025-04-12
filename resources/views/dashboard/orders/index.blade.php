@extends('layouts.admin')

@section('content')
    <div class="container-fluid px-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="mt-4">Orders List</h1>
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">Dashboard</a></li>
                <li class="breadcrumb-item active">Orders</li>
            </ol>
        </div>

        <div class="card mb-4">
            <div class="card-header">
                <i class="fas fa-list me-1"></i>
                Orders
            </div>
            <div class="card-body table-responsive p-0">
                <table class="table table-bordered table-hover">
                    <thead>
                        <tr>
                            <th>Customer</th>
                            <th>Total</th>
                            <th>Products</th>
                            <th>Ordered At</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($orders as $order)
                            <tr>
                                <td>{{ $order->customer->name }}</td>
                                <td>{{ number_format($order->total, 2) }} DT</td>
                                <td>
                                    <div class="d-flex flex-wrap gap-2">
                                        @foreach ($order->products as $product)
                                            <a href="{{ route('products.show', $product) }}"
                                                class="btn btn-sm btn-outline-secondary">
                                                {{ Str::limit($product->name, 25, '...') }}
                                            </a>
                                        @endforeach
                                    </div>
                                </td>
                                <td>{{ $order->created_at->format('d M Y') }}</td>
                                <td>
                                    @php
                                        $statusClasses = [
                                            'pending' => 'badge bg-warning text-dark',
                                            'confirmed' => 'badge bg-primary',
                                            'completed' => 'badge bg-success',
                                            'canceled' => 'badge bg-danger',
                                        ];
                                    @endphp
                                    <span class="{{ $statusClasses[$order->status] ?? 'badge bg-secondary' }}">
                                        {{ ucfirst($order->status) }}
                                    </span>
                                </td>
                                <td>
                                    <form action="{{ route('update.status') }}" method="POST">
                                        @csrf
                                        <input type="hidden" name="order_id" value="{{ $order->id }}">
                                        <select name="status" class="form-select form-select-sm d-inline w-auto"
                                            onchange="this.form.submit()"
                                            {{ in_array($order->status, ['canceled', 'completed']) ? 'disabled' : '' }}>
                                            <option value="pending" @selected($order->status == 'pending')>Pending</option>
                                            <option value="confirmed" @selected($order->status == 'confirmed')>Confirmed</option>
                                            <option value="completed" @selected($order->status == 'completed')>Completed</option>
                                            <option value="canceled" @selected($order->status == 'canceled')>Canceled</option>
                                        </select>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center">No orders found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if ($orders->hasPages())
                <div class="card-footer clearfix">
                    {{ $orders->links('pagination::bootstrap-5') }}
                </div>
            @endif
        </div>
    </div>
@endsection
