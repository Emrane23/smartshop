<!DOCTYPE html>
<html lang="en">

<head>
    <!-- header.php -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>Chick Deco & Cadeaux</title>


    <!-- Bootstrap core CSS -->
    <link href="{{ asset('assets/css/bootstrap.css') }}" rel="stylesheet">
    <!-- Fontawesome core CSS -->
    <link href="{{ asset('assets/css/font-awesome.min.css') }}" rel="stylesheet" />
    <!-- GOOGLE FONT -->
    <link href="https://fonts.googleapis.com/css?family=Open+Sans" rel="stylesheet" type="text/css">
    <!-- Slide Show CSS -->
    <link href="{{ asset('assets/ItemSlider/css/main-style.css') }}" rel="stylesheet" />
    <!-- Custom CSS -->
    <link href="{{ asset('assets/css/style.css') }}" rel="stylesheet" />
</head>

<body>
    @include('frontoffice.partials.navbar')

    <div class="container mt-4 my-4">
        @yield('content')
    </div>

    @include('frontoffice.partials.footer')


    <!--Core JavaScript file  -->
    <script src="{{asset('assets/js/jquery-1.10.2.js')}}"></script>
    <!--bootstrap JavaScript file  -->
    <script src="{{asset('assets/js/bootstrap.js')}}"></script>
    <!--Slider JavaScript file  -->
    {{-- <script src="/public/assets/ItemSlider/js/modernizr.custom.63321.js"></script>
    <script src="/public/assets/ItemSlider/js/jquery.catslider.js"></script> --}}
</body>

</html>
