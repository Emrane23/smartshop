@extends('layouts.base')

@section('content')
    <div class="container">
        <!-- Breadcrumb -->
        <ol class="breadcrumb">
            <li><a href="{{ route('home') }}">Home</a></li>
            <li class="active">{{ $product->name }}</li>
        </ol>

        <div class="row">
            <div class="col-md-8">
                <div class="panel panel-default">
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-md-5 text-center">
                                <img src="{{ url($product->image) }}" alt="{{ $product->name }}" class="img-responsive"
                                    style="max-width: 100%; height: auto;">
                                    <p style="font-size: 11px; font-weight: bold; margin: 5px 0; color: black;">
                                        Free <span style="color: #d80101; font-size: 13px;">Shipping</span> on orders over 300DT
                                    </p>
                            </div>

                            <div class="col-md-7">
                                <h2>{{ $product->name }}</h2>
                                <h3 class="text-danger">{{ $product->price }} Dt</h3>

                                @if ($product->stock > 0)
                                    <span class="label label-success">In stock</span>
                                    <br><br>
                                    <button class="btn btn-success add-to-cart" data-id="{{ $product->id }}"
                                        data-name="{{ $product->name }}" data-price="{{ $product->price }}"
                                        data-image="{{ url($product->image) }}">
                                        <i class="fa fa-shopping-cart"></i> Add to Cart
                                    </button>
                                @else
                                    <span class="label label-danger">Out of stock</span>
                                @endif

                            </div>
                            
                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <hr>
                                <h4>Description</h4>
                                <p>{{ $product->description }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <h4 class="text-center">Other Products</h4>
                <hr>

                @foreach ($otherProducts as $other)
                    <div class="row" style="margin-bottom: 15px;">
                        <div class="col-xs-4">
                            <img src="{{ url($other->image) }}" alt="{{ $other->name }}" class="img-responsive"
                                style="max-width: 70px; height: auto;">
                        </div>

                        <div class="col-xs-8">
                            <h5><a href="{{ route('frontoffice.products.show', ['id' => $other->id]) }}">{{ $other->name }}</a></h5>
                            <p class="text-success"><strong>{{ $other->price }} Dt</strong></p>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
@endsection
