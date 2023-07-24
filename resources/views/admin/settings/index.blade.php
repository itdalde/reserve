@extends('layouts.admin')
@section('content')
<div class="container">
    <div class="row">
        <div class="col-4">
            <h3>Settings</h3>
        </div>
        <div class="card w-100">
            <div class="card-body">
                <ul class="nav nav-tabs" id="myTab" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active" id="userProfile-tab" data-bs-toggle="tab"
                            data-bs-target="#userProfile" type="button" role="tab" aria-controls="userProfile"
                            aria-selected="true">User Profile</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="companyProfile-tab" data-bs-toggle="tab"
                            data-bs-target="#companyProfile" type="button" role="tab" aria-controls="companyProfile"
                            aria-selected="false">Company Profile</button>
                    </li>
                </ul>
                <div class="tab-content" id="myTabContent">
                    <div class="tab-pane fade show active" id="userProfile" role="tabpanel" aria-labelledby="userProfile-tab"
                        style="min-height: 140px;">

                        <div class="d-flex flex-column bd-highlight">
                            <form action="{{route('settings.store')}}" method="post" enctype="multipart/form-data">
                                @csrf
                                <div class="p-2 bd-highlight">
                                    <div class="d-flex justify-content-around  flex-wrap">
                                        <div class="p-1">

                                            <a href="#" class="profile-image-holder">
                                                @if(Auth::user() && Auth::user()->profile_picture )
                                                <img width="200" id="profile-image-view"
                                                    src="{{Auth::user()->profile_picture }}" alt="...." />
                                                @else
                                                <img width="200" id="profile-image-view"
                                                    src="{{asset('assets/images/icons/image-select.png')}}" alt="...">
                                                @endif
                                            </a>
                                            <input
                                                onchange="document.getElementById('profile-image-view').src = window.URL.createObjectURL(this.files[0])"
                                                id="profile-image-file" accept="image/png, image/gif, image/jpeg"
                                                type="file" class="d-none" name="profile_image">

                                            <div class="mx-auto text-center">
                                                <label for="">User Profile</label>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="p-2 bd-highlight">
                                    <div class="row mt-5">
                                        <div class="col-xs-12 col-md-6 mt-5">
                                            <label class="form-label" for="first-name"> First Name</label>
                                            <input value="{{Auth::user()->first_name}}" type="text" id="first-name"
                                                name="first_name" class="form-control" placeholder="First name"
                                                aria-label="First name">
                                        </div>
                                        <div class="col-xs-12 col-md-6 mt-5">
                                            <label class="form-label" for="last-name"> Last Name</label>
                                            <input value="{{Auth::user()->last_name}}" id="last-name" type="text"
                                                name="last_name" class="form-control" placeholder="Last name"
                                                aria-label="Last name">
                                        </div>
                                    </div>
                                    <div class="row mt-5">
                                        <div class="col-xs-12 col-md-6 mt-5">
                                            <label class="form-label" for="phone-number"> Phone Number</label>
                                            <input value="{{Auth::user()->phone_number}}" type="text" id="phone-number"
                                                name="phone_number" class="form-control" placeholder="Phone number"
                                                aria-label="Phone number">
                                        </div>
                                        <div class="col-xs-12 col-md-6 mt-5 ">
                                            <label class="form-label" for="email"> Email</label>
                                            <input value="{{Auth::user()->email}}" id="email" name="email" type="email"
                                                class="form-control" placeholder="Email Address"
                                                aria-label="Email Address" readonly>
                                        </div>
                                    </div>
                                    <div class="row mt-5">
                                        <div class="col-xs-12 col-md-6 ">

                                            <div class="input-group input-group-lg first pt-3">
                                                <span class="input-group-text rounded-0 bg-white">
                                                    <i class="bi bi-shield-lock"></i>
                                                </span>
                                                <input type="password"
                                                    class="form-control shadow-none rounded-0 border-start-0 hide-if-valid fs-5"
                                                    placeholder="Enter your password" id="password" name="password"
                                                    pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}"
                                                    autocomplete="new-password" title="{{ __('login.password_role') }}"
                                                    required>

                                                <span class="input-group-text rounded-0 bg-white border-start-0"
                                                    role="button" style="margin-left: -1px;">
                                                    <i class="bi bi-eye-slash toggle-password"></i>
                                                </span>
                                            </div>
                                        </div>

                                    </div>

                                    <!-- Password Rules -->
                                    <div class="d-flex flex-column validations mt-3">
                                        <span class="d-none lcase invalid d-flex align-items-center pb-2 text-danger">{{
                                            __('login.password_role1') }}
                                            <i class="ps-2 bi bi-x-circle"></i>
                                        </span>
                                        <span class="d-none ucase invalid d-flex align-items-center pb-2 text-danger">{{
                                            __('login.password_role2') }}
                                            <i class="ps-2 bi bi-x-circle"></i> </span>
                                        <span class="d-none onum invalid d-flex align-items-center pb-2 text-danger">{{
                                            __('login.password_role3') }}
                                            <i class="ps-2 bi bi-x-circle"></i> </span>
                                        <span class="d-none schar invalid d-flex align-items-center pb-2 text-danger">{{
                                            __('login.password_role4') }}
                                            <i class="ps-2 bi bi-x-circle"></i> </span>
                                        <span class="d-none mchar invalid d-flex align-items-center pb-2 text-danger">{{
                                            __('login.password_role5') }}
                                            <i class="ps-2 bi bi-x-circle"></i> </span>
                                    </div>

                                    <div class="d-flex justify-content-end button-panel">
                                        <div class="row button-container">
                                            <div class="col">
                                                <div class="d-flex bd-highlight mt-5 mb-3">
                                                    <div class="p-2 submit-button bd-highlight">
                                                        <button
                                                            class="btn w-100 btn-warning bg-orange text-light">Save</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="companyProfile" role="tabpanel"
                        aria-labelledby="inActiveInquiries-tab" style="min-height: 140px;">

                        <div class="d-flex flex-column bd-highlight">
                            <form action="{{route('settings.company_update')}}" method="post"
                                enctype="multipart/form-data">
                                @csrf
                                <div class="p-2 bd-highlight">
                                    <div class="d-flex justify-content-around  flex-wrap">
                                        <div class="p-1">

                                            <a href="#" class="company-image-holder">
                                                @if(Auth::user() && Auth::user()->company &&
                                                Auth::user()->company->logo)
                                                <img width="200" id="company-image-view"
                                                    src="{{Auth::user()->company->logo }}" alt="...." />
                                                @else
                                                <img width="200" id="company-image-view"
                                                    src="{{asset('assets/images/icons/image-select.png')}}" alt="...">
                                                @endif
                                            </a>
                                            <input
                                                onchange="document.getElementById('company-image-view').src = window.URL.createObjectURL(this.files[0])"
                                                id="company-image-file" accept="image/png, image/gif, image/jpeg"
                                                type="file" class="d-none" name="company_image">

                                            <div class="mx-auto text-center">
                                                <label for="">Company Profile</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="p-2 bd-highlight">
                                    <div class="row mt-5">
                                        <div class="col-xs-12 col-md-6 mt-5">
                                            <label class="form-label" for="company-name-name"> Company Name</label>
                                            <input value="{{Auth::user()->company ? Auth::user()->company->name : ''}}"
                                                type="text" id="company-name-name" autocomplete="new-password"
                                                name="name" class="form-control" placeholder="Company name"
                                                aria-label="Company name">
                                        </div>
                                        <div class="col-xs-12 col-md-6 mt-5">
                                            <label class="form-label" for="phone-number">Company Phone Number</label>
                                            <input
                                                value="{{Auth::user()->company ? Auth::user()->company->phone_number : ''}}"
                                                type="text" id="phone-number" autocomplete="new-password"
                                                name="phone_number" class="form-control" placeholder="Phone number"
                                                aria-label="Phone number">
                                        </div>
                                    </div>

                                    <div class="row mt-5">
                                        <div class="col-xs-12 col-md-6">
                                            <label class="form-label" for="phone-number">Availability Days</label>
                                            <input
                                                value="{{Auth::user()->company ? Auth::user()->company->business_days : ''}}"
                                                type="text" id="availability" autocomplete="availability"
                                                name="availability" class="form-control"
                                                placeholder="Enter Availability Days"
                                                aria-label="Enter Availability Days">
                                        </div>

                                        <div class="col-xs-12 col-md-6">
                                            <label class="form-label" for="phone-number">Business Hours</label>
                                            <div class="row">
                                                <div class="col-6">
                                                    <input
                                                        value="{{Auth::user()->company ? Auth::user()->company->open_at : ''}}"
                                                        type="text" id="open_at" autocomplete="open_at"
                                                        name="open_at" class="form-control"
                                                        placeholder="Opens At"
                                                        aria-label="Opens At">
                                                </div>
                                                <div class="col-6">
                                                    <input
                                                        value="{{Auth::user()->company ? Auth::user()->company->close_at : ''}}"
                                                        type="text" id="close_at" autocomplete="close_at"
                                                        name="close_at" class="form-control"
                                                        placeholder="Close At"
                                                        aria-label="Close At">
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row mt-5 d-none">
                                        <div class="col company-tags mt-5">
                                            <label class="form-label" for="company-tags-input"> Meta Tags</label>
                                            <input value="{{Auth::user()->company ? Auth::user()->company->tags : ''}}"
                                                type="text" id="company-tags-input" autocomplete="new-password"
                                                name="tags" class="form-control" placeholder="Company tags"
                                                aria-label="Company tags">
                                        </div>
                                    </div>
                                    <div class="row mt-5 d-none">
                                        <div class="col-xs-12 col-md-6">
                                            <label class="form-label" for="address">Company Address</label>
                                            <input
                                                value="{{Auth::user()->company ? Auth::user()->company->location : ''}}"
                                                id="address" name="location" autocomplete="new-password" type="text"
                                                class="form-control" placeholder="Address" aria-label="Address">
                                        </div>
                                        <div class="col-xs-12 col-md-6">
                                            <div class="form-check form-switch pt-3 mt-5">
                                                <input {{Auth::user()->company && Auth::user()->company->is_custom == 1
                                                ? 'Checked' : ''}} class="form-check-input" name="is_custom"
                                                type="checkbox" id="Accepts-custom-order">
                                                <label class="form-check-label" for="Accepts-custom-order">Accepts
                                                    custom order</label>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row mt-5">
                                        <div class="col-12">
                                            <label class="form-label" for="password">Company Description</label>
                                            <div class="">
                                                <textarea dir="auto" name="description" class="form-control"
                                                    placeholder="Enter Company description" id="description" cols="4"
                                                    rows="6">{{Auth::user()->company ? Auth::user()->company->description : ''}}</textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="d-flex justify-content-end button-panel">
                                    <div class="row button-container">
                                        <div class="col">
                                            <div class="d-flex bd-highlight mt-5 mb-3">
                                                <div class=" p-2 submit-button bd-highlight">
                                                    <button
                                                        class="btn w-100 btn-warning bg-orange text-light">Save</button>
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
    </div>
</div>
@endsection
@section('content_javascript')
<script>
    $(document).ready(function () {

        $('#company-tags-input').tagsinput();


        const $textarea = $('#description');

        $textarea.on('change keyup blur', function () {
            const maxWords = 25;
            const text = $textarea.val().trim();
            const words = text.trim().split(/\s+/);
            if (words.length > maxWords) {
                const truncatedText = words.slice(0, maxWords).join(' ');
                $textarea.val(truncatedText + ' ');
            }
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
            if (this.value.length) {
                $('.validations').removeClass('d-none');
            } else {
                $('.validations').addClass('d-none');
            }

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
                        $('.lcase').addClass('d-none');
                    }
                    $('.lcase').addClass('valid').removeClass('invalid')
                    $('.lcase span').text('check_circle_outline');

                } else {
                    if (hideIfValid) {
                        $('.lcase').removeClass('d-none');
                    }
                    $('.lcase').addClass('invalid').removeClass('valid')
                    $('.lcase span').text('highlight_off');
                }

                if (pass.match(upperCaseLetters)) {
                    if (hideIfValid) {
                        $('.ucase').addClass('d-none');
                    }
                    $('.ucase').addClass('valid').removeClass('invalid')
                    $('.ucase span').text('check_circle_outline');
                } else {
                    if (hideIfValid) {
                        $('.ucase').removeClass('d-none');
                    }
                    $('.ucase').addClass('invalid').removeClass('valid')
                    $('.ucase span').text('highlight_off');
                }

                if (pass.match(numbers)) {
                    if (hideIfValid) {
                        $('.onum').addClass('d-none');
                    }
                    $('.onum').addClass('valid').removeClass('invalid')
                    $('.onum span').text('check_circle_outline');
                } else {
                    if (hideIfValid) {
                        $('.onum').removeClass('d-none');
                    }
                    $('.onum').addClass('invalid').removeClass('valid')
                    $('.onum span').text('highlight_off');

                }

                if (pass.match(char)) {
                    if (hideIfValid) {
                        $('.schar').addClass('d-none');
                    }
                    $('.schar').addClass('valid').removeClass('invalid')
                    $('.schar span').text('check_circle_outline');
                } else {
                    if (hideIfValid) {
                        $('.schar').removeClass('d-none');
                    }
                    $('.schar').addClass('invalid').removeClass('valid')
                    $('.schar span').text('highlight_off');
                }

                if (pass.length >= 8) {
                    if (hideIfValid) {
                        $('.mchar').addClass('d-none');
                    }
                    $('.mchar').addClass('valid').removeClass('invalid')
                    $('.mchar span').text('check_circle_outline');
                } else {
                    if (hideIfValid) {
                        $('.mchar').removeClass('d-none');
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
                // $('.validations').find('span').addClass('hide');
            }
        });
    });
</script>
@endsection