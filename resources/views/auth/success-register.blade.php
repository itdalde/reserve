
<link href="{{ asset('assets/landing/vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
<link href="{{ asset('assets/landing/vendor/bootstrap-icons/bootstrap-icons.css') }}" rel="stylesheet">
<link href="{{ asset('assets/landing/vendor/boxicons/css/boxicons.min.css') }}" rel="stylesheet">
<link href="{{ asset('assets/landing/vendor/glightbox/css/glightbox.min.css') }}" rel="stylesheet">
<link href="{{ asset('assets/landing/vendor/swiper/swiper-bundle.min.css') }}" rel="stylesheet">
@extends('auth.layouts.auth')

@section('body_class','register')

@section('content')
    <div class="mx-auto login-main">
        <img class="auth-img-top" src="{{asset('assets/auth/img/login-img-top.png')}}" alt="login-img-top">
        <div class="container">
            <div class="row mx-auto mt-5" style="width: 34em;">

                <div class="p-2 text-center">
                    <img src="{{asset('assets/landing/img/logo-black.png')}}" alt="logo-black">

                </div>
                <div class="p-2 mt-5">
                    <div class="card">
                        <div class="card-body p-5">
                            <div class="login_content">
                                <h4 class="text-black"> Application sent successfully!</h4>
                                <p>Your application has been sent! Someone from our team will review your request and get back to you via e-mail within 2-3 working days</p>
                                <a class="btn bg-orange" href="/">Return Home</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <img class="auth-img-bottom" src="{{asset('assets/auth/img/login-bottom-img.png')}}" alt="login-bottom-img.png">
    </div>
@endsection

@section('styles')
    @parent

    {{ Html::style(mix('assets/auth/css/register.css')) }}
@endsection
