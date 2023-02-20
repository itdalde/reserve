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
        <link href="{{ asset('assets/landing/css/mobile.style.css')}}" rel="stylesheet">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/flag-icon-css/6.6.6/css/flag-icons.min.css" integrity="sha512-uvXdJud8WaOlQFjlz9B15Yy2Au/bMAvz79F7Xa6OakCl2jvQPdHD0hb3dEqZRdSwG4/sknePXlE7GiarwA/9Wg==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    </head>
    <body  data-aos-once="false">
    <!-- ======= Header ======= -->
    <header id="header" class="fixed-top d-flex align-items-center">
        <div class="container d-flex align-items-center">

            <div class="logo me-auto">
                <a href="/"><img src="{{ asset('assets/landing/img/Logo.png') }}" alt="" class="img-fluid"></a>
            </div>

            <nav id="navbar" class="navbar order-last order-lg-0">
                <ul style=" {{__('home.home')  == 'Home' ? 'direction: ltr;' : 'direction: rtl;'}}"  >
                    <li><a class="nav-link scrollto " href="/#about">{{__('home.home')}}</a></li>
                    <li><a class="nav-link scrollto" href="#services">{{__('home.what_we_offer')}}</a></li>
                    <li><a class="nav-link scrollto " href="#portfolio">{{__('home.for_vendors')}}</a></li>
                    <li><a class="nav-link " href="{{ route('login',['register'=>'1']) }}"><span class="btn bg-orange" style="color: white;
    background-color: orange;
    border-color: orange;">
                                {{__('home.download_for_free')}}
                            </span></a></li>
                     @if (Route::has('login'))
                            @if (!Auth::check())
                                @if(config('auth.users.registration'))
                                 @endif
                                    <li><a class="nav-link scrollto " href="{{ url('/login') }}">{{__('home.login')}}</a></li>
                            @else
                                @if(auth()->user()->hasRole('administrator'))
                                <li><a class="nav-link scrollto " href="{{ url('/admin') }}">{{ __('views.welcome.admin') }}</a></li>
                                @endif
                                    <li><a class="nav-link scrollto " href="{{ url('/logout') }}">{{ __('views.welcome.logout') }}</a></li>
                            @endif
                        @endif
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <span class="fi fis fi-{{Config::get('languages')[App::getLocale()]['flag-icon']}}"></span> {{ Config::get('languages')[App::getLocale()]['display'] }}
                        </a>
                        <div class="dropdown-menu w-100" aria-labelledby="navbarDropdownMenuLink">
                            @foreach (Config::get('languages') as $lang => $language)
                                @if ($lang != App::getLocale())
                                    <a class="dropdown-item text-dark w-100" href="{{ route('lang.switch', $lang) }}">
                                        <div class="d-inline-flex mx-auto">{{$language['display']}} <span class="fi fis fi-{{$language['flag-icon']}}"></span></div>
                                    </a>
                                @endif
                            @endforeach
                        </div>
                    </li>
                </ul>
                <i class="bi bi-list mobile-nav-toggle"></i>

            </nav><!-- .navbar -->
        </div>
    </header><!-- End Header -->

    <main id="main"  style=" {{__('home.home')  == 'Home' ? 'direction: ltr;' : 'direction: rtl;'}}">

        <!-- ======= About Section ======= -->
        <section id="about" class="about">
            <div class="container" style="height: 503px;">

                <div class="row">
                    <div class="top-panel col-lg-6 d-flex flex-column justify-contents-center aos-item"  data-aos-once="false" data-aos-mirror="true" data-aos="fade-left">
                        <div class="content pt-4 pt-lg-0">
                            <h3 data-aos-once="false" data-aos-mirror="true" data-aos="fade-right" class="w-auto">{{__('home.banner')}} </h3>
                            <p data-aos-once="false" data-aos-mirror="true" data-aos="zoom-in" class="w-auto">
                                {{__('home.banner1')}}
                            </p>
                            <div class="apps-store d-flex justify-content-center" style=" margin-top: 20em;">
                                <a class="p-2 m-2" data-aos-once="false" data-aos-mirror="true" data-aos="fade-up" href="https://apps.apple.com/">
                                    <img src="{{asset('assets/landing/img/App Store.png')}}" alt="App Store.png">
                                </a>
                                <a class="p-2 m-2" data-aos-once="false" data-aos-mirror="true" data-aos="fade-right" href="https://play.google.com/store/apps">
                                    <img src="{{asset('assets/landing/img/Google Play.png')}}" alt="Google Play.png">
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="abt-logo col-lg-6 aos-item" data-aos-mirror="true" data-aos="fade-up" data-aos-once="false">
                        <img src="{{ asset('assets/landing/img/about-image.png')}}" class="img-fluid" alt="">
                    </div>
                </div>
            </div>
        </section><!-- End About Section -->

        <!-- ======= Services Section ======= -->
        <section id="services" class="services section-bg">
            <div class="container">

                <img src="{{asset('assets/landing/img/service-border.png')}}" alt="service-border" style="margin-top: 8em;">
                <div class="section-title aos-item" data-aos-mirror="true" data-aos="fade-up" data-aos-once="false" style="margin-top: 3em;">
                    <h3> {{__('home.how_it_works')}}</h3>
                </div>

                <div class="row">
                    <div class="col-md-6 col-lg-4 d-flex align-items-stretch mb-5 mb-lg-0 aos-item" data-aos-mirror="true" data-aos-once="false" data-aos="zoom-in">
                        <div class="icon-box icon-box-pink">
                            <div class="icon"><img src="{{asset('assets/landing/img/service-1.png')}}" alt="service-3"></div>
                            <h4 class="title"><a href="">{{__('home.card1')}}</a></h4>
                            <p class="description">{{__('home.card1_body')}}</p>
                        </div>
                    </div>

                    <div class="col-md-6 col-lg-4 d-flex align-items-stretch mb-5 mb-lg-0 aos-item" data-aos-mirror="true" data-aos-once="false" data-aos="zoom-in" data-aos-delay="100">
                        <div class="icon-box icon-box-cyan">
                            <div class="icon"><img src="{{asset('assets/landing/img/service-2.png')}}" alt="service-3"></div>
                            <h4 class="title"><a href="">{{__('home.card2')}}</a></h4>
                            <p class="description">{{__('home.card2_body')}}</p>
                        </div>
                    </div>

                    <div class="col-md-6 col-lg-4 d-flex align-items-stretch mb-5 mb-lg-0 aos-item" data-aos-mirror="true" data-aos-once="false" data-aos="zoom-in" data-aos-delay="200">
                        <div class="icon-box icon-box-green">
                            <div class="icon"><img src="{{asset('assets/landing/img/service-3.png')}}" alt="service-3"></div>
                            <h4 class="title"><a href="">{{__('home.card3')}}</a></h4>
                            <p class="description">{{__('home.card3_body')}}</p>
                        </div>
                    </div>
                </div>
            </div>
        </section><!-- End Services Section -->
        <!-- ======= Portfolio Section ======= -->
        <section id="portfolio" class="portfolio">
            <div class="container">

                <div class="section-title aos-item" data-aos-mirror="true" data-aos-once="false" data-aos="fade-up">
                    <h2>{{__('home.for_vendors_title')}}</h2>
                    <p>{{__('home.for_vendors_sub')}}</p>
                </div>

                <div class="row">
                    <div class="col-lg-6 d-flex flex-column justify-contents-center aos-item">
                        <div class="content pt-4 pt-lg-0 p-5"  data-aos-once="false" data-aos-mirror="true" data-aos="fade-up">
                            <img src="{{asset('assets/landing/img/portfolio-dashboard.png')}}" alt="portfolio-dashboard">
                            <h3>{{__('home.simple_ui')}}</h3>
                            <p>{{__('home.simple_ui_sub')}}</p>
                        </div>
                        <div class="content pt-4 pt-lg-0 p-5" data-aos-mirror="true" data-aos-once="false" data-aos="fade-left">
                            <img src="{{asset('assets/landing/img/portfolio-notes.png')}}" alt="portfolio-notes">
                            <h3>{{__('home.Fast and easy registration')}}</h3>
                            <p>{{__('home.Fast and easy registration_sub')}}</p>
                        </div>
                        <div class="content pt-4 pt-lg-0 p-5 hpi" data-aos-mirror="true" data-aos-once="false" data-aos="fade-left">
                            <img src="{{asset('assets/landing/img/portfolio-cards.png')}}" alt="portfolio-cards">

                        </div>
                        <div class="content pt-4 pt-lg-0 p-5 hpi" data-aos-mirror="true" data-aos-once="false" data-aos="fade-left">
                            <img src="{{asset('assets/landing/img/portfolio-line-graph.png')}}" alt="portfolio-line-graph">

                        </div>
                    </div>
                    <div class="col-lg-6 d-flex flex-column justify-contents-center aos-item">
                        <div class="content pt-4 pt-lg-0 p-5 hpi" data-aos-mirror="true" data-aos-once="false" data-aos="fade-left">
                            <img src="{{asset('assets/landing/img/portfolio-computer.png')}}" alt="portfolio-computer">
                        </div>
                        <div class="content pt-4 pt-lg-0 p-5" data-aos-mirror="true" data-aos-once="false" data-aos="fade-left">
                            <img src="{{asset('assets/landing/img/portfolio-graph.png')}}" alt="portfolio-graph">
                            <h3>{{__("home.Simple earning and statistics tracking")}}</h3>
                            <p>{{__('home.sub_1')}}</p>
                        </div>
                        <div class="content pt-4 pt-lg-0 p-5" data-aos-mirror="true" data-aos-once="false" data-aos="fade-left">
                            <img src="{{asset('assets/landing/img/portfolio-pie.png')}}" alt="portfolio-pie">
                            <h3>{{__('home.Efficient optimization tips and hints')}}</h3>
                            <p>{{__('home.sub_2')}}</p>
                        </div>
                    </div>
                </div>
                <div class="d-flex justify-content-center aos-item" data-aos-mirror="true" data-aos-once="false" data-aos="fade-up" data-aos-delay="200">
                    <div class="d-flex flex-column">
                        <div class="p-2 mx-auto"><a class="btn btn-orange" href="{{ route('login',['register'=>'1']) }}">{{__('home.Register as a vendor')}}</a></div>
                    </div>
                </div>

            </div>
        </section><!-- End Portfolio Section -->

        <!-- ======= Contact Section ======= -->
        <section id="contact" class="contact" style="    background-color: #F6E9DF;">
            <div class="container">
                <div class="row">

                    <div class="col-lg-5 d-flex align-items-stretch aos-item" data-aos-mirror="true" data-aos-once="false" data-aos="fade-right">
                        <img src="{{asset('assets/landing/img/Reserve App 1.png')}}" alt="Reserve App 1">

                    </div>

                    <div class="col-lg-7 mt-5 mt-lg-0 d-flex align-items-stretch aos-item" data-aos-mirror="true" data-aos-once="false" data-aos="fade-left">
                        <div class="d-flex flex-column">
                            <div class="p-2">
                                <h3>{{__('home.Download a World of Hospitality')}}</h3>
                            </div>
                            <div class="p-2">
                                <div class="d-flex flex-row" >
                                    <a class="p-2 m-2" href="https://apps.apple.com/">
                                        <img src="{{asset('assets/landing/img/App Store.png')}}" alt="App Store.png">
                                    </a>
                                    <a class="p-2 m-2" href="https://play.google.com/store/apps">
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
