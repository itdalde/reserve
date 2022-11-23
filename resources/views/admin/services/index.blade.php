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
                    <div class="d-flex justify-content-center">

                        <div class="p-1 w-25">
                            <h5 class="card-title">Services</h5>
                        </div>
                        <div class="p-1 w-15">
                        </div>
                        <div class="p-1 ">
                            <input type="text" class="form-control" placeholder="Search..."
                                   id="search-service-name" value="">
                        </div>
                        <div class="p-1 d-none">
                            <div class="dropdown">
                                <button class="btn btn-outline-secondary dropdown-toggle" type="button"
                                        id="occasion-filter-dropdown" data-bs-toggle="dropdown" aria-expanded="false">
                                    Occasion type
                                </button>
                                <ul class="dropdown-menu" aria-labelledby="occasion-filter-dropdown">
                                    @if(isset($occasionTypes))
                                        @foreach($occasionTypes as $occasionType)
                                            <li><a class="dropdown-item occasion-filter-dropdown-li"
                                                   data-id="{{$occasionType['id']}}"
                                                   href="#">{{$occasionType['name']}}</a></li>
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
                                    @if(isset($serviceTypes))
                                        @foreach($serviceTypes as $serviceType)
                                            <li><a class="dropdown-item service-filter-dropdown-li"
                                                   data-id="{{$serviceType['id']}}"
                                                   href="#">{{$serviceType['name']}}</a></li>
                                        @endforeach
                                    @endif
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="p2">
                        <hr>
                        <table class="table w-100" id="myTable">
                            <thead>
                            <tr class="d-none">
                                <th scope="col">Image</th>
                                <th scope="col">Name</th>
                                <th scope="col">Occasion Type</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($services as $service)
                                <tr style="cursor: pointer;"
                                    data-available-slot="{{$service->availability_slot}}"
                                    data-end-available-date="{{Carbon\Carbon::parse($service->availability_end_date)->format('Y-m-d')}}"
                                    data-start-available-date="{{Carbon\Carbon::parse($service->availability_start_date)->format('Y-m-d')}}"
                                    data-id="{{$service->id}}"
                                    data-description="{{$service->description}}"
                                    data-name="{{$service->name}}"
                                    data-location="{{$service->address_1 ?? ''}}"
                                    data-max-capacity="{{$service->min_capacity}}"
                                    data-min-capacity="{{$service->max_capacity}}"
                                    data-hall-capacity="{{$service->min_capacity .' - '. $service->max_capacity}}"
                                    data-available-date="{{ Carbon\Carbon::parse($service->availability_start_date)->format('M d').' - '. Carbon\Carbon::parse($service->availability_end_date)->format('M d')}}"
                                    data-available-time="{{Carbon\Carbon::parse($service->availability_time_in)->format('h:i a').' - '. Carbon\Carbon::parse($service->availability_time_out)->format('h:i a')}}"
                                    @php $occasionHolder = '';
                                        $paymentPlansHolder= '';
                                        $imagesHolder = ''; @endphp
                                    @if($service->images)
                                    @foreach ($service->images as $image)
                                    @php $imagesHolder .= $image->image ? asset($image->image).',' : ''; @endphp
                                    @endforeach
                                    @endif
                                    @if($service->occasion)
                                    @foreach ($service->occasion as $srv)
                                    @php $occasionHolder .= $srv->occasion ? $srv->occasion->name.',' : ''; @endphp
                                    @endforeach
                                    @endif
                                    @if($service->occasionEventPrice)
                                    @foreach ($service->occasionEventPrice as $price)
                                    @php $paymentPlansHolder .= $price->planType ? $price->planType->name.':$'.number_format($price->service_price).',' : ''; @endphp
                                    @endforeach
                                    @endif
                                    data-payment-plans="{{$paymentPlansHolder}}"
                                    data-occasion-types="{{$occasionHolder}}"
                                    data-images="{{$imagesHolder}}"
                                    data-service-type="{{$service->serviceType ?  $service->serviceType->name : ''}}"
                                    data-image="{{asset($service->image)}}"
                                    data-rating="{{$service->occasionEventsReviewsAverage && isset($service->occasionEventsReviewsAverage[0]) ? $service->occasionEventsReviewsAverage[0]->aggregate : 0}}"
                                >
                                    <td><img width="100" src="{{asset($service->image)}}"
                                             onerror="this.onerror=null; this.src='{{asset('images/no-image.jpg')}}'"
                                             alt="..."></td>

                                    <td>{{$service->name}}
                                        <p>{{$service->address_1}}</p>
                                        @if($service->occasionEventsReviewsAverage && isset($service->occasionEventsReviewsAverage[0]))
                                            <span
                                                class="bi bi-star {{$service->occasionEventsReviewsAverage[0]->aggregate >= 1? 'checked' : ''}} "></span>
                                            <span
                                                class="bi bi-star {{$service->occasionEventsReviewsAverage[0]->aggregate >= 2? 'checked' : ''}}"></span>
                                            <span
                                                class="bi bi-star {{$service->occasionEventsReviewsAverage[0]->aggregate >= 3? 'checked' : ''}}"></span>
                                            <span
                                                class="bi bi-star {{$service->occasionEventsReviewsAverage[0]->aggregate >= 4? 'checked' : ''}}"></span>
                                            <span
                                                class="bi bi-star {{$service->occasionEventsReviewsAverage[0]->aggregate >= 5? 'checked' : ''}}"></span>
                                        @else
                                            <span class="bi bi-star"></span>
                                            <span class="bi bi-star"></span>
                                            <span class="bi bi-star"></span>
                                            <span class="bi bi-star"></span>
                                            <span class="bi bi-star"></span>
                                        @endif
                                    </td>
                                    <td><small>Occasion Type</small><br>
                                        @if($service->occasion)
                                            @foreach ($service->occasion as $srv)
                                                <span
                                                    class="badge bg-secondary">{{$srv->occasion ? $srv->occasion->name : ''}}</span>
                                            @endforeach
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-12 col-md-6">
            <div class="card mb-2">
                <div class="card-body">
                    <form action="{{route('services.update_service')}}" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="d-flex flex-column bd-highlight mb-3">
                            <div class="p-2 bd-highlight "><h2 class="service-title edit-trigger-display"></h2>
                                <input dir="auto" name="service_name" id="edit-service-title-input"
                                       class="form-control edit-trigger-show d-none" placeholder="Service Name" type="text"></div>
                            <div class="p-2 bd-highlight">

                                <a href="#" class="edit-featured-service-image-holder edit-trigger-show d-none">
                                    <img width="100" id="edit-featured-service-image-view"
                                         src="{{asset('assets/images/icons/image-select.png')}}" alt="image-select">
                                </a>

                                <input
                                    onchange="document.getElementById('edit-featured-service-image-view').src = window.URL.createObjectURL(this.files[0])"
                                    id="edit-featured-service-image-file" accept="image/png, image/gif, image/jpeg" type="file"
                                    class="d-none" name="featured_image" >
                                <img class="edit-trigger-display" id="image-display-view" width="100" src=""
                                     onerror="this.onerror=null; this.src='{{asset('images/no-image.jpg')}}'" alt="...">
                            </div>
                            <div class="p-2 bd-highlight">
                                <div class="d-flex flex-row bd-highlight mb-3">
                                    <div class="p-2 bd-highlight"><span id="service-no-of-orders">0</span> Orders</div>
                                    <div class="p-2 bd-highlight">
                                        <span class="bi bi-star" id="service-ratings-1"></span>
                                        <span class="bi bi-star" id="service-ratings-2"></span>
                                        <span class="bi bi-star" id="service-ratings-3"></span>
                                        <span class="bi bi-star" id="service-ratings-4"></span>
                                        <span class="bi bi-star" id="service-ratings-5"></span>
                                    </div>
                                    <div class="p-2 bd-highlight">
                                        <a href="#" class="see-reviews-link"> See Reviews</a>
                                        <input type="hidden" name="id" id="service-id">
                                        <a href="#" class="show-order-details-link d-none"> Show order details</a>
                                    </div>
                                </div>
                            </div>
                            <hr>
                        </div>
                        <div class="review-holder d-none">

                            <div class="d-flex bd-highlight mb-3">
                                <div class="p-2 bd-highlight"><h4>Reviews</h4></div>
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
                            <hr>
                            <div class="d-flex flex-column bd-highlight mb-3">
                                <div class="p-2 bd-highlight">Location</div>
                                <div class="d-inline-flex">
                                    <img class="img-fluid mt-2 me-2" style="width: 15px;
                                        height: 100%;
                                        top: 13px;" src="{{asset('assets/images/icons/location.png')}}" alt="location">
                                    <span type="text" readonly
                                          class="form-control-plaintext sp-2 bd-highlight service-location edit-trigger-display"></span>
                                    <input dir="auto" name="service_location" id="edit-service-location-input"
                                           class="form-control edit-trigger-show d-none" placeholder="Service Location" type="text">
                                </div>
                            </div>
                            <hr>
                            <div class="d-flex flex-column bd-highlight mb-3">
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
                                <span class="p-2 bd-highlight service-description edit-trigger-display"></span>

                                <div class="mb-3 row edit-trigger-show d-none">
                                    <div class="col-sm-12 ">
                                        <div class="form-floating">
                                        <textarea dir="auto" name="service_description" class="form-control" placeholder="Description"
                                                  id="edit-service-description-input" style="height: 100px"></textarea>
                                            <label for="edit-service-description-input">Enter Service description</label>
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
                                                src="{{asset('assets/images/icons/add.png')}}" alt="add.png"> Add
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
                                        <div class="p-2 bd-highlight"><p>Capacity</p>
                                            <div class="badge bg-secondary d-inline-flex">
                                                <img src="{{asset('assets/images/icons/capacity.png')}}" alt="..">
                                                <span
                                                    class="service-hall-features-capacity badge bg-secondary  px-2 mt-1"></span>
                                            </div>
                                        </div>
                                        <div class="p-2 bd-highlight"><p>Available time</p>
                                            <div class="badge bg-secondary d-inline-flex">
                                                <img src="{{asset('assets/images/icons/clock.png')}}" alt="..">
                                                <span
                                                    class="service-hall-features-available-time badge bg-secondary  px-2 mt-1"></span>
                                            </div>
                                        </div>
                                        <div class="p-2 bd-highlight"><p>Available date</p>
                                            <div class="badge bg-secondary d-inline-flex">
                                                <img src="{{asset('assets/images/icons/calendar-icon.png')}}" alt="..">
                                                <span class="service-hall-features-available-date  px-2 mt-1"></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="p-2 bd-highlight d-none  edit-trigger-show ">

                                    <div class="col-sm-10">
                                        <div class="mb-3">
                                            <label class="form-label">Capacity</label>
                                            <div class="d-flex flex-row bd-highlight mb-3">
                                                <div class="bd-highlight w-50">
                                                    <input id="edit-service-min-capacity-input" min="0" value="0" placeholder="Minimum" name="min_capacity"
                                                           class="float-end form-control" type="number">
                                                </div>
                                                <div class="bd-highlight w-15">
                                                    <hr>
                                                </div>
                                                <div class="bd-highlight w-50">
                                                    <input id="edit-service-max-capacity-input" min="0" value="0" placeholder="Maximum" name="max_capacity"
                                                           class="float-start form-control" type="number">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="d-flex flex-row bd-highlight mb-3">
                                            <div class="col-sm-12 pe-2 ">
                                                <div class="row">
                                                    <label class="form-label">Available Date</label>
                                                    <div class="col-sm-6 ">
                                                        <input id="edit-service-start_available_date-input" value=""
                                                               name="start_available_date" class="float-end form-control"
                                                               type="date">
                                                    </div>
                                                    <div class="col-sm-6 ">
                                                        <input value=""
                                                               id="edit-service-end_available_date-input"
                                                               name="end_available_date" class="float-start form-control"
                                                               type="date">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="d-flex flex-row bd-highlight mb-3">
                                            <div class="col-sm-12 ">
                                                <label class="form-label">Available Slot</label>
                                                <div class="bd-highlight">
                                                    <input id="edit-service-available_slot-input" value="0" name="available_slot" class=" form-control"
                                                           type="number">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <hr>
                            <div class="d-flex flex-column bd-highlight mb-3">
                                <div class="p-2 bd-highlight">Available payment plans</div>
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
                                    <button class="btn btn-warning d-none edit-trigger-show"
                                            type="submit">Save
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
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
                for(let i=0;i<this.files.length;++i){
                    let filereader = new FileReader();
                    let $img=jQuery.parseHTML("<img class='new-added-mg-temp figure-img img-fluid img-thumbnail image-gallery' src=''>");
                    filereader.onload = function(){
                        $img[0].src=this.result;
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

            function generateReviewList(sort = 'DESC') {
                $.ajax({
                    url: "{{route('services-reviews')}}",
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
                        "columns": [
                            {"data": "rate", className: 'cust-cell-font', "bSortable": false},
                        ],
                        processing: true,
                        destroy: true,
                    })
                    $('.dataTables_filter, .dataTables_length').addClass("d-none");
                })

            }

            $.fn.dataTable.ext.errMode = 'none';
            let datatable = $('#myTable').DataTable({
                "pageLength": 10,
            });
            $('#myTable').on('error.dt', function (e, settings, techNote, message) {
                console.log('An error has been reported by DataTables: ', message);
            })
            $('#myTable_length, #myTable_filter').remove();


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
                    url: "{{route('services-remove-image')}}",
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
            @if(Request::get('search'))
            datatable.search("{{Request::get('search')}}").draw();
            @endif
            $('#db-wrapper').addClass('blur-bg');
            $('#loader').show();
            setTimeout(function () {
                $('#db-wrapper').removeClass('blur-bg');
                $('#loader').hide();
                $('#myTable > tbody > tr:nth-child(1) > td:nth-child(2)').click();
            }, 2000);
            $('.dataTable').on('click', 'tbody td', function () {
                previewElement()
                let name = $(this).closest('tr').attr('data-name');
                let image = $(this).closest('tr').attr('data-image');
                let location = $(this).closest('tr').attr('data-location');
                let occasionTypes = $(this).closest('tr').attr('data-occasion-types');
                let serviceType = $(this).closest('tr').attr('data-service-type');
                let rating = $(this).closest('tr').attr('data-rating');
                let description = $(this).closest('tr').attr('data-description');
                let images = $(this).closest('tr').attr('data-images');
                let hallCapacity = $(this).closest('tr').attr('data-hall-capacity');
                let availableTime = $(this).closest('tr').attr('data-available-time');
                let availableDate = $(this).closest('tr').attr('data-available-date');
                let maxCapacity = $(this).closest('tr').attr('data-max-capacity');
                let minCapacity = $(this).closest('tr').attr('data-min-capacity');
                let availableSlot = $(this).closest('tr').attr('data-available-slot');
                let endAvailableDate = $(this).closest('tr').attr('data-end-available-date');
                let startAvailableDate = $(this).closest('tr').attr('data-start-available-date');

                let id = $(this).closest('tr').attr('data-id');
                let paymentPlans = $(this).closest('tr').attr('data-payment-plans');
                $("#service-id").val(id);
                paymentPlans = paymentPlans.split(',')
                $('.appended-payment-plans').remove();
                paymentPlans.forEach(function (e) {
                    if (e != '') {
                        let plan = e.split(':')
                        $('.service-available-payment-plans').append('<div class="appended-payment-plans p-2 bd-highlight"><p>' + plan[0] + '</p>' +
                            '<span class=" badge bg-secondary">' + plan[1] + '</span>' +
                            '</div>');
                    }
                });

                $('#edit-service-available_slot-input').val(availableSlot);
                $('#edit-service-end_available_date-input').val(endAvailableDate);
                $('#edit-service-start_available_date-input').val(startAvailableDate);
                $('#edit-service-min-capacity-input').val(minCapacity);
                $('#edit-service-max-capacity-input').val(maxCapacity);
                $('#edit-service-location-input').val(location);
                $('#edit-service-title-input').val(name);
                $('#edit-service-description-input').val(description);
                $('.service-hall-features-capacity').text(hallCapacity)
                $('.service-hall-features-available-time').text(availableTime)
                $('.service-hall-features-available-date').text(availableDate)

                $('#service-ratings-1, #service-ratings-2, #service-ratings-3, #service-ratings-4, #service-ratings-5').removeClass('checked');
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
                        $('.service-occasion-types').append(' <span class="appended-data badge bg-secondary">' + e + '</span>');
                    }
                });
                $('.appended-images-data').remove();
                eventImages.forEach(function (e) {
                    if (e != '') {
                        $('.service-images').append('<div class="col-sm-3 appended-images-data"> <div class="thumbnail"><input type="hidden" value="' + e + '"><button class="close-service-images edit-trigger-show d-none" type="button">×</button><img class="img-fluid" style=" width: 158px;" src="' + e + '" alt="e"></div></div>');
                    }
                });

                $('.service-description').text(description)
                $('.service-type').text(serviceType)
                $('.service-location').text(location)
                $('.service-title').text(name)
                $('#image-display-view, #edit-featured-service-image-view').attr('src', image)


            })
        });
    </script>
@endsection



