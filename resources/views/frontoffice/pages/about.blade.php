@extends('layouts.base')

@section('content')
<div class="container">
    <div class="row d-flex align-items-center py-5">
        <!-- Texte (Colonne gauche) -->
        <div class="col-lg-6 text-center text-lg-start">
            <h2 class="fw-bold mb-4">Who We Are</h2>
            <p class="lead text-secondary">
                We’re more than just a store — we’re a passionate team committed to delivering quality, value, and an exceptional shopping experience.
            </p>
            <p>
                Our goal is simple: offer a curated selection of top-quality products at fair prices, with customer service that truly makes a difference.
            </p>
            <p>
                Whether you're here for the latest trends or everyday essentials, we’re here to help you find exactly what you need — and love the experience along the way.
            </p>
            <p class="fw-semibold text-primary mt-3">
                Thank you for being part of our journey. Let’s grow together.
            </p>
        </div>

        <!-- Image de cover (Colonne droite) -->
        <div class="col-lg-6 text-center">
            <img src="{{ asset('assets/img/about-cover.jpg') }}" alt="About Us" class="img-fluid rounded shadow-lg">
        </div>
    </div>
</div>
@endsection
