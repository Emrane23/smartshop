<!-- navbar.php -->
<nav class="navbar navbar-default navbar-fixed-top" role="navigation">
    <div class="container-fluid">
        <!-- Brand and toggle -->
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#navbar-content">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="{{ route('home') }}"><strong>Chick Deco & Cadeaux</strong></a>
        </div>

        <!-- Menu -->
        <div class="collapse navbar-collapse" id="navbar-content">
            <ul class="nav navbar-nav navbar-right">
                <li><a href="{{ route('home') }}">Home</a></li>
                <li><a href="{{ route('about') }}">About</a></li>

                @guest('web')
                    @guest('customer')
                        <li><a href="#">Signup</a></li>
                        <li><a href="{{ route('login.show') }}">Login</a></li>
                    @endguest
                @endguest

                @auth('web')
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                            {{ Auth::user()->name }} <b class="caret"></b>
                        </a>
                        <ul class="dropdown-menu">
                            <li><a href="{{ route('dashboard.home') }}">Dashboard</a></li>
                            <li>
                                <form action="{{ route('logout') }}" method="POST">
                                    @csrf
                                    <button type="submit" class="btn btn-link p-0">Logout</button>
                                </form>
                            </li>
                        </ul>
                    </li>
                @endauth

                @auth('customer')
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                            {{ Auth::guard('customer')->user()->name }} <b class="caret"></b>
                        </a>
                        <ul class="dropdown-menu">
                            <li><a href="{{ route('customer.area') }}">Customer Area</a></li>
                            <li>
                                <form action="{{ route('logout') }}" method="POST">
                                    @csrf
                                    <button type="submit" class="btn btn-link p-0">Logout</button>
                                </form>
                            </li>
                        </ul>
                    </li>
                @endauth

                <!-- Cart Icon with Badge -->
                <li class="nav-item">
                    <a class="nav-link" href="#" id="cart-icon">
                        <i class="fa fa-shopping-cart"></i> Cart <span class="badge badge-pill badge-danger"
                            id="cart-count">0</span>
                    </a>
                </li>
            </ul>
        </div>
    </div>
</nav>

<!-- Panneau latéral (Off-canvas) pour le panier -->
<div id="cartSidebar" class="cart-sidebar">
    <div class="cart-header">
        <h4><i class="fa fa-shopping-cart"></i> Your Cart</h4>
        <button class="close-btn" onclick="closeCarte()">&times;</button>
    </div>
    <div class="cart-content">
        <ul id="cart-items">
            <li>Your cart is empty</li>
        </ul>
    </div>
    <div class="cart-footer">
        <h5>Total: <span class="cart-total">0.00 TND</span> </h5>
        <a href="{{ route('cart.show') }}" class="btn btn-success btn-lg btn-block">Checkout</a>
    </div>
</div>