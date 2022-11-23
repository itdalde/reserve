@extends('layouts.admin')
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-4">
                <div class="d-flex flex-column bd-highlight mb-3">
                    <div class="p-2 bd-highlight"><a href="javascript: history.go(-1)"><-- Customers</a></div>
                    <div class="p-2 bd-highlight">
                        <div class="d-flex justify-content-between">
                            <h3>Customer details</h3>
                            <a class="btn btn-danger" href="{{route('users.delete-user',['id' => $user->id])}}"  onclick="return confirm('Are you sure want to delete this user?')">
                                Delete
                            </a>
                        </div>
                    </div>
                    <div class="p-2 bd-highlight">
                        <div class="card">
                            <div class="card-body">
                                <div class="d-flex flex-column bd-highlight mb-3">
                                    <div class="p-2 bd-highlight">
                                        <div class="d-flex justify-content-between">
                                            <div class="p-0">
                                                @if($user->profile_picture )
                                                    <img width="35" class="rounded-circle" src="{{ asset( $user->profile_picture) }}" alt="...."   />
                                                @else
                                                    <img width="35" class="rounded-circle" src="https://ui-avatars.com/api/?name={{$user->first_name ? $user->first_name: $user->email}}" alt="...">
                                                @endif
                                                {{$user->first_name ? $user->first_name . ' ' . $user->last_name : $user->email}}
                                            </div>
                                            <div class="p-0">
                                                <span class="badge  bg-secondary">0 unresolved</span>
                                            </div>
                                        </div>
                                        <hr>
                                    </div>
                                    <div class="p-2 bd-highlight">
                                        <div class="d-flex justify-content-between">
                                            <div class="p-0">
                                                <img src="{{asset('assets/images/icons/cart-profile.png')}}" alt="cart-profile.png">
                                                <span>0 Orders</span>
                                            </div>
                                            <div class="p-0">
                                                <img src="{{asset('assets/images/icons/dollar-profile.png')}}" alt="dollar-profile.png">
                                                <span>0 Spent</span>
                                            </div>
                                        </div>
                                        <hr>
                                    </div>
                                    <div class="p-2 bd-highlight">
                                        <h5>Last {{$user->company ? 'sales' : "purchase"}}</h5>
                                        <span>{{Carbon\Carbon::parse($user->created_at)->format('Y-m-d')}}</span>
                                        <hr>
                                    </div>
                                    <div class="p-2 bd-highlight">
                                        <h5>Contact Info</h5>
                                        <div class="d-flex flex-column">
                                            <div class="p-2">
                                                <img src="{{asset('assets/images/icons/email-profile.png')}}" alt="email-profile"> {{$user->email}}
                                            </div>
                                            <div class="p-2">
                                                <img src="{{asset('assets/images/icons/phone-profile.png')}}" alt="phone-profile"> {{$user->phone_number}}
                                            </div>
                                        </div>
                                        <hr>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-8">

                <div class="d-flex flex-column bd-highlight mb-3">
                    <div class="p-2 bd-highlight"></div>
                    <div class="p-1 bd-highlight">
                        <div class="d-flex justify-content-end">
                            <div class="alert alert-secondary" role="alert">
                                <img src="{{asset('assets/images/icons/alert-icon.png')}}" alt="alert-icon.png"> <strong>Abdul</strong> Changed email address <strong>20/10/2022 8:30pm</strong>
                            </div>
                        </div>
                    </div>
                    <div class="p-2 bd-highlight">
                        <div class="card">
                            <div class="card-body">

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('content_javascript')
    <script type="text/javascript">
        $(document).ready( function () {
        } );
    </script>
@endsection
