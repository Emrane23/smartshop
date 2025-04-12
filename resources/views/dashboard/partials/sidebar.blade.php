<aside class="app-sidebar bg-body-secondary shadow" data-bs-theme="dark">
    <div class="sidebar-brand">
        <a href="{{ route('dashboard.home') }}" class="brand-link">
            <img src="{{ asset('assets/img/AdminLTELogo.png') }}" alt="Admin Logo" class="brand-image opacity-75 shadow">
            <span class="brand-text fw-light">Admin</span>
        </a>
    </div>

    <div class="sidebar-wrapper">
        <nav class="mt-2">
            <ul class="nav sidebar-menu flex-column" data-lte-toggle="treeview" role="menu" data-accordion="false">

                <!-- Dashboard -->
                <li class="nav-item">
                    <a href="{{ route('dashboard.home') }}"
                        class="nav-link {{ request()->routeIs('dashboard.home') ? 'active' : '' }}">
                        <i class="nav-icon bi bi-speedometer2"></i>
                        <p>Dashboard</p>
                    </a>
                </li>

                <!-- Customers -->
                <li class="nav-item">
                    <a href="{{ route('customers.index') }}"
                        class="nav-link {{ request()->routeIs('customers.index') ? 'active' : '' }}">
                        <i class="nav-icon bi bi-people-fill"></i>
                        <p>Customers</p>
                    </a>
                </li>

                <!-- Orders -->
                <li class="nav-item">
                    <a href="{{ route('dashboard.orders.index') }}"
                        class="nav-link {{ request()->routeIs('dashboard.orders.index') ? 'active' : '' }}">
                        <i class="nav-icon bi bi-cart-fill"></i>
                        <p>Orders</p>
                    </a>
                </li>

                <!-- Products -->
                <li class="nav-item">
                    <a href="{{ route('products.index') }}"
                        class="nav-link {{ request()->routeIs('products.index') ? 'active' : '' }}">
                        <i class="nav-icon bi bi-box-seam"></i>
                        <p>Products</p>
                    </a>
                </li>

                <!-- Categories -->
                <li class="nav-item">
                    <a href="{{ route('categories.index') }}"
                        class="nav-link {{ request()->routeIs('categories.index') ? 'active' : '' }}">
                        <i class="nav-icon bi bi-tags-fill"></i>
                        <p>Categories</p>
                    </a>
                </li>


            </ul>
        </nav>
    </div>
</aside>
