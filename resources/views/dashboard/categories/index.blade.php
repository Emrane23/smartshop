@extends('layouts.admin')

@section('content')
    <div class="container-fluid px-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="mt-4">Categories List</h1>
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">Dashboard</a></li>
                <li class="breadcrumb-item active">Categories</li>
            </ol>
        </div>

        <div class="card mb-4">
            <div class="card-header">
                <i class="fas fa-list me-1"></i>
                Categories
                <a href="{{ route('categories.create') }}" class="btn btn-success float-end">
                    <i class="fas fa-plus-circle"></i> Add New Category
                </a>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Name</th>
                                <th>Slug</th>
                                <th>Description</th>
                                <th>Created At</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($categories as $category)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $category->name }}</td>
                                    <td>{{ $category->slug }}</td>
                                    <td>{{ Str::limit($category->description, 50) }}</td>
                                    <td>{{ $category->created_at->format('d M Y') }}</td>
                                    <td>
                                        <a href="{{ route('categories.edit', $category->id) }}" class="btn btn-warning btn-sm">
                                            <i class="fas fa-edit"></i> Edit
                                        </a>
                                        <form action="{{ route('categories.destroy', $category->id) }}" method="POST" class="d-inline-block">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this category?')">
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
            @if ($categories->hasPages())
            <div class="card-footer clearfix">
                {{ $categories->links('pagination::bootstrap-5') }}
            </div>
        @endif
        </div>
    </div>
@endsection
