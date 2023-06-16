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
  <link href="{{ asset('assets/landing/css/style-v2.css') }}" rel="stylesheet">
  <!-- <link href="{{ asset('assets/landing/css/style.css?v-1') }}" rel="stylesheet">
    <link href="{{ asset('assets/landing/css/mobile.style.css?v-1') }}" rel="stylesheet"> -->
  <link href="{{ asset('assets/landing/vendor/remixicon/remixicon.css') }}" rel="stylesheet">
  <link href="{{ asset('assets/landing/vendor/swiper/swiper-bundle.min.css') }}" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/flag-icon-css/6.6.6/css/flag-icons.min.css"
    integrity="sha512-uvXdJud8WaOlQFjlz9B15Yy2Au/bMAvz79F7Xa6OakCl2jvQPdHD0hb3dEqZRdSwG4/sknePXlE7GiarwA/9Wg=="
    crossorigin="anonymous" referrerpolicy="no-referrer" />

</head>

<body data-aos-once="false">
  <!-- ======= Header ======= -->
  <header id="header" class="header fixed-top">
    <div class="container-fluid container-xl d-flex align-items-center justify-content-between">

      <a href="/" class="logo d-flex align-items-center">
        <img src="{{ asset('assets/landing/img/logo-black.png') }}" alt="" class="img-fluid">
      </a>

      <nav id="navbar" class="navbar">
        <ul style=" {{ __('home.home') == 'Home' ? 'direction: ltr;' : 'direction: rtl;' }}">
          <li><a class="nav-link scrollto active" href="#header">{{ __('home.home') }}</a></li>
          <li><a class="nav-link scrollto" href="#services">{{ __('home.what_we_offer') }}</a></li>
          <li><a class="nav-link scrollto" href="#vendor">{{ __('home.for_vendors') }}</a></li>
          <li><a class="nav-link " href="{{ route('login', ['register' => '1']) }}"><span
                class="btn text-white btn-solid">
                {{ __('home.download_for_free') }}
              </span></a></li>
          @if (Route::has('login'))
          @if (!Auth::check())
          @if (config('auth.users.registration'))
          @endif
          <li><a class="nav-link scrollto " href="{{ url('/login') }}">{{ __('home.login') }}</a>
          </li>
          @else
          @if (auth()->user())
          <li><a class="nav-link scrollto " href="{{ url('/admin') }}">{{ __('views.welcome.admin') }}</a></li>
          @endif
          <li><a class="nav-link scrollto " href="{{ url('/logout') }}">{{ __('views.welcome.logout') }}</a></li>
          @endif
          @endif

          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" data-bs-toggle="dropdown"
              aria-haspopup="true" aria-expanded="false">
              <span class="fi fis fi-{{ Config::get('languages')[App::getLocale()]['flag-icon'] }} me-2"></span>
              {{ Config::get('languages')[App::getLocale()]['display'] }}
            </a>
            <div class="dropdown-menu w-100 ms-2" aria-labelledby="navbarDropdownMenuLink">
              @foreach (Config::get('languages') as $lang => $language)
              @if ($lang != App::getLocale())
              <a class="dropdown-item text-dark w-100" href="{{ route('lang.switch', $lang) }}">
                <div class="d-inline-flex mx-auto">{{ $language['display'] }} <span
                    class="fi fis fi-{{ $language['flag-icon'] }} me-2"></span></div>
              </a>
              @endif
              @endforeach
            </div>
          </li>
        </ul>
        <i class="bi bi-list mobile-nav-toggle toggle-mobile-top"></i>
      </nav><!-- .navbar -->

    </div>
  </header><!-- End Header -->

  <!-- ======= Hero Section ======= -->
  <section id="hero" class="hero d-flex align-items-center">
    <div class="container ">
      <div class="row">
        <div class="col-lg-6 d-flex flex-column justify-content-center">
          <h1 data-aos="fade-up">{{ __('home.banner') }}</h1>
          <h2 data-aos="fade-up" data-aos-delay="400">{{ __('home.banner1') }}</h2>
          <div data-aos="fade-up" data-aos-delay="600">
            <div class="text-lg-start pt-5">
              <a href="https://apps.apple.com/"
                class="scrollto d-inline-flex align-items-center justify-content-center align-self-center">
                <img src="{{ asset('assets/landing/img/App Store.png') }}" alt="App Store.png">
              </a>
              <a href="https://play.google.com/store/apps"
                class="scrollto d-inline-flex align-items-center justify-content-center align-self-center">
                <img src="{{ asset('assets/landing/img/Google Play.png') }}" alt="Google Play.png">
              </a>
            </div>
          </div>
        </div>
        <div class="col-lg-6 hero-img" data-aos="zoom-out" data-aos-delay="200">
          <img src="{{ asset('assets/landing/img/homepage-banner.png') }}" class="img-fluid" alt="">
        </div>
      </div>
    </div>
  </section><!-- End Hero -->

  <!-- ======= Services Section ======= -->
  <section id="services" class="services">

    <div class="container" data-aos="fade-up">

      <header class="section-header">
        <p>{{ __('home.how_it_works') }}</p>
      </header>

      <div class="row gy-4">

        <div class="col-lg-4 col-md-6" data-aos="fade-right" data-aos-delay="200">
          <div class="service-box">
            <img src="{{ asset('assets/landing/img/work-1.png') }}" alt="service-3">
            <h3>{{ __('home.card1') }}</h3>
            <p>{{ __('home.card1_body') }}</p>
          </div>
        </div>

        <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="300">
          <div class="service-box">
            <img src="{{ asset('assets/landing/img/work-2.png') }}" alt="service-3">
            <h3>{{ __('home.card2') }}</h3>
            <p>{{ __('home.card2_body') }}</p>
          </div>
        </div>

        <div class="col-lg-4 col-md-6" data-aos="fade-right" data-aos-delay="400">
          <div class="service-box">
            <img src="{{ asset('assets/landing/img/work-3.png') }}" alt="service-3">
            <h3>{{ __('home.card3') }}</h3>
            <p>{{ __('home.card3_body') }}</p>
          </div>
        </div>
      </div>

    </div>
    <div class="d-flex justify-content-between">
      <img src="{{ asset('assets/landing/img/overlay-top.png') }}" alt="service-3" class="img-fluid overlay-left">
      <img src="{{ asset('assets/landing/img/Frame.png') }}" alt="service-3" class="img-fluid overlay-right">
    </div>
  </section><!-- End Services Section -->


  <!-- ======= Vendor Section ======= -->
  <section id="vendor" class="vendor">

    <div class="container" data-aos="fade-up">

      <header class="section-header" data-aos="fade-right" data-aos-delay="100" data-aos-mirror="true"
        data-aos-once="false">
        <p>{{ __('home.for_vendors_title') }}</p>
        <h2 class="pt-3">{{ __('home.for_vendors_sub') }}</h2>
      </header>

      <!-- Computer -->
      <div class="row pt-5">

        <div class="col-lg-4" data-aos="fade-right" data-aos-delay="200" data-aos-mirror="true" data-aos-once="false">
          <div class="box text-end">
            <img src="{{ asset('assets/landing/img/portfolio-dashboard.png') }}" alt="portfolio-dashboard"
              class="img-fluid">
            <h3>{{ __('home.simple_ui') }}</h3>
            <p>{{ __('home.simple_ui_sub') }}</p>
          </div>
        </div>

        <div class="col-lg-4 mt-4 mt-lg-0" data-aos="fade-up" data-aos-delay="400" data-aos-mirror="true"
          data-aos-once="false">
          <div class="box p-0">
            <img src="{{ asset('assets/landing/img/portfolio-computer.png') }}" class="img-fluid w-100"
              alt="portfolio-computer">
          </div>
        </div>

        <div class="col-lg-4 mt-4 mt-lg-0" data-aos="fade-right" data-aos-delay="600" data-aos-mirror="true"
          data-aos-once="false">
          <div class="box text-start">
            <img src="{{ asset('assets/landing/img/portfolio-notes.png') }}" alt="portfolio-notes" class="img-fluid">
            <h3>{{ __('home.Fast and easy registration') }}</h3>
            <p>{{ __('home.Fast and easy registration_sub') }}</p>
          </div>
        </div>

      </div>
      <!-- Statistics -->
      <div class="row pt-5">

        <div class="col-lg-4" data-aos="fade-up" data-aos-delay="200" data-aos-mirror="true" data-aos-once="false">
          <div class="box stat-top-img">
            <img src="{{ asset('assets/landing/img/body-circle-2.png') }}" alt="portfolio-dashboard" class="img-fluid">
          </div>
        </div>

        <div class="col-lg-4 mt-4 mt-lg-0" data-aos="fade-right" data-aos-delay="400" data-aos-mirror="true"
          data-aos-once="false">
          <div class="box p-0">
            <img src="{{ asset('assets/landing/img/portfolio-cards.png') }}" class="w-100 img-fluid"
              alt="portfolio-cards">
          </div>
        </div>

        <div class="col-lg-4 mt-4 mt-lg-0" data-aos="fade-up" data-aos-delay="600" data-aos-mirror="true"
          data-aos-once="false">
          <div class="box text-start">
            <img src="{{ asset('assets/landing/img/portfolio-graph.png') }}" alt="portfolio-notes" class="img-fluid">
            <h3>{{ __('home.Simple earning and statistics tracking') }}</h3>
            <p>{{ __('home.sub_1') }}</p>
          </div>
        </div>

      </div>

      <!-- Graph -->
      <div class="row pt-5">

        <div class="col-lg-4" data-aos="fade-right" data-aos-delay="200" data-aos-mirror="true" data-aos-once="false">
          <div class="box text-end">
            <img src="{{ asset('assets/landing/img/portfolio-pie.png') }}" alt="portfolio-pie" class="img-fluid" />
            <h3>{{ __('home.Efficient optimization tips and hints') }}</h3>
            <p>{{ __('home.sub_2') }}</p>
          </div>
        </div>

        <div class="col-lg-4 mt-4 mt-lg-0" data-aos="fade-up" data-aos-delay="400" data-aos-mirror="true"
          data-aos-once="false">
          <div class="box p-0">
            <img src="{{ asset('assets/landing/img/portfolio-line-graph.png') }}" class="img-fluid"
              alt="portfolio--line-graph">
          </div>
        </div>

        <div class="col-lg-4 mt-4 mt-lg-0" data-aos="fade-right" data-aos-delay="600" data-aos-mirror="true"
          data-aos-once="false">
          <div class="box stat-bottom-img">
            <img src="{{ asset('assets/landing/img/body-circle.png') }}" alt="portfolio-notes" class="img-fluid">
          </div>
        </div>

      </div>

    </div>

  </section><!-- End Vendor Section -->


  <!-- ======= Features Section ======= -->
  <section id="contacts" class="contacts">

    <div class="container" data-aos="fade-up">
      <!-- Feature Icons -->
      <div class="row" data-aos="fade-up">

        <div class="row">

          <div class="col-xl-4 text-center" data-aos="fade-right" data-aos-delay="100" data-aos-mirror="true"
            data-aos-once="false">
            <img src="{{ asset('assets/landing/img/Reserve App 1.png') }}" alt="Reserve App 1" class="img-fluid w-100">
          </div>

          <div class="col-xl-8 d-flex content">
            <div class="row align-self-center gy-4">

              <div class="col-md-12" data-aos="fade-up">
                <div>
                  <h4 class="text-lg fs-1 fw-bold">{{ __('home.Download a World of Hospitality') }}</h4>
                </div>
                <div data-aos="fade-up" data-aos-delay="600">
                  <div class="text-lg-start pt-5">
                    <a href="https://apps.apple.com/"
                      class="scrollto d-inline-flex align-items-center justify-content-center align-self-center">
                      <img src="{{ asset('assets/landing/img/App Store.png') }}" alt="App Store.png">
                    </a>
                    <a href="https://play.google.com/store/apps"
                      class="scrollto d-inline-flex align-items-center justify-content-center align-self-center">
                      <img src="{{ asset('assets/landing/img/Google Play.png') }}" alt="Google Play.png">
                    </a>
                  </div>
                </div>
              </div>

            </div>
          </div>

        </div>

      </div><!-- End Feature Icons -->

    </div>

  </section><!-- End Features Section -->



  <!-- ======= Footer ======= -->
  @include('layouts.includes.footer')
  <!-- ======= End Footer ======= -->
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
  <script src="{{ asset('assets/landing/js/main.js?v=1.0') }}"></script>
</body>

</html>