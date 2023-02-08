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
    <link href="{{ asset('assets/auth/css/login.css') }}" rel="stylesheet">

</head>
<body data-aos-once="false">
<div class="container row mx-auto" data-aos-once="false" data-aos-mirror="true" data-aos="zoom-in">
    <div class="forms-container col-sm-12 col-md-12  col-lg-6 ">
        <div class="signin-signup">
            <div class="d-flex align-content-end flex-wrap">
                <div class="signin-p1 sign-in-form mx-auto">
                    <form method="POST" action="{{route('login')}}" class=" ">

                        <div class="d-flex flex-column w-100 mx-auto " style="{{__('home.home')  == 'Home' ? 'direction: ltr;' : 'direction: rtl;'}}">
                            <h2 class="title">
                                <div class="p-2 text-center">
                                    <a href="/">
                                        <img src="{{asset('assets/landing/img/logo-black.png')}}" alt="logo-black">
                                    </a>

                                </div>
                            </h2>
                            @csrf

                            <div class="input-field">
                                <i class="bi bi-person-circle"></i>
                                <input type="email" class="form-control" name="email" value="{{ old('email') }}"
                                       placeholder="{{ __('login.E-Mail address') }}" required autofocus>
                            </div>
                            <div class="input-field">
                                <i class="bi bi-shield-lock"></i>
                                <input autocomplete="new-password" type="password" class="form-control" name="password"
                                       placeholder="{{ __('login.Password') }}" required/>
                                <i class="bi bi-eye-slash toggle-password"
                                   style="cursor: pointer;  {{__('home.home')  == 'Home' ? 'margin-left: 590%;' : 'margin-left: 0;'}}   margin-top: -57px;"></i>
                            </div>
                            <input type="submit" value="{{ __('login.login_btn') }}" class="btn solid  w-100"/>
                            @if (!old('first_name') && !$errors->isEmpty())
                                <div class="alert alert-danger" role="alert">
                                    {!! $errors->first() !!}
                                </div>
                            @endif
                        </div>
                    </form>
                </div>
                <div class="signup-p1 sign-up-form mx-auto hide">
                    <div class="row">

                        <form method="POST" action="{{route('register')}}" class=" ">
                            @csrf
                            <div class="p-3">
                                <div class="card" style="    min-width: 100%;
                                    width: 106%;
                                    max-width: 200%; border: none">
                                    <div class="card-body" style="{{__('home.home')  == 'Home' ? 'direction: ltr;' : 'direction: rtl;'}}">
                                        <div class="d-flex flex-column w-100 mx-auto">
                                            <h2 class="title">
                                                <div class="p-2 text-center">
                                                    <a href="/">
                                                        <img src="{{asset('assets/landing/img/logo-black.png')}}"
                                                             alt="logo-black">
                                                    </a>
                                                </div>
                                            </h2>
                                            <div class="p-1 signup-container" style="    max-height: 68vh; overflow-y: auto;">
                                                <div class="control-group p-1 mx-auto">
                                                    <label for="">{{__('login.Company Name')}} <strong class="text-danger"> * </strong></label> <br>
                                                    <div class="ms-2 input-field">
                                                        <i class="bi bi-people"></i>
                                                        <input id="company_name" autocomplete="new-password" type="text"
                                                               name="company_name"
                                                               class="mb-0 form-control w-100"
                                                               value="{{ old('company_name') }}" required autofocus/>
                                                    </div>
                                                </div>
                                                <div class="control-group p-1 mx-auto">
                                                    <label for="">{{__('login.Full Name')}} <strong class="text-danger"> * </strong></label> <br>
                                                    <div class="ms-2 input-field">
                                                        <i class="bi bi-person-circle"></i>
                                                        <input required type="text" id="first_name"
                                                               value="{{ old('full_name') }}"
                                                               name="full_name"
                                                               class="mb-0 form-control w-100" />
                                                    </div>
                                                </div>

                                                <div class="control-group p-1 mx-auto">
                                                    <label for="">{{__('login.Position')}} <strong class="text-danger"> * </strong></label> <br>
                                                    <div class="ms-2 input-field">
                                                        <i class="bi bi-award"></i>
                                                        <input type="text" id="position" value="{{ old('position') }}"
                                                               name="position"
                                                               class="mb-0 form-control w-100" />
                                                    </div>
                                                </div>

                                                <div class="control-group p-1 mx-auto">
                                                    <label for="">{{__('login.Phone number')}} <strong class="text-danger"> * </strong></label> <br>
                                                    <div class="ms-2 input-field">
                                                        <i class="bi bi-telephone"></i>
                                                        <input required type="text" id="phone_number"
                                                               value="{{ old('phone_number') }}"
                                                               name="phone_number"
                                                               class="mb-0 form-control w-100" />
                                                    </div>
                                                </div>

                                                <div class="control-group p-1 mx-auto">
                                                    <label for="">{{__('login.Email')}} <strong class="text-danger"> * </strong></label> <br>
                                                    <div class="ms-2 input-field">
                                                        <i class="bi bi-envelope"></i>
                                                        <input id="email" type="email" name="email"
                                                               class="mb-0 form-control w-100"
                                                               value="{{ old('email') }}"
                                                               required/>
                                                    </div>

                                                </div>

                                                <div class="control-group p-1 mx-auto">
                                                    <label for="">{{__('login.location')}} </label> <br>
                                                    <div class="ms-2 input-field"><i class="bi bi-geo-alt"></i>
                                                        <input type="text" id="location" value="{{ old('location') }}"
                                                               name="location"
                                                               class="mb-0 form-control w-100">
                                                    </div>
                                                </div>

                                                <div class="control-group p-1 mx-auto">
                                                    <label for="">{{__('login.registration_number')}} <strong class="text-danger"> * </strong></label> <br>
                                                    <div class="ms-2 input-field">
                                                        <i class="bi bi-journal-text"></i>
                                                        <input type="text" id="registration_number"
                                                               value="{{ old('registration_number') }}"
                                                               name="registration_number"
                                                               class="mb-0 form-control w-100"
                                                               required/>
                                                    </div>
                                                </div>

                                                <div class="control-group p-1 mx-auto">
                                                    <label for="">{{__('login.Password')}} <strong class="text-danger"> * </strong></label> <br>
                                                    <div class="ms-2 input-field">
                                                        <i class="bi bi-shield-lock"></i>

                                                        <input
                                                            class="form-control password block mb-0 hide-if-valid w-100"
                                                            pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}"
                                                            title="{{__('login.password_role')}}"
                                                            id="password"
                                                            type="password"
                                                            name="password"
                                                            style="width: 92%;
                                                            border-right: none;"
                                                            autocomplete="new-password"
                                                            required/>
                                                        <i class="bi bi-eye-slash toggle-password"
                                                           style="cursor: pointer;  {{__('home.home')  == 'Home' ? 'margin-left: 590%;' : 'margin-left: 0;'}}   margin-top: -57px;"></i>

                                                    </div>
                                                </div>

                                                <div class="d-flex flex-column validations px-3">
                                                    <span
                                                        class="hide lcase invalid d-flex align-items-center pb-2 text-danger">{{__('login.password_role1')}}
                                                        <i class="ps-2 bi bi-x-circle"></i>
                                                    </span>
                                                    <span
                                                        class="hide ucase invalid d-flex align-items-center pb-2 text-danger">{{__('login.password_role2')}}
                                                        <i class="ps-2 bi bi-x-circle"></i> </span>
                                                    <span
                                                        class="hide onum invalid d-flex align-items-center pb-2 text-danger">{{__('login.password_role3')}}
                                                        <i class="ps-2 bi bi-x-circle"></i> </span>
                                                    <span
                                                        class="hide schar invalid d-flex align-items-center pb-2 text-danger">{{__('login.password_role4')}}
                                                        <i class="ps-2 bi bi-x-circle"></i> </span>
                                                    <span
                                                        class="hide mchar invalid d-flex align-items-center pb-2 text-danger">{{__('login.password_role5')}}
                                                        <i class="ps-2 bi bi-x-circle"></i> </span>
                                                </div>


                                                <div class="control-group p-1 mx-auto">
                                                    <label for="">{{__('login.Select Service Type')}} <strong class="text-danger"> * </strong></label> <br>
                                                    <div class="ms-2 input-field">
                                                        <i class="bi bi-card-checklist"></i>

                                                        <input type="text" id="service_type"
                                                               value="{{ old('service_type') }}"
                                                               name="service_type"
                                                               class="mb-0 form-control w-100"
                                                               required/>
                                                    </div>
                                                </div>
                                                <input type="hidden" name="company_description">

                                                @if (old('first_name') && !$errors->isEmpty())
                                                    <div class="alert alert-danger" role="alert">
                                                        {!! $errors->first() !!}
                                                    </div>
                                                @endif

                                                @if(config('auth.captcha.registration'))
                                                    @captcha()
                                                @endif
                                            </div>


                                            <div class="pt-3">
                                                <button id="btn-submit-change-pass " type="submit"
                                                        class="btn btn-default bg-orange submit w-100">{{__('login.Sign up')}}
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="panels-container col-sm-12  col-md-12 col-lg-6 ">
        <div class="panel left-panel">
            <div class="content " data-aos-once="false" data-aos-mirror="true" data-aos="zoom-in">
                <h3>{{__('login.have an account')}} </h3>
                <p>
                    {{__('login.Welcome to Reservgcc')}}
                </p>
                <button class="btn transparent w-100" id="sign-up-btn">
                    {{__('login.Register Service Provider')}}
                </button>
            </div>
            <img data-aos-once="false" data-aos-mirror="true" data-aos="zoom-in" src="/assets/landing/img/6207967.jpg"
                 class="image img-fluid img-sign-in" alt="..."/>
        </div>
        <div class="panel right-panel">
            <div class="content">
                <h3>{{__('login.Already registered')}}</h3>
                <button class="btn transparent w-100 " id="sign-in-btn">
                    {{__('login.Login Service Provider')}}
                </button>
            </div>
            <img src="/assets/landing/img/6206973.jpg" class="image img-fluid img-sign-up" alt="..."/>
        </div>
    </div>
</div>

@if (Session::has('signup'))
    <div class="modal fade" id="signupSuccessModal" tabindex="-1" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content py-4 px-md-4 px-sm-4 px-3">
                <div class="modal-header justify-content-center border-0">
                    <img src="{{asset('assets/landing/img/logo-black.png')}}" alt="logo-black">
                </div>
                <div class="modal-body " style="{{__('home.home')  == 'Home' ? 'direction: ltr;' : 'direction: rtl;'}}">
                    <div class="text-center par-2 ">
                        <p class="text-black"> {{__('login.Application sent successfully!')}}</p>
                        <p>{{__('login.review')}}</p>

                    </div>
                </div>
                <div class="modal-footer bg-transparent text-center border-0">
                    <a class="w-100 btn bg-orange solid " style="    line-height: 36px;"
                       href="/">{{__('login.Return Home')}}</a>
                </div>
            </div>
        </div>
    </div>
@endif
<script src="{{asset('assets/libs/jquery/dist/jquery.min.js')}}"></script>
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
    const sign_in_btn = document.querySelector("#sign-in-btn");
    const sign_up_btn = document.querySelector("#sign-up-btn");
    const container = document.querySelector(".container");

    sign_up_btn.addEventListener("click", () => {
        container.classList.add("sign-up-mode");
    });

    sign_in_btn.addEventListener("click", () => {
        container.classList.remove("sign-up-mode");
    });
</script>

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
        let data = "{{old('first_name')}}";
        if (data) {
            onCLickSignUp()
        }

        function onCLickSignUp() {
            $('#sign-up-btn').click();
            $('.sign-in-form').removeClass('show').addClass('hide')
            setTimeout(function () {
                $('.sign-up-form').addClass('show').removeClass('hide')
            }, 1000);
        }

        $('body').on('click', '#sign-up-btn', function (e) {
            $('.sign-in-form').removeClass('show').addClass('hide')
            setTimeout(function () {
                $('.sign-up-form').addClass('show').removeClass('hide')
            }, 1000);
        });

        $('body').on('click', '#sign-in-btn', function (e) {
            $('.sign-up-form').removeClass('show').addClass('hide')
            setTimeout(function () {
                $('.sign-in-form').addClass('show').removeClass('hide')
            }, 1000);
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
    });
</script>
</body>
</html>

