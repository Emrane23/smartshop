<footer class="container-fluid bg-light py-4">
    <div class="container">
        <div class="row g-3">
            <div class="col-lg-8 col-md-6">
                <h5 class="fw-bold">Our Location</h5>
                <hr>
                <p class="mb-1">2076, Tunis, La Marsa</p>
                <p class="mb-1">Just Location, Tunisia</p>
                <p class="mb-1">Call: +216 54352960</p>
                <p>Email: omranklaai@gmail.com</p>
                <p class="text-muted">&copy; {{ date('Y') }} {{ request()->getHost() }} | All Rights Reserved</p>
            </div>

            <div class="col-lg-4 col-md-6 text-center">
                <h5 class="fw-bold">We are Social</h5>
                <hr>
                <a href="https://www.facebook.com/profile.php?id=61570627625305&mibextid=JRoKGi" target="_blank" class="text-primary">
                    <i class="fa fa-facebook-square fa-3x"></i>
                </a>
                <p class="mt-2 text-muted">
                    Discover a wide selection of decorative items to enhance your interior.
                </p>
            </div>
        </div>
    </div>
    
    <div class="text-center text-white py-3 mt-4" style="background-color: #ded1c1">
        &copy; {{ date('Y') }} | All Rights Reserved | {{ request()->getHost() }} | Email us: omranklaai@gmail.com
    </div>
</footer>