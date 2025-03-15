@extends('layouts.base')

@section('content')
    <div class="container">
        <h2><i class="fa fa-shopping-cart"></i> Your Cart</h2>
        <table class="table">
            <thead>
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
        <h4>Total: <span class="cart-total">0.00 TND</span> </h4>
        <button class="btn btn-success" id="place-order" data-url="{{ route('order.store') }}">
            Order
        </button>
    </div>
@endsection
