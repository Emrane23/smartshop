@extends('layouts.base')

@section('content')
<div class="d-flex justify-content-center align-items-center vh-100">
    <div class="col-md-5">
        <div class="card shadow-lg p-4">
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
    </div>
</div>
@endsection
