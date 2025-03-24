@extends('layouts.base')

@section('content')
    <div class="container py-4">
        <!-- Breadcrumb -->
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                <li class="breadcrumb-item active" aria-current="page"> {{ Str::limit($product->name, 50, ' ...') }}</li>
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
                                    <img src="{{ asset('assets/img/offre-special.png') }}" alt="Special Offer"
                                        class="offer-badge">
                                @endif
                                <img src="{{ url($product->image) }}" alt="{{ $product->name }}" class="img-fluid rounded">
                                <p class="small fw-bold mt-2 text-black">
                                    Free <span class="text-danger fs-6">Shipping</span> on orders over 300DT
                                </p>
                            </div>

                            <div class="col-md-7">
                                <h2 class="fw-bold">{{ $product->name }}</h2>
                                @php
                                    $totalReviews = $product->ratings()->count();
                                @endphp
                                <x-rating-summary :rating="$product->ratings()->avg('rating')" :totalReviews="$totalReviews" :productId="$product->id" :displaytotalReviews="$totalReviews === 0 ? false : true"
                                    :disableJs="$totalReviews === 0 ? true : false" />
                                <!-- Affichage du bouton de notation -->
                                @if (auth()->guard('customer')->check() && $product->canRate(auth()->guard('customer')->user()->id))
                                    @php
                                        $lastOrderId = auth()
                                            ->guard('customer')
                                            ->user()
                                            ->orders()
                                            ->latest()
                                            ->value('id');
                                    @endphp
                                    <button class="btn btn-outline-primary btn-sm mt-2 btn-rate-product"
                                        data-product-id="{{ $product->id }}" data-order-id="{{ $lastOrderId }}"
                                        data-product-name="{{ $product->name }}">
                                        <i class="fa fa-star"></i> Rate this product
                                    </button>
                                @endif

                                @if ($product->discount)
                                    @php
                                        $newPrice = $product->price - ($product->price * $product->discount) / 100;
                                    @endphp
                                    <p class="fw-bold text-danger text-decoration-line-through">{{ $product->price }} Dt</p>
                                    <p class="fw-bold text-warning">{{ number_format($newPrice, 2) }} Dt
                                        (-{{ $product->discount }}%)</p>
                                @else
                                    <p class="fw-bold text-danger">{{ $product->price }} Dt</p>
                                @endif

                                @if ($product->stock > 0)
                                    <span class="badge bg-success">In stock</span>
                                    <br><br>
                                    <button class="btn btn-primary btn-lg add-to-cart" data-id="{{ $product->id }}"
                                        data-name="{{ $product->name }}" data-price="{{ $product->price }}"
                                        data-image="{{ url($product->image) }}" data-discount="{{ $product->discount }}">
                                        <i class="fa fa-shopping-cart"></i> Add to Cart
                                    </button>
                                @else
                                    <span class="badge bg-danger">Out of stock</span>
                                @endif
                                <br>

                            </div>
                        </div>

                        <hr>
                        <h4>Description</h4>
                        <p>{{ $product->description }}</p>
                    </div>
                </div>
                <!-- Section des Témoignages -->
                <div class="card shadow-sm mt-4">
                    <div class="card-body">
                        <h4>Customer Testimonials</h4>
                        <hr>

                        @php
                            $publishedComments = $product->ratings->filter(function ($rating) {
                                return !empty($rating->comment);
                            });
                        @endphp

                        @if ($publishedComments->isNotEmpty())
                            <!-- Flèches de Contrôle au-Dessus du Carousel (si plus d'un commentaire) -->
                            @if ($publishedComments->count() > 1)
                                <div class="d-flex justify-content-center mb-3 gap-2">
                                    <button class="btn btn-link p-2" type="button" data-bs-target="#testimonialsCarousel"
                                        data-bs-slide="prev">
                                        <span class="fa fa-chevron-left fa-lg"></span>
                                    </button>
                                    <button class="btn btn-link p-2" type="button" data-bs-target="#testimonialsCarousel"
                                        data-bs-slide="next">
                                        <span class="fa fa-chevron-right fa-lg"></span>
                                    </button>
                                </div>
                            @endif

                            <!-- Carousel -->
                            <div id="testimonialsCarousel" class="carousel slide" data-bs-ride="carousel">
                                <div class="carousel-inner">
                                    @foreach ($publishedComments as $index => $rating)
                                        <div class="carousel-item {{ $index === 0 ? 'active' : '' }}">
                                            <div class="testimonial">
                                                <div class="d-flex justify-content-between align-items-center">
                                                    <div class="rating">
                                                        @for ($i = 1; $i <= 5; $i++)
                                                            <span
                                                                class="fa fa-star {{ $i <= $rating->rating ? 'text-info' : 'custom-lightgray' }}"></span>
                                                        @endfor
                                                    </div>
                                                    <small
                                                        class="text-muted">{{ $rating->comment->created_at->format('F d, Y') }}</small>
                                                </div>
                                                <p class="testimonial-text mt-2">"{{ $rating->comment->comment }}"</p>
                                                <p class="testimonial-author">
                                                    - {{ $rating->customer->name }}
                                                </p>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @else
                            <p class="text-muted">No reviews yet. Only customers who have purchased this product may leave a
                                review.</p>
                        @endif
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
                            <img src="{{ asset('assets/img/offre-special.png') }}" alt="Special Offer"
                                class="offer-badge-small">
                        @endif

                        <img src="{{ url($other->image) }}" alt="{{ $other->name }}" class="rounded"
                            style="width: 70px; height: auto;">
                        <div class="ms-3">
                            <h6 class="mb-1">
                                <a href="{{ route('frontoffice.products.show', ['id' => $other->id]) }}"
                                    class="text-decoration-none">
                                    {{ Str::limit($other->name, 50, ' ...') }}
                                </a>
                            </h6>

                            <x-rating-summary :rating="$other->ratings()->avg('rating')" :totalReviews="$other->ratings()->count()" :productId="$other->id" :displaytotalReviews="false"
                                :disableJs="true" />

                            @if ($other->discount)
                                @php
                                    $newOtherPrice = $other->price - ($other->price * $other->discount) / 100;
                                @endphp
                                <p class="fw-bold text-danger text-decoration-line-through mb-0">{{ $other->price }} Dt
                                </p>
                                <p class="fw-bold text-warning mb-0">{{ number_format($newOtherPrice, 2) }} Dt
                                    (-{{ $other->discount }}%)
                                </p>
                            @else
                                <p class="fw-bold text-danger mb-0">{{ $other->price }} Dt</p>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    @include('frontoffice.partials.rating_modal')
    @push('scripts')
        <script src="{{ asset('assets/js/rating.js') }}"></script>
    @endpush
@endsection
