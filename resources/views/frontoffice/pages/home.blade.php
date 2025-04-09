@extends('layouts.base')

@section('content')
    <div class="container">
        <!-- ✅ Message de bienvenue -->
        <div class="row">
            <div class="col-12">
                <div class="alert alert-primary text-center" role="alert">
                    Welcome To Chick Deco & Cadeaux
                </div>
            </div>
        </div>

        <div class="row">
            <!-- ✅ Liste des produits -->
            <div class="col-md-9 border-end pe-4">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                    </ol>
                </nav>

                <div class="row">
                    @if ($category_id)
                        <h4 class="mb-4">
                            Products in category:
                            <span class="text-primary">
                                {{ optional($categories->firstWhere('id', $category_id))->name }}
                            </span>
                        </h4>
                    @endif
                </div>
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

                                    <x-rating-summary :rating="$product->ratings()->avg('rating')" :totalReviews="$product->ratings()->count()" :productId="$product->id"
                                        :displaytotalReviews="true" :displayReviewsText="false" :disableJs="true" :displayChevron="false"
                                        :displayAverageRatings="false" :dFlex="false" />

                                    <a href="{{ route('frontoffice.products.show', ['id' => $product->id]) }}"
                                        class="btn btn-primary">See Details</a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- ✅ Pagination centrée -->
                <div class="col-md-12 text-center mt-4">
                    {{ $products->links() }}
                </div>
            </div>

            <!-- ✅ Suggestions -->
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
                                                {{ Str::limit($suggestion->name, 20, ' ...') }}
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

                <!-- ✅ Liste des catégories -->
                <div class="mb-4 mt-4">
                    <h4 class="text-center">🗂 Browse by Category</h4>
                    <hr>
                    <div style="max-height: 570px; overflow-y: auto;">
                        <ul class="list-group list-group-flush">
                            @foreach ($categories as $category)
                                <li class="list-group-item p-2">
                                    <a href="{{ route('home', ['category' => $category->id]) }}"
                                        class="text-decoration-none {{ $category_id == $category->id ? 'fw-bold text-primary' : '' }}">
                                         {{ $category->name }}
                                     </a>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>


            </div>

        </div>

        <!-- ✅ Section Top Rated (pleine largeur, sous les suggestions) -->
        <div class="row mt-5">
            <div class="col-12">
                <h4 class="text-center mb-4">🔥 Top Rated Products 🔥</h4>
                <div class="row g-4">
                    @if ($topRatedProducts->isNotEmpty())
                        @foreach ($topRatedProducts as $topProduct)
                            <div class="col-lg-3 col-md-4 col-sm-6 text-center">
                                <div class="card h-100 shadow-sm">
                                    <img src="{{ url($topProduct->image ?? 'img/products/default-product-image.jpg') }}"
                                        alt="{{ $topProduct->name }}" class="card-img-top"
                                        style="width: 100%; height: 200px; object-fit: cover;">
                                    <div class="card-body">
                                        <h6 class="card-title">
                                            <a href="{{ route('frontoffice.products.show', ['id' => $topProduct->id]) }}"
                                                class="text-decoration-none">
                                                {{ Str::limit($topProduct->name, 40) }}
                                            </a>
                                        </h6>

                                        <x-rating-summary :rating="$topProduct->ratings_avg_rating" :totalReviews="$topProduct->ratings->count()" :productId="$topProduct->id"
                                            :displaytotalReviews="true" :displayReviewsText="false" :disableJs="true" :displayChevron="false"
                                            :displayAverageRatings="false" :dFlex="false" />

                                        <p class="fw-bold text-danger">{{ number_format($topProduct->price, 2) }} Dt</p>

                                        <a href="{{ route('frontoffice.products.show', ['id' => $topProduct->id]) }}"
                                            class="btn btn-sm btn-primary">See Details</a>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @else
                        <p class="text-muted text-center w-100">No top-rated products available.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
