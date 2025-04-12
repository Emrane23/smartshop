@extends('layouts.admin')

@section('content')
    <div class="container-fluid px-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="mt-4">Product List</h1>
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">Dashboard</a></li>
                <li class="breadcrumb-item active">Products</li>
            </ol>
        </div>

        <div class="card mb-4">
            <div class="card-header">
                <i class="fas fa-boxes me-1"></i>
                Products
                <a href="{{ route('products.create') }}" class="btn btn-success float-end">
                    <i class="fas fa-plus-circle"></i> Add New Product
                </a>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Image</th>
                                <th>Name</th>
                                <th>Price</th>
                                <th>Discount</th>
                                <th>Stock</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($products as $product)
                                <tr>
                                    <td>
                                        @if ($product->image)
                                            <img src="{{ url($product->image) }}" alt="Product Image" class="img-thumbnail" width="50">
                                        @else
                                            <span>No Image</span>
                                        @endif
                                    </td>
                                    <td>{{ Str::limit($product->name, 50, '...') }}</td>
                                    <td>{{ $product->price }} DT</td>
                                    <td>
                                        @if ($product->discount)
                                            <span class="badge
                                                @if ($product->discount >= 50) bg-danger
                                                @elseif ($product->discount >= 20) bg-warning
                                                @else bg-success @endif">
                                                {{ $product->discount }}%
                                            </span>
                                        @else
                                            <span class="badge bg-secondary">No Discount</span>
                                        @endif
                                    </td>
                                    <td>{{ $product->stock }}</td>
                                    <td>
                                        <a href="{{ route('products.show', $product->id) }}" class="btn btn-info btn-sm">
                                            <i class="fas fa-eye"></i> Show
                                        </a>
                                        <a href="{{ route('products.edit', $product->id) }}" class="btn btn-warning btn-sm">
                                            <i class="fas fa-edit"></i> Edit
                                        </a>
                                        <form action="{{ route('products.destroy', $product->id) }}" method="POST" class="d-inline-block">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this product?')">
                                                <i class="fas fa-trash-alt"></i> Delete
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            @if ($products->hasPages())
                <div class="card-footer clearfix">
                    {{ $products->links('pagination::bootstrap-5') }}
                </div>
            @endif
        </div>
    </div>
@endsection
