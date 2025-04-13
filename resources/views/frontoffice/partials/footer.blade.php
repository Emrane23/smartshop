<footer class="bg-dark text-light pt-5 pb-4">
    <div class="container text-md-left">
        <div class="row g-4">

            <!-- Our Location -->
            <div class="col-md-6 col-lg-4">
                <h5 class="text-uppercase fw-bold mb-4">
                    <i class="fa fa-map-marker-alt me-2 text-warning"></i>Our Location
                </h5>
                <p class="mb-1"><i class="fa fa-map-marker me-2 text-warning"></i>El Kef, El Sers</p>
                <p class="mb-1"><i class="fa fa-phone me-2 text-warning"></i>+216 54670322</p>
                <p><i class="fa fa-envelope me-2 text-warning"></i>ihebheni013@gmail.com</p>
            </div>

            <!-- Quick Links -->
            <div class="col-md-6 col-lg-4">
                <h5 class="text-uppercase fw-bold mb-4">
                    <i class="fa fa-compass me-2 text-warning"></i>Quick Links
                </h5>
                <ul class="list-unstyled">
                    <li><a href="{{ route('home') }}" class="text-decoration-none text-light"><i class="fa fa-home me-2 text-warning"></i>Home</a></li>
                    <li><a href="{{ route('about') }}" class="text-decoration-none text-light"><i class="fa fa-info-circle me-2 text-warning"></i>About Us</a></li>
                    <li><a href="{{ route('cart.show') }}" class="text-decoration-none text-light"><i class="fa fa-shopping-cart me-2 text-warning"></i>Cart</a></li>
                    <li><a href="{{ route('register.show') }}" class="text-decoration-none text-light"><i class="fa fa-user-plus me-2 text-warning"></i>Signup</a></li>
                </ul>
            </div>

            <!-- Follow Us -->
            <div class="col-md-12 col-lg-4 text-center text-lg-start">
                <h5 class="text-uppercase fw-bold mb-4">
                    <i class="fa fa-globe me-2 text-warning"></i>Follow Us
                </h5>
                <div class="d-flex justify-content-center justify-content-lg-start gap-3">
                    <a href="https://www.facebook.com/iheb.heni.1865" target="_blank"
                       class="text-light fs-4">
                        <i class="fab fa-facebook"></i>
                    </a>
                </div>
                <p class="mt-3 small text-muted">
                    Discover a wide selection of decorative items to enhance your interior.
                </p>
            </div>

        </div>
    </div>

    <!-- Footer Bottom -->
    <div class="text-center py-3 mt-4" style="background-color: #222">
        <small class="text-muted">
            &copy; {{ date('Y') }} | All Rights Reserved | {{ request()->getHost() }} | 
            <i class="fa fa-envelope me-1 text-warning"></i> ihebheni013@gmail.com
        </small>
    </div>
</footer>
