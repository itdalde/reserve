@extends('layouts.admin')
@section('content')
    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-8">
            <div class="card mb-2">
                <div class="card-body">
                    <h5 class="card-title">Statistics</h5>
                    <small>Sales summary</small>

                    <div class="row pt-4">
                        <div class="col-sm-12 col-md-3 pb-5">
                            <div class="card card-bg-green ">
                                <div class="card-body">
                                    <img src="{{ asset('assets/images/icons/sales.png') }}" alt="..">
                                    <h2>QAR {{ $totalOrder }}</h2>
                                    <p class="fs-6">Total sales</p>
                                    {{--                                    <small class="error-message"> 0% from last week</small> --}}
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-12 col-md-3 pb-5">
                            <div class="card card-bg-purple">
                                <div class="card-body">
                                    <img src="{{ asset('assets/images/icons/customers.png') }}" alt="..">
                                    <h2>{{ count($users) }}</h2>
                                    <p class="fs-6">Customers</p>
                                    {{--                                    <small class="error-message"> 0% from last week</small> --}}
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-12 col-md-3 pb-5">
                            <div class="card card-bg-blue">
                                <div class="card-body">
                                    <img src="{{ asset('assets/images/icons/cart.png') }}" alt="..">
                                    <h2>{{ count($completedOrders) }}</h2>
                                    <p class="fs-6">Completed orders</p>
                                    {{--                                    <small class="error-message"> 0% from last week</small> --}}
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-12 col-md-3 pb-5">
                            <div class="card card-bg-orange">
                                <div class="card-body">
                                    <img src="{{ asset('assets/images/icons/orders.png') }}" alt="..">
                                    <h2>{{ count($orders) }}</h2>
                                    <p class="fs-6">Total orders</p>
                                    {{--                                    <small class="error-message"> 0% from last week</small> --}}
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row pt-2 d-none">
                        <div class="col-sm-12 col-md-6 pb-5">
                            <div class="card card-bg-green ">
                                <div class="card-body py-2">
                                    <h2 class="fs-3">{{ $totalOrder }}</h2>
                                    <p class="fs-6">Total cancelled orders</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-12 col-md-6 pb-5">
                            <div class="card card-bg-orange ">
                                <div class="card-body py-2">
                                    <h2 class="fs-3">{{ $totalOrder }}</h2>
                                    <p class="fs-6">Total pending orders</p>
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
                                src="{{ asset('assets/images/icons/calendar.png') }}" alt="..."></div>
                        <div class="p-2 bd-highlight w-50">Recent activity<br> 0% from last month</div>
                        <div class="p-2 bd-highlight w-25">0% <br>
                            <div class="progress">
                                <div class="progress-bar bg-warning" role="progressbar" style="width: 0%" aria-valuenow="0"
                                    aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                        </div>
                    </div>
                    <div class="text-center">
                        <div class="chart-container" style="position: relative; height:100%; width:100%">
                            <canvas id="myChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card mb-2">
                <div class="card-body table-responsive">
                    <div class="d-flex justify-content-between">
                        <div class="p-2 w-75">
                            <h3>New Orders</h3>
                        </div>

                        <div class="ml-auto p-2"><a href="{{ route('orders.index') }}">See more</a></div>
                    </div>
                    <table class="table table-hover">
                        <thead class="thead-light">
                            <tr style="background-color: #F2F1F0;">
                                <th scope="col" style="border-top-left-radius: 11px; ">Name</th>
                                <th scope="col" style="">Order ID</th>
                                <th scope="col" style="">Order type</th>
                                <th scope="col" style="border-top-right-radius: 11px;"></th>
                            </tr>
                        </thead>
                        <tbody>
                            @if (count($orders) > 0)
                            @foreach ($orders as $order)
                                <tr>
                                    <td>
                                        <div class="d-flex">
                                            @if ($order['order']['user']['profile_picture'])
                                                <img src="{{$order['order']['user']['profile_picture']}}" alt="..."
                                                style="width: 36px; height: 36px;" class="rounded-circle" />
                                            @else
                                                <img src="https://ui-avatars.com/api/?name={{ $order['order']['user']['first_name'] ? $order['order']['user']['first_name'] : $order['order']['user']['email'] }}" alt="..."
                                                style="width: 36px; height: 36px;" class="rounded-circle" />
                                            @endif
                                            <p style="color: #586981" class="m-auto fs-5 fw-bold">
                                                {{ isset($order['order']) && isset($order['order']['user']) ? $order['order']['user']['first_name'] . ' ' . $order['order']['user']['last_name'] : '' }}
                                            </p>
                                        </div>
                                    </td>
                                    <td>
                                        <p class="fs-5 fw-bold mb-0">
                                            {{ isset($order['order']) ? $order['order']['reference_no'] : '' }}</p>
                                        <label class="fs-6 fw-bolder opacity-75">{{ count($order['order']) }} items</label>
                                    </td>
                                    <td>
                                        <p class="fs-5 fw-bold mb-0">{{ ucfirst($order['status']) }}</p>
                                    </td>
                                    <td>
                                        <a href="{{route('orders.show',['order'=>$order['order']['id'] , 'from' => 'orders'])}}" class="btn btn-warning text-light rounded-3">View Order</a>
                                    </td>
                                </tr>
                            @endforeach
                            @else
                            <tr>
                                <td colspan="4" style="text-align: center; align-items: middle;">
                                    <p>There is no latest order</p>
                                </td>
                            </tr>
                            @endif
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
                                @foreach ($services as $service)
                                    <tr>
                                        <td>
                                            <div class="d-flex">
                                                <img style="height: 35px;width: 35px;object-fit: cover;"
                                                    src="{{ asset($service->image) }}"
                                                    onerror="this.onerror=null; this.src='{{ asset('images/no-image.jpg') }}'"
                                                    alt="..." class="rounded" />
                                                <p style="color: #586981; padding-left: 10px;" class="m-auto fs-6 fw-bolder ml-2">
                                                    {{ $service->name }}
                                                </p>
                                            </div>
                                        </td>
                                        <td>
                                            <p class="fw-5 fw-bold mb-0 m-auto h-100 d-flex justify-content-center">{{ count($service->orders) }}</p>
                                        </td>
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
                                @foreach ($users as $customer)
                                    <tr>
                                        <td>
                                         <div class="d-flex">
                                            @if ($customer->profile_picture)
                                            <img style="width: 35px;" class="rounded-circle"
                                                src="{{ asset($customer->profile_picture) }}" alt="...." />
                                            @else
                                                <img style="width: 35px;" class="rounded-circle"
                                                    src="https://ui-avatars.com/api/?name={{ $customer->first_name ? $customer->first_name : $customer->email }}"
                                                    alt="...">
                                            @endif
                                            <p style="color: #586981; padding-left: 10px;" class="m-auto fs-6 fw-bolder ml-2">
                                                {{ $customer->name ? $customer->name : $customer->first_name . ' ' . $customer->last_name }}
                                            </p>
                                         </div>
                                        </td>
                                        <td>
                                            <p class="fw-5 fw-bold mb-0 h-100 d-flex justify-content-center">{{ count($customer->customer_orders) }}</p>
                                        </td>
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

        let SITEURL = "{{ url('/') }}";
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            type: "GET",
            url: SITEURL + '/get-average-order',
            success: function(response) {
                var yValues = response.data;
                var max_of_array = Math.max.apply(Math, yValues);
                var xValues = response.month;
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
                        legend: {
                            display: false
                        },
                        scales: {
                            yAxes: [{
                                ticks: {
                                    min: 0,
                                    max: max_of_array
                                }
                            }],
                        }
                    }
                });
            }
        });
    </script>
@endsection
