@extends('layouts.base')

@section('content')
<div class="d-flex justify-content-center align-items-center vh-100">
    <div class="row w-75 shadow-lg rounded overflow-hidden" style="max-height: 90vh;">
        <!-- Form Section -->
        <div class="col-md-6 bg-white p-4">
            <h2 class="text-center mb-4 fw-bold">Sign In</h2>
            <form action="{{ route('login.submit') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label class="form-label">Email</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="fa fa-envelope"></i></span>
                        <input type="email" name="email" class="form-control" required placeholder="Enter your email">
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label">Password</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="fa fa-lock"></i></span>
                        <input type="password" name="password" class="form-control" required placeholder="Enter your password">
                    </div>
                </div>

                <button type="submit" class="btn btn-primary w-100 fw-bold">Login</button>
            </form>

            <p class="mt-3 text-center">
                You don't have an account? <a href="{{ route('register.show') }}">Sign Up</a>
            </p>
        </div>

        <!-- Image Section -->
        <div class="col-md-6 d-none d-md-block p-0">
            <img src="{{ asset('assets/img/login.jpg') }}" alt="Login Banner"
                class="img-fluid h-100 w-100 object-fit-cover">
        </div>
    </div>
</div>
@endsection
