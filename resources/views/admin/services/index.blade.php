@extends('layouts.admin')
@section('content')
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
                                <tr>
                                    <td><img width="100" src="{{asset($service->image)}}"  onerror="this.onerror=null; this.src='{{asset('images/no-image.jpg')}}'"  alt="..."></td>

                                    <td>{{$service->name}}
                                        <p>{{$service->address_1}}</p>
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
                </div>
            </div>
        </div>
    </div>
@endsection


@section('content_javascript')
    <script>
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

        } );
    </script>
@endsection
