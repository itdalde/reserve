@extends('layouts.welcome')

@section('content')
    <div class="title m-b-md">
        {{ config('app.name') }}
    </div>
    <div class="description m-b-md">
        Sample users:<br/>
        Admin user: admin@admin.com / password: admin<br/>
        Demo user: demo@demo.com / password: demo
    </div>
@endsection
