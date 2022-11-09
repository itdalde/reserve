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
                    <li><a class="nav-link scrollto " href="/#about">Home</a></li>
                    <li><a class="nav-link scrollto" href="#services">What We Offer</a></li>
                    <li><a class="nav-link scrollto " href="#portfolio">For vendors</a></li>
                    <li><a class="nav-link " href="#"><span class="btn bg-orange" style="color: white;
    background-color: orange;
    border-color: orange;">
                                Download for free
                            </span></a></li>
                     @if (Route::has('login'))
                            @if (!Auth::check())
                                @if(config('auth.users.registration'))
                                 @endif
                                    <li><a class="nav-link scrollto " href="{{ url('/login') }}">vendor Log In</a></li>
                            @else
                                @if(auth()->user()->hasRole('administrator'))
                                <li><a class="nav-link scrollto " href="{{ url('/admin') }}">{{ __('views.welcome.admin') }}</a></li>
                                @endif
                                    <li><a class="nav-link scrollto " href="{{ url('/logout') }}">{{ __('views.welcome.logout') }}</a></li>
                            @endif
                        @endif

                </ul>
                <i class="bi bi-list mobile-nav-toggle"></i>
            </nav><!-- .navbar -->
        </div>
    </header><!-- End Header -->

    <main id="main">

        <!-- ======= About Section ======= -->
        <section id="about" class="about">
            <div class="container" style="height: 503px;">

                <div class="row">
                    <div class="col-lg-6 d-flex flex-column justify-contents-center" data-aos="fade-left">
                        <div class="content pt-4 pt-lg-0">
                            <h3>Reserve is your one stop shop for quality services</h3>
                            <p>
                                We are is an online platform where the best vendors offer up their services at competitive rates.
                            </p>
                            <div class="d-flex justify-content-center" style=" margin-top: 20em;">
                                <a class="p-2 m-2" href="#">
                                    <img src="{{asset('assets/landing/img/App Store.png')}}" alt="App Store.png">
                                </a>
                                <a class="p-2 m-2" href="#">
                                    <img src="{{asset('assets/landing/img/Google Play.png')}}" alt="Google Play.png">
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6" data-aos="zoom-in">
                        <img src="{{ asset('assets/landing/img/about-image.png')}}" class="img-fluid" alt="">
                    </div>
                </div>
            </div>
        </section><!-- End About Section -->

        <!-- ======= Services Section ======= -->
        <section id="services" class="services section-bg">
            <div class="container">

                <img src="{{asset('assets/landing/img/service-border.png')}}" alt="service-border" style="margin-top: 8em;">
                <div class="section-title" data-aos="fade-up" style="margin-top: 3em;">
                    <h3>How it works</h3>
                </div>

                <div class="row">
                    <div class="col-md-6 col-lg-4 d-flex align-items-stretch mb-5 mb-lg-0" data-aos="zoom-in">
                        <div class="icon-box icon-box-pink">
                            <div class="icon"><img src="{{asset('assets/landing/img/service-1.png')}}" alt="service-3"></div>
                            <h4 class="title"><a href="">A wide range of services for all occasions</a></h4>
                            <p class="description">Explore and pick from any of our many vendors for single service or occasions.</p>
                        </div>
                    </div>

                    <div class="col-md-6 col-lg-4 d-flex align-items-stretch mb-5 mb-lg-0" data-aos="zoom-in" data-aos-delay="100">
                        <div class="icon-box icon-box-cyan">
                            <div class="icon"><img src="{{asset('assets/landing/img/service-2.png')}}" alt="service-3"></div>
                            <h4 class="title"><a href="">Very easy-to-use app and process</a></h4>
                            <p class="description">Choose what you need, add it to cart and create an agreement between single or multiple vendors.</p>
                        </div>
                    </div>

                    <div class="col-md-6 col-lg-4 d-flex align-items-stretch mb-5 mb-lg-0" data-aos="zoom-in" data-aos-delay="200">
                        <div class="icon-box icon-box-green">
                            <div class="icon"><img src="{{asset('assets/landing/img/service-3.png')}}" alt="service-3"></div>
                            <h4 class="title"><a href="">We take quality assurance very serious</a></h4>
                            <p class="description">We are here to help and to guarantee that you get what you ordered.</p>
                        </div>
                    </div>
                </div>
            </div>
        </section><!-- End Services Section -->
        <!-- ======= Portfolio Section ======= -->
        <section id="portfolio" class="portfolio">
            <div class="container">

                <div class="section-title" data-aos="fade-up">
                    <h2>Join our platform as a vendor</h2>
                    <p>Are you a vendor or a company that would like to join our platform and deliver the best to our users?</p>
                </div>

                <div class="row">
                    <div class="col-lg-6 d-flex flex-column justify-contents-center" data-aos="fade-left">
                        <div class="content pt-4 pt-lg-0 p-5">
                            <img src="{{asset('assets/landing/img/portfolio-dashboard.png')}}" alt="portfolio-dashboard">
                            <h3>Simple UI</h3>
                            <p>We understand that using software to manage your business can be a bit daunting so we created a platform with a very simple and straightforward UI for your convenience.</p>
                        </div>
                        <div class="content pt-4 pt-lg-0 p-5">
                            <img src="{{asset('assets/landing/img/portfolio-notes.png')}}" alt="portfolio-notes">
                            <h3>Fast and easy registration</h3>
                            <p>Our registration process is as easy as clicking the “vendor registration” button and filling in some information so we can contact you and confirm your application.</p>
                        </div>
                        <div class="content pt-4 pt-lg-0 p-5">
                            <img src="{{asset('assets/landing/img/portfolio-cards.png')}}" alt="portfolio-cards">

                        </div>
                        <div class="content pt-4 pt-lg-0 p-5">
                            <img src="{{asset('assets/landing/img/portfolio-line-graph.png')}}" alt="portfolio-line-graph">

                        </div>
                    </div>
                    <div class="col-lg-6 d-flex flex-column justify-contents-center" data-aos="fade-left">
                        <div class="content pt-4 pt-lg-0 p-5">
                            <img src="{{asset('assets/landing/img/portfolio-computer.png')}}" alt="portfolio-computer">
                        </div>
                        <div class="content pt-4 pt-lg-0 p-5">
                            <img src="{{asset('assets/landing/img/portfolio-graph.png')}}" alt="portfolio-graph">
                            <h3>Simple earning and statistics tracking</h3>
                            <p>It is very easy to never lose track of your services and how well they are performing.</p>
                        </div>
                        <div class="content pt-4 pt-lg-0 p-5">
                            <img src="{{asset('assets/landing/img/portfolio-pie.png')}}" alt="portfolio-pie">
                            <h3>Efficient optimization tips and hints</h3>
                            <p>Reserve provides you with occassional relevant summaries of how well your company and specific services are doing.</p>
                        </div>
                    </div>
                </div>
                <div class="d-flex justify-content-center" data-aos="fade-up" data-aos-delay="200">
                    <div class="d-flex flex-column">
                        <div class="p-2 mx-auto"><a class="btn btn-orange" href="{{ route('register') }}">Register as a vendor</a></div>
                    </div>
                </div>

            </div>
        </section><!-- End Portfolio Section -->

        <!-- ======= Contact Section ======= -->
        <section id="contact" class="contact" style="    background-color: #F6E9DF;">
            <div class="container">
                <div class="row">

                    <div class="col-lg-5 d-flex align-items-stretch" data-aos="fade-right">
                        <img src="{{asset('assets/landing/img/Reserve App 1.png')}}" alt="Reserve App 1">

                    </div>

                    <div class="col-lg-7 mt-5 mt-lg-0 d-flex align-items-stretch" data-aos="fade-left">
                        <div class="d-flex flex-column">
                            <div class="p-2">
                                <h3>Download a World of Hospitality</h3>
                            </div>
                            <div class="p-2">
                                <div class="d-flex flex-row" >
                                    <a class="p-2 m-2" href="#">
                                        <img src="{{asset('assets/landing/img/App Store.png')}}" alt="App Store.png">
                                    </a>
                                    <a class="p-2 m-2" href="#">
                                        <img src="{{asset('assets/landing/img/Google Play.png')}}" alt="Google Play.png">
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>

            </div>
        </section><!-- End Contact Section -->


    </main><!-- End #main -->

    <!-- ======= Footer ======= -->
    <footer id="footer">
        <div class="footer-top">
            <div class="container">
                <div class="row">

                    <div class="container d-flex align-items-center">

                        <div class="logo me-auto">
                            <a href="index.html"><img src="{{ asset('assets/landing/img/Logo.png') }}" alt="" class="img-fluid"></a>
                        </div>

                        <nav id="navbar" class="navbar order-last order-lg-0">
                            <ul>
                                <li><a class="nav-link" href="{{route('terms-condition')}}">Terms and Conditions</a></li>
                                <li><a class="nav-link" href="{{route('privacy')}}">Privacy Policy</a></li>
                                <li><a class="nav-link" href="{{route('faq')}}">FAQs</a></li>
                                <li><a class="nav-link" href="{{route('help')}}">Help</a></li>
                            </ul>
                            <i class="bi bi-list mobile-nav-toggle"></i>
                        </nav><!-- .navbar -->
                    </div>
                </div>
            </div>
        </div>
        <img src="{{asset('assets/landing/img/Line 4.png')}}" alt="Line 4">
        <div class="container">
            <div class="d-flex flex-column">
                <div class="p-2 mx-auto">
                    <div class="header-social-links d-flex align-items-center">
                        <a href="#" class="instagram"><i class="bi bi-instagram"></i></a>
                    </div>
                </div>
                <div class="copyright text-white">Terms and Conditions and Privacy Policy | ©2022 reservecc.com.All Rights Reserved</div>
            </div>
        </div>
    </footer><!-- End Footer -->

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
