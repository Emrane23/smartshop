@extends('layouts.admin')

@section('content')
    <div class="container-fluid px-4">
        <div class="d-flex justify-content-between align-items-center mt-4 mb-4">
            <div>
                <h1 class="mt-4">Product List</h1>
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item active">Products</li>
                </ol>
            </div>
            <a href="{{ route('products.create') }}" class="btn btn-primary shadow-sm">
                <i class="fas fa-plus me-2"></i> Add Product
            </a>
        </div>

        <div class="card mb-4">
            <div class="card-header">
                <i class="fas fa-table me-1"></i>
                Products List
            </div>
            <div class="card-body">
                <table id="datatablesSimple" class="table table-bordered">
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
                    <tfoot>
                        <tr>
                            <th>Image</th>
                            <th>Price</th>
                            <th>Discount</th>
                            <th>Stock</th>
                            <th>Actions</th>
                        </tr>
                    </tfoot>
                    <tbody>
                        @foreach ($products as $product)
                            <tr>
                                <td>
                                    @if ($product->image)
                                        <img src="{{ url($product->image) }}" alt="Product Image" class="img-thumbnail"
                                            width="50">
                                    @else
                                        <span>No Image</span>
                                    @endif
                                </td>

                                <td>{{ $product->name }}</td>
                                <td>{{ $product->price }}</td>
                                <td>
                                    @if ($product->discount)
                                        {{ $product->discount }}%
                                    @else
                                        No Discount
                                    @endif
                                </td>
                                <td>{{ $product->stock }}</td>
                                <td>
                                    <a href="{{ route('products.show', ['product' => $product]) }}"
                                        class="btn btn-info btn-sm text-white">Show</a>
                                    <a href="{{ route('products.edit', ['product' => $product]) }}"
                                        class="btn btn-primary btn-sm">Edit</a>
                                    <form action="{{ route('products.destroy', $product->id) }}" method="POST"
                                        class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm"
                                            onclick="return confirm('Are you sure you want to delete the product {{ $product->name }}?')">Delete</button>
                                    </form>
                                </td>
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
