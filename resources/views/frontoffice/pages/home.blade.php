@extends('layouts.base')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="alert alert-primary text-center" role="alert">
                Welcome To Chick Deco & Cadeaux
            </div>
            <br />
        </div>
    </div>

    <div class="row">
        <!-- Liste des produits -->
        <div class="col-md-9 border-end pe-4">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                </ol>
            </nav>

            <div class="row g-4">
                @foreach ($products as $product)
                    <div class="col-lg-4 col-md-6 text-center">
                        <div class="card h-100 shadow-sm position-relative">
                            @if ($product->discount)
                                <img src="{{ asset('assets/img/offre-special.png') }}" alt="Special Offer"
                                    class="offer-badge">
                            @endif
                            <img src="{{ url($product->image) }}" alt="{{ $product->name }}" class="card-img-top"
                                style="width: 100%; height: 200px; object-fit: cover;">
                            <div class="card-body">
                                <h5 class="card-title">
                                    <a href="{{ route('frontoffice.products.show', ['id' => $product->id]) }}"
                                        class="text-decoration-none">
                                        {{ Str::limit($product->name, 50, ' ...') }}
                                    </a>
                                </h5>

                                <p class="card-text">{{ Str::limit($product->description, 50, ' ...') }}</p>

                                @if ($product->discount)
                                    @php
                                        $newPrice = $product->price - ($product->price * $product->discount) / 100;
                                    @endphp
                                    <p class="fw-bold text-danger text-decoration-line-through">
                                        {{ number_format($product->price, 2) }} Dt</p>
                                    <p class="fw-bold text-warning">{{ number_format($newPrice, 2) }} Dt
                                        (-{{ number_format($product->discount, 2) }}%)
                                    </p>
                                @else
                                    <p class="fw-bold text-danger">{{ number_format($product->price, 2) }} Dt</p>
                                @endif

                                <x-rating-summary :rating="$product->ratings()->avg('rating')" :totalReviews="$product->ratings()->count()" :productId="$product->id" :displaytotalReviews="true"
                                    :displayReviewsText="false" :disableJs="true" :displayChevron="false" :displayAverageRatings="false" :dFlex="false" />

                                <a href="{{ route('frontoffice.products.show', ['id' => $product->id]) }}"
                                    class="btn btn-primary">See Details</a>
                            </div>

                        </div>
                    </div>
                @endforeach
            </div>

            <div class="col-md-12 text-center mt-4">
                {{ $products->links() }}
            </div>
        </div>

        <!-- Suggestions -->
        <div class="col-md-3">
            <h4 class="text-center">Suggestions</h4>
            <hr>
            <div id="suggestionsCarousel" class="carousel slide" data-bs-ride="carousel" data-bs-interval="3000">
                <div class="carousel-inner">
                    @foreach ($recommended_products as $index => $suggestion)
                        <div class="carousel-item {{ $index == 0 ? 'active' : '' }}">
                            <div class="card text-center mt-2 position-relative">
                                @if ($suggestion->discount)
                                    <img src="{{ asset('assets/img/offre-special.png') }}" alt="Special Offer"
                                        class="offer-badge">
                                @endif
                                <img src="{{ url($suggestion->image ?? 'img/products/default-product-image.jpg') }}"
                                    alt="{{ $suggestion->name }}" class="card-img-top"
                                    style="height: 180px; object-fit: cover;">
                                <div class="card-body">
                                    <h6 class="card-title">
                                        <a href="{{ route('frontoffice.products.show', ['id' => $suggestion->id]) }}"
                                            class="text-decoration-none">
                                            {{ $suggestion->name }}
                                        </a>
                                    </h6>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <button class="carousel-control-prev" type="button" data-bs-target="#suggestionsCarousel"
                    data-bs-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                </button>
                <button class="carousel-control-next" type="button" data-bs-target="#suggestionsCarousel"
                    data-bs-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                </button>
            </div>
        </div>
    </div>
@endsection
