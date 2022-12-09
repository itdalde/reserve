<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">

    <title>{{ config('app.name') }}</title>
    <meta content="" name="description">
    <meta content="" name="keywords">

    <link href="{{ asset('assets/landing/img/favicon.ico') }}" rel="icon">
    <link href="{{ asset('assets/landing/img/favicon.ico') }}" rel="apple-touch-icon">

    <link
        href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Raleway:300,300i,400,400i,500,500i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i"
        rel="stylesheet">

    <link href="{{ asset('assets/landing/vendor/aos/aos.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/landing/vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/landing/vendor/bootstrap-icons/bootstrap-icons.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/landing/vendor/boxicons/css/boxicons.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/landing/vendor/glightbox/css/glightbox.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/landing/vendor/swiper/swiper-bundle.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/landing/css/style.css') }}" rel="stylesheet">
</head>
<body>
<!-- ======= Header ======= -->
<header id="header" class="fixed-top d-flex align-items-center">
    <div class="container d-flex align-items-center">

        <div class="logo me-auto">
            <a href="/"><img src="{{ asset('assets/landing/img/Logo.png') }}" alt="" class="img-fluid"></a>
        </div>

        <nav id="navbar" class="navbar order-last order-lg-0">
            <ul>
                <li><a class="nav-link scrollto" href="/">Home</a></li>
                <li><a class="nav-link scrollto" href="/?#services">What We Offer</a></li>
                <li><a class="nav-link scrollto " href="/?#portfolio">For service providers</a></li>
            </ul>
            <i class="bi bi-list mobile-nav-toggle"></i>
        </nav><!-- .navbar -->
    </div>
</header><!-- End Header -->

<main id="main" style="height: 57vh;">
    <p class="p-2" style="margin-top: 6em;">
    </p>

    <div class="d-flex justify-content-center align-content-end flex-wrap">
        <div class="card mb-3 w-75  border-0">
            <div class="row g-0">
                <div class="col-md-4"  data-aos-mirror="true" data-aos-once="false" data-aos="fade-left">
                    <img style="    padding: 40px 40px 0px 40px;" data-aos-once="false" data-aos="fade-right" src="{{ asset('assets/landing/img/about-image.png')}}" class="img-fluid" alt="...">
                </div>
                <div class="col-md-8 border border-warning" style="
    border-top-left-radius: 80px 80px;
    border-bottom-right-radius: 80px 80px;">
                    <div class="card-body">

                        <div class="d-flex justify-content-center mt-5">
                            <h3 class="card-title"  data-aos-mirror="true" data-aos-once="false" data-aos="fade-right">User Confirmation Successful</h3>
                        </div>
                        <p class="card-text p-5"  data-aos-mirror="true" data-aos-once="false" data-aos="fade-left">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

</main><!-- End #main -->

<!-- ======= Footer ======= -->
@include('layouts.includes.footer')<!-- End Footer -->

<a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i
        class="bi bi-arrow-up-short"></i></a>
<!-- Vendor JS Files -->
<script src="{{ asset('assets/landing/vendor/aos/aos.js') }}"></script>
<script src="{{ asset('assets/landing/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('assets/landing/vendor/glightbox/js/glightbox.min.js') }}"></script>
<script src="{{ asset('assets/landing/vendor/isotope-layout/isotope.pkgd.min.js') }}"></script>
<script src="{{ asset('assets/landing/vendor/swiper/swiper-bundle.min.js') }}"></script>
<script src="{{ asset('assets/landing/vendor/php-email-form/validate.js') }}"></script>

<!-- Template Main JS File -->
<script src="{{ asset('assets/landing/js/main.js') }}"></script>
</body>
</html>
