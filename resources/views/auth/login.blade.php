@extends('layouts.base')
@section('content')
    <div class="row" style="display: flex; justify-content: center;">
        <div class="col-md-6">
            <h2 class="text-center">Create account</h2>
            <form method="POST">
                <div class="form-group">
                    <label>Email:</label>
                    <input type="email" name="email" class="form-control" required>
                </div>
                <div class="form-group">
                    <label>Password:</label>
                    <input type="password" name="password" class="form-control" required>
                </div>
                <button type="submit" class="btn btn-primary btn-block">Login</button>
            </form>
            <p class="mt-3 text-center">You don't have an account? <a href="#">Sign Up</a></p>

        </div>
    </div>
@endsection
