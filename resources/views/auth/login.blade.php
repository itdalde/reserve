
<link href="{{ asset('assets/landing/vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
<link href="{{ asset('assets/landing/vendor/bootstrap-icons/bootstrap-icons.css') }}" rel="stylesheet">
<link href="{{ asset('assets/landing/vendor/boxicons/css/boxicons.min.css') }}" rel="stylesheet">
<link href="{{ asset('assets/landing/vendor/glightbox/css/glightbox.min.css') }}" rel="stylesheet">
<link href="{{ asset('assets/landing/vendor/swiper/swiper-bundle.min.css') }}" rel="stylesheet">
@extends('auth.layouts.auth')

@section('body_class','login')

@section('content')

    <div class="d-flex justify-content-between">
        <div class="p-0">
            <img class="auth-img-top" src="{{asset('assets/auth/img/login-img-top.png')}}" alt="login-img-top">
        </div>
        <div class="p-0">
            <div class="container">
                <div class="row mx-auto mt-5" style="width: 34em;">

                    <div class="p-2 text-center">
                        <img src="{{asset('assets/landing/img/logo-black.png')}}" alt="logo-black">

                    </div>
                    <div class="p-2 mt-5">
                        <div class="card" >
                            <div class="card-body p-5">

                                <h4 >Service provider Log in</h4>
                                <div class="login_content">
                                    {{ Form::open(['route' => 'login']) }}
                                    <div>
                                        <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}"
                                               placeholder="{{ __('views.auth.login.input_0') }}" required autofocus>
                                    </div>
                                    <div>
                                        <input id="password" type="password" class="form-control" name="password"
                                               placeholder="{{ __('views.auth.login.input_1') }}" required>
                                    </div>
                                    <div class="checkbox al_left">
                                        <label>
                                            <input type="checkbox"
                                                   name="remember" {{ old('remember') ? 'checked' : '' }}> {{ __('views.auth.login.input_2') }}
                                        </label>
                                    </div>

                                    @if (session('status'))
                                        <div class="alert alert-success">
                                            {{ session('status') }}
                                        </div>
                                    @endif

                                    @if (!$errors->isEmpty())
                                        <div class="alert alert-danger" role="alert">
                                            {!! $errors->first() !!}
                                        </div>
                                    @endif

                                    <div>
                                        <button class="btn btn-default submit w-100 bg-orange text-white" type="submit">Service provider Log in</button>

                                    </div>

                                    <div class="clearfix"></div>

                                    <div class="separator">
                                        <div>
                                            <a class="btn btn-default submit w-100 to_register" href="{{ route('register') }}" > Service provider Sign up </a>

                                        </div>
                                    </div>
                                    <div class="text-left">

                                        <a class="reset_pass text-left" href="{{ route('password.request') }}">
                                            {{ __('views.auth.login.action_1') }}
                                        </a>
                                    </div>
                                    {{ Form::close() }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="p-0">
            <img style="
    margin-top: 29em;
    overflow: hidden;" class="auth-img-bottom" src="{{asset('assets/auth/img/login-bottom-img.png')}}" alt="login-bottom-img.png">
        </div>
    </div>
@endsection

@section('styles')
    @parent

    {{ Html::style(mix('assets/auth/css/login.css')) }}
@endsection
