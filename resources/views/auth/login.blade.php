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
    <link href="{{ asset('assets/auth/css/login-v2.css') }}" rel="stylesheet">
    <!-- <link href="{{ asset('assets/auth/css/mobile.style.css') }}" rel="stylesheet"> -->

</head>

<body data-aos-once="false">

    <div class="container-fluid d-none d-sm-none d-md-none d-lg-block d-xl-block d-xxl-block">
        <div class="row h-100 login-form">

            <!-- Form Header -->
            <div class="col-md-12 col-lg-6 login-form-header content left-content p-0" data-aos="fade-right"
                data-aos-delay="100" data-aos-mirror="true" data-aos-once="false">
                <!-- for Login -->
                <div class="top h-100 form-welcome-message">
                    <div class="pt-5">
                        <div class="row g-0 pt-5">
                            <div class="pt-5">
                                <div class="text-center">
                                    <img src="{{ asset('assets/landing/img/logo-black.png') }}" alt="logo-black">
                                </div>
                            </div>
                        </div>
                        <div class="row d-flex justify-content-center pt-5 position-relative" style="z-index: 9;">
                            <div class="mt-5 w-50">
                                <div class="text-start">
                                    <h1 class="mb-3 fw-bolder">Welcome Back!</h1>
                                    <p class="mb-0">Don't have a Reserve Vendor account?</p>
                                    <p class="">Create an account below!</p>
                                </div>
                            </div>
                            <div class="d-flex justify-content-center mt-3">
                                <div class="w-50">
                                    <button
                                        class="btn btn-outline rounded-1 fw-bold text-uppercase w-50 create-account-btn"
                                        id="sign-up-btn" role="button">create an account</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="w-100">
                        <img src="{{ asset('assets/landing/img/top-asset.png') }}" alt="top-asset"
                            class="w-100 position-absolute top-0" />
                        <img src="{{ asset('assets/landing/img/base-asset.png') }}" alt="base-asset"
                            class="w-100 position-absolute bottom-0" />
                    </div>
                </div>

                <!-- for Registration -->
                <div class="bottom h-100 d-none form-welcome-message">
                    <div class="col-md-12 col-lg-6 w-100 h-100" data-aos="fade-right" data-aos-delay="100"
                        data-aos-mirror="true" data-aos-once="false">
                        <div class="row g-0 pt-5">
                            <div class="pt-5">
                                <div class="text-center pt-5">
                                    <img src="{{ asset('assets/landing/img/logo-black.png') }}" alt="logo-black">
                                </div>
                            </div>
                        </div>
                        <div class="row d-flex justify-content-center pt-5 position-relative" style="z-index: 9;">
                            <div class="pt-5">
                                <div class="text-center">
                                    <h1 class="fw-bolder">Already Registered?</h1>
                                    <div class="my-5">
                                        <p class="mb-0">Already have a Reserve Vendor account?</p>
                                        <p class="">Login to your account below!</p>
                                    </div>
                                </div>
                            </div>
                            <div class="d-flex justify-content-center">
                                <button role="button" id="sign-in-btn"
                                    class="btn btn-outline rounded-1 fw-bold text-uppercase w-50 login-btn">Login</button>
                            </div>
                        </div>
                        <div class="w-100">
                            <img src="{{ asset('assets/landing/img/top-asset.png') }}" alt="top-asset"
                                class="w-100 position-absolute top-0" />
                            <img src="{{ asset('assets/landing/img/base-asset.png') }}" alt="base-asset"
                                class="w-100 position-absolute bottom-0" />
                        </div>
                    </div>
                </div>
            </div>


            <!-- Login Form -->
            <div class="col-md-12 col-lg-6 p-0 right-content content" data-aos="fade-left" data-aos-delay="100"
                data-aos-mirror="true" data-aos-once="false">

                <!-- for Login -->
                <div class="top sign-in-form" style="z-index: 999;">
                    <div class="row d-flex justify-content-center">
                        <div class="pt-5">
                            <h3 class="text-center mt-5">Login to Reserve</h3>
                        </div>
                    </div>
                    <div class="container w-50 mt-5">
                        <div class="row pt-5">
                            <form action="{{ route('login') }}" method="POST">
                                @csrf
                                <div class="input-group input-group-lg first">
                                    <span class="input-group-text rounded-0 bg-white">
                                        <i class="bi bi-person-circle"></i>
                                    </span>
                                    <input type="email" class="form-control shadow-none rounded-0 border-start-0"
                                        placeholder="Email Address" name="email" value="{{ old('email')}}" required
                                        autofocus autocomplete="false">
                                </div>

                                <div class="input-group input-group-lg second pt-4">
                                    <span class="input-group-text rounded-0 bg-white" id="password-icon">
                                        <i class="bi bi-shield-lock"></i>
                                    </span>

                                    <input type="password"
                                        class="form-control shadow-none rounded-0 border-start-0 border-end-0"
                                        placeholder="{{ __('login.Password')}}" name="password" required>

                                    <span class="input-group-text rounded-0 bg-white" role="button"
                                        style="margin-left: -1px;">
                                        <i class="bi bi-eye-slash toggle-password"></i>
                                    </span>
                                </div>

                                <div class="text-end pt-2 mb-3 pb-1">
                                    <a class="text-muted" href="#!">Forgot password?</a>
                                </div>

                                <input type="submit" value="{{ __('login.login_btn') }}"
                                    class="btn btn-solid rounded-0 mt-4 w-100 h-25 fs-4">
                                @if (!old('first_name') && !$errors->isEmpty())
                                <div class="alert alert-danger" role="alert">
                                    {!! $errors->first() !!}
                                </div>
                                @endif
                            </form>
                        </div>
                    </div>
                </div>


                <!-- for Registration -->
                <div class="bottom d-none sign-up-form">
                    <div class="col-md-12 col-lg-6 w-100" data-aos="fade-left" data-aos-delay="100"
                        data-aos-mirror="true" data-aos-once="false">
                        <div class="row d-flex justify-content-center">
                            <div class="pt-5">
                                <h3 class="text-center">Create an Account</h3>
                            </div>
                        </div>
                        <div class="container w-50 mt-5">
                            <div class="row">
                                <form method="POST" action="{{ route('register') }}" class="">
                                    @csrf
                                    <!-- Company name -->
                                    <div class="input-group input-group-lg first">
                                        <span class="input-group-text rounded-0 bg-white">
                                            <i class="bi bi-people"></i>
                                        </span>
                                        <input type="text" class="form-control shadow-none rounded-0 border-start-0"
                                            placeholder="Name of the Company" id="company_name" name="company_name"
                                            value="{{ old('company_name') }}" required autofocus>
                                    </div>

                                    <!-- Contact Person -->
                                    <div class="input-group input-group-lg first pt-3">
                                        <span class="input-group-text rounded-0 bg-white">
                                            <i class="bi bi-person-circle"></i>
                                        </span>
                                        <input type="text" class="form-control shadow-none rounded-0 border-start-0"
                                            placeholder="Name of the person to contact" id="first_name"
                                            value="{{ old('full_name') }}" name="full_name" required>
                                    </div>

                                    <!-- Contact Person Position -->
                                    <div class="input-group input-group-lg first pt-3">
                                        <span class="input-group-text rounded-0 bg-white">
                                            <i class="bi bi-award"></i>
                                        </span>
                                        <input type="text" class="form-control shadow-none rounded-0 border-start-0"
                                            placeholder="Position of the contact person" id="position"
                                            value="{{ old('position') }}" name="position" required>
                                    </div>

                                    <!-- Phone number -->
                                    <div class="input-group input-group-lg first pt-3">
                                        <span class="input-group-text rounded-0 bg-white">
                                            <i class="bi bi-telephone"></i>
                                        </span>
                                        <input type="phone" class="form-control shadow-none rounded-0 border-start-0"
                                            placeholder="Phone Number" id="phone_number"
                                            value="{{ old('phone_number') }}" name="phone_number" required>
                                    </div>

                                    <!-- Email -->
                                    <div class="input-group input-group-lg first pt-3">
                                        <span class="input-group-text rounded-0 bg-white">
                                            <i class="bi bi-envelope"></i>
                                        </span>
                                        <input type="email" class="form-control shadow-none rounded-0 border-start-0"
                                            placeholder="Email" id="email" name="email" value="{{ old('email')}}"
                                            required>
                                    </div>

                                    <!-- Location -->
                                    <div class="input-group input-group-lg first pt-3">
                                        <span class="input-group-text rounded-0 bg-white">
                                            <i class="bi bi-geo-alt"></i>
                                        </span>
                                        <input type="text" class="form-control shadow-none rounded-0 border-start-0"
                                            placeholder="Company location in Qatar" id="location"
                                            value="{{ old('location') }}" name="location" required>
                                    </div>

                                    <!-- Registration No. -->
                                    <div class="input-group input-group-lg first pt-3">
                                        <span class="input-group-text rounded-0 bg-white">
                                            <i class="bi bi-journal-text"></i>
                                        </span>
                                        <input type="text" class="form-control shadow-none rounded-0 border-start-0"
                                            placeholder="{{ __('login.registration_number') }}" id="registration_number"
                                            value="{{ old('registration_number') }}" name="registration_number"
                                            required>
                                    </div>

                                    <!-- Password -->
                                    <div class="input-group input-group-lg first pt-3">
                                        <span class="input-group-text rounded-0 bg-white">
                                            <i class="bi bi-shield-lock"></i>
                                        </span>
                                        <input type="password"
                                            class="form-control shadow-none rounded-0 border-start-0 hide-if-valid"
                                            placeholder="Password" id="password" name="password"
                                            pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" autocomplete="new-password"
                                            title="{{ __('login.password_role') }}" required>
                                    </div>

                                    <!-- Password Rules -->
                                    <div class="d-flex flex-column validations px-3 d-none">
                                        <span class="hide lcase invalid d-flex align-items-center pb-2 text-danger">{{
                                            __('login.password_role1') }}
                                            <i class="ps-2 bi bi-x-circle"></i>
                                        </span>
                                        <span class="hide ucase invalid d-flex align-items-center pb-2 text-danger">{{
                                            __('login.password_role2') }}
                                            <i class="ps-2 bi bi-x-circle"></i> </span>
                                        <span class="hide onum invalid d-flex align-items-center pb-2 text-danger">{{
                                            __('login.password_role3') }}
                                            <i class="ps-2 bi bi-x-circle"></i> </span>
                                        <span class="hide schar invalid d-flex align-items-center pb-2 text-danger">{{
                                            __('login.password_role4') }}
                                            <i class="ps-2 bi bi-x-circle"></i> </span>
                                        <span class="hide mchar invalid d-flex align-items-center pb-2 text-danger">{{
                                            __('login.password_role5') }}
                                            <i class="ps-2 bi bi-x-circle"></i> </span>
                                    </div>

                                    <!-- Services Offered -->
                                    <div class="input-group input-group-lg first pt-3">
                                        <span class="input-group-text rounded-0 bg-white">
                                            <i class="bi bi-card-checklist"></i>
                                        </span>
                                        <input type="text" class="form-control shadow-none rounded-0 border-start-0"
                                            placeholder="Which services would you like to sign up for?"
                                            id="service_type" value="{{ old('service_type') }}" name="service_type">
                                    </div>

                                    <!-- Description  -->
                                    <input type="hidden" name="company_description">
                                    @if (old('first_name') && !$errors->isEmpty())
                                    <div class="alert alert-danger" role="alert">
                                        {!! $errors->first() !!}
                                    </div>
                                    @endif

                                    @if (config('auth.captcha.registration'))
                                    @captcha()
                                    @endif

                                    <button type="submit" id="btn-submit-change-pass"
                                        class="btn btn-solid rounded-0 mt-4 w-100  fs-4 btn-create-account">Create
                                        Account</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Mobile Login and Registration Form -->
    <div class="container mobile-view p-0 d-none d-sm-block d-md-block d-lg-none d-xl-none d-xxl-none">
        <div class="row h-100 login-form">
            <div class="pt-4 w-100">
                <div class="text-center">
                    <a href="/">
                        <img src="{{ asset('assets/landing/img/logo-black.png') }}" alt="logo-black">
                    </a>
                </div>
            </div>
            <div class="col-12 mobile-login-form animate" data-aos="fade-left" data-aos-delay="100"
                data-aos-mirror="true" data-aos-once="false">
                <div class="top h-100">
                    <div class="pt-5">
                        <div class="text-center">
                            <h1 class="mb-2 mt-5 fw-bolder">Welcome Back!</h1>
                            <h3 class="mt-2 fs-4" data-aos="fade-left" data-aos-delay="100" data-aos-mirror="true"
                                data-aos-once="false">Login to Reserve</h3>
                        </div>
                    </div>
                    <div class="">
                        <div class="container w-100">
                            <div class="row pt-3">
                                <form action="{{ route('login') }}" method="POST">
                                    @csrf
                                    <div class="input-group input-group-lg first">
                                        <span class="input-group-text rounded-0 bg-white">
                                            <i class="bi bi-person-circle"></i>
                                        </span>
                                        <input type="email" class="form-control shadow-none rounded-0 border-start-0"
                                            placeholder="Email Address" name="email" value="{{ old('email')}}" required
                                            autofocus autocomplete="false">
                                    </div>

                                    <div class="input-group input-group-lg second pt-4">
                                        <span class="input-group-text rounded-0 bg-white" id="password-icon">
                                            <i class="bi bi-shield-lock"></i>
                                        </span>

                                        <input type="password"
                                            class="form-control shadow-none rounded-0 border-start-0 border-end-0"
                                            placeholder="{{ __('login.Password')}}" name="password" required>

                                        <span class="input-group-text rounded-0 bg-white" role="button"
                                            style="margin-left: -1px;">
                                            <i class="bi bi-eye-slash toggle-password"></i>
                                        </span>
                                    </div>

                                    <div class="text-end pt-2 mb-3 pb-1">
                                        <a class="text-muted" href="#!">Forgot password?</a>
                                    </div>

                                    <input type="submit" value="{{ __('login.login_btn') }}"
                                        class="btn btn-solid rounded-0 mt-4 w-100 h-25 fs-4">
                                    @if (!old('first_name') && !$errors->isEmpty())
                                    <div class="alert alert-danger" role="alert">
                                        {!! $errors->first() !!}
                                    </div>
                                    @endif
                                </form>
                            </div>
                        </div>

                        <div class="row w-100 mt-5">
                            <div class="text-center">
                                <p class="mb-0">Don't have a Reserve Vendor account?</p>
                                <p class="">Create an account below!</p>
                            </div>
                            <div class="d-flex justify-content-center mt-3">
                                <div class="w-50 text-center">
                                    <button
                                        class="btn btn-outline rounded-1 fw-bold text-uppercase w-100 mobile-create-account-btn"
                                        id="sign-up-btn" role="button">create an account</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Registration Form -->
            <div class="col-12 mobile-registration-form animate d-none mb-5" data-aos="fade-right" data-aos-delay="100"
                data-aos-mirror="true" data-aos-once="false">
                <div class="top h-100">
                    <div class="pt-5">
                        <h3 class="text-center">Create an Account</h3>
                    </div>
                    <!-- Registration form -->
                    <div class="container w-100 mt-5">
                        <div class="row">
                            <form method="POST" action="{{ route('register') }}" class="">
                                @csrf
                                <!-- Company name -->
                                <div class="input-group input-group-lg first">
                                    <span class="input-group-text rounded-0 bg-white">
                                        <i class="bi bi-people"></i>
                                    </span>
                                    <input type="text" class="form-control shadow-none rounded-0 border-start-0"
                                        placeholder="Name of the Company" id="company_name" name="company_name"
                                        value="{{ old('company_name') }}" required autofocus>
                                </div>

                                <!-- Contact Person -->
                                <div class="input-group input-group-lg first pt-3">
                                    <span class="input-group-text rounded-0 bg-white">
                                        <i class="bi bi-person-circle"></i>
                                    </span>
                                    <input type="text" class="form-control shadow-none rounded-0 border-start-0"
                                        placeholder="Name of the person to contact" id="first_name"
                                        value="{{ old('full_name') }}" name="full_name" required>
                                </div>

                                <!-- Contact Person Position -->
                                <div class="input-group input-group-lg first pt-3">
                                    <span class="input-group-text rounded-0 bg-white">
                                        <i class="bi bi-award"></i>
                                    </span>
                                    <input type="text" class="form-control shadow-none rounded-0 border-start-0"
                                        placeholder="Position of the contact person" id="position"
                                        value="{{ old('position') }}" name="position" required>
                                </div>

                                <!-- Phone number -->
                                <div class="input-group input-group-lg first pt-3">
                                    <span class="input-group-text rounded-0 bg-white">
                                        <i class="bi bi-telephone"></i>
                                    </span>
                                    <input type="phone" class="form-control shadow-none rounded-0 border-start-0"
                                        placeholder="Phone Number" id="phone_number" value="{{ old('phone_number') }}"
                                        name="phone_number" required>
                                </div>

                                <!-- Email -->
                                <div class="input-group input-group-lg first pt-3">
                                    <span class="input-group-text rounded-0 bg-white">
                                        <i class="bi bi-envelope"></i>
                                    </span>
                                    <input type="email" class="form-control shadow-none rounded-0 border-start-0"
                                        placeholder="Email" id="email" name="email" value="{{ old('email')}}" required>
                                </div>

                                <!-- Location -->
                                <div class="input-group input-group-lg first pt-3">
                                    <span class="input-group-text rounded-0 bg-white">
                                        <i class="bi bi-geo-alt"></i>
                                    </span>
                                    <input type="text" class="form-control shadow-none rounded-0 border-start-0"
                                        placeholder="Company location in Qatar" id="location"
                                        value="{{ old('location') }}" name="location" required>
                                </div>

                                <!-- Registration No. -->
                                <div class="input-group input-group-lg first pt-3">
                                    <span class="input-group-text rounded-0 bg-white">
                                        <i class="bi bi-journal-text"></i>
                                    </span>
                                    <input type="text" class="form-control shadow-none rounded-0 border-start-0"
                                        placeholder="{{ __('login.registration_number') }}" id="registration_number"
                                        value="{{ old('registration_number') }}" name="registration_number" required>
                                </div>

                                <!-- Password -->
                                <div class="input-group input-group-lg first pt-3">
                                    <span class="input-group-text rounded-0 bg-white">
                                        <i class="bi bi-shield-lock"></i>
                                    </span>
                                    <input type="password"
                                        class="form-control shadow-none rounded-0 border-start-0 hide-if-valid"
                                        placeholder="Password" id="password" name="password"
                                        pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" autocomplete="new-password"
                                        title="{{ __('login.password_role') }}" required>
                                </div>

                                <!-- Password Rules -->
                                <div class="d-flex flex-column validations px-3 d-none">
                                    <span class="hide lcase invalid d-flex align-items-center pb-2 text-danger">{{
                                        __('login.password_role1') }}
                                        <i class="ps-2 bi bi-x-circle"></i>
                                    </span>
                                    <span class="hide ucase invalid d-flex align-items-center pb-2 text-danger">{{
                                        __('login.password_role2') }}
                                        <i class="ps-2 bi bi-x-circle"></i> </span>
                                    <span class="hide onum invalid d-flex align-items-center pb-2 text-danger">{{
                                        __('login.password_role3') }}
                                        <i class="ps-2 bi bi-x-circle"></i> </span>
                                    <span class="hide schar invalid d-flex align-items-center pb-2 text-danger">{{
                                        __('login.password_role4') }}
                                        <i class="ps-2 bi bi-x-circle"></i> </span>
                                    <span class="hide mchar invalid d-flex align-items-center pb-2 text-danger">{{
                                        __('login.password_role5') }}
                                        <i class="ps-2 bi bi-x-circle"></i> </span>
                                </div>

                                <!-- Services Offered -->
                                <div class="input-group input-group-lg first pt-3">
                                    <span class="input-group-text rounded-0 bg-white">
                                        <i class="bi bi-card-checklist"></i>
                                    </span>
                                    <input type="text" class="form-control shadow-none rounded-0 border-start-0"
                                        placeholder="Which services would you like to sign up for?" id="service_type"
                                        value="{{ old('service_type') }}" name="service_type">
                                </div>

                                <!-- Description  -->
                                <input type="hidden" name="company_description">
                                @if (old('first_name') && !$errors->isEmpty())
                                <div class="alert alert-danger" role="alert">
                                    {!! $errors->first() !!}
                                </div>
                                @endif

                                @if (config('auth.captcha.registration'))
                                @captcha()
                                @endif

                                <button type="submit" id="btn-submit-change-pass"
                                    class="btn btn-solid rounded-0 mt-4 w-100  fs-4 btn-create-account">Create
                                    Account</button>
                            </form>
                        </div>
                    </div>
                    <div class="row w-100 mt-5">
                        <div class="pt-5">
                            <div class="text-center">
                                <h1 class="fw-bolder">Already Registered?</h1>
                                <div class="my-5">
                                    <p class="mb-0">Already have a Reserve Vendor account?</p>
                                    <p class="">Login to your account below!</p>
                                </div>
                            </div>
                        </div>
                        <div class="d-flex justify-content-center">
                            <button role="button" id="sign-in-btn"
                                class="btn btn-outline rounded-1 fw-bold text-uppercase w-100 mobile-login-btn">Login</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal -->

    @if (Session::has('signup'))
    <div class="modal fade" id="signupSuccessModal" tabindex="-1" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content py-4 px-md-4 px-sm-4 px-3">
                <div class="modal-header justify-content-center border-0">
                    <img src="{{ asset('assets/landing/img/logo-black.png') }}" alt="logo-black">
                </div>
                <div class="modal-body "
                    style="{{ __('home.home') == 'Home' ? 'direction: ltr;' : 'direction: rtl;' }}">
                    <div class="text-center par-2 ">
                        <p class="text-black"> {{ __('login.Application sent successfully!') }}</p>
                        <p>{{ __('login.review') }}</p>

                    </div>
                </div>
                <div class="modal-footer bg-transparent text-center border-0">
                    <a class="w-100 btn btn-solid " style="    line-height: 36px;" href="/">
                        {{ __('login.Return Home') }}
                    </a>
                </div>
            </div>
        </div>
    </div>
    @endif

    <script src="{{ asset('assets/libs/jquery/dist/jquery.min.js') }}"></script>
    <script src="https://code.jquery.com/jquery-3.6.1.min.js"
        integrity="sha256-o88AwQnZB+VDvE9tvIXrMQaPlFFSUTR+nldQm1LuPXQ=" crossorigin="anonymous"></script>

    <script src="{{ asset('assets/landing/vendor/aos/aos.js') }}"></script>
    <script src="{{ asset('assets/landing/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('assets/landing/vendor/glightbox/js/glightbox.min.js') }}"></script>
    <script src="{{ asset('assets/landing/vendor/isotope-layout/isotope.pkgd.min.js') }}"></script>
    <script src="{{ asset('assets/landing/vendor/swiper/swiper-bundle.min.js') }}"></script>
    <script src="{{ asset('assets/landing/vendor/php-email-form/validate.js') }}"></script>

    <!-- Template Main JS File -->
    <script src="{{ asset('assets/landing/js/main.js') }}"></script>

    <script>
        $(document).ready(function () {
            $(document).on('shown.bs.modal', '.modal', function () {
                $('.modal-backdrop').before($(this));
            });
            @if (Session::has('signup'))
            $('#signupSuccessModal').modal('show');
            @endif
            @if (app('request')->input('register'))
                onCLickSignUp()
            @endif
            let data = "{{ old('first_name') }}";
            if (data) {
                onCLickSignUp()
            }

        var pageWidth = document.documentElement.scrollWidth;
        console.log('pageWidth', pageWidth)

        function onCLickSignUp() {

            // setTimeout(function () {
            //     $('.sign-in-form').removeClass('show').addClass('d-none')
            //     $('.sign-up-form').addClass('show').removeClass('d-none');
            // }, 1200);
            if (pageWidth > 688) {
                $('.create-account-btn').click();
                $('.top').addClass('d-none');
                $('.bottom').removeClass('d-none');
                $('.right-content').addClass('animate-left animate');
                $('.left-content').addClass('animate-right animate').css('z-index', '9');
            } else {
                $('.mobile-create-account-btn').click();
                $('.mobile-login-form').addClass('d-none');
                $('.mobile-registration-form').removeClass('d-none');
            }


        }

        $('body').on('click', '.login-btn', function (e) {
            $('.login-form').removeClass('d-none')
            $('.registration-form').addClass('d-none');

        });

        $('body').on('click', '.create-account-btn', function (e) {
            $('.top').addClass('d-none');
            $('.bottom').removeClass('d-none');
            $('.right-content').addClass('animate-left animate');
            $('.left-content').addClass('animate-right animate').css('z-index', '9');
        });

        $('body').on('click', '.login-btn', function (e) {
            $('.bottom').addClass('d-none');
            $('.top').removeClass('d-none');

            $('.right-content').removeClass('animate-left animate');
            $('.left-content').removeClass('animate-right animate').css('z-index');
        })

        $('body').on('click', '.mobile-login-btn', function () {
            $('.mobile-login-form').removeClass('d-none');
            $('.mobile-registration-form').addClass('d-none');
        });
        $('body').on('click', '.mobile-create-account-btn', function () {
            $('.mobile-login-form').addClass('d-none');
            $('.mobile-registration-form').removeClass('d-none');
        });

        $('body').on('click', '#sign-up-btn', function (e) {

            $('.sign-in-form').removeClass('show').addClass('hide')
            $('.sign-up-form').addClass('show').removeClass('hide')

        });

        $('body').on('click', '#sign-in-btn', function (e) {
            setTimeout(function () {
                $('.sign-up-form').removeClass('show').addClass('hide')
                $('.sign-in-form').addClass('show').removeClass('hide')
            }, 1200);
        });
        $(".toggle-password").click(function () {

            $(this).toggleClass("bi-eye bi-eye-slash");
            let input = $(this).closest('div').find('input');
            if (input.attr("type") == "password") {
                input.attr("type", "text");
            } else {
                input.attr("type", "password");
            }
        });

        $('body').on('keyup change blur', '#password', function (e) {
            let lowerCaseLetters = /[a-z]/g;
            let upperCaseLetters = /[A-Z]/g;
            let numbers = /[0-9]/g;
            let char = /[!@#$%^&*()_+\-=\[\]{};':"\\|,.<>\/?]/g;
            let btn = $('#btn-submit-change-pass');
            let pass = $('#password').val();
            let hideIfValid = false;
            if ($(this).hasClass('hide-if-valid')) {
                hideIfValid = true;
            }
            if ($(this).val() != '') {
                if (pass.match(lowerCaseLetters)) {
                    if (hideIfValid) {
                        $('.lcase').addClass('hide');
                    }
                    $('.lcase').addClass('valid').removeClass('invalid')
                    $('.lcase span').text('check_circle_outline');

                } else {
                    if (hideIfValid) {
                        $('.lcase').removeClass('hide');
                    }
                    $('.lcase').addClass('invalid').removeClass('valid')
                    $('.lcase span').text('highlight_off');
                }

                if (pass.match(upperCaseLetters)) {
                    if (hideIfValid) {
                        $('.ucase').addClass('hide');
                    }
                    $('.ucase').addClass('valid').removeClass('invalid')
                    $('.ucase span').text('check_circle_outline');
                } else {
                    if (hideIfValid) {
                        $('.ucase').removeClass('hide');
                    }
                    $('.ucase').addClass('invalid').removeClass('valid')
                    $('.ucase span').text('highlight_off');
                }

                if (pass.match(numbers)) {
                    if (hideIfValid) {
                        $('.onum').addClass('hide');
                    }
                    $('.onum').addClass('valid').removeClass('invalid')
                    $('.onum span').text('check_circle_outline');
                } else {
                    if (hideIfValid) {
                        $('.onum').removeClass('hide');
                    }
                    $('.onum').addClass('invalid').removeClass('valid')
                    $('.onum span').text('highlight_off');

                }

                if (pass.match(char)) {
                    if (hideIfValid) {
                        $('.schar').addClass('hide');
                    }
                    $('.schar').addClass('valid').removeClass('invalid')
                    $('.schar span').text('check_circle_outline');
                } else {
                    if (hideIfValid) {
                        $('.schar').removeClass('hide');
                    }
                    $('.schar').addClass('invalid').removeClass('valid')
                    $('.schar span').text('highlight_off');
                }

                if (pass.length >= 8) {
                    if (hideIfValid) {
                        $('.mchar').addClass('hide');
                    }
                    $('.mchar').addClass('valid').removeClass('invalid')
                    $('.mchar span').text('check_circle_outline');
                } else {
                    if (hideIfValid) {
                        $('.mchar').removeClass('hide');
                    }
                    $('.mchar').addClass('invalid').removeClass('valid')
                    $('.mchar span').text('highlight_off');
                }

                if (pass.length >= 8 && pass.match(char) && pass.match(numbers) && pass.match(
                    upperCaseLetters) && pass.match(lowerCaseLetters)) {
                    btn.attr('disabled', false)
                } else {
                    btn.attr('disabled', true)
                }
            } else {
                btn.attr('disabled', false)
                //$('.validations').find('span').addClass('hide');
            }
        });
        });
    </script>
</body>

</html>