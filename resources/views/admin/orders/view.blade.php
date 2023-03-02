@extends('layouts.admin')
@section('content')
    <div class="d-flex justify-content-between">
        <div class="p-2">
            <h3>Order- {{$order['reference_no']}}</h3>
        </div>
        <div class="p-2">
            <a href="{{route('orders.index')}}" class="btn btn-warning">Back</a>
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
                                <div class="col-sm-6">{{$order['user']['first_name'] . ' ' .$order['user']['last_name']}}</div>
                            </div>
                        </li>
                        <li class="list-group-item">
                            <div class="row">
                                <div class="col-sm-6">Phone No.</div>
                                <div class="col-sm-6"><a href="#">Request from admin</a></div>
                            </div>
                        </li>
                        <li class="list-group-item">
                            <div class="row">
                                <div class="col-sm-6">Email</div>
                                <div class="col-sm-6">
                                    <a href="#">Request from admin</a>
                                </div>
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
                                    <div class="col-sm-6">Service Location</div>
                                    <div class="col-sm-6">{{$item['service']['address_1'] }}</div>
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
                                    <div class="col-sm-6">Schedule Date</div>
                                    <div class="col-sm-6">{{Carbon\Carbon::parse($item['schedule_start_datetime'])->format('F d, Y H:m') }} </div>
                                </div>
                            </li>
                            <li class="list-group-item">
                                <div class="row">
                                    <div class="col-sm-6">Schedule Time</div>
                                    <div class="col-sm-6">{{Carbon\Carbon::parse($item['schedule_start_datetime'])->format('H:m') }} </div>
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
                                    <div class="col-sm-6">{{isset($order['payment_details']['reference_no']) ? $order['payment_details']['reference_no'] : ''}}</div>
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
                                    <div class="col-sm-6">{{isset($order['payment_details']['promo_code']) ? $order['payment_details']['promo_code'] : '' }}</div>
                                </div>
                            </li>
                        </ul>
                </div>
            </div>
        </div>
        <div class="col-sm-6 mb-2 {{  $order['status'] == 'cancelled' ||$order['status'] == 'completed' || $order['status'] == 'declined' ? 'd-none' :''}}">
            <div class="card border-success ">
                <div class="card-body">
                    <h3>Admin action</h3>
                    <form action="{{route('settings.update-status-order')}}" method="POST">
                        @csrf
                        @foreach($order['items'] as $item)
                            <input type="hidden" name="id[]" value="{{$item['id']}}">
                        @endforeach
                        <input type="hidden" name="action" value="cancel">
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item">
                                <div class="row">
                                    <div class="col-sm-3">Reason</div>
                                    <div class="col-sm-9"><textarea name="reason" id="reason" cols="30" rows="10">{{$order['reason']}}</textarea></div>
                                </div>
                            </li>
                            <li class="list-group-item">
                                <div class="row">
                                    <div class="col-sm-12"><button class="btn btn-warning w-100">Cancel </button></div>
                                </div>
                            </li>
                        </ul>
                    </form>
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
