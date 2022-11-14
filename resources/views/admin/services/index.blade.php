@extends('layouts.admin')
@section('content')
    <style>
    .checked {
        color: orange;
    }
</style>
    <div class="row">
        <div class="col-sm-12 col-md-6">
            <div class="card mb-2" >
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
                                <button class="btn btn-outline-secondary dropdown-toggle" type="button" id="occasion-filter-dropdown" data-bs-toggle="dropdown" aria-expanded="false">
                                    Occasion type
                                </button>
                                <ul class="dropdown-menu" aria-labelledby="occasion-filter-dropdown">
                                    @if(isset($occasionTypes))
                                        @foreach($occasionTypes as $occasionType)
                                            <li><a class="dropdown-item occasion-filter-dropdown-li" data-id="{{$occasionType['id']}}" href="#">{{$occasionType['name']}}</a></li>
                                        @endforeach
                                    @endif
                                </ul>
                            </div>
                        </div>
                        <div class="p-1 d-none">
                            <div class="dropdown">
                                <button class="btn btn-outline-secondary dropdown-toggle" type="button" id="service-filter-dropdown" data-bs-toggle="dropdown" aria-expanded="false">
                                    Service type
                                </button>
                                <ul class="dropdown-menu" aria-labelledby="service-filter-dropdown">
                                    @if(isset($serviceTypes))
                                        @foreach($serviceTypes as $serviceType)
                                            <li><a class="dropdown-item service-filter-dropdown-li" data-id="{{$serviceType['id']}}" href="#">{{$serviceType['name']}}</a></li>
                                        @endforeach
                                    @endif
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="p2">
                        <hr>
                        <table class="table w-100"  id="myTable">
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
                                    data-id="{{$service->id}}"
                                    data-name="{{$service->name}}"
                                    data-location="{{$service->location}}"
                                    @php $holder = ''; @endphp
                                    @if($service->occasion)
                                        @foreach ($service->occasion as $srv)
                                        @php $holder .= $srv->occasion ? $srv->occasion->name.',' : ''; @endphp
                                        @endforeach
                                    @endif
                                    data-occasion-types="{{$holder}}"
                                    data-service-type="{{$service->serviceType ?  $service->serviceType->name : ''}}"
                                    data-image="{{asset($service->image)}}"
                                    data-rating="{{$service->occasionEventsReviewsAverage && $service->occasionEventsReviewsAverage[0] ? $service->occasionEventsReviewsAverage[0]->aggregate : 0}}"
                                >
                                    <td><img width="100" src="{{asset($service->image)}}"  onerror="this.onerror=null; this.src='{{asset('images/no-image.jpg')}}'"  alt="..."></td>

                                    <td>{{$service->name}}
                                        <p>{{$service->address_1}}</p>
                                        @if($service->occasionEventsReviewsAverage && $service->occasionEventsReviewsAverage[0])
                                            <span class="bi bi-star {{$service->occasionEventsReviewsAverage[0]->aggregate >= 1? 'checked' : ''}} "></span>
                                            <span class="bi bi-star {{$service->occasionEventsReviewsAverage[0]->aggregate >= 2? 'checked' : ''}}"></span>
                                            <span class="bi bi-star {{$service->occasionEventsReviewsAverage[0]->aggregate >= 3? 'checked' : ''}}"></span>
                                            <span class="bi bi-star {{$service->occasionEventsReviewsAverage[0]->aggregate >= 4? 'checked' : ''}}"></span>
                                            <span class="bi bi-star {{$service->occasionEventsReviewsAverage[0]->aggregate >= 5? 'checked' : ''}}"></span>
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
                                                <span class="badge bg-secondary">{{$srv->occasion ? $srv->occasion->name : 'a'}}</span>
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
            <div class="card mb-2" >
                <div class="card-body">
                    <div class="d-flex flex-column bd-highlight mb-3">
                        <div class="p-2 bd-highlight service-title"></div>
                        <div class="p-2 bd-highlight">
                            <img id="image-display-view" width="100" src=""  onerror="this.onerror=null; this.src='{{asset('images/no-image.jpg')}}'"  alt="...">
                        </div>
                        <div class="p-2 bd-highlight">
                            <div class="d-flex flex-row bd-highlight mb-3">
                                <div class="p-2 bd-highlight"><span id="service-no-of-orders">0</span> Orders</div>
                                <div class="p-2 bd-highlight" >
                                    <span class="bi bi-star" id="service-ratings-1"></span>
                                    <span class="bi bi-star" id="service-ratings-2"></span>
                                    <span class="bi bi-star" id="service-ratings-3"></span>
                                    <span class="bi bi-star" id="service-ratings-4"></span>
                                    <span class="bi bi-star" id="service-ratings-5"></span>
                                </div>
                                <div class="p-2 bd-highlight">
                                    <a href="#"> See Reviews</a>
                                </div>
                            </div>
                        </div>
                        <hr>
                    </div>

                    <div class="d-flex flex-column bd-highlight mb-3">
                        <div class="p-2 bd-highlight">Service Type</div>
                        <div class="p-2 bd-highlight service-type"></div>
                    </div>
                    <hr>
                    <div class="d-flex flex-column bd-highlight mb-3">
                        <div class="p-2 bd-highlight">Location</div>
                        <div class="input-group flex-nowrap">
                                    <span class="input-group-text" id="addon-wrapping">
                                        <img class="float-end" src="{{asset('assets/images/icons/location.png')}}"
                                             alt="location">
                                    </span>
                            <div class="p-2 bd-highlight service-location"></div>
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
                        <div class="p-2 bd-highlight service-description"></div>
                    </div>
                    <hr>
                    <div class="d-flex flex-column bd-highlight mb-3">
                        <div class="p-2 bd-highlight">Images</div>
                        <div class="p-2 bd-highlight service-images">

                        </div>
                    </div>
                    <hr>
                    <div class="d-flex flex-column bd-highlight mb-3">
                        <div class="p-2 bd-highlight">Hall features</div>
                        <div class="p-2 bd-highlight ">
                            <div class="d-flex flex-row bd-highlight mb-3">
                                <div class="p-2 bd-highlight"><p>Capacity</p>
                                    <span class="service-hall-features-capacity badge bg-secondary"></span>
                                </div>
                                <div class="p-2 bd-highlight"><p>Available time</p>
                                    <span class="service-hall-features-available-time badge bg-secondary"></span>
                                </div>
                                <div class="p-2 bd-highlight"><p>Available date</p>
                                    <span class="service-hall-features-available-date badge bg-secondary"></span>
                                </div>
                            </div>
                            <span class="service-hall-features-capacity badge bg-secondary"></span>
                        </div>
                    </div>
                    <hr>
                    <div class="d-flex flex-column bd-highlight mb-3">
                        <div class="p-2 bd-highlight">Available payment plans</div>
                        <div class="p-2 bd-highlight ">
                            <div class="d-flex flex-row bd-highlight mb-3">
                                <div class="p-2 bd-highlight"><p>Per person</p>
                                    <span class="service-hall-features-capacity badge bg-secondary"></span>
                                </div>
                            <span class="service-hall-features-capacity badge bg-secondary"></span>
                        </div>
                    </div>
                    <hr>
                    <button class="btn btn-warning" type="button">Edit</button>
                </div>
            </div>
        </div>
    </div>
@endsection


@section('content_javascript')
    <script type="text/javascript">
        $(document).ready( function () {
            $.fn.dataTable.ext.errMode = 'none';
            let datatable = $('#myTable').DataTable({

                "pageLength": 5,
            });
            $('#myTable').on('error.dt', function(e, settings, techNote, message) {
                console.log( 'An error has been reported by DataTables: ', message);
            })
            $('#myTable_length, #myTable_filter').remove();
            $('#search-service-name')


            $(document).on('focus', '#search-service-name', function() {
                $(this).unbind().bind('keyup', function(e) {
                    if(e.keyCode === 13) {
                        datatable.search( this.value ).draw();
                    }
                });
            });
            $('.dataTable').on('click', 'tbody td', function() {
                let name = $(this).closest('tr').attr('data-name');
                let image = $(this).closest('tr').attr('data-image');
                let location = $(this).closest('tr').attr('data-location');
                let occasionTypes = $(this).closest('tr').attr('data-occasion-types');
                let serviceType = $(this).closest('tr').attr('data-service-type');
                let rating = $(this).closest('tr').attr('data-rating');
                switch (rating) {
                    case rating >= 1:
                        $('#service-ratings-1').addClass('checked');
                        break;
                    case rating >= 2:
                        $('#service-ratings-2').addClass('checked');
                        break;
                    case rating >= 3:
                        $('#service-ratings-3').addClass('checked');
                        break;
                    case rating >= 4:
                        $('#service-ratings-4').addClass('checked');
                        break;
                    case rating >= 5:
                        $('#service-ratings-5').addClass('checked');
                        break;
                }
                let oT = occasionTypes.split(',')
                oT.forEach(function (e) {
                    if(e != '') {
                        $( '.service-occasion-types' ).append( ' <span class=" badge bg-secondary">'+e+'</span>' );
                    }
                });
                $('.service-type').text(serviceType)
                $('.service-location').text(location)
                $('.service-title').text(name)
                $('#image-display-view').attr('src',image)

            })
        } );
    </script>
@endsection
