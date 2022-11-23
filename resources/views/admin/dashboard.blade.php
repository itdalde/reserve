@extends('layouts.admin')
@section('content')
    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-8">
            <div class="card mb-2" >
                <div class="card-body">
                    <h5 class="card-title">Statistics</h5>
                    <small>Sales summary</small>

                    <div class="row pt-5">
                        <div class="col-sm-12 col-md-3 pb-5">
                            <div class="card card-bg-green " >
                                <div class="card-body">
                                    <img src="{{asset('assets/images/icons/sales.png')}}" alt="..">
                                    <h2>$ 0</h2>
                                    <p>Total sales</p>
                                    <small class="error-message"> -5% from last week</small>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-12 col-md-3 pb-5">
                            <div class="card card-bg-purple" >
                                <div class="card-body">
                                    <img src="{{asset('assets/images/icons/customers.png')}}" alt="..">
                                    <h2>23</h2>
                                    <p>Customers</p>
                                    <small class="error-message"> -5% from last week</small>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-12 col-md-3 pb-5">
                            <div class="card card-bg-blue" >
                                <div class="card-body">
                                    <img src="{{asset('assets/images/icons/cart.png')}}" alt="..">
                                    <h2>71</h2>
                                    <p>Total orders</p>
                                    <small class="error-message"> -5% from last week</small>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-12 col-md-3 pb-5">
                            <div class="card card-bg-orange" >
                                <div class="card-body">
                                    <img src="{{asset('assets/images/icons/orders.png')}}" alt="..">
                                    <h2>3</h2>
                                    <p>Total orders</p>
                                    <small class="error-message"> -5% from last week</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card mb-2" >
                <div class="card-body">
                    <div class="d-flex bd-highlight mb-3">
                        <div class="mr-auto p-2 bd-highlight w-25"><img src="{{asset('assets/images/icons/calendar.png')}}"
                                                                   alt="..."></div>
                        <div class="p-2 bd-highlight w-50">Recent activity<br> -8% from last mont</div>
                        <div class="p-2 bd-highlight w-25">60% <br>
                            <div class="progress">
                                <div class="progress-bar bg-warning" role="progressbar" style="width: 75%" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                        </div>
                    </div>
                    <div class="text-center">
                        <img class="w-100" src="{{asset('assets/images/icons/Graph.png')}}" alt="Graph">
                        <img class="w-100" src="{{asset('assets/images/icons/date.png')}}" alt="date">
                    </div>
                </div>
            </div>
            <div class="card mb-2" >
                <div class="card-body">
                    <div class="d-md-flex d-sm-block">
                        <div class="p-2 w-75"><h3>New Orders</h3></div>

                        <div class="ml-auto p-2 w-25"><a href="{{route('orders.index')}}">See more</a></div>
                    </div>
                    <table class="table">
                        <thead class="thead-light">
                        <tr>
                            <th scope="col" style="border-top-left-radius: 11px;background: #F2F1F0;">Name</th>
                            <th scope="col" style=" background: #F2F1F0;">Order ID</th>
                            <th scope="col" style="border-top-right-radius: 11px;background: #F2F1F0;">Order Type</th>
                        </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-4">
            <div class="card mb-2" >
                <div class="card-body">
                    <h5 class="card-title">Top Services</h5>
                    <div>
                        <table class="table">
                            <thead class="thead-light">
                            <tr>
                                <th scope="col" style="border-top-left-radius: 11px;background: #F2F1F0;">Name</th>
                                <th scope="col" style="border-top-right-radius: 11px;background: #F2F1F0;">No. of orders</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($services as $service)
                                <tr>
                                    <td>{{$service->name}}</td>
                                    <td>{{count($service->orders)}}</td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="card mb-2" >
                <div class="card-body">
                    <h5 class="card-title">Top Customers</h5>
                    <div>

                        <table class="table">
                            <thead class="thead-light">
                            <tr>
                                <th scope="col" style="border-top-left-radius: 11px;background: #F2F1F0;">Name</th>
                                <th scope="col" style="border-top-right-radius: 11px;background: #F2F1F0;">No. of orders</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($users as $customer)
                                <tr>
                                    <td>{{$customer->name}}</td>
                                    <td>{{count($customer->orders)}}</td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

