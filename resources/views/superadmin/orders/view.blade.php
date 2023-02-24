@extends('layouts.admin')
@section('content')
    <div class="d-flex justify-content-between">
        <div class="p-2">
            <h3>Order- {{$order['reference_no']}}</h3>
        </div>
        <div class="p-2">
            <a href="{{ route('orders.admin') }}" class="btn btn-warning">Back</a>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-6 mb-2">
            <div class="card border-info">
                <div class="card-body">
                    <h3>Client</h3>
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item">
                            <div class="row">
                                <div class="col-sm-6">Name</div>
                                <div
                                    class="col-sm-6">{{$order['user']['first_name'] . ' ' .$order['user']['last_name']}}</div>
                            </div>
                        </li>
                        <li class="list-group-item">
                            <div class="row">
                                <div class="col-sm-6">Phone No.</div>
                                <div class="col-sm-6">{{$order['user']['phone_number']}}</div>
                            </div>
                        </li>
                        <li class="list-group-item">
                            <div class="row">
                                <div class="col-sm-6">Email</div>
                                <div class="col-sm-6">{{$order['user']['email']}}</div>
                            </div>
                        </li>
                        <li class="list-group-item">
                            <div class="row">
                                <div class="col-sm-6">Location</div>
                                <div class="col-sm-6">{{$order['user']['location']}}</div>
                            </div>
                        </li>
                        <li class="list-group-item">
                            <div class="row">
                                <div class="col-sm-6">Gender</div>
                                <div class="col-sm-6">{{$order['user']['gender']}}</div>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="col-sm-6 mb-2">
            <div class="card border-secondary ">
                <div class="card-body">
                    <h3>Order Items</h3>
                    @foreach($order['items'] as $item)
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item">
                                <div class="row">
                                    <div class="col-sm-6">Service Name</div>
                                    <div class="col-sm-6">{{$item['service']['name'] }}</div>
                                </div>
                            </li>
                            <li class="list-group-item">
                                <div class="row">
                                    <div class="col-sm-6">Status</div>
                                    <div class="col-sm-6">{{$item['status'] }}</div>
                                </div>
                            </li>
                            <li class="list-group-item">
                                <div class="row">
                                    <div class="col-sm-6">Schedule</div>
                                    <div class="col-sm-6">{{$item['schedule_start_datetime'] }}
                                        - {{$item['schedule_end_datetime']}}</div>
                                </div>
                            </li>
                            <li class="list-group-item">
                                <div class="row">
                                    <div class="col-sm-6">Guest No.</div>
                                    <div class="col-sm-6">{{$item['guests'] }}</div>
                                </div>
                            </li>
                        </ul>
                    @endforeach
                </div>
            </div>
        </div>
        <div class="col-sm-6 mb-2">
            <div class="card border-success ">
                <div class="card-body">
                    <h3>Payment Details</h3>
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item">
                            <div class="row">
                                <div class="col-sm-6">Card Name</div>
                                <div class="col-sm-6">{{$order['payment_method']['name'] }}</div>
                            </div>
                        </li>
                        <li class="list-group-item">
                            <div class="row">
                                <div class="col-sm-6">Payment Ref No.</div>
                                <div class="col-sm-6">{{$order['payment_details']['reference_no'] }}</div>
                            </div>
                        </li>
                        <li class="list-group-item">
                            <div class="row">
                                <div class="col-sm-6">Total Paid</div>
                                <div class="col-sm-6">QAD {{number_format($order['total_paid'],2) }}</div>
                            </div>
                        </li>
                        <li class="list-group-item">
                            <div class="row">
                                <div class="col-sm-6">Total Balance</div>
                                <div class="col-sm-6">QAD {{number_format($order['balance'],2) }}</div>
                            </div>
                        </li>
                        <li class="list-group-item">
                            <div class="row">
                                <div class="col-sm-6">Total Amount To Be Paid</div>
                                <div class="col-sm-6">QAD {{number_format($order['total_amount'],2) }}</div>
                            </div>
                        </li>
                        <li class="list-group-item">
                            <div class="row">
                                <div class="col-sm-6">Promo Code</div>
                                <div class="col-sm-6">{{$order['payment_details']['promo_code'] }}</div>
                            </div>
                        </li>
                        <li class="list-group-item">
                            <div class="row">
                                <div class="col-sm-6">Payment URL</div>
                                <div class="col-sm-6"><a href="{{$order['payment_details']['payment_url'] }}">Go To
                                        Skipcash</a></div>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <div
            class="col-sm-6 mb-2 {{  $order['status'] == 'cancelled' ||$order['status'] == 'completed' || $order['status'] == 'declined' ? 'd-none' :''}}">

            <div class="card border-success ">
                <div class="card-body">
                    <h3>Admin action</h3>
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item">
                            <div class="row">
                                <div class="col-sm-6">Reason</div>
                                <div class="col-sm-6"><textarea name="reason" id="reason" cols="30"
                                                                rows="10"></textarea></div>
                            </div>
                        </li>
                        <li class="list-group-item">
                            <div class="row">
                                <div class="col-sm-6"></div>
                                <div class="col-sm-6">
                                    <button class="btn btn-orange">Cancel</button>
                                </div>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('content_javascript')
    <script type="text/javascript">
        $(document).ready(function () {
        });
    </script>
@endsection
