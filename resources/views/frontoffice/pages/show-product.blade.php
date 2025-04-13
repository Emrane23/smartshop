@extends('layouts.base')

@section('content')
    <div class="container py-4">
        <!-- Breadcrumb -->
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb bg-light rounded px-3 py-2 shadow-sm">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                <li class="breadcrumb-item active" aria-current="page">{{ Str::limit($product->name, 50, ' ...') }}</li>
            </ol>
        </nav>

        <div class="row g-5 align-items-start">
            <!-- Product Image & Info -->
            <div class="col-lg-9">
                <div class="card shadow-sm p-4">
                    <div class="row g-4">
                        <!-- Image -->
                        <div class="col-md-5 text-center position-relative">
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
                            <img src="{{ url($product->image) }}" alt="{{ $product->name }}"
                                class="img-fluid rounded shadow">
                            <p class="small text-muted mt-3">
                                🚚 Free shipping on orders over 300DT
                            </p>
                        </div>

                        <!-- Details -->
                        <div class="col-md-7">
                            <h5 class="fw-bold mb-3">{{ $product->name }}</h5>

                            @if ($product->discount)
                                @php $newPrice = $product->price - ($product->price * $product->discount) / 100; @endphp
                                <p class="text-muted text-decoration-line-through">{{ $product->price }} DT</p>
                                <p class="fs-4 fw-semibold text-warning">
                                    {{ number_format($newPrice, 2) }} DT
                                    <span class="badge bg-danger ms-2">-{{ $product->discount }}%</span>
                                </p>
                            @else
                                <p class="fs-4 fw-semibold text-danger">{{ $product->price }} DT</p>
                            @endif

                            <p class="mt-3">
                                @if ($product->stock > 0)
                                    <span class="badge bg-success">✔ In stock</span>
                                @else
                                    <span class="badge bg-danger">❌ Out of stock</span>
                                @endif
                            </p>

                            @if ($product->stock > 0)
                                <button class="btn btn-primary btn-lg mt-3 add-to-cart" data-id="{{ $product->id }}"
                                    data-name="{{ $product->name }}" data-price="{{ $product->price }}"
                                    data-image="{{ url($product->image) }}" data-discount="{{ $product->discount }}">
                                    <i class="fa fa-shopping-cart me-2"></i> Add to Cart
                                </button>
                            @endif

                        </div>
                        <hr class="my-4">

                        <h5>Description</h5>
                        <p class="text-muted">{{ $product->description }}</p>
                    </div>
                </div>
            </div>

            <!-- Other Products -->
            <div class="col-lg-3">
                <h4 class="text-center fw-bold mb-3">You may also like</h4>
                <div class="vstack gap-3">
                    @foreach ($otherProducts as $other)
                        @php
                            $newOtherPrice = $other->price - ($other->price * $other->discount) / 100;
                        @endphp
                        <a href="{{ route('frontoffice.products.show', $other->id) }}"
                            class="d-flex text-decoration-none bg-white p-2 rounded shadow-sm align-items-center small hover-shadow position-relative">
                            @if ($other->discount)
                                <svg class="offer-badge-small" viewBox="0 0 100 100" xmlns="http://www.w3.org/2000/svg">
                                    <circle cx="50" cy="50" r="48" fill="#ff4757" stroke="white"
                                        stroke-width="4" />
                                    <text x="50%" y="55%" text-anchor="middle" fill="white" font-size="20"
                                        font-family="Arial" font-weight="bold">
                                        -{{ $other->discount }}%
                                    </text>
                                </svg>
                            @endif
                            <img src="{{ url($other->image) }}" class="rounded" style="width: 60px;"
                                alt="{{ $other->name }}">
                            <div class="ms-3">
                                <div class="fw-semibold text-dark">{{ Str::limit($other->name, 35) }}</div>
                                @if ($other->discount)
                                    <small class="text-muted text-decoration-line-through">{{ $other->price }}
                                        DT</small><br>
                                    <span class="text-warning fw-bold">{{ number_format($newOtherPrice, 2) }} DT</span>
                                @else
                                    <span class="text-danger fw-bold">{{ $other->price }} DT</span>
                                @endif
                            </div>
                        </a>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
@endsection
