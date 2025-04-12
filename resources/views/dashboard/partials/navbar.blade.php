<nav class="app-header navbar navbar-expand bg-body"> <!--begin::Container-->
    <div class="container-fluid"> <!--begin::Start Navbar Links-->
        <ul class="navbar-nav">
            <li class="nav-item"> <a class="nav-link" data-lte-toggle="sidebar" href="#" role="button"> <i
                        class="bi bi-list"></i> </a> </li>
            <li class="nav-item d-none d-md-block"> <a href="{{ route('dashboard.home') }}" class="nav-link">Home</a>
            </li>
        </ul> <!--end::Start Navbar Links--> <!--begin::End Navbar Links-->
        <ul class="navbar-nav ms-auto"> <!--begin::Navbar Search-->
            <li class="nav-item"> <a class="nav-link" data-widget="navbar-search" href="#" role="button"> <i
                        class="bi bi-search"></i> </a> </li> <!--end::Navbar Search-->

            <li class="nav-item dropdown user-menu"> <a href="#" class="nav-link dropdown-toggle"
                    data-bs-toggle="dropdown"> <img src="{{ asset('assets/img/avatar.png') }}"
                        class="user-image rounded-circle shadow" alt="User Image"> <span
                        class="d-none d-md-inline">{{ auth()->user()->name }}</span> </a>
                <ul class="dropdown-menu dropdown-menu-lg dropdown-menu-end"> <!--begin::User Image-->
                    <li class="user-header text-bg-primary"> <img src="{{ asset('assets/img/avatar.png') }}"
                            class="rounded-circle shadow" alt="User Image">
                        <p>
                            {{ auth()->user()->name }}
                            <small>admin since  {{ auth()->user()->created_at->format('M. Y') }}</small>
                        </p>
                    </li> <!--end::User Image--> <!--begin::Menu Body-->
                    <li class="user-body"> <!--begin::Row-->
                        
                    </li> <!--end::Menu Body--> <!--begin::Menu Footer-->
                    <li class="user-footer">
                        <a href="#" class="btn btn-default btn-flat">Profile</a>

                        <form method="POST" action="{{ route('logout') }}" class="d-inline float-end">
                            @csrf
                            <button type="submit" class="btn btn-default btn-flat">Sign out</button>
                        </form>
                    </li>
                    <!--end::Menu Footer-->
                </ul>
            </li> <!--end::User Menu Dropdown-->
        </ul> <!--end::End Navbar Links-->
    </div> <!--end::Container-->
</nav> <!--end::Header--> <!--begin::Sidebar-->
