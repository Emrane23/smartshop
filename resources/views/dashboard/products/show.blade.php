@extends('layouts.admin')

@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">{{ Str::limit($product->name, 30, '...') }}</h1>
                </div>
                <div class="col-sm-6 text-end">
                    <ol class="breadcrumb float-sm-end">
                        <li class="breadcrumb-item"><a href="{{ route('products.index') }}">Products</a></li>
                        <li class="breadcrumb-item active">{{ Str::limit($product->name, 30, '...') }}</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <section class="content">
        <div class="container-fluid">
            <div class="card">

                <div class="card-body">
                    <div class="row">
                        <div class="col-md-8">
                            <div class="mb-3">
                                <strong>Name:</strong>
                                <p>{{ $product->name }}</p>
                            </div>

                            <div class="mb-3">
                                <strong>Description:</strong>
                                <p>{{ $product->description }}</p>
                            </div>

                            <div class="mb-3">
                                <strong>Price:</strong>
                                <p>{{ number_format($product->price, 2) }}DT</p>
                            </div>

                            <div class="mb-3">
                                <strong>Stock:</strong>
                                <p>{{ $product->stock }}</p>
                            </div>

                            <div class="mb-3">
                                <strong>Discount:</strong>
                                <p>
                                    @if ($product->discount)
                                        {{ $product->discount }}%
                                    @else
                                        No Discount
                                    @endif
                                </p>
                            </div>

                            <div class="mb-3">
                                <strong>Categories:</strong>
                                <div>
                                    @if ($product->categories && $product->categories->count())
                                        @foreach ($product->categories as $category)
                                            <span class="badge bg-primary me-1">{{ $category->name }}</span>
                                        @endforeach
                                    @else
                                        <span class="text-muted">No Categories</span>
                                    @endif
                                </div>
                            </div>

                            <div class="mb-3">
                                <strong>Created At:</strong>
                                <p>{{ $product->created_at->format('d M Y, H:i') }}</p>
                            </div>

                            <div class="d-flex">
                                <a href="{{ route('products.edit', $product->id) }}" class="btn btn-warning text-white me-2">Edit Product</a>
                                <a href="{{ route('products.index') }}" class="btn btn-secondary">Back to Product List</a>
                            </div>
                        </div>

                        <div class="col-md-4">
                            @if ($product->image)
                                <img src="{{ asset($product->image) }}" alt="{{ $product->name }}" class="img-fluid rounded">
                            @else
                                <img src="https://via.placeholder.com/300" alt="No Image" class="img-fluid rounded">
                            @endif

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
