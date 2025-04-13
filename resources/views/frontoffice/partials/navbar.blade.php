<nav class="navbar navbar-expand-lg navbar-dark bg-dark shadow-sm fixed-top">
    <div class="container">
        <!-- Logo -->
        <a class="navbar-brand d-flex align-items-center gap-2 fw-bold" href="{{ route('home') }}">
            <img src="{{ asset('assets/img/logo.png') }}" alt="Chick Deco & Cadeaux" style="height: 50px;">
            Smartshop
        </a>

        <!-- Mobile toggle -->
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbar-content"
            aria-controls="navbar-content" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <!-- Links -->
        <div class="collapse navbar-collapse" id="navbar-content">
            <ul class="navbar-nav ms-auto align-items-center gap-2">

                <!-- Navigation -->
                <li class="nav-item">
                    <a class="nav-link {{ Request::routeIs('home') ? 'active fw-bold text-primary' : '' }}"
                        href="{{ route('home') }}">Home</a>
                </li>

                <!-- Guests -->
                @guest('web')
                    @guest('customer')
                        <li class="nav-item">
                            <a class="nav-link {{ Request::routeIs('register.show') ? 'active fw-bold text-primary' : '' }}"
                                href="{{ route('register.show') }}">Signup</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ Request::routeIs('login.show') ? 'active fw-bold text-primary' : '' }}"
                                href="{{ route('login.show') }}">Login</a>
                        </li>
                    @endguest
                @endguest

                <!-- Admin -->
                @auth('web')
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle fw-semibold" href="#" id="userDropdown"
                            data-bs-toggle="dropdown" aria-expanded="false">
                            {{ Auth::user()->name }} <i class="fa fa-user ms-1"></i>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
                            <li>
                                <a class="dropdown-item {{ Request::routeIs('dashboard.home') ? 'active fw-bold' : '' }}"
                                    href="{{ route('dashboard.home') }}">
                                    Dashboard <i class="fa fa-dashboard ms-1"></i>
                                </a>
                            </li>
                            <li>
                                <form action="{{ route('logout') }}" method="POST">
                                    @csrf
                                    <button type="submit" class="dropdown-item">Logout <i
                                            class="fa fa-sign-out ms-1"></i></button>
                                </form>
                            </li>
                        </ul>
                    </li>
                @endauth

                <!-- Customer -->
                @auth('customer')
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle fw-semibold" href="#" id="customerDropdown"
                            data-bs-toggle="dropdown" aria-expanded="false">
                            {{ Auth::guard('customer')->user()->name }} <i class="fa fa-user ms-1"></i>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="customerDropdown">
                            <li>
                                <a class="dropdown-item {{ Request::routeIs('customer.area') ? 'active fw-bold' : '' }}"
                                    href="{{ route('customer.area') }}">
                                    Customer Area <i class="fa fa-cog ms-1"></i>
                                </a>
                            </li>
                            <li>
                                <form action="{{ route('logout') }}" method="POST">
                                    @csrf
                                    <button type="submit" class="dropdown-item">Logout <i
                                            class="fa fa-sign-out ms-1"></i></button>
                                </form>
                            </li>
                        </ul>
                    </li>
                @endauth

                <li class="nav-item">
                    <a class="nav-link {{ Request::routeIs('about') ? 'active fw-bold text-primary' : '' }}"
                        href="{{ route('about') }}">About</a>
                </li>
                <!-- Cart -->
                <li class="nav-item position-relative">
                    <a class="nav-link d-flex align-items-center gap-1" href="{{ route('cart.show') }}" id="cart-icon">
                        <i class="fa fa-shopping-cart"></i> Cart
                        <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger"
                            id="cart-count"></span>
                    </a>
                </li>
            </ul>
        </div>
    </div>
</nav>

<!-- Sidebar Cart -->
<div id="cartSidebar" class="cart-sidebar">
    <div class="cart-header d-flex justify-content-between align-items-center px-3 py-2 border-bottom">
        <h5 class="mb-0"><i class="fa fa-shopping-cart me-2"></i>Your Cart</h5>
        <button class="btn btn-sm btn-light" onclick="closeCarte()">&times;</button>
    </div>
    <div class="cart-content px-3 py-2">
        <ul id="cart-items" class="list-unstyled">
            <li>Your cart is empty</li>
        </ul>
    </div>
    <div class="cart-footer px-3 py-3 border-top">
        <h6>Total: <span class="cart-total text-danger">0.00 TND</span></h6>
        <a href="{{ route('cart.show') }}" class="btn btn-primary w-100 mt-2">Checkout</a>
    </div>
</div>
