@extends('layouts.base')

@section('content')
<div class="d-flex justify-content-center align-items-center vh-100">
    <div class="row w-75 shadow-lg rounded overflow-hidden" style="max-height: 90vh;">
        <!-- Form Section -->
        <div class="col-md-6 bg-white p-4">
            <h2 class="text-center mb-4 fw-bold">Sign Up</h2>
            <form action="{{ route('register.submit') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label class="form-label">Full Name</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="fa fa-user"></i></span>
                        <input type="text" name="name" class="form-control" required placeholder="Enter your full name">
                    </div>
                </div>
                
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

                <div class="mb-3">
                    <label class="form-label">Confirm Password</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="fa fa-lock"></i></span>
                        <input type="password" name="password_confirmation" class="form-control" required placeholder="Confirm your password">
                    </div>
                </div>

                <button type="submit" class="btn btn-primary w-100 fw-bold">Sign Up</button>
            </form>

            <p class="mt-3 text-center">
                Already have an account? <a href="{{ route('login.show') }}">Login</a>
            </p>
        </div>

        <!-- Image Section -->
        <div class="col-md-6 d-none d-md-block p-0">
            <img src="{{ asset('assets/img/login.jpg') }}" alt="Register Banner"
                class="img-fluid h-100 w-100 object-fit-cover">
        </div>
    </div>
</div>
@endsection
