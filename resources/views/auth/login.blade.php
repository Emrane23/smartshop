@extends('layouts.base')

@section('content')
<div class="d-flex justify-content-center align-items-center vh-100">
    <div class="col-md-5">
        <div class="card shadow-lg p-4">
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
                You don't have an account? <a href="#">Sign Up</a>
            </p>
        </div>
    </div>
</div>
@endsection
