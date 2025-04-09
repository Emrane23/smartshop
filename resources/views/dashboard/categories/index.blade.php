@extends('layouts.admin')

@section('content')
    <div class="container-fluid px-4">
        <div class="d-flex justify-content-between align-items-center mt-4 mb-4">
            <div>
                <h1 class="mt-4">Category List</h1>
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item active">Categories</li>
                </ol>
            </div>
            <a href="{{ route('categories.create') }}" class="btn btn-primary shadow-sm">
                <i class="fas fa-plus me-2"></i> Add Category
            </a>
        </div>

        <div class="card mb-4">
            <div class="card-header">
                <i class="fas fa-tags me-1"></i>
                Categories List
            </div>
            <div class="card-body">
                <table id="datatablesSimple" class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Created At</th>
                            <th>Products Count</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th>Name</th>
                            <th>Created At</th>
                            <th>Products Count</th>
                            <th>Actions</th>
                        </tr>
                    </tfoot>
                    <tbody>
                        @foreach ($categories as $category)
                            <tr>
                                <td>{{ Str::limit($category->name, 50) }}</td>
                                <td>{{ $category->created_at->format('Y-m-d') }}</td>
                                <td>{{ $category->products()->count() }}</td>
                                <td>
                                    <a href="{{ route('categories.edit', $category) }}"
                                        class="btn btn-primary btn-sm">Edit</a>
                                    <form action="{{ route('categories.destroy', $category) }}" method="POST"
                                        class="d-inline"
                                        onsubmit="return confirm('Are you sure you want to delete this category?')">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-danger btn-sm">Delete</button>
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