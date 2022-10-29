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
                                {{ Form::open(['route' => 'register']) }}
                                <div>
                                    <input type="email" name="email" class="form-control"
                                           placeholder="{{ __('views.auth.register.input_1') }}"
                                           required/>
                                </div>
                                <div>
                                    <input type="password" name="password" class="form-control"
                                           placeholder="{{ __('views.auth.register.input_2') }}"
                                           required=""/>
                                </div>
                                <div>
                                    <input type="password" name="password_confirmation" class="form-control"
                                           placeholder="{{ __('views.auth.register.input_3') }}"
                                           required/>
                                </div>
                                <div>
                                    <input type="text" name="company_name" class="form-control"
                                           placeholder="Company Name"
                                           value="{{ old('company_name') }}" required autofocus/>
                                </div>
                                <div>
                                    <textarea type="text" name="company_description" class="form-control"
                                           placeholder="Company Description"
                                              value="{{ old('company_description') }}"  autofocus></textarea>
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

                                @if(config('auth.captcha.registration'))
                                    @captcha()
                                @endif

                                <div class="pt-5">
                                    <button type="submit"
                                            class="btn btn-default bg-orange submit w-50">Submit</button>
                                </div>

                                {{ Form::close() }}
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
