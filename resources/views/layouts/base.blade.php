<!DOCTYPE html>
<html lang="en">

<head>
    <!-- header.php -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Chick Deco & Cadeaux</title>


    <!-- Bootstrap core CSS -->
    {{-- <link href="{{ asset('assets/css/bootstrap.css') }}" rel="stylesheet"> --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">

    <!-- Fontawesome core CSS -->
    <link href="{{ asset('assets/css/font-awesome.min.css') }}" rel="stylesheet" />
    <!-- GOOGLE FONT -->
    <link href="https://fonts.googleapis.com/css?family=Open+Sans" rel="stylesheet" type="text/css">
    <!-- Slide Show CSS -->
    <link href="{{ asset('assets/ItemSlider/css/main-style.css') }}" rel="stylesheet" />
    <!-- Custom CSS -->
    <link href="{{ asset('assets/css/style.css') }}?v={{ time() }}" rel="stylesheet" />
</head>

<body>
    @include('dashboard.partials.alerts')
    @include('frontoffice.partials.navbar')

    <div class="container mt-4 my-4">
        @yield('content')
    </div>

    @include('frontoffice.partials.footer')


    <!--Core JavaScript file  -->
    <script src="{{ asset('assets/js/jquery-1.10.2.js') }}"></script>
    <!--bootstrap JavaScript file  -->
    {{-- <script src="{{ asset('assets/js/bootstrap.js') }}"></script> --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>

    <script src="https://cdn.jsdelivr.net/npm/toastr@2.1.4/toastr.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/toastr@2.1.4/build/toastr.min.css" rel="stylesheet">

    <!--Slider JavaScript file  -->
    {{-- <script src="/public/assets/ItemSlider/js/modernizr.custom.63321.js"></script>
    <script src="/public/assets/ItemSlider/js/jquery.catslider.js"></script> --}}
    @stack('scripts')
    <script src="{{ asset('assets/js/cart.js') }}"></script>
</body>

</html>
