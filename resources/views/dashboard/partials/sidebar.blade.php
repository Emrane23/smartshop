<div id="layoutSidenav_nav">
    <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
        <div class="sb-sidenav-menu">
            <div class="nav">
                <div class="sb-sidenav-menu-heading">Core</div>
                <a class="nav-link {{ request()->routeIs('dashboard.home') ? 'active' : '' }}" href="{{ route('dashboard.home') }}">
                    <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                    Dashboard
                </a>
                
                <div class="sb-sidenav-menu-heading">Pages</div>
                <a class="nav-link {{ request()->routeIs('dashboard.orders.index') ? 'active' : '' }}" href="{{ route('dashboard.orders.index') }}">
                    <div class="sb-nav-link-icon"><i class="fas fa-shopping-cart"></i></div>
                    Orders
                </a>
                <a class="nav-link {{ request()->routeIs('products.index') ? 'active' : '' }}" href="{{ route('products.index') }}">
                    <div class="sb-nav-link-icon"><i class="fas fa-shopping-basket"></i></div>
                    Products
                </a>
                <a class="nav-link {{ request()->routeIs('comments.index') ? 'active' : '' }}" href="{{ route('comments.index') }}">
                    <div class="sb-nav-link-icon"><i class="fas fa-comments"></i></div>
                    Manage Comments
                </a>
                <a class="nav-link {{ request()->routeIs('categories.index') ? 'active' : '' }}" href="{{ route('categories.index') }}">
                    <div class="sb-nav-link-icon"><i class="fas fa-tags"></i></div>
                    Categories
                </a>
            </div>
        </div>
        <div class="sb-sidenav-footer">
            <div class="small">Logged in as:</div>
            {{ auth()->user()->name }}
        </div>
    </nav>
</div>