@extends('layouts.base')

@section('content')
<div class="container">
    <div class="row d-flex align-items-center py-5">
        <!-- Texte (Colonne gauche) -->
        <div class="col-lg-6 text-center text-lg-start">
            <h2 class="fw-bold">About Us</h2>
            <p class="lead text-secondary">
                Welcome to our platform! We are dedicated to providing high-quality products and services to our customers.
            </p>
            <p>
                Our mission is to bring the best selection of items at competitive prices, ensuring customer satisfaction at every step.
            </p>
            <p>
                Thank you for choosing us. Feel free to explore our products and services!
            </p>
        </div>

        <!-- Image de cover (Colonne droite) -->
        <div class="col-lg-6 text-center">
            <img src="{{ asset('assets/img/about-cover.jpg') }}" alt="About Us" class="img-fluid rounded shadow-lg">
        </div>
    </div>
</div>
@endsection
