@extends('layouts.admin')

@section('content')
    <div class="container-fluid px-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="mt-4">Customers List</h1>
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">Dashboard</a></li>
                <li class="breadcrumb-item active">Customers</li>
            </ol>
        </div>

        <div class="card mb-4">
            <div class="card-header">
                <i class="fas fa-users me-1"></i>
                Customers
            </div>
            <div class="card-body table-responsive p-0">
                <table class="table table-bordered table-hover">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Registered At</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($customers as $customer)
                            <tr>
                                <td>{{ $customer->id }}</td>
                                <td>{{ $customer->name }}</td>
                                <td>{{ $customer->email }}</td>
                                <td>{{ $customer->created_at->format('d M Y') }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center">No customers found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if ($customers->hasPages())
                <div class="card-footer clearfix">
                    {{ $customers->links('pagination::bootstrap-5') }}
                </div>
            @endif
        </div>
    </div>
@endsection
