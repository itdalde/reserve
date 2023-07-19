@extends('layouts.admin')
@section('content')
<style>
    .checked {
        color: orange;
    }
</style>
<div class="row">
    <div class="col-sm-12 col-md-6">
        <div class="card mb-2">
            <div class="card-body">
                <div class="">

                    <div class="p-1 w-100">
                        @if(session('message'))
                        <div class="alert alert-success">
                            {{ session('message') }}
                        </div>
                        @endif
                        <h5 class="card-title align-middle m-auto">Services</h5>
                    </div>
                    <div class="p-1 d-none">
                        <div class="d-flex justify-content-between">
                            <div class="separator " style="border-left: 2px solid #ccc;
                                                        width: 1px;
                                                        height: 30px!important;
                                                        margin: auto 0;"></div>
                            <div class="d-flex ps-4">
                                <label class="" style="width: 75px; margin: auto;">Search</label>
                                <input type="text" class="form-control" placeholder="" id="search-service-name"
                                    value="">
                            </div>
                        </div>

                    </div>
                    <div class="d-flex justify-content-between pb-3 pt-3">
                        <div class="w-100">
                            <div class="">
                                <!-- Form -->
                                @if(!Auth::user()->hasRole('superadmin'))
                                <form class="d-flex align-items-center">
                                    <input id="head-general-search" type="search" class="form-control"
                                        placeholder="Search" />
                                </form>
                                @else
                                <span>
                                    <h3>Admin account</h3>
                                </span>
                                @endif
                            </div>
                        </div>

                        <div class="w-100">
                            @if(!Auth::user()->hasRole('superadmin') )
                            <div class="mx-2 d-flex justify-content-center custom-service-header">
                                <a href="{{ route('services.create') }}" class="btn btn-outline-warning">
                                    <img src="{{asset('assets/images/icons/add.png')}}" alt="...">&nbsp;<span
                                        class="btn-add-service" style="margin-left: 12px">Add new service</span>
                                </a>
                            </div>
                            @endif
                        </div>
                    </div>
                    <div class="p-1 d-none">
                        <div class="dropdown">
                            <button class="btn btn-outline-secondary dropdown-toggle" type="button"
                                id="occasion-filter-dropdown" data-bs-toggle="dropdown" aria-expanded="false">
                                Occasion type
                            </button>
                            <ul class="dropdown-menu" aria-labelledby="occasion-filter-dropdown">
                                @if (isset($occasionTypes))
                                @foreach ($occasionTypes as $occasionType)
                                <li><a class="dropdown-item occasion-filter-dropdown-li"
                                        data-id="{{ $occasionType['id'] }}" href="#">{{ $occasionType['name'] }}</a>
                                </li>
                                @endforeach
                                @endif
                            </ul>
                        </div>
                    </div>
                    <div class="p-1 d-none">
                        <div class="dropdown">
                            <button class="btn btn-outline-secondary dropdown-toggle" type="button"
                                id="service-filter-dropdown" data-bs-toggle="dropdown" aria-expanded="false">
                                Service type
                            </button>
                            <ul class="dropdown-menu" aria-labelledby="service-filter-dropdown">
                                @if (isset($serviceTypes))
                                @foreach ($serviceTypes as $serviceType)
                                <li><a class="dropdown-item service-filter-dropdown-li"
                                        data-id="{{ $serviceType['id'] }}" href="#">{{ $serviceType['name'] }}</a></li>
                                @endforeach
                                @endif

                            </ul>
                        </div>
                    </div>
                </div>
                <div class="">
                    <ul class="nav nav-tabs" id="service-tab" role="tablist">
                        <li class="nav-item">
                            <button class="nav-link active" id="published-tab" data-bs-toggle="tab"
                                data-bs-target="#published" type="button" role="tab" aria-controls="published"
                                aria-selected="true">Published</button>
                        </li>
                        <li class="nav-item">
                            <button class="nav-link" id="paused-tab" data-bs-toggle="tab" data-bs-target="#paused"
                                type="button" role="tab" aria-controls="paused" aria-selected="true">Paused</button>
                        </li>
                        <li class="nav-item">
                            <button class="nav-link" id="saved-tab" data-bs-toggle="tab" data-bs-target="#saved"
                                type="button" role="tab" aria-controls="saved" aria-selected="true">Saved</button>
                        </li>
                        <li class="nav-item ">
                            <button class="nav-link" id="deleted-tab" data-bs-toggle="tab" data-bs-target="#deleted"
                                type="button" role="tab" aria-controls="deleted" aria-selected="true">Deleted</button>
                        </li>
                    </ul>
                </div>
                <div class="tab-content" id="myTabContent">
                    {{-- Published --}}
                    <div class="tab-pane fade show active" id="published">
                        <div class="p2">
                            <hr>
                            <table class="table w-100 service-table" id="published-table">
                                <thead>
                                    <tr class="d-none">
                                        <th scope="col">Image</th>
                                        <th scope="col">Name</th>
                                        <th scope="col">Occasion Type</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($services->where('active', 1) as $service)
                                    <tr style="cursor: pointer;" data-table-elem="published"
                                        data-available-slot="{{ $service->availability_slot }}"
                                        data-end-available-date="{{ Carbon\Carbon::parse($service->availability_end_date)->format('Y-m-d') }}"
                                        data-start-available-date="{{ Carbon\Carbon::parse($service->availability_start_date)->format('Y-m-d') }}"
                                        data-end-available-time="{{ Carbon\Carbon::parse($service->availability_time_out)->format('H:m') }}"
                                        data-start-available-time="{{ Carbon\Carbon::parse($service->availability_time_in)->format('H:m') }}"
                                        data-id="{{ $service->id }}" data-description="{{ $service->description }}"
                                        data-name="{{ $service->name }}" data-location="{{ $service->address_1 ?? '' }}"
                                        data-max-capacity="{{ $service->min_capacity }}"
                                        data-min-capacity="{{ $service->max_capacity }}"
                                        data-hall-capacity="{{ $service->min_capacity . ' - ' . $service->max_capacity }}"
                                        data-available-date="{{ Carbon\Carbon::parse($service->availability_start_date)->format('M d') . ' - ' . Carbon\Carbon::parse($service->availability_end_date)->format('M d') }}"
                                        data-available-time="{{ Carbon\Carbon::parse($service->availability_time_in)->format('h:i a') . ' - ' . Carbon\Carbon::parse($service->availability_time_out)->format('h:i a') }}"
                                        @php $occasionHolder='' ; $paymentPlansHolder='' ; $imagesHolder='' ; @endphp
                                        @if ($service->images) @foreach ($service->images as $image)
                                        @php $imagesHolder .= $image->image ? asset($image->image).',' : ''; @endphp
                                        @endforeach @endif
                                        @if ($service->occasion) @foreach ($service->occasion as $srv)
                                        @php $occasionHolder .= $srv->occasion ? $srv->occasion->name.',' : ''; @endphp
                                        @endforeach @endif
                                        @if ($service->occasionEventPrice) @foreach ($service->occasionEventPrice as
                                        $price)
                                        @php $paymentPlansHolder .= $price->planType ? $price->id.'id'.
                                        $price->planType->name.':QAD '.number_format($price->service_price).',' : '';
                                        @endphp
                                        @endforeach @endif
                                        data-payment-plans="{{ $paymentPlansHolder }}"
                                        data-occasion-types="{{ $occasionHolder }}"
                                        data-images="{{ $imagesHolder }}"
                                        data-orders-count="{{ count($service->orders) }}"
                                        data-service-type="{{ $service->serviceType ? $service->serviceType->name : ''
                                        }}"
                                        data-image="{{ asset($service->image) }}"
                                        data-rating="{{ $service->occasionEventsReviewsAverage &&
                                        isset($service->occasionEventsReviewsAverage[0]) ?
                                        $service->occasionEventsReviewsAverage[0]->aggregate : 0 }}"
                                        data-active="{{ $service->active }}"
                                        data-price="{{ $service->price }}"
                                        >
                                        <td width="20%">
                                            <img width="100" height="100" src="{{ asset($service->image) }}"
                                                onerror="this.onerror=null; this.src='{{ asset('images/no-image.jpg') }}'"
                                                alt="..." class="rounded-3" style="object-fit: cover;">
                                        </td>

                                        <td dir="auto" width="60%">
                                            <div class="d-flex justify-content-between">
                                                <div>
                                                    <h3 class="fs-3 fw-bold">{{ $service->name }}</h3>
                                                    <p dir="auto" class="fw-bolder fw-4">{{ $service->address_1 }}</p>
                                                    <div>
                                                        <label class="fw-bold">
                                                            {{ $service->occasionEventsReviewsAverage &&
                                                            isset($service->occasionEventsReviewsAverage[0]) ?
                                                            $service->occasionEventsReviewsAverage[0]->aggregate : 0 }}
                                                        </label>
                                                        @if ($service->occasionEventsReviewsAverage &&
                                                        isset($service->occasionEventsReviewsAverage[0]))
                                                        <span
                                                            class="bi bi-star {{ $service->occasionEventsReviewsAverage[0]->aggregate >= 1 ? 'checked' : '' }} "></span>
                                                        <span
                                                            class="bi bi-star {{ $service->occasionEventsReviewsAverage[0]->aggregate >= 2 ? 'checked' : '' }}"></span>
                                                        <span
                                                            class="bi bi-star {{ $service->occasionEventsReviewsAverage[0]->aggregate >= 3 ? 'checked' : '' }}"></span>
                                                        <span
                                                            class="bi bi-star {{ $service->occasionEventsReviewsAverage[0]->aggregate >= 4 ? 'checked' : '' }}"></span>
                                                        <span
                                                            class="bi bi-star {{ $service->occasionEventsReviewsAverage[0]->aggregate >= 5 ? 'checked' : '' }}"></span>
                                                        @else
                                                        <span class="bi bi-star"></span>
                                                        <span class="bi bi-star"></span>
                                                        <span class="bi bi-star"></span>
                                                        <span class="bi bi-star"></span>
                                                        <span class="bi bi-star"></span>
                                                        @endif
                                                    </div>
                                                </div>
                                                <div class="separator h-100 w-10" style="border-right: 2px solid #ccc;
                                                            width: 47px;
                                                            height: 86px!important;
                                                            margin: auto 0;">

                                                </div>
                                            </div>
                                        </td>
                                        <td width="20%">
                                            <div dir="auto" class="fw-light">Occasion Type</div>
                                            <div class="fs-5 fw-light">
                                                @if ($service->occasion)
                                                @foreach ($service->occasion as $srv)
                                                <span class="badge"
                                                    style="background-color: #d9e9ff; color: #48484A;">{{ $srv->occasion
                                                    ? $srv->occasion->name : '' }}</span>
                                                @endforeach
                                                @endif
                                            </div>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>

                    {{-- Paused --}}
                    <div class="tab-pane fade show" id="paused">
                        <div class="p2">
                            <hr>
                            <table class="table w-100 service-table" id="paused-table">
                                <thead>
                                    <tr class="d-none">
                                        <th scope="col">Image</th>
                                        <th scope="col">Name</th>
                                        <th scope="col">Occasion Type</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($services->where('active', 2) as $service)
                                    <tr style="cursor: pointer;" data-table-elem="paused"
                                        data-available-slot="{{ $service->availability_slot }}"
                                        data-end-available-date="{{ Carbon\Carbon::parse($service->availability_end_date)->format('Y-m-d') }}"
                                        data-start-available-date="{{ Carbon\Carbon::parse($service->availability_start_date)->format('Y-m-d') }}"
                                        data-end-available-time="{{ Carbon\Carbon::parse($service->availability_time_out)->format('H:m') }}"
                                        data-start-available-time="{{ Carbon\Carbon::parse($service->availability_time_in)->format('H:m') }}"
                                        data-id="{{ $service->id }}" data-description="{{ $service->description }}"
                                        data-name="{{ $service->name }}" data-location="{{ $service->address_1 ?? '' }}"
                                        data-max-capacity="{{ $service->min_capacity }}"
                                        data-min-capacity="{{ $service->max_capacity }}"
                                        data-hall-capacity="{{ $service->min_capacity . ' - ' . $service->max_capacity }}"
                                        data-available-date="{{ Carbon\Carbon::parse($service->availability_start_date)->format('M d') . ' - ' . Carbon\Carbon::parse($service->availability_end_date)->format('M d') }}"
                                        data-available-time="{{ Carbon\Carbon::parse($service->availability_time_in)->format('h:i a') . ' - ' . Carbon\Carbon::parse($service->availability_time_out)->format('h:i a') }}"
                                        @php $occasionHolder='' ; $paymentPlansHolder='' ; $imagesHolder='' ; @endphp
                                        @if ($service->images) @foreach ($service->images as $image)
                                        @php $imagesHolder .= $image->image ? asset($image->image).',' : ''; @endphp
                                        @endforeach @endif
                                        @if ($service->occasion) @foreach ($service->occasion as $srv)
                                        @php $occasionHolder .= $srv->occasion ? $srv->occasion->name.',' : ''; @endphp
                                        @endforeach @endif
                                        @if ($service->occasionEventPrice) @foreach ($service->occasionEventPrice as
                                        $price)
                                        @php $paymentPlansHolder .= $price->planType ? $price->id.'id'.
                                        $price->planType->name.':QAD '.number_format($price->service_price).',' : '';
                                        @endphp
                                        @endforeach @endif
                                        data-payment-plans="{{ $paymentPlansHolder }}"
                                        data-occasion-types="{{ $occasionHolder }}"
                                        data-images="{{ $imagesHolder }}"
                                        data-orders-count="{{ count($service->orders) }}"
                                        data-service-type="{{ $service->serviceType ? $service->serviceType->name : ''
                                        }}"
                                        data-image="{{ asset($service->image) }}"
                                        data-rating="{{ $service->occasionEventsReviewsAverage &&
                                        isset($service->occasionEventsReviewsAverage[0]) ?
                                        $service->occasionEventsReviewsAverage[0]->aggregate : 0 }}"
                                        data-active="{{ $service->active }}">
                                        <td width="20%"><img width="100" height="100" src="{{ asset($service->image) }}"
                                                onerror="this.onerror=null; this.src='{{ asset('images/no-image.jpg') }}'"
                                                alt="..." style="border-radius: 5px; object-fit: cover;"></td>

                                        <td dir="auto" width="60%" style="border-right: 1px solid #ccc">
                                            <h3 class="fs-3 fw-bold">{{ $service->name }}</h3>
                                            <p dir="auto">{{ $service->address_1 }}</p>
                                            <div>
                                                <label class="fw-bold">
                                                    {{ $service->occasionEventsReviewsAverage &&
                                                    isset($service->occasionEventsReviewsAverage[0]) ?
                                                    $service->occasionEventsReviewsAverage[0]->aggregate : 0 }}
                                                </label>
                                                @if ($service->occasionEventsReviewsAverage &&
                                                isset($service->occasionEventsReviewsAverage[0]))
                                                <span
                                                    class="bi bi-star {{ $service->occasionEventsReviewsAverage[0]->aggregate >= 1 ? 'checked' : '' }} "></span>
                                                <span
                                                    class="bi bi-star {{ $service->occasionEventsReviewsAverage[0]->aggregate >= 2 ? 'checked' : '' }}"></span>
                                                <span
                                                    class="bi bi-star {{ $service->occasionEventsReviewsAverage[0]->aggregate >= 3 ? 'checked' : '' }}"></span>
                                                <span
                                                    class="bi bi-star {{ $service->occasionEventsReviewsAverage[0]->aggregate >= 4 ? 'checked' : '' }}"></span>
                                                <span
                                                    class="bi bi-star {{ $service->occasionEventsReviewsAverage[0]->aggregate >= 5 ? 'checked' : '' }}"></span>
                                                @else
                                                <span class="bi bi-star"></span>
                                                <span class="bi bi-star"></span>
                                                <span class="bi bi-star"></span>
                                                <span class="bi bi-star"></span>
                                                <span class="bi bi-star"></span>
                                                @endif
                                            </div>

                                        </td>
                                        <td width="20%">
                                            <div dir="auto" class="fw-light">Occasion Type</div>
                                            <div class="fs-5 fw-light">
                                                @if ($service->occasion)
                                                @foreach ($service->occasion as $srv)
                                                <span class="badge"
                                                    style="background-color: #d9e9ff; color: #48484A;">{{ $srv->occasion
                                                    ? $srv->occasion->name : '' }}</span>
                                                @endforeach
                                                @endif
                                            </div>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>

                    {{-- Saved --}}
                    <div class="tab-pane fade show" id="saved">
                        <div class="p2">
                            <hr>
                            <table class="table w-100 service-table" id="saved-table">
                                <thead>
                                    <tr class="d-none">
                                        <th scope="col">Image</th>
                                        <th scope="col">Name</th>
                                        <th scope="col">Occasion Type</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($services->where('active', 3) as $service)
                                    <tr style="cursor: pointer;" data-table-elem="saved"
                                        data-available-slot="{{ $service->availability_slot }}"
                                        data-end-available-date="{{ Carbon\Carbon::parse($service->availability_end_date)->format('Y-m-d') }}"
                                        data-start-available-date="{{ Carbon\Carbon::parse($service->availability_start_date)->format('Y-m-d') }}"
                                        data-end-available-time="{{ Carbon\Carbon::parse($service->availability_time_out)->format('H:m') }}"
                                        data-start-available-time="{{ Carbon\Carbon::parse($service->availability_time_in)->format('H:m') }}"
                                        data-id="{{ $service->id }}" data-description="{{ $service->description }}"
                                        data-name="{{ $service->name }}" data-location="{{ $service->address_1 ?? '' }}"
                                        data-max-capacity="{{ $service->min_capacity }}"
                                        data-min-capacity="{{ $service->max_capacity }}"
                                        data-hall-capacity="{{ $service->min_capacity . ' - ' . $service->max_capacity }}"
                                        data-available-date="{{ Carbon\Carbon::parse($service->availability_start_date)->format('M d') . ' - ' . Carbon\Carbon::parse($service->availability_end_date)->format('M d') }}"
                                        data-available-time="{{ Carbon\Carbon::parse($service->availability_time_in)->format('h:i a') . ' - ' . Carbon\Carbon::parse($service->availability_time_out)->format('h:i a') }}"
                                        @php $occasionHolder='' ; $paymentPlansHolder='' ; $imagesHolder='' ; @endphp
                                        @if ($service->images) @foreach ($service->images as $image)
                                        @php $imagesHolder .= $image->image ? asset($image->image).',' : ''; @endphp
                                        @endforeach @endif
                                        @if ($service->occasion) @foreach ($service->occasion as $srv)
                                        @php $occasionHolder .= $srv->occasion ? $srv->occasion->name.',' : ''; @endphp
                                        @endforeach @endif
                                        @if ($service->occasionEventPrice) @foreach ($service->occasionEventPrice as
                                        $price)
                                        @php $paymentPlansHolder .= $price->planType ? $price->id.'id'.
                                        $price->planType->name.':QAD '.number_format($price->service_price).',' : '';
                                        @endphp
                                        @endforeach @endif
                                        data-payment-plans="{{ $paymentPlansHolder }}"
                                        data-occasion-types="{{ $occasionHolder }}"
                                        data-images="{{ $imagesHolder }}"
                                        data-orders-count="{{ count($service->orders) }}"
                                        data-service-type="{{ $service->serviceType ? $service->serviceType->name : ''
                                        }}"
                                        data-image="{{ asset($service->image) }}"
                                        data-rating="{{ $service->occasionEventsReviewsAverage &&
                                        isset($service->occasionEventsReviewsAverage[0]) ?
                                        $service->occasionEventsReviewsAverage[0]->aggregate : 0 }}"
                                        data-active="{{ $service->active }}">
                                        <td width="20%"><img width="100" height="100" src="{{ asset($service->image) }}"
                                                onerror="this.onerror=null; this.src='{{ asset('images/no-image.jpg') }}'"
                                                alt="..." style="border-radius: 5px; object-fit: cover;"></td>

                                        <td dir="auto" width="60%" style="border-right: 1px solid #ccc">
                                            <h3 class="fs-3 fw-bold">{{ $service->name }}</h3>
                                            <p dir="auto">{{ $service->address_1 }}</p>
                                            <div>
                                                <label class="fw-bold">
                                                    {{ $service->occasionEventsReviewsAverage &&
                                                    isset($service->occasionEventsReviewsAverage[0]) ?
                                                    $service->occasionEventsReviewsAverage[0]->aggregate : 0 }}
                                                </label>
                                                @if ($service->occasionEventsReviewsAverage &&
                                                isset($service->occasionEventsReviewsAverage[0]))
                                                <span
                                                    class="bi bi-star {{ $service->occasionEventsReviewsAverage[0]->aggregate >= 1 ? 'checked' : '' }} "></span>
                                                <span
                                                    class="bi bi-star {{ $service->occasionEventsReviewsAverage[0]->aggregate >= 2 ? 'checked' : '' }}"></span>
                                                <span
                                                    class="bi bi-star {{ $service->occasionEventsReviewsAverage[0]->aggregate >= 3 ? 'checked' : '' }}"></span>
                                                <span
                                                    class="bi bi-star {{ $service->occasionEventsReviewsAverage[0]->aggregate >= 4 ? 'checked' : '' }}"></span>
                                                <span
                                                    class="bi bi-star {{ $service->occasionEventsReviewsAverage[0]->aggregate >= 5 ? 'checked' : '' }}"></span>
                                                @else
                                                <span class="bi bi-star"></span>
                                                <span class="bi bi-star"></span>
                                                <span class="bi bi-star"></span>
                                                <span class="bi bi-star"></span>
                                                <span class="bi bi-star"></span>
                                                @endif
                                            </div>

                                        </td>
                                        <td width="20%">
                                            <div dir="auto" class="fw-light">Occasion Type</div>
                                            <div class="fs-5 fw-light">
                                                @if ($service->occasion)
                                                @foreach ($service->occasion as $srv)
                                                <span class="badge"
                                                    style="background-color: #d9e9ff; color: #48484A;">{{ $srv->occasion
                                                    ? $srv->occasion->name : '' }}</span>
                                                @endforeach
                                                @endif
                                            </div>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="tab-pane fade show" id="deleted">
                        <div class="p2">
                            <hr>
                            <table class="table w-100 service-table" id="deleted-table">
                                <thead>
                                    <tr class="d-none">
                                        <th scope="col">Image</th>
                                        <th scope="col">Name</th>
                                        <th scope="col">Occasion Type</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($services->where('active', 0) as $service)
                                    <tr style="cursor: pointer;" data-table-elem="deleted"
                                        data-available-slot="{{ $service->availability_slot }}"
                                        data-end-available-date="{{ Carbon\Carbon::parse($service->availability_end_date)->format('Y-m-d') }}"
                                        data-start-available-date="{{ Carbon\Carbon::parse($service->availability_start_date)->format('Y-m-d') }}"
                                        data-end-available-time="{{ Carbon\Carbon::parse($service->availability_time_out)->format('H:m') }}"
                                        data-start-available-time="{{ Carbon\Carbon::parse($service->availability_time_in)->format('H:m') }}"
                                        data-id="{{ $service->id }}" data-description="{{ $service->description }}"
                                        data-name="{{ $service->name }}" data-location="{{ $service->address_1 ?? '' }}"
                                        data-max-capacity="{{ $service->min_capacity }}"
                                        data-min-capacity="{{ $service->max_capacity }}"
                                        data-hall-capacity="{{ $service->min_capacity . ' - ' . $service->max_capacity }}"
                                        data-available-date="{{ Carbon\Carbon::parse($service->availability_start_date)->format('M d') . ' - ' . Carbon\Carbon::parse($service->availability_end_date)->format('M d') }}"
                                        data-available-time="{{ Carbon\Carbon::parse($service->availability_time_in)->format('h:i a') . ' - ' . Carbon\Carbon::parse($service->availability_time_out)->format('h:i a') }}"
                                        @php $occasionHolder='' ; $paymentPlansHolder='' ; $imagesHolder='' ; @endphp
                                        @if ($service->images) @foreach ($service->images as $image)
                                        @php $imagesHolder .= $image->image ? asset($image->image).',' : ''; @endphp
                                        @endforeach @endif
                                        @if ($service->occasion) @foreach ($service->occasion as $srv)
                                        @php $occasionHolder .= $srv->occasion ? $srv->occasion->name.',' : ''; @endphp
                                        @endforeach @endif
                                        @if ($service->occasionEventPrice) @foreach ($service->occasionEventPrice as
                                        $price)
                                        @php $paymentPlansHolder .= $price->planType ? $price->id.'id'.
                                        $price->planType->name.':QAD '.number_format($price->service_price).',' : '';
                                        @endphp
                                        @endforeach @endif
                                        data-payment-plans="{{ $paymentPlansHolder }}"
                                        data-occasion-types="{{ $occasionHolder }}"
                                        data-images="{{ $imagesHolder }}"
                                        data-orders-count="{{ count($service->orders) }}"
                                        data-service-type="{{ $service->serviceType ? $service->serviceType->name : ''
                                        }}"
                                        data-image="{{ asset($service->image) }}"
                                        data-rating="{{ $service->occasionEventsReviewsAverage &&
                                        isset($service->occasionEventsReviewsAverage[0]) ?
                                        $service->occasionEventsReviewsAverage[0]->aggregate : 0 }}"
                                        data-active="{{ $service->active }}">
                                        <td width="20%"><img width="100" height="100" src="{{ asset($service->image) }}"
                                                onerror="this.onerror=null; this.src='{{ asset('images/no-image.jpg') }}'"
                                                alt="..." style="border-radius: 5px; object-fit: cover;"></td>

                                        <td dir="auto" width="60%" style="border-right: 1px solid #ccc">
                                            <h3 class="fs-3 fw-bold">{{ $service->name }}</h3>
                                            <p dir="auto">{{ $service->address_1 }}</p>
                                            <div>
                                                <label class="fw-bold">
                                                    {{ $service->occasionEventsReviewsAverage &&
                                                    isset($service->occasionEventsReviewsAverage[0]) ?
                                                    $service->occasionEventsReviewsAverage[0]->aggregate : 0 }}
                                                </label>
                                                @if ($service->occasionEventsReviewsAverage &&
                                                isset($service->occasionEventsReviewsAverage[0]))
                                                <span
                                                    class="bi bi-star {{ $service->occasionEventsReviewsAverage[0]->aggregate >= 1 ? 'checked' : '' }} "></span>
                                                <span
                                                    class="bi bi-star {{ $service->occasionEventsReviewsAverage[0]->aggregate >= 2 ? 'checked' : '' }}"></span>
                                                <span
                                                    class="bi bi-star {{ $service->occasionEventsReviewsAverage[0]->aggregate >= 3 ? 'checked' : '' }}"></span>
                                                <span
                                                    class="bi bi-star {{ $service->occasionEventsReviewsAverage[0]->aggregate >= 4 ? 'checked' : '' }}"></span>
                                                <span
                                                    class="bi bi-star {{ $service->occasionEventsReviewsAverage[0]->aggregate >= 5 ? 'checked' : '' }}"></span>
                                                @else
                                                <span class="bi bi-star"></span>
                                                <span class="bi bi-star"></span>
                                                <span class="bi bi-star"></span>
                                                <span class="bi bi-star"></span>
                                                <span class="bi bi-star"></span>
                                                @endif
                                            </div>

                                        </td>
                                        <td width="20%">
                                            <div dir="auto" class="fw-light">Occasion Type</div>
                                            <div class="fs-5 fw-light">
                                                @if ($service->occasion)
                                                @foreach ($service->occasion as $srv)
                                                <span class="badge"
                                                    style="background-color: #d9e9ff; color: #48484A;">{{ $srv->occasion
                                                    ? $srv->occasion->name : '' }}</span>
                                                @endforeach
                                                @endif
                                            </div>
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
    </div>
    <div class="col-sm-12 col-md-6 ">
        @if (count($services) > 0)
        <div class="card mb-2">
            <div class="card-body">
                <form action="{{ route('services.update_service') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="d-flex flex-column bd-highlight mb-3">
                        <div class="d-flex justify-content-between service-action">

                        </div>


                        <div class="p-2 bd-highlight ">
                            <h2 class="service-title edit-trigger-display"></h2>
                            <input dir="auto" name="service_name" id="edit-service-title-input"
                                class="form-control edit-trigger-show d-none" placeholder="Service Name" type="text">
                        </div>
                        <div class="p-2 bd-highlight">

                            <a href="#" class="edit-featured-service-image-holder edit-trigger-show d-none">
                                <img width="100" id="edit-featured-service-image-view"
                                    src="{{ asset('assets/images/icons/image-select.png') }}" alt="image-select">
                            </a>

                            <input
                                onchange="document.getElementById('edit-featured-service-image-view').src = window.URL.createObjectURL(this.files[0])"
                                id="edit-featured-service-image-file" accept="image/png, image/gif, image/jpeg"
                                type="file" class="d-none" name="featured_image">
                            <img class="edit-trigger-display rounded rounded-3" id="image-display-view" width="200"
                                height="200" src=""
                                onerror="this.onerror=null; this.src='{{ asset('images/no-image.jpg') }}'" alt="..."
                                style="object-fit: cover;">
                        </div>
                        <div class="p-2 bd-highlight">
                            <div class="d-flex flex-row bd-highlight mb-3">
                                <div class="p-2 bd-highlight border rounded-2 fw-bold fs-4"
                                    style="background-color: #d3d3d3;">
                                    <span id="service-no-of-orders">0</span> Orders
                                </div>
                                <div class="p-2 bd-highlight">
                                    <label class="fw-bolder fs-4 rating-total">0</label>
                                    <span class="bi bi-star" id="service-ratings-1"></span>
                                    <span class="bi bi-star" id="service-ratings-2"></span>
                                    <span class="bi bi-star" id="service-ratings-3"></span>
                                    <span class="bi bi-star" id="service-ratings-4"></span>
                                    <span class="bi bi-star" id="service-ratings-5"></span>
                                </div>
                                <div class="p-2 bd-highlight" style="height: 100%; margin: auto 0;">
                                    <a href="#" class="see-reviews-link text-decoration-underline"> See Reviews</a>
                                    <input type="hidden" name="id" id="service-id">
                                    <a href="#" class="show-order-details-link d-none"> Show order
                                        details</a>
                                </div>
                            </div>
                        </div>
                        <hr>
                    </div>
                    <div class="review-holder d-none">

                        <div class="d-flex bd-highlight mb-3">
                            <div class="p-2 bd-highlight">
                                <h4>Reviews</h4>
                            </div>
                            <div class="ms-auto p-2 bd-highlight">
                                <div class="dropdown">
                                    <button class="btn btn-warning dropdown-toggle" type="button" id="review-filter-btn"
                                        data-bs-toggle="dropdown" aria-expanded="false">
                                        Filter By
                                    </button>
                                    <ul class="dropdown-menu" aria-labelledby="review-filter-btn">
                                        <li><a class="dropdown-item review-filter-list" data-sort="ASC" href="#">Highest
                                                first</a></li>
                                        <li><a class="dropdown-item review-filter-list" data-sort="DESC" href="#">Lowest
                                                first</a></li>
                                    </ul>
                                </div>
                            </div>

                        </div>
                        <hr>
                        <div class="d-flex flex-column bd-highlight mb-3">
                            <div class="p-2 bd-highlight">
                                <table class="table w-100" id="services-reviews-table">
                                    <thead>
                                        <tr class="d-none">
                                            <th scope="col">Review</th>
                                        </tr>
                                    </thead>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="preview-holder">
                        <div class="d-flex flex-column bd-highlight mb-3">
                            <div class="p-2 bd-highlight">Service Type</div>
                            <div class="p-2 bd-highlight ">
                                <span type="text" readonly
                                    class="form-control-plaintext service-type badge bg-secondary w-25"></span>
                            </div>
                        </div>
                        <div class="d-flex flex-column bd-highlight mb-3 d-none">
                            <div class="p-2 bd-highlight">Location</div>
                            <div class="d-inline-flex">
                                <img class="img-fluid mt-2 me-2" style="width: 15px;
                                        height: 100%;
                                        top: 13px;" src="{{ asset('assets/images/icons/location.png') }}"
                                    alt="location">
                                <span dir="auto" type="text" readonly
                                    class="form-control-plaintext sp-2 bd-highlight service-location edit-trigger-display"></span>
                                <input dir="auto" name="service_location" id="edit-service-location-input"
                                    class="form-control edit-trigger-show d-none" placeholder="Service Location"
                                    type="text">
                            </div>
                        </div>
                        <div class="d-flex flex-column bd-highlight mb-3 d-none">
                            <div class="p-2 bd-highlight">Occasion Type</div>
                            <div class="p-2 bd-highlight ">
                                <div class="d-flex flex-row bd-highlight mb-3">
                                    <div class="p-2 bd-highlight service-occasion-types">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <hr>
                        <div class="d-flex flex-column bd-highlight mb-3">
                            <div class="p-2 bd-highlight">Description</div>
                            <span dir="auto" class="p-2 bd-highlight service-description edit-trigger-display"></span>

                            <div class="mb-3 row edit-trigger-show d-none">
                                <div class="col-sm-12 ">
                                    <div class="form-floating">
                                        <textarea dir="auto" name="service_description" class="form-control"
                                            placeholder="Description" id="edit-service-description-input"
                                            style="height: 100px"></textarea>
                                        <label for="edit-service-description-input">Enter Service
                                            description</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <hr>
                        <div class="d-flex flex-column bd-highlight mb-3">
                            <div class="p-2 bd-highlight">Images</div>
                            <div class="p-2 bd-highlight">
                                <div class="container">
                                    <div class="row service-images">
                                    </div>
                                    <button type="button" id="add-images-data-btn"
                                        class="edit-trigger-show btn btn-orange d-none"><img
                                            src="{{ asset('assets/images/icons/add.png') }}" alt="add.png"> Add
                                    </button>

                                    <input name="images[]" id="add-images-data-file" type="file" multiple="multiple"
                                        class="d-none">
                                </div>
                            </div>
                        </div>
                        <hr>
                        <div class="d-flex flex-column bd-highlight mb-3">
                            <div class="p-2 bd-highlight">Details</div>
                            <div class="p-2 bd-highlight edit-trigger-display">
                                <div class="d-flex flex-row bd-highlight mb-3">
                                    <div class="p-2 bd-highlight">
                                        <p>Capacity</p>
                                        <div class="badge bg-secondary d-inline-flex">
                                            <img src="{{ asset('assets/images/icons/capacity.png') }}" alt="..">
                                            <span
                                                class="service-hall-features-capacity badge bg-secondary  px-2 mt-1"></span>
                                        </div>
                                    </div>
                                    <div class="p-2 bd-highlight d-none">
                                        <p>Available time</p>
                                        <div class="badge bg-secondary d-inline-flex">
                                            <img src="{{ asset('assets/images/icons/clock.png') }}" alt="..">
                                            <span
                                                class="service-hall-features-available-time badge bg-secondary  px-2 mt-1"></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="d-flex flex-column bd-highlight mb-3 d-none">
                                <div class="p-2 bd-highlight">Availability</div>
                                <div class="p-2 bd-highlight edit-trigger-display">
                                    <div class="p-2 w-100">
                                        <p>Available date</p>
                                    </div>
                                    <div class="d-flex flex-row bd-highlight mb-3">
                                        <div class="p-2 bd-highlight available-date">

                                        </div>
                                    </div>
                                </div>
                                <div class="p-2 bd-highlight edit-trigger-display">
                                    <div class="p-2 w-100">
                                        <p>Un-Available date</p>
                                    </div>
                                    <div class="d-flex flex-row bd-highlight mb-3">
                                        <div class="p-2 bd-highlight un-available-date">

                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="p-2 bd-highlight d-none  edit-trigger-show ">

                                <div class="col-sm-10">
                                    <div class="mb-3">
                                        <label class="form-label">Allowed Guests</label>
                                        <div class="d-flex flex-row bd-highlight mb-3">
                                            <div class="bd-highlight w-50">
                                                <input id="edit-service-min-capacity-input" min="0" value="0"
                                                    placeholder="Minimum" name="min_capacity"
                                                    class="float-end form-control" type="number">
                                            </div>
                                            <div class="bd-highlight w-15">
                                                <hr>
                                            </div>
                                            <div class="bd-highlight w-50">
                                                <input id="edit-service-max-capacity-input" min="0" value="0"
                                                    placeholder="Maximum" name="max_capacity"
                                                    class="float-start form-control" type="number">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="d-flex flex-row bd-highlight mb-3 d-none">
                                        <div class="col-sm-12 pe-2 ">
                                            <div class="row">
                                                <div class="col-sm-6 ">
                                                    <label class="form-label">Available Start time</label>
                                                    <input id="edit-service-start_available_time-input" value=""
                                                        name="start_available_time"
                                                        class="float-end form-control datepicker-time" type="text">
                                                </div>
                                                <div class="col-sm-6 ">
                                                    <label class="form-label">Available End time</label>
                                                    <input id="edit-service-end_available_time-input" value=""
                                                        name="end_available_time"
                                                        class="float-end form-control  datepicker-time" type="text">
                                                </div>
                                                <div class="col-sm-6 ">
                                                    <label class="form-label">Available Date</label>
                                                    <input id="edit-service-start_available_date-input" value=""
                                                        name="available_date" class="float-end form-control datepicker"
                                                        type="text">
                                                </div>
                                                <div class="col-sm-6 ">
                                                    <label class="form-label">Un-Available Date</label>
                                                    <input value="" id="edit-service-end_available_date-input"
                                                        name="un_available_date"
                                                        class="float-start form-control datepicker" type="text">
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="d-flex flex-row bd-highlight mb-3 d-none">
                                        <div class="col-sm-12 ">
                                            <label class="form-label">Available Slot</label>
                                            <div class="bd-highlight">
                                                <input id="edit-service-available_slot-input" value="0"
                                                    name="available_slot" class=" form-control" type="number">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <hr>
                        <div class="d-flex flex-column bd-highlight mb-3">
                            <div class="p-2 bd-highlight">Price</div>
                            <div class="p-2 bd-highlight ">
                                <div class="d-flex flex-row bd-highlight mb-3 service-price">
                                </div>
                            </div>
                        </div>
                        <hr>
                        <div class="d-flex flex-column bd-highlight mb-3">
                            <div class="p-2 bd-highlight">Pricing Type</div>
                            <div class="p-2 bd-highlight ">
                                <div class="d-flex flex-row bd-highlight mb-3 service-available-payment-plans">
                                </div>
                            </div>
                        </div>
                        <hr>
                        <div class="d-flex">
                            <div class="mr-auto p-2 w-100">
                                <button class="btn btn-warning edit-trigger-display" id="edit-service-btn"
                                    type="button">Edit
                                </button>
                                <button class="btn  d-none edit-trigger-show" id="edit-service-cancel-btn"
                                    type="button">Cancel
                                </button>
                            </div>
                            <div class="p-2">
                                <button class="btn btn-warning d-none edit-trigger-show" type="submit">Save
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        @endif
    </div>
</div>
@endsection


@section('content_javascript')
<script type="text/javascript">
    $(document).ready(function () {

        $('body').on('click', '.edit-featured-service-image-holder', function () {
            $('#edit-featured-service-image-file').click();
        });
        $('body').on('change', '#add-images-data-file', function () {
            $('.new-added-mg-temp').remove();
            for (let i = 0; i < this.files.length; ++i) {
                let filereader = new FileReader();
                let $img = jQuery.parseHTML(
                    "<img class='new-added-mg-temp figure-img img-fluid img-thumbnail image-gallery' src=''>"
                );
                filereader.onload = function () {
                    $img[0].src = this.result;
                };
                filereader.readAsDataURL(this.files[i]);
                $(".service-images").append($img);
            }

        });
        $('body').on('click', '#edit-service-btn', function () {
            $('.edit-trigger-show').removeClass('d-none');
            $('.edit-trigger-display').addClass('d-none');
        });
        $('body').on('click', '#edit-service-cancel-btn', function () {
            $('.edit-trigger-show').addClass('d-none');
            $('.edit-trigger-display').removeClass('d-none');
        });

        $('body').on('click', '#add-images-data-btn', function () {
            $('#add-images-data-file').click();
        });
        $('body').on('click', '.see-reviews-link', function () {
            $('.preview-holder, .see-reviews-link').addClass('d-none');
            $('.review-holder, .show-order-details-link ').removeClass('d-none');
            generateReviewList();
        });
        $('body').on('click', '.show-order-details-link', function () {
            previewElement()
        });

        function previewElement() {
            $('.preview-holder, .see-reviews-link').removeClass('d-none');
            $('.review-holder, .show-order-details-link ').addClass('d-none')
        }

        $('body').on('click', '.review-filter-list', function () {
            let sort = $(this).attr('data-sort');
            generateReviewList(sort)
        });
        $('#new-service-modal').on('hidden.bs.modal', function () {
            generateReviewList();
        })

        $('body').on('click', '#resume-service-action', function () {
            let id = $(this).attr('data-service_id');
            $('#resume-service-modal #service_id').val(id);
        });
        $('body').on('click', '#publish-service-action', function () {
            let id = $(this).attr('data-service_id');
            $('#publish-service-modal #service_id').val(id);
        });

        $('body').on('click', '#pause-service-action', function () {
            let id = $(this).attr('data-service_id');
            $('#pause-service-modal #service_id').val(id);
        });
        $('body').on('click', '#delete-service-action', function () {
            let id = $(this).attr('data-service_id');
            $('#delete-service-modal #service_id').val(id);
        });
        $('body').on('click', '#activate-service-action', function () {
            let id = $(this).attr('data-service_id');
            $('#activate-service-modal #service_id').val(id);
        });

        function generateReviewList(sort = 'DESC') {
            $.ajax({
                url: "{{ route('services-reviews') }}",
                method: "GET",
                data: {
                    occasion_event_id: $("#service-id").val(),
                    sort: sort
                },
                beforeSend: function () {
                    $('#db-wrapper').addClass('blur-bg');
                    $('#loader').show();
                    $(".review-holder").css("opacity", "0.1");
                },
            }).done(function (response) {
                $('#db-wrapper').removeClass('blur-bg');
                $('#loader').hide();
                $('.review-holder').css("opacity", "1");
                let data = JSON.parse(response);
                $('#services-reviews-table').DataTable({
                    "aaData": data,
                    "ordering": false,
                    "columns": [{
                        "data": "rate",
                        className: 'cust-cell-font',
                        "bSortable": false
                    },],
                    processing: true,
                    destroy: true,
                })
                $('.dataTables_filter, .dataTables_length').addClass("d-none");
            })

        }

        $.fn.dataTable.ext.errMode = 'none';
        let datatable = $('.service-table').DataTable({
            "pageLength": 10,
        });
        $('.service-table').on('error.dt', function (e, settings, techNote, message) {
            console.log('An error has been reported by DataTables: ', message);
        })
        $('.dataTables_length, .dataTables_filter').remove();


        $(document).on('focus', '#search-service-name', function () {
            $(this).unbind().bind('keyup', function (e) {
                if (e.keyCode === 13) {
                    datatable.search(this.value).draw();
                }
            });
        });

        $('body').on('click', '.close-service-images', function () {
            let that = this;
            $.ajax({
                url: "{{ route('services-remove-image') }}",
                method: "POST",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: {
                    occasion_event_id: $("#service-id").val(),
                    image_url: $(that).closest('div').find('input').val()
                },
                beforeSend: function () {
                    window.VIEW_LOADING();
                },
            }).done(function (response) {
                window.HIDE_LOADING();
                $(that).closest('.col-sm-3').remove();
                datatable.search("").draw();
            })
        });
        @if (Request:: get('search'))
    datatable.search("{{ Request::get('search') }}").draw();
    @endif
    $('#db-wrapper').addClass('blur-bg');
    $('#loader').show();
    setTimeout(function () {
        $('#db-wrapper').removeClass('blur-bg');
        $('#loader').hide();
        if ($('#published-table > tbody > tr:nth-child(1) > td:nth-child(2)').length) {
            $('#published-tab').click();
            $('#published-table > tbody > tr:nth-child(1) > td:nth-child(2)').click();
            return;
        }
        if ($('#paused-table > tbody > tr:nth-child(1) > td:nth-child(2)').length) {
            $('#paused-tab').click();
            $('#paused-table > tbody > tr:nth-child(1) > td:nth-child(2)').click();
            return;
        }
        if ($('#saved-table > tbody > tr:nth-child(1) > td:nth-child(2)').length) {
            $('#saved-tab').click();
            $('#saved-table > tbody > tr:nth-child(1) > td:nth-child(2)').click();
            return;
        }
    }, 2000);
    $('.dataTable').on('click', 'tbody td', function () {
        previewElement()
        if ($(this).closest('tr').attr('data-table-elem') == 'deleted') {
            $('#edit-service-btn').addClass('d-none')
            $('#edit-service-cancel-btn').addClass('d-none')
        }
        let name = $(this).closest('tr').attr('data-name');
        let image = $(this).closest('tr').attr('data-image');
        let location = $(this).closest('tr').attr('data-location');
        let occasionTypes = $(this).closest('tr').attr('data-occasion-types');
        let serviceType = $(this).closest('tr').attr('data-service-type');
        let rating = +$(this).closest('tr').attr('data-rating');
        let description = $(this).closest('tr').attr('data-description');
        let images = $(this).closest('tr').attr('data-images');
        let hallCapacity = $(this).closest('tr').attr('data-hall-capacity');
        let availableTime = $(this).closest('tr').attr('data-available-time');
        let availableDate = $(this).closest('tr').attr('data-available-date');
        let maxCapacity = $(this).closest('tr').attr('data-max-capacity');
        let minCapacity = $(this).closest('tr').attr('data-min-capacity');
        let availableSlot = $(this).closest('tr').attr('data-available-slot');
        let endAvailableTime = $(this).closest('tr').attr('data-end-available-time');
        let startAvailableTime = $(this).closest('tr').attr('data-start-available-time');
        let totalOrders = $(this).closest('tr').attr('data-orders-count');
        let serviceStatus = $(this).closest('tr').attr('data-active')
        let servicePrice = +$(this).closest('tr').attr('data-price');
        $('#service-no-of-orders').text(totalOrders)
        let id = $(this).closest('tr').attr('data-id');
        $.ajax({
            url: "{{ route('fetch-available-dates-per-service') }}",
            method: "GET",
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: {
                service_id: id,
            },
            beforeSend: function () {
                window.VIEW_LOADING();
            },
        }).done(function (response) {
            window.HIDE_LOADING();

            let data = JSON.parse(response);
            console.log('data', data);
            let availablehtml = "";
            let unavailablehtml = "";
            let availableDates = [];
            let unavailableDates = [];
            for (let x = 0; x < data.length; x++) {
                if (data[x].status == '1') {
                    availableDates.push(data[x].date);
                    availablehtml +=
                        '<div class="badge bg-secondary d-inline-flex"> <img src="{{ asset('assets / images / icons / calendar - icon.png') }}" alt="..">';
                    availablehtml +=
                        '<span class="service-hall-features-available-date  px-2 mt-1">' +
                        data[x].date + '</span> </div>';
                } else {
                    unavailableDates.push(data[x].date);
                    unavailablehtml +=
                        '<div class="badge bg-secondary d-inline-flex"> <img src="{{ asset('assets / images / icons / calendar - icon.png') }}" alt="..">';
                    unavailablehtml +=
                        '<span class="service-hall-features-available-date  px-2 mt-1">' +
                        data[x].date + '</span> </div>';
                }
            }
            $('#edit-service-end_available_date-input').datepicker("setDate",
                unavailableDates);
            $('#edit-service-start_available_date-input').datepicker("setDate",
                availableDates);
            $('.available-date').html(availablehtml)
            $('.un-available-date').html(unavailablehtml)
        })
        let paymentPlans = $(this).closest('tr').attr('data-payment-plans');
        $("#service-id").val(id);
        paymentPlans = paymentPlans.split(',')
        $('.appended-payment-plans').remove();
        paymentPlans.forEach(function (e) {
            if (e != '') {
                let plan = e.split(':')
                let planType = plan[0].split('id')
                let symbol = plan[1].split(' ')
                $('.service-available-payment-plans').append(
                    '<div class="appended-payment-plans p-2 bd-highlight"><p>' +
                    planType[1] + '</p>' +
                    '<span class=" badge bg-secondary "><span class="edit-trigger-display">' +
                    symbol[1] +
                    '</span><span class="edit-trigger-show d-none"><input type="number" class=" form-control" name="price[][' +
                    planType[0] + ']" value="' + symbol[1] + '"/></span></span>' +
                    '</div>');
            }
        });

        $('#edit-service-available_slot-input').val(availableSlot);
        $('#edit-service-start_available_time-input').val(startAvailableTime);
        $('#edit-service-end_available_time-input').val(endAvailableTime);
        $('#edit-service-min-capacity-input').val(minCapacity);
        $('#edit-service-max-capacity-input').val(maxCapacity);
        $('#edit-service-location-input').val(location);
        $('#edit-service-title-input').val(name);
        $('#edit-service-description-input').val(description);
        $('.service-hall-features-capacity').text(hallCapacity)
        $('.service-hall-features-available-time').text(availableTime)
        $('.service-hall-features-available-date').text(availableDate)
        $('.rating-total').text(rating.toFixed(1))
        $('.service-price').text(`QAR ${servicePrice.toFixed(2)}`);
        $('#service-ratings-1, #service-ratings-2, #service-ratings-3, #service-ratings-4, #service-ratings-5')
            .removeClass('checked');
        if (rating >= 1) {
            $('#service-ratings-1').addClass('checked');
        }
        if (rating >= 2) {
            $('#service-ratings-2').addClass('checked')
        }
        if (rating >= 3) {
            $('#service-ratings-3').addClass('checked');
        }
        if (rating >= 4) {
            $('#service-ratings-4').addClass('checked');
        }
        if (rating >= 5) {
            $('#service-ratings-5').addClass('checked');
        }
        let oT = occasionTypes.split(',')
        let eventImages = images.split(',')
        $('.appended-data').remove();
        oT.forEach(function (e) {
            if (e != '') {
                $('.service-occasion-types').append(
                    ' <span class="appended-data badge bg-secondary">' + e + '</span>');
            }
        });
        $('.appended-images-data').remove();
        eventImages.forEach(function (e) {
            if (e != '') {
                $('.service-images').append(
                    '<div class="col-sm-3 appended-images-data"> <div class="thumbnail"><input type="hidden" value="' +
                    e +
                    '"><button class="close-service-images edit-trigger-show d-none" type="button">×</button><img class="img-fluid" style=" width: 158px;" src="' +
                    e + '" alt="e"></div></div>');
            }
        });

        $('.service-description').text(description)
        $('.service-type').text(serviceType)
        $('.service-location').text(location)
        $('.service-title').text(name)
        $('#image-display-view, #edit-featured-service-image-view').attr('src', image)
        $('#paused-service-action').attr('data-id', serviceStatus);

        if (serviceStatus == '1') {

            $('.added-elem').remove();
            $('.service-action').append('<div class="added-elem">'
                + '<i class="bi bi-info-circle icon-info"'
                + 'data-bs-toggle="tooltip" data-bs-placement="bottom"'
                + 'title="Please pause this service to access the edit option"'
                + '>'
                + '</i>'
                + '</div>'
                + '<div class="added-elem" style="margin: auto 0;">'
                + '<button type="button" class="btn btn-sm btn-warning text-white px-5" data-service_id="' + id + '" data-id="2" id="pause-service-action" data-bs-toggle="modal" data-bs-target="#pause-service-modal">Pause</button>'
                + '<button type="button" class="btn btn-sm btn-danger text-white px-5 ms-2 delete-service-btn" data-service_id="' + id + '" id="delete-service-action" data-bs-toggle="modal" data-bs-target="#delete-service-modal">Delete</button>'
                + '</div>');
        }

        if (serviceStatus == '2') {
            $('.added-elem').remove();
            $('.service-action').append('<div class="added-elem">'
                + '<p class="bg-warning text-white px-4">This service has been paused</p>'
                + '</div>'
                + '<div class="added-elem" style="margin: auto 0;">'
                + '<button type="button" class="btn btn-sm btn-success text-white px-5" data-service_id="' + id + '" data-id="1" id="resume-service-action" data-bs-toggle="modal" data-bs-target="#resume-service-modal">Resume</button>'
                + '<button type="button" class="btn btn-sm btn-danger text-white px-5 ms-2 delete-service-btn" data-service_id="' + id + '"  id="delete-service-action" data-bs-toggle="modal" data-bs-target="#delete-service-modal">Delete</button>'
                + '</div>');
        }

        if (serviceStatus == '3') {
            $('.added-elem').remove();
            $('.service-action').append('<div class="added-elem">'
                + '<p class="bg-warning text-white px-4">This service is not yet published</p>'
                + '</div>'
                + '<div class="added-elem" style="margin: auto 0;">'
                + '<button type="button" class="btn btn-sm btn-success text-white px-5" data-service_id="' + id + '" data-id="1" id="publish-service-action" data-bs-toggle="modal" data-bs-target="#publish-service-modal">Publish</button>'
                + '<button type="button" class="btn btn-sm btn-danger text-white px-5 ms-2 delete-service-btn" data-service_id="' + id + '" id="delete-service-action" data-bs-toggle="modal" data-bs-target="#delete-service-modal" >Delete</button>'
                + '</div>');
        }
        if (serviceStatus == '0') {
            $('.added-elem').remove();
            $('.service-action').append('<div class="added-elem">'
                + '<p class="bg-warning text-white px-4">This service is deactivated</p>'
                + '</div>'
                + '<div class="added-elem" style="margin: auto 0;">'
                + '<button type="button" class="btn btn-sm btn-success text-white px-5" data-service_id="' + id + '" data-id="1" id="activate-service-action" data-bs-toggle="modal" data-bs-target="#activate-service-modal">Activate</button>'
                + '</div>');
        }
    })
        });
</script>
@endsection