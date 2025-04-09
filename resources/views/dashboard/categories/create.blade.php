@extends('layouts.admin')

@section('content')
<div class="container-fluid px-4">
    <h1 class="mt-4">Create Category</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="{{ route('categories.index') }}">Categories</a></li>
        <li class="breadcrumb-item active">Create Category</li>
    </ol>

    <div class="card mb-4">
        <div class="card-header">
            <i class="fas fa-plus me-1"></i>
            Add New Category
        </div>
        <div class="card-body">
            <form action="{{ route('categories.store') }}" method="POST">
                @csrf

                <div class="mb-3">
                    <label for="name" class="form-label">Name</label>
                    <input 
                        type="text" 
                        class="form-control" 
                        id="name" 
                        name="name" 
                        value="{{ old('name') }}" 
                        required>
                </div>

                <div class="mb-3">
                    <label for="slug" class="form-label">Slug</label>
                    <input 
                        type="text" 
                        class="form-control" 
                        id="slug" 
                        name="slug" 
                        value="{{ old('slug') }}" 
                        placeholder="e.g. electronics-accessories" 
                        required>
                </div>

                <div class="mb-3">
                    <label for="description" class="form-label">Description</label>
                    <textarea 
                        class="form-control" 
                        id="description" 
                        name="description" 
                        rows="4"
                    >{{ old('description') }}</textarea>
                </div>

                <button type="submit" class="btn btn-success">Create Category</button>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
    document.addEventListener("DOMContentLoaded", function () {
        const nameInput = document.getElementById("name");
        const slugInput = document.getElementById("slug");

        nameInput.addEventListener("input", function () {
            const slug = nameInput.value
                .toLowerCase()
                .trim()
                .replace(/[^a-z0-9\s-]/g, '')
                .replace(/\s+/g, '-')         
                .replace(/-+/g, '-');   
            slugInput.value = slug;
        });
    });
</script>
@endpush

@endsection
