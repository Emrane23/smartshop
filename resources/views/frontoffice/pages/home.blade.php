@extends('layouts.base')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="well well-lg offer-box text-center">
                Welcome To Chick Deco & Cadeaux
            </div>
            <br />
        </div>
    </div>

    <div class="row">
        <!-- Liste des produits avec une bordure à droite -->
        <div class="col-md-9" style="border-right: 1px solid #ddd; padding-right: 20px;">
            <div>
                <ol class="breadcrumb">
                    <li><a href="{{ route('home') }}">Home</a></li>
                </ol>
            </div>
            <div class="row">
                @foreach ($products as $product)
                    <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12 text-center">
                        <div class="thumbnail product-box">
                            <img src="{{ $product->image }}" alt="{{ $product->name }}"
                                style="width: 166px; height: 166px;" />
                            <div class="caption">
                                <h3><a href="#">
                                        {{ $product->name }}
                                    </a></h3>
                                <p><strong>Description:</strong> {{ Str::limit($product->description, 50, ' ...') }}
                                </p>
                                <p><strong>Price:</strong>
                                    {{ $product->price }} Dt</p>
                                <p><small>Created at:
                                        {{ $product->created_at->translatedFormat('M d, Y') }}
                                    </small></p>
                                <p><a href="#" class="btn btn-primary" role="button">See Details</a></p>
                            </div>
                        </div>
                    </div>
                @endforeach

                <div class="col-md-12 text-center">
                    {{ $products->links() }}
                </div>
                <hr>
            </div>
        </div>

        <!-- Suggestions en slider (Bootstrap 3.1) -->
        <div class="col-md-3">
            <h4 class="text-center">Suggestions</h4>
            <hr>
            <div id="suggestionsCarousel" class="carousel slide" data-ride="carousel">
                <div class="carousel-inner">
                    <div class="item active">
                        <div class="offer-text">
                            30% off here
                        </div>
                        <div class="thumbnail product-box text-center">
                            <img src="assets/img/dummyimg.png" alt="Produit 1"
                                class="img-responsive suggestions-carousel" />
                            <div class="caption">
                                <h5><a href="#">Produit 1</a></h5>
                            </div>
                        </div>
                    </div>
                    <div class="item">
                        <div class="offer-text">
                            Special Offer!
                        </div>
                        <div class="thumbnail product-box text-center">
                            <img src="assets/img/dummyimg.png" alt="Produit 2"
                                class="img-responsive suggestions-carousel" />
                            <div class="caption">
                                <h5><a href="#">Produit 2</a></h5>
                            </div>
                        </div>
                    </div>
                    <div class="item">
                        <div class="offer-text">
                            Limited Time Deal!
                        </div>
                        <div class="thumbnail product-box text-center">
                            <img src="assets/img/dummyimg.png" alt="Produit 3"
                                class="img-responsive suggestions-carousel" />
                            <div class="caption">
                                <h5><a href="#">Produit 3</a></h5>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Contrôles du slider -->
                <a class="left carousel-control" href="#suggestionsCarousel" data-slide="prev">
                    <span class="glyphicon glyphicon-chevron-left"></span>
                </a>
                <a class="right carousel-control" href="#suggestionsCarousel" data-slide="next">
                    <span class="glyphicon glyphicon-chevron-right"></span>
                </a>
            </div>
        </div>


    </div>
@endsection
