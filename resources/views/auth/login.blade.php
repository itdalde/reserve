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
                <div class="signin-p1">
                    <form method="POST" action="{{route('login')}}" class="sign-in-form ">

                        <div class="d-flex flex-column w-100 mx-auto">
                            <h2 class="title">
                                <div class="p-2 text-center">
                                    <img src="{{asset('assets/landing/img/logo-black.png')}}" alt="logo-black">

                                </div>
                            </h2>
                            @csrf

                            <div class="input-field">
                                <i class="bi bi-person-circle"></i>
                                <input type="email" class="form-control" name="email" value="{{ old('email') }}"
                                       placeholder="{{ __('views.auth.login.input_0') }}" required autofocus>
                            </div>
                            <div class="input-field">
                                <i class="bi bi-shield-lock"></i>
                                <input autocomplete="new-password" type="password" class="form-control" name="password"
                                       placeholder="{{ __('views.auth.login.input_1') }}" required/>
                                <i class="bi bi-eye-slash toggle-password"
                                   style="cursor: pointer;   margin-left: 590%;  margin-top: -57px;"></i>
                            </div>
                            <input type="submit" value="Login" class="btn solid  w-100"/>
                            @if (!old('first_name') && !$errors->isEmpty())
                                <div class="alert alert-danger" role="alert">
                                    {!! $errors->first() !!}
                                </div>
                            @endif
                        </div>
                    </form>
                </div>
                <div class="signup-p1">
                    <form method="POST" action="{{route('register')}}" class="hide sign-up-form">
                        @csrf
                        <div class="d-flex flex-column w-100mx-auto">
                            <h2 class="title">
                                <div class="p-2 text-center">
                                    <img src="{{asset('assets/landing/img/logo-black.png')}}" alt="logo-black">

                                </div>
                            </h2>
                            <div class="input-field">
                                <i class="bi bi-person-circle"></i>
                                <input required type="text" id="first_name" value="{{ old('first_name') }}"
                                       name="first_name"
                                       placeholder="First Name"/>
                            </div>
                            <div class="input-field">
                                <i class="bi bi-person-circle"></i>
                                <input required type="text" id="last_name" value="{{ old('last_name') }}"
                                       name="last_name"
                                       placeholder="Last Name"/>
                            </div>
                            <div class="input-field">
                                <i class="bi bi-envelope"></i>
                                <input id="email" type="email" name="email"
                                       class="mb-0 form-control"
                                       value="{{ old('email') }}"
                                       placeholder="Email"
                                       required/>
                            </div>

                            <div class="input-field">
                                <i class="bi bi-shield-lock"></i>

                                <input class="form-control password block mb-0 hide-if-valid"
                                       pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}"
                                       title="Must contain at least one number and one uppercase and lowercase letter, and at least 8 or more characters"
                                       id="password"
                                       type="password"
                                       name="password"
                                       style="width: 92%;
                                                            border-right: none;"
                                       placeholder="Password"
                                       autocomplete="new-password"
                                       required/>

                                <i class="bi bi-eye-slash toggle-password"
                                   style="cursor: pointer;   margin-left: 590%;  margin-top: -57px;"></i>
                            </div>

                            <div class="d-flex flex-column validations px-3">
                <span class="hide lcase invalid d-flex align-items-center pb-2 text-danger">At least one lowercase character <i
                        class="ps-2 bi bi-x-circle"></i> </span>
                                <span class="hide ucase invalid d-flex align-items-center pb-2 text-danger">At least one uppercase character <i
                                        class="ps-2 bi bi-x-circle"></i> </span>
                                <span class="hide onum invalid d-flex align-items-center pb-2 text-danger">At least one numeric character <i
                                        class="ps-2 bi bi-x-circle"></i> </span>
                                <span class="hide schar invalid d-flex align-items-center pb-2 text-danger">At least one special character <i
                                        class="ps-2 bi bi-x-circle"></i> </span>
                                <span class="hide mchar invalid d-flex align-items-center pb-2 text-danger">8-16 characters <i
                                        class="ps-2 bi bi-x-circle"></i> </span>
                            </div>

                            <div class="input-field"><i class="bi bi-people"></i>
                                <input id="company_name" autocomplete="new-password" type="text"
                                       name="company_name"
                                       class="mb-0 form-control"
                                       placeholder="Company Name"
                                       value="{{ old('company_name') }}" required autofocus/>
                            </div>
                            <div class="input-field"><i class="bi bi-card-checklist"></i>
                                <select id="service_type" name="service_type" required autofocus
                                        value="{{ old('service_type') }}"
                                        class="mb-0 form-control" aria-label="Select Service Type">
                                    <option value="">Service Type</option>
                                    @if(isset($serviceTypes))
                                        @foreach($serviceTypes as $serviceType)
                                            <option
                                                value="{{$serviceType['id']}}">{{$serviceType['name']}}</option>
                                        @endforeach
                                    @endif
                                </select>
                            </div>

                            <div class="input-field"><i class="bi bi-info-circle"></i>
                                <textarea id="company_description" type="text" name="company_description"
                                          class="mb-0 form-control"
                                          placeholder="Company Description"
                                          value="{{ old('company_description') }}" autofocus></textarea>
                            </div>

                            @if (old('first_name') && !$errors->isEmpty())
                                <div class="alert alert-danger" role="alert">
                                    {!! $errors->first() !!}
                                </div>
                            @endif

                            @if(config('auth.captcha.registration'))
                                @captcha()
                            @endif

                            <div class="pt-5">
                                <button id="btn-submit-change-pass " type="submit"
                                        class="btn btn-default bg-orange submit w-100">Sign up
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="panels-container col-sm-12  col-md-12 col-lg-6 ">
        <div class="panel left-panel">
            <div class="content " data-aos-once="false" data-aos-mirror="true" data-aos="zoom-in">
                <h3>Don't have an account ? </h3>
                <p>
                    Welcome to Reservgcc
                </p>
                <button class="btn transparent w-100" id="sign-up-btn">
                    Register Service Provider
                </button>
            </div>
            <img data-aos-once="false" data-aos-mirror="true" data-aos="zoom-in" src="/assets/landing/img/6207967.jpg"
                 class="image img-fluid img-sign-in" alt="..."/>
        </div>
        <div class="panel right-panel">
            <div class="content">
                <h3>Already registered</h3>
                <button class="btn transparent w-100 " id="sign-in-btn">
                    Login Service Provider
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
                <div class="modal-body ">
                    <div class="text-center par-1 mb-5">
                        <div>Thanks for signing up</div>
                        <div class="user-name">{{Session::get('name')}}</div>
                    </div>
                    <div class="text-center par-2 text-muted">
                        <h4 class="text-black"> Application sent successfully!</h4>
                        <p>Your application has been sent! Someone from our team will review your request and get back
                            to you via e-mail within 2-3 working days</p>

                    </div>
                </div>
                <div class="modal-footer bg-transparent text-center border-0">
                    <a class="w-100 btn bg-orange solid " style="    line-height: 36px;" href="/">Return Home</a>
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
        @if (Session::has('signup'))
        $('#signupSuccessModal').modal('show');
        @endif
        let data = "{{old('first_name')}}";
        if (data) {
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

