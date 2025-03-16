@extends('layouts.admin')

@section('content')
    <div class="container-fluid px-4">
        <h1 class="mt-4">{{ $product->name }}</h1>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item"><a href="{{ route('products.index') }}">Products</a></li>
            <li class="breadcrumb-item active">{{ $product->name }}</li>
        </ol>

        <div class="card mb-4">
            <div class="card-header">
                <i class="fas fa-eye me-1"></i> Show Product
            </div>
            <div class="card-body">
                <div class="row mb-3">
                    <div class="col-md-4">
                        @if ($product->image)
                            <img src="{{ asset($product->image) }}" alt="{{ $product->name }}" class="img-fluid rounded">
                        @else
                            <img src="https://via.placeholder.com/300" alt="No Image" class="img-fluid rounded">
                        @endif
                    </div>
                    <div class="col-md-8">
                        <table class="table table-bordered">
                            <tr>
                                <th>Name</th>
                                <td>{{ $product->name }}</td>
                            </tr>
                            <tr>
                                <th>Description</th>
                                <td>{{ $product->description }}</td>
                            </tr>
                            <tr>
                                <th>Price</th>
                                <td>{{ number_format($product->price, 2) }}DT</td>
                            </tr>
                            <tr>
                                <th>Stock</th>
                                <td>{{ $product->stock }}</td>
                            </tr>
                            <tr>
                                <th>Discount</th>
                                <td>
                                    @if ($product->discount)
                                        {{ $product->discount }}%
                                    @else
                                        No Discount
                                    @endif
                                </td>
                            </tr>

                            <tr>
                                <th>Created At</th>
                                <td>{{ $product->created_at->format('d M Y, H:i') }}</td>
                            </tr>
                        </table>
                        <a href="{{ route('products.edit', $product->id) }}" class="btn btn-warning text-white">Edit
                            Product</a>
                        <a href="{{ route('products.index') }}" class="btn btn-secondary">Back to Product List</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
