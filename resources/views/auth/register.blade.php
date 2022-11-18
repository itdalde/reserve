
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
                                {{ Form::open(['route' => 'register']) }}
                                <div>
                                    <input  autocomplete="new-password" type="text" name="first_name" class="form-control"
                                           placeholder="First Name"
                                           required/>
                                </div>
                                <div>
                                    <input autocomplete="new-password" type="text" name="last_name" class="form-control"
                                           placeholder="Last Name"
                                           required/>
                                </div>
                                <div>
                                    <input autocomplete="new-password" type="email" name="email" class="form-control"
                                           placeholder="{{ __('views.auth.register.input_1') }}"
                                           required/>
                                </div>
                                <div>
                                    <input autocomplete="new-password" type="password" name="password" class="form-control"
                                           placeholder="{{ __('views.auth.register.input_2') }}"
                                           required=""/>
                                </div>
                                <div>
                                    <input autocomplete="new-password" type="password" name="password_confirmation" class="form-control"
                                           placeholder="{{ __('views.auth.register.input_3') }}"
                                           required/>
                                </div>
                                <div>
                                    <input autocomplete="new-password" type="text" name="company_name" class="form-control"
                                           placeholder="Company Name"
                                           value="{{ old('company_name') }}" required autofocus/>
                                </div>
                                <div class="mb-4">
                                    <select name="service_type" required autofocus value="{{ old('service_type') }}" class="form-control" aria-label="Select Service Type">
                                        @if(isset($serviceTypes))
                                            @foreach($serviceTypes as $serviceType)
                                                <option value="{{$serviceType['id']}}">{{$serviceType['name']}}</option>
                                            @endforeach
                                        @endif
                                    </select>
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
