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
                            <p>Sort by</p>
                        </div>
                        <div class="p-1 ">
                            <div class="dropdown">
                                <button class="btn btn-outline-secondary dropdown-toggle" type="button" id="occasion-filter-dropdown" data-bs-toggle="dropdown" aria-expanded="false">
                                    Occasion type
                                </button>
                                <ul class="dropdown-menu" aria-labelledby="occasion-filter-dropdown">
                                    <li><a class="dropdown-item" href="#">Meds</a></li>
                                </ul>
                            </div>
                        </div>
                        <div class="p-1">
                            <div class="dropdown">
                                <button class="btn btn-outline-secondary dropdown-toggle" type="button" id="service-filter-dropdown" data-bs-toggle="dropdown" aria-expanded="false">
                                    Service type
                                </button>
                                <ul class="dropdown-menu" aria-labelledby="service-filter-dropdown">
                                    <li><a class="dropdown-item" href="#">Food Service</a></li>
                                </ul>
                            </div>
                        </div>
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

