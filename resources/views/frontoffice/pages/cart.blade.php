@extends('layouts.base')

@section('content')
<div class="container py-4">
    <h2 class="fw-bold mb-3 mt-3"><i class="fa fa-shopping-cart"></i> Your Cart</h2>
    
    <table class="table">
        <thead class="table-light">
            <tr>
                <th>Image</th>
                <th>Produit</th>
                <th>Price</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody id="cart-list">
        </tbody>
    </table>

    <h4 class="fw-bold">Total: <span class="cart-total text-danger">0.00 TND</span></h4>

    <button class="btn btn-success btn-lg" id="place-order" data-url="{{ route('order.store') }}">
        <i class="fa fa-credit-card"></i> Order
    </button>
</div>
