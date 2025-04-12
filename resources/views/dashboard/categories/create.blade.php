@extends('layouts.admin')

@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Add New Category</h1>
                </div>
                <div class="col-sm-6 text-end">
                    <ol class="breadcrumb float-sm-end">
                        <li class="breadcrumb-item"><a href="{{ route('categories.index') }}">Categories</a></li>
                        <li class="breadcrumb-item active">Add Category</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <section class="content">
        <div class="container-fluid">

            <div class="card">

                <div class="card-body">
                    <form action="{{ route('categories.store') }}" method="POST">
                        @csrf

                        <div class="mb-3">
                            <label for="name" class="form-label">Category Name</label>
                            <input type="text" class="form-control" id="name" name="name" value="{{ old('name') }}" required>
                        </div>

                        <div class="mb-3">
                            <label for="slug" class="form-label">Slug</label>
                            <input type="text" class="form-control" id="slug" name="slug" value="{{ old('slug') }}" placeholder="e.g. electronics-accessories" required>
                        </div>

                        <div class="mb-3">
                            <label for="description" class="form-label">Category Description</label>
                            <textarea class="form-control" id="description" name="description" rows="4">{{ old('description') }}</textarea>
                        </div>

                        <button type="submit" class="btn btn-success">Create Category</button>
                    </form>
                </div>
            </div>

        </div>
    </section>
@endsection

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
