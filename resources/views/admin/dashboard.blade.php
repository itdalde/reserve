@extends('layouts.admin')
@section('content')
    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-8">
            <div class="card mb-2">
                <div class="card-body">
                    <h5 class="card-title">Statistics</h5>
                    <small>Sales summary</small>

                    <div class="row pt-5">
                        <div class="col-sm-12 col-md-3 pb-5">
                            <div class="card card-bg-green ">
                                <div class="card-body">
                                    <img src="{{asset('assets/images/icons/sales.png')}}" alt="..">
                                    <h2>QAR 0</h2>
                                    <p>Total sales</p>
                                    <small class="error-message"> 0% from last week</small>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-12 col-md-3 pb-5">
                            <div class="card card-bg-purple">
                                <div class="card-body">
                                    <img src="{{asset('assets/images/icons/customers.png')}}" alt="..">
                                    <h2>0</h2>
                                    <p>Customers</p>
                                    <small class="error-message"> 0% from last week</small>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-12 col-md-3 pb-5">
                            <div class="card card-bg-blue">
                                <div class="card-body">
                                    <img src="{{asset('assets/images/icons/cart.png')}}" alt="..">
                                    <h2>0</h2>
                                    <p>Total orders</p>
                                    <small class="error-message"> 0% from last week</small>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-12 col-md-3 pb-5">
                            <div class="card card-bg-orange">
                                <div class="card-body">
                                    <img src="{{asset('assets/images/icons/orders.png')}}" alt="..">
                                    <h2>0</h2>
                                    <p>Total orders</p>
                                    <small class="error-message"> 0% from last week</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card mb-2">
                <div class="card-body">
                    <div class="d-flex bd-highlight mb-3">
                        <div class="mr-auto p-2 bd-highlight w-25"><img
                                src="{{asset('assets/images/icons/calendar.png')}}"
                                alt="..."></div>
                        <div class="p-2 bd-highlight w-50">Recent activity<br> 0% from last mont</div>
                        <div class="p-2 bd-highlight w-25">0% <br>
                            <div class="progress">
                                <div class="progress-bar bg-warning" role="progressbar" style="width: 0%"
                                     aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                        </div>
                    </div>
                    <div class="text-center">
                        <div class="chart-container" style="position: relative; height:52vh; width:100%">
                            <canvas id="myChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card mb-2">
                <div class="card-body table-responsive">
                    <div class="d-md-flex d-sm-block">
                        <div class="p-2 w-75"><h3>New Orders</h3></div>

                        <div class="ml-auto p-2 w-25"><a href="{{route('orders.index')}}">See more</a></div>
                    </div>
                    <table class="table table-hover">
                        <thead class="thead-light">
                        <tr>
                            <th scope="col" style="border-top-left-radius: 11px;background: #F2F1F0;">Name</th>
                            <th scope="col" style=" background: #F2F1F0;">Order ID</th>
                            <th scope="col" style="border-top-right-radius: 11px;background: #F2F1F0;">Status</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($orders as $order)
                            <tr>
                                <td>{{isset($order['order']) && isset($order['order']['user']) ? $order['order']['user']['first_name'] .' '. $order['order']['user']['last_name']  : ''}}</td>
                                <td>{{isset($order['order']) ? $order['order']['reference_no'] : ''}}</td>
                                <td>{{$order['status']}}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-4">
            <div class="card mb-2">
                <div class="card-body">
                    <h5 class="card-title">Top Services</h5>
                    <div>
                        <table class="table">
                            <thead class="thead-light">
                            <tr>
                                <th scope="col" style="border-top-left-radius: 11px;background: #F2F1F0;">Name</th>
                                <th scope="col" style="border-top-right-radius: 11px;background: #F2F1F0;">No. of
                                    orders
                                </th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($services as $service)
                                <tr>
                                    <td><img  style="    height: 35px;width: 35px;object-fit: cover;" src="{{asset($service->image)}}"
                                             onerror="this.onerror=null; this.src='{{asset('images/no-image.jpg')}}'"
                                             alt="..."> {{$service->name}}</td>
                                    <td>{{count($service->orders)}}</td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="card mb-2">
                <div class="card-body">
                    <h5 class="card-title">Top Customers</h5>
                    <div>

                        <table class="table">
                            <thead class="thead-light">
                            <tr>
                                <th scope="col" style="border-top-left-radius: 11px;background: #F2F1F0;">Name</th>
                                <th scope="col" style="border-top-right-radius: 11px;background: #F2F1F0;">No. of
                                    orders
                                </th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($users as $customer)
                                <tr>
                                    <td>@if($customer->profile_picture )
                                            <img style="width: 35px;" class="rounded-circle"
                                                 src="{{ asset( $customer->profile_picture) }}" alt="...."/>
                                        @else
                                            <img style="width: 35px;" class="rounded-circle"
                                                 src="https://ui-avatars.com/api/?name={{$customer->first_name ? $customer->first_name: $customer->email}}"
                                                 alt="...">
                                        @endif {{$customer->name ? $customer->name : $customer->first_name . ' ' . $customer->last_name}}
                                    </td>
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


@section('content_javascript')
    <script type="text/javascript">
        window.addEventListener('beforeprint', () => {
            myChart.resize(600, 600);
        });
        window.addEventListener('afterprint', () => {
            myChart.resize();
        });

        var xValues = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
        var yValues = [2, 3, 4, 5, 4, 1, 2, 11, 14, 14, 15, 0];

        new Chart("myChart", {
            type: "line",
            data: {
                labels: xValues,
                datasets: [{
                    fill: false,
                    lineTension: 0,
                    lineWidth: 0,
                    backgroundColor: "rgb(226,134,26)",
                    borderColor: 'rgb(176,161,104)',
                    data: yValues,
                    tension: 0.1
                }]
            },
            options: {
                legend: {display: false},
                scales: {
                    yAxes: [{ticks: {min: 0, max: 15}}],
                }
            }
        });
    </script>
@endsection
