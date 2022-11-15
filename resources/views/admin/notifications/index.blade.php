@extends('layouts.admin')
@section('content')
    <div class="container">

        <div class="row">
            <div class="col-12">
                <h3>Notifications</h3>
                @foreach($notifications as $notification)
                    <div class="card mb-2" >
                        <div class="card-body">
                            <div class="d-flex flex-column bd-highlight mb-3">
                                <div class="p-2 bd-highlight">{{$notification->created_at->diffForHumans()}}</div>
                                <div class="p-2 bd-highlight">
                                    <img class="img-fluid" src="{{asset('assets/images/icons/cart-black.png')}}" alt="..."> {{$notification->title}}
                                </div>
                                <div class="p-2 bd-highlight">{{$notification->description}}</div>
                            </div>

                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
@endsection
