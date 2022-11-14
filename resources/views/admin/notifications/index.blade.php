@extends('layouts.admin')
@section('content')
    <div class="container">

        <div class="row">
            <div class="col-12">
                <h3>Notifications</h3>
                @foreach($notifications as $notification)
                    <div class="card mb-2" >
                        <div class="card-body">
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
@endsection
