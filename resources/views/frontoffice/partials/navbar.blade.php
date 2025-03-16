<nav class="navbar navbar-expand-lg navbar-light bg-light fixed-top">
    <div class="container-fluid">
        <!-- Brand and toggle -->
        <a class="navbar-brand" href="{{ route('home') }}">
            <img src="{{ asset('assets/img/logo.png') }}" alt="Chick Deco & Cadeaux" class="img-fluid" style="height: 50px;">
            <strong>Chick Deco & Cadeaux</strong>
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbar-content"
            aria-controls="navbar-content" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <!-- Menu -->
        <div class="collapse navbar-collapse" id="navbar-content">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item">
                    <a class="nav-link {{ Request::routeIs('home') ? 'active' : '' }}" href="{{ route('home') }}">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ Request::routeIs('about') ? 'active' : '' }}" href="{{ route('about') }}">About</a>
                </li>

                @guest('web')
                    @guest('customer')
                        <li class="nav-item">
                            <a class="nav-link {{ Request::routeIs('register.show') ? 'active' : '' }}" href="{{ route('register.show') }}">Signup</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ Request::routeIs('login.show') ? 'active' : '' }}" href="{{ route('login.show') }}">Login</a>
                        </li>
                    @endguest
                @endguest

                @auth('web')
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle {{ Request::routeIs('dashboard.home') ? 'active' : '' }}" href="#" id="userDropdown" role="button"
                            data-bs-toggle="dropdown" aria-expanded="false">
                            {{ Auth::user()->name }}
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
                            <li><a class="dropdown-item {{ Request::routeIs('dashboard.home') ? 'active' : '' }}" href="{{ route('dashboard.home') }}">Dashboard</a></li>
                            <li>
                                <form action="{{ route('logout') }}" method="POST">
                                    @csrf
                                    <button type="submit" class="dropdown-item">Logout</button>
                                </form>
                            </li>
                        </ul>
                    </li>
                @endauth

                @auth('customer')
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle {{ Request::routeIs('customer.area') ? 'active' : '' }}" href="#" id="customerDropdown" role="button"
                            data-bs-toggle="dropdown" aria-expanded="false">
                            {{ Auth::guard('customer')->user()->name }}
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="customerDropdown">
                            <li><a class="dropdown-item {{ Request::routeIs('customer.area') ? 'active' : '' }}" href="{{ route('customer.area') }}">Customer Area</a></li>
                            <li>
                                <form action="{{ route('logout') }}" method="POST">
                                    @csrf
                                    <button type="submit" class="dropdown-item">Logout</button>
                                </form>
                            </li>
                        </ul>
                    </li>
                @endauth

                <!-- Cart Icon with Badge -->
                <li class="nav-item">
                    <a class="nav-link position-relative" href="{{ route('cart.show') }}" id="cart-icon">
                        <i class="fa fa-shopping-cart"></i> Cart
                        <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger"
                            id="cart-count">0</span>
                    </a>
                </li>
            </ul>
        </div>
    </div>
</nav>

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
        <a href="{{ route('cart.show') }}" class="btn btn-primary d-grid gap-2">Checkout</a>
    </div>
</div>