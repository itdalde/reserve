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
    <div class="container">
        <div class="row">
            <div class="col-4">
                <div class="d-flex flex-column bd-highlight mb-3">
                    <div class="p-2 bd-highlight"><a href="javascript: history.go(-1)"><-- @if($user->company)
                                Service Providers
                            @else
                                Customers
                            @endif</a></div>
                    <div class="p-2 bd-highlight">
                        <div class="d-flex justify-content-between">
                            <h3>Customer details</h3>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-8">
                <div class="d-flex flex-column bd-highlight mb-3">
                    <div class="p-2 bd-highlight"></div>
                    <div class="p-1 bd-highlight">
                        <div class="d-flex justify-content-end">
                            <div class="alert alert-secondary" role="alert">
                                <img src="{{asset('assets/images/icons/alert-icon.png')}}" alt="alert-icon.png">
                                <strong>Abdul</strong> Changed email address
                                <strong>{{Carbon\Carbon::parse($user->created_at)->format('d/m/Y H:s a')}}</strong>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div style="margin-top: -2em;" class="col">
                <div class="p-2 bd-highlight">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex flex-column bd-highlight mb-3">
                                <div class="p-2 bd-highlight">
                                    <div class="d-flex justify-content-between">
                                        <div class="p-0">
                                            @if($user->profile_picture )
                                                <img width="35" class="rounded-circle"
                                                     src="{{ asset( $user->profile_picture) }}" alt="...."/>
                                            @else
                                                <img width="35" class="rounded-circle"
                                                     src="https://ui-avatars.com/api/?name={{$user->first_name ? $user->first_name: $user->email}}"
                                                     alt="...">
                                            @endif
                                            {{$user->first_name ? $user->first_name . ' ' . $user->last_name : $user->email}}
                                        </div>
                                        <div class="p-0">
                                            <span class="status-field p-2 me-4 badge bg-secondary text-dark">
                                                0 unresolved
                                            </span>
                                            <a class="btn btn-danger"
                                               href="{{route('users.delete-user',['id' => $user->id])}}"
                                               onclick="return confirm('Are you sure want to delete this user?')">
                                                Delete
                                            </a>
                                            <i data-bs-toggle="tooltip" data-bs-placement="top"
                                               title="{{Carbon\Carbon::parse($user->created_at)->format('Y-m-d')}}"
                                               class="bi bi-info-circle ms-4 icon-info"></i>
                                        </div>
                                    </div>
                                    <div class="d-flex justify-content-center">
                                        <ul class="nav nav-pills mb-3 justify-content-center" id="pills-tab"
                                            role="tablist">
                                            <li class="nav-item" role="presentation">
                                                <a class="nav-link active" id="pills-home-tab" data-bs-toggle="pill"
                                                   data-bs-target="#pills-home" type="button" role="tab"
                                                   aria-controls="pills-home" aria-selected="true">Overview</a>
                                            </li>
                                            <li class="nav-item" role="presentation">
                                                <a class="nav-link" id="pills-profile-tab" data-bs-toggle="pill"
                                                   data-bs-target="#pills-profile" type="button" role="tab"
                                                   aria-controls="pills-profile" aria-selected="false">Order history</a>
                                            </li>
                                            <li class="nav-item" role="presentation">
                                                <a class="nav-link" id="pills-contact-tab" data-bs-toggle="pill"
                                                   data-bs-target="#pills-contact" type="button" role="tab"
                                                   aria-controls="pills-contact" aria-selected="false">Admin notes</a>
                                            </li>
                                        </ul>
                                    </div>
                                    <hr>
                                    <div class="tab-content" id="pills-tabContent">
                                        <div class="tab-pane fade show active" id="pills-home" role="tabpanel"
                                             aria-labelledby="pills-home-tab">

                                            <div class="p-2 bd-highlight">
                                                <div class="d-flex justify-content-start">
                                                    <div class="p-0">
                                                        <img src="{{asset('assets/images/icons/cart-profile.png')}}"
                                                             alt="cart-profile.png">
                                                        <span>{{$totalOrders}} Orders</span>
                                                    </div>
                                                    <div class="p-0">
                                                        <img src="{{asset('assets/images/icons/dollar-profile.png')}}"
                                                             alt="dollar-profile.png">
                                                        <span>QAD {{number_format($total,2)}} @if($user->company)
                                                                Sales @else Spent @endif</span>
                                                    </div>
                                                </div>
                                                <hr>
                                            </div>
                                            <div class="p-2 bd-highlight">
                                                <h5>Last {{$user->company ? 'sales' : "purchase"}}</h5>
                                                <span>{{Carbon\Carbon::parse($user->created_at)->format('Y-m-d')}}</span>
                                                <hr>
                                            </div>
                                            <div class="p-2 bd-highlight">
                                                <h5>Contact Info</h5>
                                                <div class="d-flex flex-column">
                                                    <div class="p-2">
                                                        <img src="{{asset('assets/images/icons/email-profile.png')}}"
                                                             alt="email-profile"> {{$user->email}}
                                                    </div>
                                                    <div class="p-2">
                                                        <img src="{{asset('assets/images/icons/phone-profile.png')}}"
                                                             alt="phone-profile"> {{$user->phone_number}}
                                                    </div>
                                                </div>
                                                <hr>
                                            </div>
                                            <div class="p-2 bd-highlight">
                                                <h5>{{$user->company ? 'Company name' : "Default Address"}}</h5>
                                                @if($user->company)
                                                    {{$user->company->name}}
                                                @else
                                                    {{$user->first_name ? $user->first_name . ' ' . $user->last_name : $user->email}}
                                                @endif
                                                <br>
                                                {{$user->phone_number}}
                                                <hr>
                                            </div>
                                        </div>
                                        <div class="tab-pane fade" id="pills-profile" role="tabpanel"
                                             aria-labelledby="pills-profile-tab">
                                            <div class="row table-orders-div">
                                                <div class="col-sm-5">
                                                    <div class="d-flex justify-content-start">
                                                        <h4>Orders ( {{$totalOrders}} )</h4>
                                                    </div>
                                                    <div class="d-flex justify-content-start">

                                                        <div class="input-group mx-auto" style="    width: 96%;">
                                                            <input id="search-t"
                                                                   class="form-control border-end-0 border"
                                                                   type="search"  >
                                                            <span class="input-group-append">
                                                                <button
                                                                    class="btn btn-outline-secondary bg-white border-start-0  border ms-n5"
                                                                    type="button">
                                                                    <i class="bi bi-search"></i>
                                                                </button>
                                                            </span>
                                                        </div>
                                                    </div>
                                                    <table class="table" id="user-table">
                                                        <thead style="display: none">
                                                        <tr>
                                                            <th scope="col">Customer name</th>
                                                        </tr>
                                                        </thead>
                                                        <tbody>
                                                        @foreach($user->customer_orders as $order)
                                                            @foreach($order->items as $item)
                                                                <tr>
                                                                    <td>
                                                                        <div class="card border-info border">
                                                                            <div class="card-body">
                                                                                <div class="row">
                                                                                    <span>Service Name</span>
                                                                                    <label
                                                                                        for="">{{$item->service->name}}</label>
                                                                                </div>
                                                                                <div class="row">
                                                                                    <span>Location</span>
                                                                                    <label
                                                                                        for="">{{$item->service->address_1}}</label>
                                                                                </div>
                                                                                <div class="row">
                                                                                    <span>Scheduled date</span>
                                                                                    <label
                                                                                        for="">{{Carbon\Carbon::parse($item->schedule_start_datetime)->format('F, d Y')}}</label>
                                                                                </div>
                                                                                <div class="row">
                                                                                    <span>Scheduled time</span>
                                                                                    <label
                                                                                        for="">{{Carbon\Carbon::parse($item->schedule_start_datetime)->format('H:s a')}}</label>
                                                                                </div>
                                                                                <hr>

                                                                                <div class="row">
                                                                                    <div class="col p-0">
                                                                                        <span>Total cost</span>
                                                                                        <label for="">
                                                                                            QAR {{ number_format($item->service->price,2)}}
                                                                                        </label>
                                                                                    </div>
                                                                                    <div class="col p-0">
                                                                                        <span>Paid cost</span>
                                                                                        <label for="" class="text-success">
                                                                                            QAR {{ number_format($item->total_paid,2)}}
                                                                                        </label>
                                                                                    </div>
                                                                                    <div class="col p-0">
                                                                                        <span>Outstanding cost</span>
                                                                                        <label for="" class="text-danger">
                                                                                            QAR {{ number_format($item->balance,2)}}
                                                                                        </label>
                                                                                    </div>
                                                                                </div>
                                                                                <hr>
                                                                                <div class="row">
                                                                                    <span>Order status
                                                                                        <span class="p-2 me-4 badge bg-secondary text-dark  ms-4 text-capitalize">
                                                                                            {{$item->status}}
                                                                                        </span>
                                                                                    </span>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="row mt-3 mb-3">
                                                                            <button data-order-id="{{$order->reference_no}}" class="btn mx-auto btn-warning text-white text-center view-full-order-btn" type="button" style="width:92%">
                                                                                View full order
                                                                            </button>
                                                                        </div>
                                                                    </td>
                                                                </tr>
                                                                <?php continue; ?>
                                                            @endforeach
                                                        @endforeach

                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                            <div class="row info-orders-div d-none">

                                                <div class="d-flex justify-content-end mb-3">
                                                    <div class="p-1">

                                                        <button class="btn mx-auto btn-warning text-white text-center close-info-order-btn" type="button"  >
                                                            Close
                                                        </button>
                                                    </div>
                                                </div>
                                                @foreach($user->customer_orders as $order)
                                                    @foreach($order->items as $i => $item)

                                                        <div class="d-none order-ref-id col-sm-12 order-ref-id-{{$order->reference_no}}">
                                                            <div class="card border border-info">
                                                                <div class="card-body ">
                                                                    <span>Order - <span class="order-reference-number">{{$order->reference_no}}</span></span>
                                                                    <div class="row">
                                                                        <div class="col">
                                                                            <div class="card">
                                                                                <div class="card-body ">
                                                                                    <ul class="list-group list-group-flush">
                                                                                        <li class="list-group-item">
                                                                                            <div class="row">
                                                                                                <div class="col-sm-6">Name</div>
                                                                                                <div class="col-sm-6">{{$user->name ? $user->name : ($user->first_name ? $user->first_name . ' ' . $user->last_name : $user->email) }}</div>
                                                                                            </div>
                                                                                        </li>
                                                                                        <li class="list-group-item">
                                                                                            <div class="row">
                                                                                                <div class="col-sm-6">Phone No.</div>
                                                                                                <div class="col-sm-6">{{$user->phone_number}}</div>
                                                                                            </div>
                                                                                        </li>
                                                                                        <li class="list-group-item">
                                                                                            <div class="row">
                                                                                                <div class="col-sm-6">Email</div>
                                                                                                <div class="col-sm-6">{{$user->email }}</div>
                                                                                            </div>
                                                                                        </li>
                                                                                        <li class="list-group-item">
                                                                                            <div class="row">
                                                                                                <div class="col-sm-6">Location</div>
                                                                                                <div class="col-sm-6">
                                                                                                    {{$user->location }}
                                                                                                </div>
                                                                                            </div>
                                                                                        </li>
                                                                                        <li class="list-group-item">
                                                                                            <div class="row">
                                                                                                <div class="col-sm-6">Gender</div>
                                                                                                <div class="col-sm-6">-</div>
                                                                                            </div>
                                                                                        </li>
                                                                                    </ul>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col">
                                                                            <div class="card">
                                                                                <div class="card-body ">
                                                                                    <ul class="list-group list-group-flush">
                                                                                        <li class="list-group-item">
                                                                                            <div class="row">
                                                                                                <div class="col-sm-6">Card Name</div>
                                                                                                <div class="col-sm-6">{{$order->paymentMethod->name }}</div>
                                                                                            </div>
                                                                                        </li>
                                                                                        <li class="list-group-item">
                                                                                            <div class="row">
                                                                                                <div class="col-sm-6">Payment Ref. No.</div>
                                                                                                <div class="col-sm-6">{{$order->paymentDetails ? $order->paymentDetails->reference_no : ''}}</div>
                                                                                            </div>
                                                                                        </li>
                                                                                        <li class="list-group-item">
                                                                                            <div class="row">
                                                                                                <div class="col-sm-6">Total Paid</div>
                                                                                                <div class="col-sm-6">
                                                                                                    QAR {{ number_format($item->total_paid,2)}}
                                                                                                </div>
                                                                                            </div>
                                                                                        </li>
                                                                                        <li class="list-group-item">
                                                                                            <div class="row">
                                                                                                <div class="col-sm-6">Total Balance</div>
                                                                                                <div class="col-sm-6">
                                                                                                    QAR {{ number_format($item->balance,2)}}
                                                                                                </div>
                                                                                            </div>
                                                                                        </li>
                                                                                        <li class="list-group-item">
                                                                                            <div class="row">
                                                                                                <div class="col-sm-6">Total Amount To Be Paid</div>
                                                                                                <div class="col-sm-6">
                                                                                                    QAR {{ number_format($item->service->price,2)}}
                                                                                                </div>
                                                                                            </div>
                                                                                        </li>
                                                                                    </ul>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="row mt-3">
                                                                        <div class="col">
                                                                            <div class="card">
                                                                                <div class="card-body ">
                                                                                    <h3>Order Items</h3>
                                                                                    <div class="d-flex justify-content-center ">
                                                                                        <div id="gallery-lightbox" class="row" data-bs-toggle="modal" data-bs-target="#exampleModal-{{$i+=1}}">
                                                                                            <div class="col-6 col-md-4 col-lg-3 p-0">
                                                                                                <img class="w-100 thumbnail"
                                                                                                     src="https://reservegcc.com/{{$item->service->image }}"
                                                                                                     alt="First Slide" data-bs-target="#carouselExampleControls" data-bs-slide-to="0">
                                                                                            </div>

                                                                                            @foreach($item->service->gallery as $k =>  $image)
                                                                                                <div class="col-6 col-md-4 col-lg-3 p-0">
                                                                                                    <img class="w-100 thumbnail" src="https://reservegcc.com/{{$image->image }}"
                                                                                                         alt="{{$k+=1}} Slide" data-bs-target="#carouselExampleControls" data-bs-slide-to="{{$k+=1}}">
                                                                                                </div>
                                                                                            @endforeach

                                                                                            <div class="modal" id="exampleModal-{{$i}}" tabindex="-1" role="dialog" aria-hidden="true">
                                                                                                <button   type="button" class="btn-close position-absolute right-0 p-2" data-bs-dismiss="modal"
                                                                                                          aria-label="Close"></button>
                                                                                                <div class="modal-dialog modal-lg" role="document">
                                                                                                    <div class="modal-content bg-transparent">
                                                                                                        <div class="modal-body p-0">
                                                                                                            <div id="carouselExampleControls" class="carousel slide" data-bs-ride="carousel">
                                                                                                                <div class="carousel-inner">

                                                                                                                    @foreach($order->items as $item)
                                                                                                                        <div class="carousel-item active">
                                                                                                                            <img class="d-block w-100"
                                                                                                                                 src="https://reservegcc.com/{{$item['service']['image'] }}"
                                                                                                                                 alt="First Slide">
                                                                                                                        </div>
                                                                                                                        @foreach($item->service->gallery as $k =>  $image)
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
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>

                                                                    <div class="row mt-3">
                                                                        <div class="col">
                                                                            <div class="card">
                                                                                <div class="card-body ">
                                                                                    <ul class="list-group list-group-flush">
                                                                                        <li class="list-group-item">
                                                                                            <div class="row">
                                                                                                <div class="col-sm-6">Service Name</div>
                                                                                                <div class="col-sm-6">{{$item->service->name }}</div>
                                                                                            </div>
                                                                                        </li>
                                                                                        <li class="list-group-item">
                                                                                            <div class="row">
                                                                                                <div class="col-sm-6">Service Location</div>
                                                                                                <div class="col-sm-6">
                                                                                                    {{$item->service->location }}
                                                                                                </div>
                                                                                            </div>
                                                                                        </li>
                                                                                        <li class="list-group-item">
                                                                                            <div class="row">
                                                                                                <div class="col-sm-6">Service Price</div>
                                                                                                <div class="col-sm-6">
                                                                                                    {{$item->service->price }}
                                                                                                </div>
                                                                                            </div>
                                                                                        </li>
                                                                                        <li class="list-group-item">
                                                                                            <div class="row">
                                                                                                <div class="col-sm-6">Capacity</div>
                                                                                                <div class="col-sm-6">
                                                                                                    min {{$item->service->min_capacity }} - max {{$item->service->max_capacity }}
                                                                                                </div>
                                                                                            </div>
                                                                                        </li>
                                                                                    </ul>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col">
                                                                            <div class="card">
                                                                                <div class="card-body ">
                                                                                    <ul class="list-group list-group-flush">
                                                                                        <li class="list-group-item">
                                                                                            <div class="row">
                                                                                                <div class="col-sm-6">Status</div>
                                                                                                <div class="col-sm-6">{{$item->status }}</div>
                                                                                            </div>
                                                                                        </li>
                                                                                        <li class="list-group-item">
                                                                                            <div class="row">
                                                                                                <div class="col-sm-6">Scheduled Date</div>
                                                                                                <div class="col-sm-6">{{Carbon\Carbon::parse($item->schedule_start_datetime)->format('F, d Y')}}</div>
                                                                                            </div>
                                                                                        </li>
                                                                                        <li class="list-group-item">
                                                                                            <div class="row">
                                                                                                <div class="col-sm-6">Scheduled Time</div>
                                                                                                <div class="col-sm-6">
                                                                                                    {{Carbon\Carbon::parse($item->schedule_start_datetime)->format('H:m a')}}
                                                                                                </div>
                                                                                            </div>
                                                                                        </li>
                                                                                        <li class="list-group-item">
                                                                                            <div class="row">
                                                                                                <div class="col-sm-6">Guest No.</div>
                                                                                                <div class="col-sm-6">
                                                                                                     {{ $item->guests}}
                                                                                                </div>
                                                                                            </div>
                                                                                        </li>
                                                                                    </ul>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <?php continue; ?>
                                                    @endforeach
                                                @endforeach
                                            </div>
                                        </div>
                                        <div class="tab-pane fade" id="pills-contact" role="tabpanel"
                                             aria-labelledby="pills-contact-tab">

                                            @foreach($user->notes as $note)
                                                <div class="row mb-3">
                                                    <div class="col">
                                                        <div class="card">
                                                            <div class="card-body ">
                                                                <div class="d-flex justify-content-between">

                                                                    <div class="p-0">
                                                                        @if($user->profile_picture )
                                                                            <img width="35" class="rounded-circle"
                                                                                 src="{{ asset( $user->profile_picture) }}" alt="...."/>
                                                                        @else
                                                                            <img width="35" class="rounded-circle"
                                                                                 src="https://ui-avatars.com/api/?name={{$user->first_name ? $user->first_name: $user->email}}"
                                                                                 alt="...">
                                                                        @endif
                                                                            <h3>{{$user->first_name ? $user->first_name . ' ' . $user->last_name : $user->email}}</h3>
                                                                    </div>
                                                                    <div class="p-0">

                                                                        <a
                                                                           href="{{route('notes.destroy-note',['id' => $note->id])}}"
                                                                           onclick="return confirm('Are you sure want to delete this note?')">
                                                                            <i class="bi bi-trash"></i>
                                                                        </a>
                                                                    </div>
                                                                </div>
                                                                <div class="row">
                                                                    <div class="col">
                                                                        <h4>{{$note->subject}}</h4>
                                                                        <p>{{$note->description}}</p>

                                                                        <small>{{Carbon\Carbon::parse($note->created_at)->format('d/m/Y H:s a')}}</small>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach

                                                <button type="button" class="btn btn-warning text-white text-center w-100"  data-bs-toggle="modal" data-bs-target="#new-notes-modal">
                                                   Add new note
                                                </button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="new-notes-modal" tabindex="-1" aria-labelledby="new-notes-modalLabel"
         aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="new-notes-modalLabel">Add new note</h5>
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal" aria-label="Close">close
                    </button>
                </div>
                <form method="post" action="{{route('notes.store')}}"  >
                    @csrf
                    <input type="hidden" name="user_id" value="{{$user->id}}">
                    <div class="modal-body">
                        <div class="row g-3 align-items-center mb-3">
                            <div class="col-auto" style="width: 29%;">
                                <label for="ticket-modal-title-field" class="col-form-label">
                                    Enter subject
                                </label>
                            </div>
                            <div class="col-auto" style="width: 70%;">
                                <input dir="auto" name="subject" type="text"
                                       class="form-control"
                                       placeholder="Enter subject of note">
                            </div>
                        </div>
                        <div class="row g-3 align-items-center mb-3">
                            <div class="col-auto" style="width: 29%; margin-top: -157px;">
                                <label for="ticket-modal-description-field" class="col-form-label">
                                    Note description
                                </label>
                            </div>
                            <div class="col-auto" style="width: 70%;">
                                <textarea dir="auto" rows="8" name="description" type="text"
                                  class="form-control"
                                  placeholder="This is a note about..."> </textarea>
                            </div>
                        </div>

                        <div class="d-flex justify-content-between mb-3">
                            <div class="p-2 bd-highlight">
                                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
                            </div>

                            <div class="  p-2 bd-highlight">
                                <button type="submit" class="btn btn-warning">Submit</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('content_javascript')
    <script type="text/javascript">
        $(document).ready(function () {
            $('body').on('click','.view-full-order-btn',function (e) {
                let orderId = $(this).attr('data-order-id');
                $('.info-orders-div').removeClass('d-none');
                $('.table-orders-div').addClass('d-none');
                $('.order-ref-id-'+orderId).removeClass('d-none')
            });
            $('body').on('click','.close-info-order-btn',function (e) {
                $('.info-orders-div,.order-ref-id').addClass('d-none');
                $('.table-orders-div').removeClass('d-none');
            });

            $.fn.dataTable.ext.errMode = 'none';
            let datatable = $('#user-table').DataTable({});
            $('#user-table').on('error.dt', function (e, settings, techNote, message) {
                console.log('An error has been reported by DataTables: ', message);
            })
            $('#search-t').keyup(function () {
                datatable.search($(this).val()).draw();
            })
            $('#user-table_length, .dataTables_paginate, .dataTables_info,.dataTables_filter').remove();
        });
    </script>
@endsection
