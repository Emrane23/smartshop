@extends('layouts.base')

@section('content')
<div class="container py-5">
    <h2 class="fw-bold mb-4"><i class="fa fa-shopping-cart me-2"></i> Your Cart</h2>

    <div id="cart-list" class="row g-4">
        <!-- Items will be dynamically injected here -->
    </div>

    <div class="row mt-5 justify-content-end">
        <div class="col-md-6">
            <div class="card shadow-sm border-0 p-4">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h4 class="fw-bold mb-0">🧾 Total:</h4>
                    <h4 class="cart-total text-danger fw-bold mb-0">0.00 TND</h4>
                </div>
                <button class="btn btn-success btn-lg w-100" id="place-order" data-url="{{ route('order.store') }}">
                    <i class="fa fa-credit-card me-2"></i> Place Order
                </button>
            </div>
        </div>
    </div>
</div>
@endsection
