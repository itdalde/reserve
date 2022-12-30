@extends('layouts.admin')
@section('content')
<div class="container">

    <div class="row">
        <div class="col-9">
            <h3>Order List</h3>

            <div class="card mb-2" >
                <div class="card-body">
                    <table class="table">
                <thead class="thead-light">
                <tr>
                    <th scope="col" style="border-top-left-radius: 11px;background: #F2F1F0;">Name</th>
                    <th scope="col" style=" background: #F2F1F0;">ID</th>
                    <th scope="col" style=" background: #F2F1F0;">Type</th>
                    <th scope="col" style=" background: #F2F1F0;">Volume</th>
                    <th scope="col" style=" background: #F2F1F0;">Date</th>
                    <th scope="col" style="border-top-right-radius: 11px;background: #F2F1F0;">Status</th>
                </tr>
                </thead>
                <tbody>
                    @foreach($orders as $order)
                        <tr>
                            <td>{{$order['order']['user']['first_name'] . ' ' . $order['order']['user']['last_name']}}</td>
                            <td>{{$order['order']['reference_no']}}</td>
                            <td>{{$order['service']['price']['plan_type']['name']}}</td>
                            <td>1 Service</td>
                            <td>{{Carbon\Carbon::parse($order['created_at'])->format('F d, Y H:m')}}</td>
                            <td>
                                @switch($order['order']['status'])
                                    @case('pending')
                                        <span class="w-100 badge bg-warning text-dark text-capitalize">{{$order['order']['status']}}</span>
                                        @break
                                    @case('accepted')
                                        <span class="w-100 badge bg-secondary text-capitalize">{{$order['order']['status']}}</span>
                                        @break
                                    @case('declined')
                                        <span class="w-100 badge bg-danger text-capitalize">{{$order['order']['status']}}</span>
                                        @break
                                    @case('completed')
                                        <span class="w-100 badge bg-success text-capitalize">{{$order['order']['status']}}</span>
                                        @break
                                    @case('cancelled')
                                        <span class="w-100 badge bg-danger text-capitalize">{{$order['order']['status']}}</span>
                                        @break
                                    @default
                                     <span class="w-100 badge bg-primary text-capitalize">{{$order['order']['status']}}</span
                                @endswitch

                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
                </div>
            </div>
        </div>
        <div class="col-3 p-0">
            <h3>Upcoming orders</h3>
            <div class="d-flex justify-content-around">
                <div class="px-2"> <span class=" pending-dot"></span> Pending
                </div>
                <div class="px-2 "> <span class=" accepted-dot"></span> Accepted
                </div>
            </div>
            @foreach($futureOrders as $order)
                <div class="card mb-2 {{$order['order']['status'] == 'pending' ? 'border-card-pending' : 'border-card-accepted'}}"  >
                    <div class="card-body">
                        <div class="row">
                            <div class="col-2">
                                <div class="avatar avatar-md avatar-indicators avatar-online">
                                    @if($order['order']['user']['profile_picture'] )
                                        <img class="rounded-circle" src="{{ asset( $order['order']['user']['profile_picture']) }}" alt="...."   />
                                    @else
                                        <img class="rounded-circle" src="https://ui-avatars.com/api/?name={{$order['order']['user']['first_name']. ' ' . $order['order']['user']['last_name']}}" alt="...">
                                    @endif
                                </div>
                            </div>
                            <div class="col-5">
                                <div>{{$order['order']['reference_no']}}</div>
                                <div>{{$order['order']['user']['first_name'] . ' ' . $order['order']['user']['last_name']}}</div>
                            </div>
                            <div class="col-5" style="border-left: 2px solid #a69382;">
                                <div>{{Carbon\Carbon::parse($order['created_at'])->format('H:m A')}}</div>
                                <div>{{Carbon\Carbon::parse($order['created_at'])->format('Y/d/m')}}</div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>
@endsection
