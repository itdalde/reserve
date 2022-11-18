@extends('layouts.admin')
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-4">
                <h3>Settings</h3>
            </div>
            <div class="card w-100" >
                <div class="card-body">
                    <div class="d-flex flex-column bd-highlight">
                        <form action="{{route('settings.store')}}" method="post" enctype="multipart/form-data">
                            @csrf
                            <div class="p-2 bd-highlight">
                                <div class="d-flex justify-content-around  flex-wrap">
                                    <div class="p-1">

                                        <a href="#" class="profile-image-holder">
                                            @if(Auth::user() && Auth::user()->profile_picture )
                                                <img width="200" id="profile-image-view" src="{{Auth::user()->profile_picture }}" alt="...."   />
                                            @else
                                                <img width="200" id="profile-image-view" src="{{asset('assets/images/icons/image-select.png')}}" alt="...">
                                            @endif
                                        </a>
                                        <input
                                            onchange="document.getElementById('profile-image-view').src = window.URL.createObjectURL(this.files[0])"
                                            id="profile-image-file" accept="image/png, image/gif, image/jpeg" type="file"
                                            class="d-none" name="profile_image" >

                                        <div class="mx-auto text-center">
                                            <label for="">User Profile</label>

                                        </div>
                                    </div>
                                    <div class="p-1">

                                        <a href="#" class="company-image-holder">
                                            @if(Auth::user() && Auth::user()->company && Auth::user()->company->logo)
                                                <img width="200" id="company-image-view" src="{{Auth::user()->company->logo }}" alt="...."   />
                                            @else
                                                <img width="200" id="company-image-view" src="{{asset('assets/images/icons/image-select.png')}}" alt="...">
                                            @endif
                                        </a>
                                        <input
                                            onchange="document.getElementById('company-image-view').src = window.URL.createObjectURL(this.files[0])"
                                            id="company-image-file" accept="image/png, image/gif, image/jpeg" type="file"
                                            class="d-none" name="company_image" >

                                        <div class="mx-auto text-center">
                                            <label for="">Company Profile</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="p-2 bd-highlight">
                                <div class="row m-3">
                                    <div class="col">
                                        <label class="form-label" for="first-name"> First Name</label>
                                        <input value="{{Auth::user()->first_name}}" type="text" id="first-name" autocomplete="new-password" name="first_name" class="form-control" placeholder="First name" aria-label="First name">
                                    </div>
                                    <div class="col">
                                        <label class="form-label" for="last-name"> Last Name</label>
                                        <input value="{{Auth::user()->last_name}}" id="last-name" type="text" autocomplete="new-password" name="last_name" class="form-control" placeholder="Last name" aria-label="Last name">
                                    </div>
                                </div>
                                <div class="row m-3">
                                    <div class="col">
                                        <label class="form-label" for="phone-number"> Phone Number</label>
                                        <input value="{{Auth::user()->phone_number}}" type="text" id="phone-number"  autocomplete="new-password" name="phone_number" class="form-control" placeholder="Phone number" aria-label="Phone number">
                                    </div>
                                    <div class="col">
                                        <label class="form-label" for="address"> Address</label>
                                        <input value="{{Auth::user()->location}}" id="address" name="location" autocomplete="new-password" type="text" class="form-control" placeholder="Address" aria-label="Address">
                                    </div>
                                </div>
                                <div class="row m-3">
                                    <div class="col">
                                        <label class="form-label" for="password"> Password</label>
                                        <input  type="password" name="password" id="password" class="form-control"  autocomplete="new-password" placeholder="* * * * * * * " aria-label="Password">
                                    </div>
                                    <div class="col">
                                        <div class="d-flex bd-highlight mt-5 mb-3">
                                            <div class="ms-auto p-2 w-50 bd-highlight">
                                                <button class="btn w-100 btn-warning bg-orange">Save</button>
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
@endsection
@section('content_javascript')
    <script>
        $( document ).ready(function() {

        });
    </script>
@endsection
