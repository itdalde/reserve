<link href="{{ asset('assets/landing/vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
<link href="{{ asset('assets/landing/vendor/bootstrap-icons/bootstrap-icons.css') }}" rel="stylesheet">
<link href="{{ asset('assets/landing/vendor/boxicons/css/boxicons.min.css') }}" rel="stylesheet">
<link href="{{ asset('assets/landing/vendor/glightbox/css/glightbox.min.css') }}" rel="stylesheet">
<link href="{{ asset('assets/landing/vendor/swiper/swiper-bundle.min.css') }}" rel="stylesheet">
@extends('auth.layouts.auth')

@section('body_class','register')

@section('content')
    <div class=" d-flex justify-content-between">
        <div class="p-0">
            <img class="auth-img-top" src="{{asset('assets/auth/img/login-img-top.png')}}" alt="login-img-top">
        </div>
        <div class="p-0">
            <div class="container">
                <div class="row mx-auto mt-5" style="width:40em;">

                    <div class="p-2 text-center">
                        <img src="{{asset('assets/landing/img/logo-black.png')}}" alt="logo-black">

                    </div>
                    <div class="p-2 mt-5">
                        <div class="card">
                            <div class="card-body px-5">
                                <div class="login_content" style="text-align: left !important;">
                                    {{ Form::open(['route' => 'register']) }}
                                    <div class="form-group">
                                        <label for="first_name">First Name</label>
                                        <input id="first_name" autocomplete="new-password" type="text" name="first_name"
                                               class="mb-0 form-control"
                                               placeholder="First Name"
                                               required/>
                                    </div>
                                    <div class="form-group">
                                        <label for="last_name" class="col-form-label">Last Name</label>
                                        <input id="last_name" autocomplete="new-password" type="text" name="last_name"
                                               class="mb-0 form-control"
                                               placeholder="Last Name"
                                               required/>
                                    </div>
                                    <div class="form-group">
                                        <label for="email" class="col-form-label">Email</label>
                                        <input id="email" autocomplete="new-password" type="email" name="email"
                                               class="mb-0 form-control"
                                               placeholder="{{ __('views.auth.register.input_1') }}"
                                               required/>
                                    </div>
                                    <div class="form-group">
                                        <div class="d-flex ">
                                            <div class="flex-fill">

                                                <label for="password" class="col-form-label">Password</label>

                                                <div class="input-group">
                                                    <input class="form-control password block mb-0 hide-if-valid"
                                                           pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}"
                                                           title="Must contain at least one number and one uppercase and lowercase letter, and at least 8 or more characters"
                                                           id="password"
                                                           type="password"
                                                           name="password"
                                                           style="width: 92%;
                                                            border-right: none;"
                                                           placeholder="{{ __('views.auth.register.input_2') }}"
                                                           autocomplete="new-password"
                                                           required />
                                                    <span class="input-group-text" id="basic-addon2"
                                                            style="height: 34px;
                                                            background: none;
                                                            border-left: none;
                                                            font-size: 20px;"
                                                    >
                                                        <i class="bi bi-eye-slash toggle-password" style="cursor: pointer"></i>
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="d-flex flex-column validations px-3">
                                        <span class="hide lcase invalid d-flex align-items-center pb-2 text-danger">At least one lowercase character <i class="ps-2 bi bi-x-circle"></i> </span>
                                        <span class="hide ucase invalid d-flex align-items-center pb-2 text-danger">At least one uppercase character <i class="ps-2 bi bi-x-circle"></i> </span>
                                        <span class="hide onum invalid d-flex align-items-center pb-2 text-danger">At least one numeric character <i class="ps-2 bi bi-x-circle"></i> </span>
                                        <span class="hide schar invalid d-flex align-items-center pb-2 text-danger">At least one special character <i class="ps-2 bi bi-x-circle"></i> </span>
                                        <span class="hide mchar invalid d-flex align-items-center pb-2 text-danger">8-16 characters <i class="ps-2 bi bi-x-circle"></i> </span>
                                    </div>
                                    <div class="form-group">
                                        <label for="company_name" class="col-form-label">Company Name</label>
                                        <input id="company_name" autocomplete="new-password" type="text"
                                               name="company_name"
                                               class="mb-0 form-control"
                                               placeholder="Company Name"
                                               value="{{ old('company_name') }}" required autofocus/>
                                    </div>
                                    <div class="form-group">
                                        <label for="password" class="col-form-label">Service Type</label>
                                        <select id="service_type" name="service_type" required autofocus
                                                value="{{ old('service_type') }}"
                                                class="mb-0 form-control" aria-label="Select Service Type">
                                            @if(isset($serviceTypes))
                                                @foreach($serviceTypes as $serviceType)
                                                    <option
                                                        value="{{$serviceType['id']}}">{{$serviceType['name']}}</option>
                                                @endforeach
                                            @endif
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="company_description" class="col-form-label">Description</label>
                                        <textarea id="company_description" type="text" name="company_description"
                                                  class="mb-0 form-control"
                                                  placeholder="Company Description"
                                                  value="{{ old('company_description') }}" autofocus></textarea>
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
                                        <button id="btn-submit-change-pass" type="submit"
                                                class="btn btn-default bg-orange submit w-100">Submit
                                        </button>
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
    {{ Html::style(mix('assets/auth/css/register.css')) }}
@endsection
@section('scripts')
    <script>

        $(".toggle-password").click(function() {

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

                    if (pass.length >= 8 && pass.match(char) && pass.match(numbers) && pass.match(upperCaseLetters) && pass.match(lowerCaseLetters)) {
                        btn.attr('disabled', false)
                    } else {
                        btn.attr('disabled', true)
                    }
                } else {
                    btn.attr('disabled', false)
                    //$('.validations').find('span').addClass('hide');
                }
        });

    </script>
@endsection
