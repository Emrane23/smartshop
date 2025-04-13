@extends('layouts.base')

@section('content')
    <div class="container py-4">
        <div class="row">
            <div class="col-md-3 mb-4">
                <h5 class="mb-3 text-center">📁 Categories</h5>
                <div class="d-flex flex-wrap gap-2 justify-content-center">
                    @foreach ($categories as $category)
                        <a href="{{ route('home', ['category' => $category->id]) }}"
                            class="btn btn-sm {{ $category_id == $category->id ? 'btn-primary' : 'btn-outline-secondary' }}">
                            {{ Str::limit($category->name, 20) }}
                        </a>
                    @endforeach
                </div>
            </div>



            <!-- ✅ Produits principaux -->
            <div class="col-md-9">

                @if ($category_id)
                    <h4 class="mb-4">
                        Result For:
                        <span class="text-primary">
                            {{ optional($categories->firstWhere('id', $category_id))->name }}
                        </span>
                    </h4>
                @endif

                <div class="row g-4">
                    @foreach ($products as $product)
                        <div class="col-md-6">
                            <div class="card h-100 shadow-sm">
                                @if ($product->discount)
                                    <svg class="offer-badge" viewBox="0 0 100 100" xmlns="http://www.w3.org/2000/svg">
                                        <circle cx="50" cy="50" r="48" fill="#ff4757" stroke="white"
                                            stroke-width="4" />
                                        <text x="50%" y="55%" text-anchor="middle" fill="white" font-size="18"
                                            font-family="Arial" font-weight="bold">
                                            -{{ $product->discount }}%
                                        </text>
                                    </svg>
                                @endif
                                <img src="{{ url($product->image) }}" alt="{{ $product->name }}" class="card-img-top"
                                    style="height: 180px; object-fit: cover;">
                                <div class="card-body">
                                    <h6 class="card-title">
                                        <a href="{{ route('frontoffice.products.show', ['id' => $product->id]) }}"
                                            class="text-decoration-none">
                                            {{ Str::limit($product->name, 40) }}
                                        </a>
                                    </h6>
                                    <p class="small text-muted">{{ Str::limit($product->description, 50) }}</p>

                                    @if ($product->discount)
                                        @php
                                            $newPrice = $product->price - ($product->price * $product->discount) / 100;
                                        @endphp
                                        <p class="fw-bold text-danger text-decoration-line-through">
                                            {{ number_format($product->price, 2) }} DT
                                        </p>
                                        <p class="fw-bold text-success">
                                            {{ number_format($newPrice, 2) }} DT ({{ $product->discount }}%)
                                        </p>
                                    @else
                                        <p class="fw-bold text-primary">{{ number_format($product->price, 2) }} DT</p>
                                    @endif

                                    <a href="{{ route('frontoffice.products.show', ['id' => $product->id]) }}"
                                        class="btn btn-outline-primary btn-sm mt-2 w-100">See Details</a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Pagination -->
                <div class="text-center mt-4">
                    {{ $products->links() }}
                </div>

            </div>
        </div>
        <div class="row">
            @if ($recommended_products->count())
                <div class="mt-5">
                    <h4 class="text-center mb-4">🎁 Suggestions For You</h4>

                    <div id="suggestion-splide" class="splide">
                        <div class="splide__track">
                            <ul class="splide__list">
                                @foreach ($recommended_products as $suggestion)
                                    <li class="splide__slide">
                                        <div class="card shadow-sm mx-2" style="min-width: 230px;">
                                            @if ($suggestion->discount)
                                                <img src="{{ asset('assets/img/offre-special.png') }}" alt="Special Offer"
                                                    class="offer-badge">
                                            @endif
                                            <img src="{{ url($suggestion->image ?? 'img/products/default-product-image.jpg') }}"
                                                class="card-img-top" style="height: 140px; object-fit: cover;">
                                            <div class="card-body p-2">
                                                <h6 class="card-title mb-2">
                                                    <a href="{{ route('frontoffice.products.show', ['id' => $suggestion->id]) }}"
                                                        class="text-decoration-none">
                                                        {{ Str::limit($suggestion->name, 10) }}
                                                    </a>
                                                </h6>
                                            </div>
                                        </div>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
    @push('scripts')
        <!-- Splide JS -->
        <script src="https://cdn.jsdelivr.net/npm/@splidejs/splide@4.1.3/dist/js/splide.min.js"></script>

        <script>
            document.addEventListener('DOMContentLoaded', function() {
                new Splide('#suggestion-splide', {
                    type: 'loop',
                    perPage: 4,
                    gap: '1rem',
                    pagination: false,
                    arrows: true,
                    breakpoints: {
                        992: {
                            perPage: 2,
                        },
                        576: {
                            perPage: 1,
                        }
                    }
                }).mount();
            });
        </script>
    @endpush
@endsection
