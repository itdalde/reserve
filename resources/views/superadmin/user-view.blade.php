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
    <div class="">
        <div class="row">
            <div class="col-4">
                <div class="d-flex flex-column bd-highlight mb-3">
                    <div class="p-2 bd-highlight"><a href="javascript: history.go(-1)">
                            <--
                                @if ($user->company) Service Providers
                            @else
                                Customers @endif</a>
                    </div>
                    <div class="p-2 bd-highlight">
                        <div class="d-flex justify-content-between">
                            <h3>
                                @if ($user->company)
                                    Service provider details
                                @else
                                    Customer details
                                @endif
                            </h3>
                        </div>
                    </div>

                </div>
            </div>
            <div class="col-8">
                <div class="d-flex flex-column bd-highlight mb-3">
                    <div class="p-2 bd-highlight"></div>
                    <div class="p-1 bd-highlight">
                        <div class="d-flex justify-content-end">
                            <div class="alert bg-white" role="alert">
                                <img src="{{ asset('assets/images/icons/alert-icon.png') }}" alt="alert-icon.png">
                                <strong>Abdul</strong> Changed email address
                                <strong
                                    class="fs-5">{{ Carbon\Carbon::parse($user->created_at)->format('d/m/Y H:s a') }}</strong>
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
                                            <div class="d-flex">
                                                <div class="">
                                                    @if ($user->profile_picture)
                                                    <img width="50" class="rounded-circle"
                                                        src="{{ asset($user->profile_picture) }}" alt="...." />
                                                    @else
                                                        <img width="50" class="rounded-circle"
                                                            src="https://ui-avatars.com/api/?name={{ $user->first_name ? $user->first_name : $user->email }}"
                                                            alt="...">
                                                    @endif
                                                </div>
                                                <div class="ms-3" style="margin-top: -3px;">
                                                    <p class="fs-4 fw-bolder mb-0">{{ $user->first_name ? $user->first_name . ' ' . $user->last_name : $user->full_name }}</p>
                                                    <p class="fs-4 fw-bolder mt-0">{{ $user->email }}</p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="p-0">
                                            <span class="status-field p-2 me-4 badge bg-secondary text-dark">
                                                0 unresolved
                                            </span>
                                            <a class="btn btn-danger"
                                                href="{{ route('users.delete-user', ['id' => $user->id]) }}"
                                                onclick="return confirm('Are you sure want to delete this user?')">
                                                Delete
                                            </a>
                                            <i data-bs-toggle="tooltip" data-bs-placement="top"
                                                title="{{ Carbon\Carbon::parse($user->created_at)->format('Y-m-d') }}"
                                                class="bi bi-info-circle ms-4 icon-info"></i>
                                        </div>
                                    </div>
                                    <div class="d-flex justify-content-center">
                                        <ul class="nav nav-pills mb-3 justify-content-center" id="pills-tab" role="tablist">
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
                                            @if ($user->company !== null)
                                                <li class="nav-item" role="presentation">
                                                    <a class="nav-link" id="pills-vendor-tab" data-bs-toggle="pill"
                                                        data-bs-target="#pills-vendor" type="button" role="tab"
                                                        aria-controls="pills-vendor" aria-selected="false">
                                                        Vendor Category
                                                    </a>
                                                </li>
                                            @endif
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
                                                    <div class="p-0 my-auto">
                                                        <img src="{{ asset('assets/images/icons/cart-profile.png') }}"
                                                            alt="cart-profile.png">
                                                        <span>{{ $totalOrders }} Orders</span>
                                                    </div>
                                                    <div class="ms-9 my-auto">
                                                        <img src="{{ asset('assets/images/icons/dollar-profile.png') }}"
                                                            alt="dollar-profile.png">
                                                        <span>QAD {{ number_format($total, 2) }}
                                                            @if ($user->company)
                                                                Sales
                                                            @else
                                                                Spent
                                                            @endif
                                                        </span>
                                                    </div>
                                                    <div class="p-0 w-25 d-flex my-auto">
                                                        <h5 class="fw-bolder fs-5 text-secondary ms-9 my-auto">Last {{ $user->company ? 'Sales' : 'Purchase' }}</h5>
                                                        <em class="ms-3 fs-5 my-auto">{{ Carbon\Carbon::parse($user->created_at)->format('d/m/Y') }}</em>        
                                                    </div>
                                                </div>
                                                <hr>
                                            </div>
                                            <div class="p-2 bd-highlight border borde-2 rounded">
                                                <h4 class="fw-bolder text-secondary mb-5">Customer Profile</h4>
                                                <div class="">
                                                    @if ($user->first_name == '' || $user->last_name == '') 
                                                    <p class="fs-5 fw-bolder mb-2">Full Name: <em class="fs-5 fw-normal">{{ $user->full_name ?? 'not specified' }}</em></p>
                                                    @else
                                                    <p class="fs-5 fw-bolder mb-2">First Name: <em class="fs-5 fw-normal">{{ $user->first_name ?? 'not specified' }}</em></p>
                                                    <p class="fs-5 fw-bolder mb-2">Last Name: <em class="fs-5 fw-normal">{{ $user->last_name ?? 'not specified' }}</em></p>
                                                    @endif
                                                    
                                                    <p class="fs-5 fw-bolder mb-2">Gender: <em class="fs-5 fw-normal">{{ $user->gender ?? 'not specified' }}</em></p>
                                                    <p class="fs-5 fw-bolder mb-2">Birth Date: <em class="fs-5 fw-normal">{{ $user->birth_date ?? 'not specified' }}</em></p>
                                                    <p class="fs-5 fw-bolder mb-2">Email: <em class="fs-5 fw-normal ms-3"><img src="{{ asset('assets/images/icons/email-profile.png') }}"
                                                        alt="email-profile" style="width: 15px;"> {{ $user->email ?? 'not specified' }}</em></p>
                                                    <p class="fs-5 fw-bolder mb-2">Contact #: <em class="fs-5 fw-normal ms-3"><img src="{{ asset('assets/images/icons/phone-profile.png') }}"
                                                        alt="phone-profile" style="width: 15px;">{{ $user->phone_number ?? 'not specified' }}</em></p>
                                                    <p class="fs-5 fw-bolder mb-2">Position: <em class="fs-5 fw-normal ms-3">{{ $user->position ?? 'not specified' }}</em></p>
                                                    <hr />
                                                    <p class="fs-5 fw-bolder mb-2">Default Address: <em class="fs-5 fw-normal ms-2">{{ $user->location ?? 'not specified' }}</em></p>
                                                    <p class="fs-5 fw-bolder mb-2">Billing Address: <em class="fs-5 fw-normal ms-2">{{ $user->location ?? 'not specified' }}</em></p>

                                                </div>
                                            </div>
                                            <div class="p-2 bd-highlight d-none">
                                                <h5 class="fw-bold text-secondary pb-2">Card Details</h5>
                                                <div class="pb-3">
                                                    <div>Card 1 <img
                                                            src="{{ asset('assets/images/creditcard/mastercard.svg') }}"
                                                            alt="..." class="rounded-circle ms-2" /></div>
                                                    <div>
                                                        <p class="mb-1">Abdul Rasak</p>
                                                        <p class="m-0">5073 2489 4274 8293</p>
                                                        <p class="m-0">19/23 - 443</p>
                                                    </div>
                                                </div>
                                                <div class="pb-3">
                                                    <div class="pb-1">Card 1 <img
                                                            src="{{ asset('assets/images/creditcard/mastercard.svg') }}"
                                                            alt="..." class="rounded-circle ms-2" /></div>
                                                    <div>
                                                        <p class="mb-1">Abdul Rasak</p>
                                                        <p class="m-0">5073 2489 4274 8293</p>
                                                        <p class="m-0">19/23 - 443</p>
                                                    </div>
                                                </div>
                                                <hr />
                                            </div>
                                            {{-- <div class="p-2 bd-highlight">
                                                <h5>{{ $user->company ? 'Company name' : 'Default Address' }}</h5>
                                                @if ($user->company)
                                                    {{ $user->company->name }}
                                                @else
                                                    {{ $user->first_name ? $user->first_name . ' ' . $user->last_name : $user->email }}
                                                @endif
                                                <br>
                                                {{ $user->phone_number }}
                                                <hr>
                                            </div> --}}
                                        </div>
                                        <div class="tab-pane fade" id="pills-profile" role="tabpanel"
                                            aria-labelledby="pills-profile-tab">
                                            <div class="table-orders-div">
                                                <div class="">
                                                    <div class="d-flex justify-content-start">
                                                        <h4>Orders ( {{ $totalOrders }} )</h4>
                                                    </div>
                                                    <div class="d-flex justify-content-start">

                                                        <div class="input-group" style="width: 50%; margin-bottom: 20px;">
                                                            <input id="search-t" class="form-control border-end-0 border"
                                                                type="search">
                                                            <span class="input-group-append">
                                                                <button
                                                                    class="btn btn-outline-secondary bg-white border-start-0  border ms-n5"
                                                                    type="button">
                                                                    <i class="bi bi-search"></i>
                                                                </button>
                                                            </span>
                                                        </div>
                                                    </div>
                                                    <div class="row">

                                                    @foreach($user->customer_orders as $order)
                                                        @foreach($order->items as $item)
                                                            <div class="col-sm-12 col-md-6">
                                                                <div class="card border-info border">
                                                                    <div class="card-body">
                                                                        <div class="row">
                                                                            <span class="p-0">Service
                                                                                Name</span>
                                                                            <label for=""
                                                                                class="fs-5 fw-bold text-secondary p-0">{{ $item->service->name }}</label>
                                                                        </div>
                                                                        <div class="row">
                                                                            <span
                                                                                class="p-0">Location</span>
                                                                            <label for=""
                                                                                class="fs-5 fw-bold text-secondary p-0">{{ $item->service->address_1  ?? '-'}}</label>
                                                                        </div>
                                                                        <div class="row">
                                                                            <span class="p-0">Scheduled
                                                                                date</span>
                                                                            <label for=""
                                                                                class="fs-5 fw-bold text-secondary p-0">{{ Carbon\Carbon::parse($item->schedule_start_datetime)->format('F, d Y') }}</label>
                                                                        </div>
                                                                        <div class="row">
                                                                            <span class="p-0">Scheduled
                                                                                time</span>
                                                                            <label for=""
                                                                                class="fs-5 fw-bold text-secondary p-0">{{ Carbon\Carbon::parse($item->schedule_start_datetime)->format('H:s a') }}</label>
                                                                        </div>

                                                                        <div
                                                                            class="row border-bottom border-1 border-secondary p-1 opacity-50">
                                                                        </div>

                                                                        <div class="row pt-2">
                                                                            <div class="col p-0">
                                                                                <span class="fs-6">Total
                                                                                    cost</span>
                                                                                <label for=""
                                                                                    class="fs-5 fw-bold text-secondary p-0">
                                                                                    QAR
                                                                                    {{ number_format($item->service->price, 2) }}
                                                                                </label>
                                                                            </div>
                                                                            <div class="col p-0">
                                                                                <span class="fs-6">Paid
                                                                                    cost</span>
                                                                                <label for=""
                                                                                    class="text-success fs-5 fw-bold text-secondary">
                                                                                    QAR
                                                                                    {{ number_format($item->total_paid, 2) }}
                                                                                </label>
                                                                            </div>
                                                                            <div class="col p-0">
                                                                                <span
                                                                                    class="fs-6">Outstanding
                                                                                    cost</span>
                                                                                <label for=""
                                                                                    class="text-danger fs-5 fw-bold text-secondary">
                                                                                    QAR
                                                                                    {{ number_format($item->balance, 2) }}
                                                                                </label>
                                                                            </div>
                                                                        </div>
                                                                        <div
                                                                            class="row border-bottom border-1 border-secondary p-1 opacity-50">
                                                                        </div>
                                                                        <div class="row pt-2">
                                                                            <span>Order status
                                                                                <span
                                                                                    class="p-2 me-4 badge bg-secondary text-dark  ms-4 text-capitalize">
                                                                                    {{ $item->status }}
                                                                                </span>
                                                                            </span>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="row mt-3 mb-3">
                                                                    <button
                                                                        data-order-id="{{ $order->reference_no }}"
                                                                        class="btn mx-auto btn-warning text-white text-center view-full-order-btn"
                                                                        type="button" style="width:92%">
                                                                        View full order
                                                                    </button>
                                                                </div>
                                                            </div>
                                                        <?php continue; ?>
                                                        @endforeach
                                                    @endforeach
                                                </div>

                                                </div>
                                            </div>
                                            <div class="row info-orders-div d-none">

                                                <div class="d-flex justify-content-end mb-3">
                                                    <div class="p-1">

                                                        <button
                                                            class="btn mx-auto btn-warning text-white text-center close-info-order-btn"
                                                            type="button">
                                                            Close
                                                        </button>
                                                    </div>
                                                </div>
                                                @foreach ($user->customer_orders as $order)
                                                    @foreach ($order->items as $i => $item)
                                                        <div
                                                            class="d-none order-ref-id col-sm-12 order-ref-id-{{ $order->reference_no }}">
                                                            <div class="card border border-info">
                                                                <div class="card-body ">
                                                                    <span>Order - <span
                                                                            class="order-reference-number">{{ $order->reference_no }}</span></span>
                                                                    <div class="row">
                                                                        <div class="col">
                                                                            <div class="card">
                                                                                <div class="card-body ">
                                                                                    <ul
                                                                                        class="list-group list-group-flush">
                                                                                        <li class="list-group-item">
                                                                                            <div class="row">
                                                                                                <div class="col-sm-6">Name
                                                                                                </div>
                                                                                                <div class="col-sm-6">
                                                                                                    {{ $user->name ? $user->name : ($user->first_name ? $user->first_name . ' ' . $user->last_name : $user->email) }}
                                                                                                </div>
                                                                                            </div>
                                                                                        </li>
                                                                                        <li class="list-group-item">
                                                                                            <div class="row">
                                                                                                <div class="col-sm-6">Phone
                                                                                                    No.</div>
                                                                                                <div class="col-sm-6">
                                                                                                    {{ $user->phone_number }}
                                                                                                </div>
                                                                                            </div>
                                                                                        </li>
                                                                                        <li class="list-group-item">
                                                                                            <div class="row">
                                                                                                <div class="col-sm-6">Email
                                                                                                </div>
                                                                                                <div class="col-sm-6">
                                                                                                    {{ $user->email }}
                                                                                                </div>
                                                                                            </div>
                                                                                        </li>
                                                                                        <li class="list-group-item">
                                                                                            <div class="row">
                                                                                                <div class="col-sm-6">
                                                                                                    Location</div>
                                                                                                <div class="col-sm-6">
                                                                                                    {{ $user->location }}
                                                                                                </div>
                                                                                            </div>
                                                                                        </li>
                                                                                        <li class="list-group-item">
                                                                                            <div class="row">
                                                                                                <div class="col-sm-6">
                                                                                                    Gender</div>
                                                                                                <div class="col-sm-6">-
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
                                                                                    <ul
                                                                                        class="list-group list-group-flush">
                                                                                        <li class="list-group-item">
                                                                                            <div class="row">
                                                                                                <div class="col-sm-6">Card
                                                                                                    Name</div>
                                                                                                <div class="col-sm-6">
                                                                                                    {{ $order->paymentMethod->name }}
                                                                                                </div>
                                                                                            </div>
                                                                                        </li>
                                                                                        <li class="list-group-item">
                                                                                            <div class="row">
                                                                                                <div class="col-sm-6">
                                                                                                    Payment Ref. No.</div>
                                                                                                <div class="col-sm-6">
                                                                                                    {{ $order->paymentDetails ? $order->paymentDetails->reference_no : '' }}
                                                                                                </div>
                                                                                            </div>
                                                                                        </li>
                                                                                        <li class="list-group-item">
                                                                                            <div class="row">
                                                                                                <div class="col-sm-6">Total
                                                                                                    Paid</div>
                                                                                                <div class="col-sm-6">
                                                                                                    QAR
                                                                                                    {{ number_format($item->total_paid, 2) }}
                                                                                                </div>
                                                                                            </div>
                                                                                        </li>
                                                                                        <li class="list-group-item">
                                                                                            <div class="row">
                                                                                                <div class="col-sm-6">Total
                                                                                                    Balance</div>
                                                                                                <div class="col-sm-6">
                                                                                                    QAR
                                                                                                    {{ number_format($item->balance, 2) }}
                                                                                                </div>
                                                                                            </div>
                                                                                        </li>
                                                                                        <li class="list-group-item">
                                                                                            <div class="row">
                                                                                                <div class="col-sm-6">Total
                                                                                                    Amount To Be Paid</div>
                                                                                                <div class="col-sm-6">
                                                                                                    QAR
                                                                                                    {{ number_format($item->service->price, 2) }}
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
                                                                                    <div
                                                                                        class="d-flex justify-content-center ">
                                                                                        <div id="gallery-lightbox"
                                                                                            class="row"
                                                                                            data-bs-toggle="modal"
                                                                                            data-bs-target="#exampleModal-{{ $i += 1 }}">
                                                                                            <div
                                                                                                class="col-6 col-md-4 col-lg-3 p-0">
                                                                                                <img class="w-100 thumbnail"
                                                                                                    src="https://reservegcc.com/{{ $item->service->image }}"
                                                                                                    alt="First Slide"
                                                                                                    data-bs-target="#carouselExampleControls"
                                                                                                    data-bs-slide-to="0">
                                                                                            </div>

                                                                                            @foreach ($item->service->gallery as $k => $image)
                                                                                                <div
                                                                                                    class="col-6 col-md-4 col-lg-3 p-0">
                                                                                                    <img class="w-100 thumbnail"
                                                                                                        src="https://reservegcc.com/{{ $image->image }}"
                                                                                                        alt="{{ $k += 1 }} Slide"
                                                                                                        data-bs-target="#carouselExampleControls"
                                                                                                        data-bs-slide-to="{{ $k += 1 }}">
                                                                                                </div>
                                                                                            @endforeach

                                                                                            <div class="modal"
                                                                                                id="exampleModal-{{ $i }}"
                                                                                                tabindex="-1"
                                                                                                role="dialog"
                                                                                                aria-hidden="true">
                                                                                                <button type="button"
                                                                                                    class="btn-close position-absolute right-0 p-2"
                                                                                                    data-bs-dismiss="modal"
                                                                                                    aria-label="Close"></button>
                                                                                                <div class="modal-dialog modal-lg"
                                                                                                    role="document">
                                                                                                    <div
                                                                                                        class="modal-content bg-transparent">
                                                                                                        <div
                                                                                                            class="modal-body p-0">
                                                                                                            <div id="carouselExampleControls"
                                                                                                                class="carousel slide"
                                                                                                                data-bs-ride="carousel">
                                                                                                                <div
                                                                                                                    class="carousel-inner">

                                                                                                                    @foreach ($order->items as $item)
                                                                                                                        <div
                                                                                                                            class="carousel-item active">
                                                                                                                            <img class="d-block w-100"
                                                                                                                                src="https://reservegcc.com/{{ $item['service']['image'] }}"
                                                                                                                                alt="First Slide">
                                                                                                                        </div>
                                                                                                                        @foreach ($item->service->gallery as $k => $image)
                                                                                                                            <div
                                                                                                                                class="carousel-item">
                                                                                                                                <img class="d-block w-100"
                                                                                                                                    src="https://reservegcc.com/{{ $image['image'] }}"
                                                                                                                                    alt="{{ $k += 1 }} Slide">
                                                                                                                            </div>
                                                                                                                        @endforeach
                                                                                                                    @endforeach
                                                                                                                </div>
                                                                                                                <button
                                                                                                                    class="carousel-control-prev"
                                                                                                                    type="button"
                                                                                                                    data-bs-target="#carouselExampleControls"
                                                                                                                    data-bs-slide="prev">
                                                                                                                    <span
                                                                                                                        class="carousel-control-prev-icon"
                                                                                                                        aria-hidden="true"></span>
                                                                                                                    <span
                                                                                                                        class="visually-hidden">Previous</span>
                                                                                                                </button>
                                                                                                                <button
                                                                                                                    class="carousel-control-next"
                                                                                                                    type="button"
                                                                                                                    data-bs-target="#carouselExampleControls"
                                                                                                                    data-bs-slide="next">
                                                                                                                    <span
                                                                                                                        class="carousel-control-next-icon"
                                                                                                                        aria-hidden="true"></span>
                                                                                                                    <span
                                                                                                                        class="visually-hidden">Next</span>
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
                                                                                    <ul
                                                                                        class="list-group list-group-flush">
                                                                                        <li class="list-group-item">
                                                                                            <div class="row">
                                                                                                <div class="col-sm-6">
                                                                                                    Service Name</div>
                                                                                                <div class="col-sm-6">
                                                                                                    {{ $item->service->name }}
                                                                                                </div>
                                                                                            </div>
                                                                                        </li>
                                                                                        <li class="list-group-item">
                                                                                            <div class="row">
                                                                                                <div class="col-sm-6">
                                                                                                    Service Location</div>
                                                                                                <div class="col-sm-6">
                                                                                                    {{ $item->service->location }}
                                                                                                </div>
                                                                                            </div>
                                                                                        </li>
                                                                                        <li class="list-group-item">
                                                                                            <div class="row">
                                                                                                <div class="col-sm-6">
                                                                                                    Service Price</div>
                                                                                                <div class="col-sm-6">
                                                                                                    {{ $item->service->price }}
                                                                                                </div>
                                                                                            </div>
                                                                                        </li>
                                                                                        <li class="list-group-item">
                                                                                            <div class="row">
                                                                                                <div class="col-sm-6">
                                                                                                    Capacity</div>
                                                                                                <div class="col-sm-6">
                                                                                                    min
                                                                                                    {{ $item->service->min_capacity }}
                                                                                                    - max
                                                                                                    {{ $item->service->max_capacity }}
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
                                                                                    <ul
                                                                                        class="list-group list-group-flush">
                                                                                        <li class="list-group-item">
                                                                                            <div class="row">
                                                                                                <div class="col-sm-6">
                                                                                                    Status</div>
                                                                                                <div class="col-sm-6">
                                                                                                    {{ $item->status }}
                                                                                                </div>
                                                                                            </div>
                                                                                        </li>
                                                                                        <li class="list-group-item">
                                                                                            <div class="row">
                                                                                                <div class="col-sm-6">
                                                                                                    Scheduled Date</div>
                                                                                                <div class="col-sm-6">
                                                                                                    {{ Carbon\Carbon::parse($item->schedule_start_datetime)->format('F, d Y') }}
                                                                                                </div>
                                                                                            </div>
                                                                                        </li>
                                                                                        <li class="list-group-item">
                                                                                            <div class="row">
                                                                                                <div class="col-sm-6">
                                                                                                    Scheduled Time</div>
                                                                                                <div class="col-sm-6">
                                                                                                    {{ Carbon\Carbon::parse($item->schedule_start_datetime)->format('H:m a') }}
                                                                                                </div>
                                                                                            </div>
                                                                                        </li>
                                                                                        <li class="list-group-item">
                                                                                            <div class="row">
                                                                                                <div class="col-sm-6">Guest
                                                                                                    No.</div>
                                                                                                <div class="col-sm-6">
                                                                                                    {{ $item->guests }}
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
                                        <div class="tab-pane fade" id="pills-vendor" role="tabpanel"
                                            aria-labelledby="pills-profile-tab">
                                            @if($serviceType)
                                                <div class="">
                                                    <div
                                                        class="alert alert-light border border-info d-flex ps-4 pe-4 pt-2 pb-2">
                                                        <div class="col-8 fs-5 m-auto">{{$serviceType->name}}</div>
                                                        <div class="col-2 fs-5 m-auto">
                                                            <h3 class="badge bg-secondary">{{$serviceType->active  == 1 ? 'Active' : 'Inactive'}}</h3>
                                                        </div>
                                                        <div class="col-2 d-flex">
                                                            <button type="button" data-type="delete"
                                                                class="btn btn-danger ms-2 service-type-action"
                                                                data-service_type_id="{{$serviceType->id}}"
                                                                data-company_id="{{$user->company ? $user->company->id : null}}"
                                                                data-bs-toggle="modal"
                                                                data-bs-target="#delete-assign-modal">Delete</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            @else
                                                <div class="row mt-3">
                                                    <div class="col">
                                                        <button data-bs-toggle="modal" data-bs-target="#assign-service-modal"
                                                                class="btn btn-warning text-white text-center w-100" type="button">
                                                            Add Vendor Service
                                                        </button>
                                                    </div>
                                                </div>
                                            @endif
                                        </div>
                                        <div class="tab-pane fade" id="pills-contact" role="tabpanel"
                                            aria-labelledby="pills-contact-tab">

                                            @foreach ($user->notes as $note)
                                                <div class="row mb-3">
                                                    <div class="col">
                                                        <div class="card">
                                                            <div class="card-body ">
                                                                <div class="d-flex justify-content-between">
                                                                    <div class="p-0">

                                                                        @if ($note->createdBy->profile_picture)
                                                                            <img width="35" class="rounded-circle"
                                                                                src="{{ asset($note->createdBy->profile_picture) }}"
                                                                                alt="...." />
                                                                        @else
                                                                            <img width="35" class="rounded-circle"
                                                                                src="https://ui-avatars.com/api/?name={{ $note->createdBy->first_name ? $note->createdBy->first_name : $note->createdBy->email }}"
                                                                                alt="...">
                                                                        @endif
                                                                        <h3>{{ $note->createdBy->first_name ? $note->createdBy->first_name . ' ' . $note->createdBy->last_name : $note->createdBy->email }}
                                                                        </h3>
                                                                    </div>
                                                                    <div class="p-0">

                                                                        <a href="{{ route('notes.destroy-note', ['id' => $note->id]) }}"
                                                                            onclick="return confirm('Are you sure want to delete this note?')">
                                                                            <i class="bi bi-trash"></i>
                                                                        </a>
                                                                    </div>
                                                                </div>
                                                                <div class="row">
                                                                    <div class="col">
                                                                        <h4>{{ $note->subject }}</h4>
                                                                        <p>{{ $note->description }}</p>

                                                                        <small>{{ Carbon\Carbon::parse($note->created_at)->format('d/m/Y H:s a') }}</small>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach

                                            <button type="button" class="btn btn-warning text-white text-center w-100"
                                                data-bs-toggle="modal" data-bs-target="#new-notes-modal">
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

    <div class="modal fade" id="assign-service-modal" tabindex="-1" aria-labelledby="assign-service-modalLabel"
         aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="assign-service-modalLabel">Assign to Service</h5>
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal" aria-label="Close">close
                    </button>
                </div>
                <form method="post" action="{{ route('occasions-services.assign') }}">
                    @csrf
                    <input type="hidden" name="user_id" value="{{ $user->id }}">
                    <div class="modal-body">
                        <div class="row g-3 align-items-center mb-3">
                            <div class="col-auto w-100"  >
                                <select class="form-control selectpicker" name="service_type"  >
                                    @foreach($serviceTypes as $serviceType)
                                        <option value="{{$serviceType->id}}">{{$serviceType->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="d-flex justify-content-between mb-3">
                            <div class="p-2 bd-highlight">
                                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
                            </div>

                            <div class="  p-2 bd-highlight">
                                <button type="submit" class="btn btn-warning">Save</button>
                            </div>
                        </div>
                    </div>
                </form>
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
                <form method="post" action="{{ route('notes.store') }}">
                    @csrf
                    <input type="hidden" name="user_id" value="{{ $user->id }}">
                    <div class="modal-body">
                        <div class="row g-3 align-items-center mb-3">
                            <div class="col-auto" style="width: 29%;">
                                <label for="ticket-modal-title-field" class="col-form-label">
                                    Enter subject
                                </label>
                            </div>
                            <div class="col-auto" style="width: 70%;">
                                <input dir="auto" name="subject" type="text" class="form-control"
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
                                <textarea dir="auto" rows="8" name="description" type="text" class="form-control"
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

    <div class="modal fade" id="delete-service-modal" tabindex="-1" aria-labelledby="delete-service-modalLabel"
         aria-hidden="true">
        <div class="modal-dialog">
            <form action="" method="post">
                @csrf
                <input type="hidden" name="service_id" value="{{ $user->id }}">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="delete-service-modal-title">Service</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="">
                            <i class="fa-sharp fa-light fa-triangle-exclamation"></i> Are you sure to delete this service?
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger">Delete</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <div class="modal fade" id="delete-assign-modal" tabindex="-1" aria-labelledby="delete-assign-modalLabel"
         aria-hidden="true">
        <div class="modal-dialog">
            <form method="post" action="{{route('occasions-services-type.un-assign')}}">
                @csrf
                <input type="hidden" name="user_id" value="{{ $user->id }}">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="delete-assign-modalLabel">Service</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="">
                            <i class="fa-sharp fa-light fa-triangle-exclamation"></i> Are you sure to delete this from its category?
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-danger">Delete</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div class="modal fade" id="edit-service-modal" tabindex="-1" aria-labelledby="edit-service-modalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <form action="" method="post">
                @csrf
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="edit-service-modal-title">Service</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="input-group">
                            <input type="text" class="form-control" placeholder="Service" aria-label="Service" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary">Save</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection

@section('content_javascript')
    <script type="text/javascript">
        $(document).ready(function() {
            $('.selectpicker').selectpicker();
            $('body').on('click', '.view-full-order-btn', function(e) {
                let orderId = $(this).attr('data-order-id');
                $('.info-orders-div').removeClass('d-none');
                $('.table-orders-div').addClass('d-none');
                $('.order-ref-id-' + orderId).removeClass('d-none')
            });
            $('body').on('click', '.close-info-order-btn', function(e) {
                $('.info-orders-div,.order-ref-id').addClass('d-none');
                $('.table-orders-div').removeClass('d-none');
            });

            $('body').on('click', '.action-service', function(e) {
                let actionService = $(this).attr('data-type');
                console.log('actionService', actionService);
            });


            $.fn.dataTable.ext.errMode = 'none';
            let datatable = $('#user-table').DataTable({});
            $('#user-table').on('error.dt', function(e, settings, techNote, message) {
                console.log('An error has been reported by DataTables: ', message);
            })
            $('#search-t').keyup(function() {
                datatable.search($(this).val()).draw();
            })
            $('#user-table_length, .dataTables_paginate, .dataTables_info,.dataTables_filter').remove();
        });
    </script>
@endsection
