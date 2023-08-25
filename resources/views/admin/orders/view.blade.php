@extends('layouts.admin')
@section('content')
    <style>

        #gallery-lightbox img {
            height: 350px;
            object-fit: cover;
            cursor: pointer;
        }

        #gallery-lightbox img:hover {
            opacity: 0.9;
            transition: 0.5s ease-out;
        }
    </style>
    <div class="d-flex justify-content-between">
        <div class="p-2 d-inline-flex">
            <h3>Order- {{$order['reference_no']}}</h3>
        </div>
        <div class="p-2">
            @if($from == 'manage')
                <a href="{{route('settings.manage_orders')}}" class="btn btn-warning">Back</a>
            @elseif($from == 'super')
                <a href="{{route('orders.admin')}}" class="btn btn-warning">Back</a>
            @else
                <a href="{{route('orders.index')}}" class="btn btn-warning">Back</a>
            @endif

        </div>
    </div>
    <div class="row">
        <div class="col-sm-6 mb-2">
            <div class="card border-info">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div class="p-2 d-inline-flex">
                            <h3>Client</h3>
                        </div>
                        <div class="p-2">
                            <button
                                class="btn btn-warning {{  $order['status'] == 'cancelled' ||$order['status'] == 'completed' || $order['status'] == 'declined' ? 'd-none' :''}}"
                                data-bs-toggle="modal" data-bs-target="#cancel-order-modal">
                                Cancel Order
                            </button>
                        </div>
                    </div>
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
            <div class="card border-success ">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div class="p-2 d-inline-flex">
                            <h3>Payment Details</h3>
                        </div>
                    </div>
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item">
                            <div class="row">
                                <div class="col-sm-6">Card Name</div>
                                <div class="col-sm-6">{{$order['payment_method'] ? $order['payment_method']['name'] : ''}}</div>
                            </div>
                        </li>
                        <li class="list-group-item">
                            <div class="row">
                                <div class="col-sm-6">Payment Ref No.</div>
                                <div
                                    class="col-sm-6">{{isset($order['payment_details']['reference_no']) ? $order['payment_details']['reference_no'] : ''}}</div>
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
                    </ul>
                </div>
            </div>
        </div>
        <div class="col-sm-12 mb-2">
            <div class="card border-secondary ">
                <div class="card-body">
                    <h3>Order Items</h3>
                    @foreach($order['items'] as $i => $item)
                        <div class="d-flex justify-content-center p-5">

                            <div id="gallery-lightbox" class="row p-5" data-bs-toggle="modal" data-bs-target="#exampleModal-{{$i+=1}}">
                                <div class="col-6 col-md-4 col-lg-3 p-0">
                                    <img class="w-100 thumbnail"
                                         src="https://reservegcc.com/{{$item['service']['image'] }}"
                                         alt="First Slide" data-bs-target="#carouselExampleControls" data-bs-slide-to="0">
                                </div>

                                @foreach($item['service']['gallery'] as $k =>  $image)
                                    <div class="col-6 col-md-4 col-lg-3 p-0">
                                        <img class="w-100 thumbnail" src="https://reservegcc.com/{{$image['image'] }}"
                                             alt="{{$k+=1}} Slide" data-bs-target="#carouselExampleControls" data-bs-slide-to="{{$k+=1}}">
                                    </div>
                                @endforeach
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="border rounded">
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
                                                <div class="col-sm-6">Service Price</div>
                                                <div class="col-sm-6">QAD {{$item['service']['price'] }}</div>
                                            </div>
                                        </li>
                                        <li class="list-group-item">
                                            <div class="row">
                                                <div class="col-sm-6">Capacity</div>
                                                <div class="col-sm-6">min: {{$item['service']['min_capacity'] }} -
                                                    max: {{$item['service']['max_capacity'] }}</div>
                                            </div>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="border  rounded">
                                    <ul class="list-group list-group-flush">
                                        <li class="list-group-item">
                                            <div class="row">
                                                <div class="col-sm-6">Status</div>
                                                <div class="col-sm-6">{{$order['status'] }}</div>
                                            </div>
                                        </li>
                                        <li class="list-group-item">
                                            <div class="row">
                                                <div class="col-sm-6">Schedule Date</div>
                                                <div
                                                    class="col-sm-6">{{Carbon\Carbon::parse($item['schedule_start_datetime'])->format('F d, Y') }} </div>
                                            </div>
                                        </li>
                                        <li class="list-group-item">
                                            <div class="row">
                                                <div class="col-sm-6">Schedule Time</div>
                                                <div
                                                    class="col-sm-6">{{Carbon\Carbon::parse($item['schedule_start_datetime'])->format('H:m') }} </div>
                                            </div>
                                        </li>
                                        <li class="list-group-item">
                                            <div class="row">
                                                <div class="col-sm-6">Guest No.</div>
                                                <div class="col-sm-6">{{$item['guests'] }}</div>
                                            </div>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="modal" id="exampleModal-{{$i}}" tabindex="-1" role="dialog" aria-hidden="true">
                            <button   type="button" class="btn-close position-absolute right-0 p-2" data-bs-dismiss="modal"
                                      aria-label="Close"></button>
                            <div class="modal-dialog modal-lg" role="document">
                                <div class="modal-content bg-transparent">
                                    <div class="modal-body p-0">
                                        <div id="carouselExampleControls" class="carousel slide" data-bs-ride="carousel">
                                            <div class="carousel-inner">

                                                @foreach($order['items'] as $item)
                                                    <div class="carousel-item active">
                                                        <img class="d-block w-100"
                                                             src="https://reservegcc.com/{{$item['service']['image'] }}"
                                                             alt="First Slide">
                                                    </div>
                                                    @foreach($item['service']['gallery'] as $k =>  $image)
                                                        <div class="carousel-item">
                                                            <img class="d-block w-100"
                                                                 src="https://reservegcc.com/{{$image['image'] }}"
                                                                 alt="{{$k+=1}} Slide">
                                                        </div>
                                                    @endforeach
                                                @endforeach
                                            </div>
                                            <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleControls" data-bs-slide="prev">
                                                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                                <span class="visually-hidden">Previous</span>
                                            </button>
                                            <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleControls" data-bs-slide="next">
                                                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                                <span class="visually-hidden">Next</span>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="cancel-order-modal" tabindex="-1" aria-labelledby="cancel-order-modalLabel"
         aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="{{route('settings.update-status-order')}}" method="POST">
                    <div class="modal-header">
                        <h5 class="modal-title" id="cancel-order-modalLabel">Cancel Order</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        @csrf
                        @foreach($order['items'] as $item)
                            <input type="hidden" name="id[]" value="{{$item['id']}}">
                        @endforeach
                        <input type="hidden" name="action" value="cancel">
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item">
                                <div class="row">
                                    <div class="col-sm-3">Reason</div>
                                    <div class="col-sm-9">
                                        <input name="reason" id="reason" class="form-control"
                                               value="{{$order['reason']}}"/>
                                    </div>
                                </div>
                            </li>
                        </ul>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary">Save</button>
                    </div>
                </form>
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
