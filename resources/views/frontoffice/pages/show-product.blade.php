@extends('layouts.base')

@section('content')
<div class="container py-4">
    <!-- Breadcrumb -->
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
            <li class="breadcrumb-item active" aria-current="page">{{ $product->name }}</li>
        </ol>
    </nav>

    <div class="row g-4">
        <!-- Product Details -->
        <div class="col-lg-9">
            <div class="card shadow-sm">
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-md-5 text-center position-relative">
                            <!-- Badge Offre Spéciale -->
                            @if ($product->discount)
                                <img src="{{ asset('assets/img/offre-special.png') }}" alt="Special Offer" class="offer-badge">
                            @endif
                            <img src="{{ url($product->image) }}" alt="{{ $product->name }}" class="img-fluid rounded">
                            <p class="small fw-bold mt-2 text-black">
                                Free <span class="text-danger fs-6">Shipping</span> on orders over 300DT
                            </p>
                        </div>

                        <div class="col-md-7">
                            <h2 class="fw-bold">{{ $product->name }}</h2>

                            <!-- Gestion du prix avec réduction -->
                            @if ($product->discount)
                                @php
                                    $newPrice = $product->price - ($product->price * $product->discount) / 100;
                                @endphp
                                <p class="fw-bold text-muted text-decoration-line-through">{{ $product->price }} Dt</p>
                                <p class="fw-bold text-warning">{{ number_format($newPrice, 2) }} Dt (-{{ $product->discount }}%)</p>
                            @else
                                <p class="fw-bold text-danger">{{ $product->price }} Dt</p>
                            @endif

                            @if ($product->stock > 0)
                                <span class="badge bg-success">In stock</span>
                                <br><br>
                                <button class="btn btn-primary btn-lg add-to-cart" 
                                    data-id="{{ $product->id }}"
                                    data-name="{{ $product->name }}"
                                    data-price="{{ $product->price }}"
                                    data-image="{{ url($product->image) }}"
                                    data-discount="{{ $product->discount }}">
                                    <i class="fa fa-shopping-cart"></i> Add to Cart
                                </button>
                            @else
                                <span class="badge bg-danger">Out of stock</span>
                            @endif
                        </div>
                    </div>

                    <hr>
                    <h4>Description</h4>
                    <p>{{ $product->description }}</p>
                </div>
            </div>
        </div>

        <!-- Other Products -->
        <div class="col-lg-3">
            <h4 class="text-center fw-bold">Other Products</h4>
            <hr>

            @foreach ($otherProducts as $other)
                <div class="d-flex align-items-center mb-3 position-relative">
                    <!-- Badge Offre Spéciale -->
                    @if ($other->discount)
                        <img src="{{ asset('assets/img/offre-special.png') }}" alt="Special Offer" class="offer-badge-small">
                    @endif
                    
                    <img src="{{ url($other->image) }}" alt="{{ $other->name }}" class="rounded" style="width: 70px; height: auto;">
                    <div class="ms-3">
                        <h6 class="mb-1">
                            <a href="{{ route('frontoffice.products.show', ['id' => $other->id]) }}" class="text-decoration-none">{{ $other->name }}</a>
                        </h6>

                        <!-- Gestion du prix avec réduction -->
                        @if ($other->discount)
                            @php
                                $newOtherPrice = $other->price - ($other->price * $other->discount) / 100;
                            @endphp
                            <p class="fw-bold text-muted text-decoration-line-through mb-0">{{ $other->price }} Dt</p>
                            <p class="fw-bold text-warning mb-0">{{ number_format($newOtherPrice, 2) }} Dt (-{{ $other->discount }}%)</p>
                        @else
                            <p class="fw-bold text-success mb-0">{{ $other->price }} Dt</p>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>
@endsection
