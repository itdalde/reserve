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

    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Raleway:300,300i,400,400i,500,500i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">

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
                <li><a class="nav-link scrollto " href="/">{{__('home.home')}}</a></li>
                <li><a class="nav-link scrollto" href="/?#services">{{__('home.what_we_offer')}}</a></li>
                <li><a class="nav-link scrollto " href="/?#portfolio">{{__('home.for_vendors')}}</a></li>
            </ul>
            <i class="bi bi-list mobile-nav-toggle"></i>
        </nav><!-- .navbar -->
    </div>
</header><!-- End Header -->

<main id="main">
    <p class="p-2" style="margin-top: 3em;">
    </p>

    <div class=" sub-section-bg" >
        <h3 style="margin-left: 122px" class="pt-3 text-white" data-aos="fade-up">Help</h3>
    </div>
    <!-- ======= Help Section ======= -->
    <section id="help" class="help">
        <div class="container">

            <div class="p-2" data-aos="fade-up">
                <h2>Send us a message!</h2>
            </div>
            <div class="row">
                <div class="col-md-6 mt-5  col-lg-6 d-flex align-items-stretch mb-5 mb-lg-0" data-aos="zoom-in">
                    <div class="icon-box icon-box-pink  mx-auto w-75">
                        <div class="d-flex justify-content-between">
                            <div class="p2">
                                <div class="d-flex flex-column">
                                    <div class="p-2 text-left">
                                        <h5 class="title">Helpline Numbers</h5>
                                        <img style="width: 10px" src="{{asset('assets/landing/img/red-dot.png')}}" alt="red-dot">
                                        <h5 class="title">9388 89 3888 </h5>
                                    </div>
                                </div>
                            </div>
                            <div class="p-2">
                                <img src="{{asset('assets/landing/img/help-img-call.png')}}" alt="help-img-call">
                            </div>
                        </div>


                    </div>
                </div>

                <div class="col-md-6 mt-5  col-lg-6d-flex align-items-stretch mb-5 mb-lg-0" data-aos="zoom-in" data-aos-delay="100">
                    <div class="icon-box icon-box-cyan  mx-auto w-75">
                        <div class="d-flex justify-content-between">
                            <div class="p2">
                                <div class="d-flex flex-column">
                                    <div class="p-2 text-left">
                                        <h5 class="title">Email address </h5>
                                        <img style="width: 10px" src="{{asset('assets/landing/img/red-dot.png')}}" alt="red-dot">
                                        <h5 class="title">Customer support : <a href="mailto:Info@reserve.com">Info@reserve.com</a> </h5>
                                    </div>
                                </div>
                            </div>
                            <div class="p-2">
                                <img src="{{asset('assets/landing/img/help-img-email.png')}}" alt="help-img-email">
                            </div>
                        </div>


                    </div>
                </div>

            </div>
            <div class="row">

                <div class="mt-5  mx-auto col-md-6 col-lg-6d-flex align-items-stretch mb-5 mb-lg-0" data-aos="zoom-in" data-aos-delay="100">
                    <div class="icon-box icon-box-green  mx-auto w-75">
                        <div class="d-flex justify-content-between">
                            <div class="p2">
                                <div class="d-flex flex-column">
                                    <div class="p-2 text-left">
                                        <h5 class="title">Corporate Office Address</h5>
                                        <img style="width: 10px" src="{{asset('assets/landing/img/red-dot.png')}}" alt="red-dot">
                                        <h5 class="title">
                                            3891 Ranchview Dr. Richardson, California 62639
                                            4517 Washington Ave. Manchester, Kentucky 39495
                                            4140 Parker Rd. Allentown, New Mexico 31134</h5>
                                    </div>
                                </div>
                            </div>
                            <div class="p-2">
                                <img src="{{asset('assets/landing/img/help-img-c.png')}}" alt="help-img-c">
                            </div>
                        </div>


                    </div>
                </div>
            </div>
        </div>
    </section><!-- End Help Section -->

</main><!-- End #main -->

<!-- ======= Footer ======= -->
@include('layouts.includes.footer')
<a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>
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
