@extends('layouts.admin')

@section('content')
<div class="row pb-5 create-new-service-page">


    <div class="col-sm-12 col-md-12">
        <div class="card mb-2 pb-3">
            <div class="card-body">
                <!-- Card Title -->
                @if(session('message'))
                <div class="alert alert-success">
                    {{ session('message') }}
                </div>
                @endif
                <h5 class="card-title page-title label-color">Create a new service </h5>
            </div>

            <form action="{{ route('services.store') }}" method="post" enctype="multipart/form-data" id="create-service"
                style="margin-top: -20px;">
                @csrf
                <div class="container">
                    <div class="row">
                        <div class="mb-3">
                            <label for="service_name" class="form-label field-label label-color">Service Name</label>
                            <input type="text" class="form-control" name="service_name" id="service-name"
                                placeholder="Service name" required>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="mb-3">
                            <label for="cover-image" class="form-label field-label label-color">Cover Image
                                &nbsp;&nbsp;<span class="text-danger">*</span></label>
                            <div class="d-flex justify-content-between flex-wrap">
                                <a href="#" class="service-image-holder rounded-3">
                                    <img width="180" id="service-image-view"
                                        src="{{ asset('assets/images/icons/image-select.png') }}" alt="image-select"
                                        style="border-radius: 10px;">
                                </a>
                            </div>
                            <input
                                onchange="document.getElementById('service-image-view').src = window.URL.createObjectURL(this.files[0])"
                                id="service-image-file" accept="image/png, image/gif, image/jpeg" type="file"
                                class="d-none" name="featured_image" required>

                            <div class="service-image-error alert alert-danger d-none mt-2" role="alert">
                                Please add image first
                            </div>
                        </div>
                    </div>
                    @if(Auth::user()->hasRole('superadmin') )
                    <hr>
                    <div class="row">
                        <div class="mb-3 col-3">
                            <label for="service-type" class="form-label field-label label-color">Service
                                Type&nbsp;&nbsp;<span class="text-danger">*</span></label>
                            <select class="form-select" name="service_type" aria-label="service-type">
                                <option selected disabled>Select Service Type</option>
                                <option value="1">Service 1</option>
                                <option value="2">Service 2</option>
                                <option value="3">Service 3</option>
                            </select>
                            <!-- <input type="hidden" name="service_type"
                    value="{{ Auth::user() && Auth::user()->company && Auth::user()->company->service_type_id ? Auth::user()->company->service_type_id : 1 }}">
                  <input type="text" class="form-control" readonly
                    value="{{ Auth::user() && Auth::user()->company && Auth::user()->company->serviceType ? Auth::user()->company->serviceType->name : 'Service' }}"> -->
                        </div>
                    </div>
                    @endif
                    <hr>
                    <div class="row">
                        <div class="mb-3">
                            <label for="description"
                                class="form-label field-label label-color">Description&nbsp;&nbsp;<span
                                    class="text-danger">*</span></label>
                            <textarea dir="auto" name="service_description" class="form-control"
                                placeholder="Description" id="floatingTextarea2" style="height: 100px" required></textarea>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="mb-3">
                            <label for="service-images" class="form-label field-label label-color">Service
                                Images&nbsp;&nbsp;<span class="text-danger">*</span></label>
                            <div class="d-flex">
                                <div class="d-flex justify-content-between flex-wrap">
                                    <a href="#" class="service-image-holder">
                                        <img width="80" id="service-image-view"
                                            src="{{ asset('assets/images/icons/image-select.png') }}"
                                            alt="image-select">
                                    </a>
                                </div>

                                <!-- <div class="d-flex justify-content-between service-image-gallery-holder  flex-wrap"></div>
                    <input id="service-image-gallery-file" accept="image/png, image/gif, image/jpeg" type="file" class=""
                      name="images[]" multiple> -->

                                <button type="button" id="" class="btn btn-orange action-button"><img
                                        src="{{ asset('assets/images/icons/add.png') }}" alt="add.png"> Add
                                </button>
                            </div>
                        </div>

                    </div>
                    <hr>
                    <div class="pt-4">
                        <h5 class="page-title label-color">Available packages and payment plans</h5>
                        <div class="row pt-4">
                            <label for="pricing-type" class="form-label field-label label-color">Pricing
                                Type&nbsp;&nbsp;<span class="text-danger">*</span></label>
                            <div class="mb-3">
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input pricing_type" name="pricing_type" type="checkbox"
                                        id="per_guest" value="per_guest">
                                    <label class="form-check-label" for="per_guest">Per Guest</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input pricing_type" name="pricing_type" type="checkbox"
                                        id="per_package" value="per_package">
                                    <label class="form-check-label" for="per_package">Per Package</label>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <label for="description" class="form-label field-label label-color">How
                                much?&nbsp;&nbsp;<span class="text-danger">*</span></label>
                            <div class="col-3">
                                <div class="d-flex">
                                    <div class="input-group mb-3">
                                        <span class="input-group-text" id="price">QAR</span>
                                        <input type="number" name="service_price" class="form-control mr-4"
                                            placeholder="Price" aria-label="price" aria-describedby="price">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <label for="description" class="form-label field-label label-color">Is the service timed?
                                If yes, how
                                long?</label>
                            <div class="row col-5">
                                <div class="d-flex">
                                    <div>
                                        <div class="input-group mb-3 mr-3">
                                            <span class="input-group-text" id="price">Hours</span>
                                            <input type="number" class="form-control price_per_hour"
                                                name="price_per_hour" placeholder="Hours" aria-label="hours"
                                                aria-describedby="hours" value="24">
                                        </div>
                                        <span class="badge-hour">Maximum of 24</span>
                                    </div>
                                    &nbsp;&nbsp;
                                    <div class="form-check form-check-inline w-100 pl-5 mt-2">
                                        <div class="">
                                            <input class="form-check-input" type="checkbox" id="price-not-applicable" name="price_not_applicable"
                                                value="not-applicable">
                                            <label class="form-check-label" for="price-not-applicable">Not
                                                Applicable</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-2">
                                <div class="mb-3">
                                    <label for="minimum-guest" class="form-label">Minimum guests</label>
                                    <input type="number" min="0" value="" class="form-control guests_field float-end"
                                        id="minimum-guest" name="min_capacity" placeholder="0.00">
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="mb-3">
                                    <label for="maximum-guests" class="form-label">Maximum guests</label>
                                    <input type="number" min="0" value="" class="form-control guests_field float-start"
                                        id="maximum-guests" name="max_capacity" placeholder="0.00">
                                </div>
                            </div>
                            <div class="form-check form-check-inline" style="margin-left: 16px;">
                                <input class="form-check-input" type="checkbox" id="allowed_guests" name="not_allowed_guests"
                                    value="not-applicable">
                                <label class="form-check-label" for="allowed_guests">Not Applicable</label>
                            </div>
                        </div>

                        <!-- Features -->
                        <div class="row mt-2">
                            <label for="feature" class="form-label label-color field-label">Features</label>
                            <div class="col-5 mb-3" id="feature-fields">
                                <div class="d-flex mb-2 form-field">
                                    <input class="form-control" type="text" id="feature" name="feature[]" placeholder="Enter service features" value="">
                                    <button type="button" id="add-feature-data-btn" class="btn btn-orange action-button" style="width: 30%;">
                                        <img src="{{ asset('assets/images/icons/add.png') }}" alt="add-feature" />&nbsp;Add
                                    </button>
                                </div>
                            </div>
                        </div>

                          <!-- Conditions -->
                          <div class="row mt-2">
                            <label for="condition" class="form-label label-color field-label">Conditions</label>
                            <div class="col-5 mb-3" id="condition-fields">
                                <div class="d-flex mb-2 form-field">
                                    <input class="form-control form-control-sm" type="text" name="condition[]" id="condition"  placeholder="Enter service conditions" value="">
                                    <button type="button" id="add-condition-data-btn" class="btn btn-orange action-button" style="width: 30%;">
                                        <img src="{{ asset('assets/images/icons/add.png') }}" alt="add-condition" />&nbsp;Add
                                    </button>
                                </div>
                            </div>
                        </div>

                        <div class="row mb-3 mt-2 d-none">
                            <div class="col-md-12">
                                <div class="">
                                    <label for="minimum-guest" class="form-label field-label label-color">Do you want
                                        to accept special
                                        requests?</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input special_request" type="checkbox"
                                        name="special_request_yes" id="special_request_yes" value="yes">
                                    <label class="form-check-label" for="special_request_yes">Yes</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input special_request" type="checkbox"
                                        name="special_request_no" id="special_request_no" value="no">
                                    <label class="form-check-label" for="special_request_no">No</label>
                                </div>
                            </div>
                        </div>
                        <hr>
                        <!-- Add On Fields -->
                        <div class="add-on-name add-on-div cloneable d-none">
                            <div class="row">
                                <div class="mb-3">
                                    <label for="location-name" class="form-label field-label label-color">What is the
                                        title of the
                                        addon?</label>
                                    <input dir="auto" type="text" class="form-control add_on_name border border-danger"
                                        name="add_on_name[]" placeholder="Add-on name">
                                </div>
                            </div>
                            <div class="row">
                                <label for="description" class="form-label field-label label-color">What is the price
                                    of the
                                    add-on?</label>
                                <div class="col-3">
                                    <div class="input-group mb-3">
                                        <span class="input-group-text" id="price">QAR</span>
                                        <input type="number" placeholder="0" class="form-control" required
                                            name="add_on_price[]" min="0" value="0" step="0.01" title="Amount"
                                            pattern="^\d+(?:\.\d{1,2})?$">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="d-flex bd-highlight mb-3 remove-btn-div d-none">
                                    <div class="p-2 bd-highlight w-75">
                                        <hr>
                                    </div>
                                    <div class="ms-auto p-2 bd-highlight">
                                        <button type="button" class="btn btn-orange remove-addon-data-btn"><img
                                                src="{{ asset('assets/images/icons/remove-circle.png') }}"
                                                alt="remove-circle.png">&nbsp;
                                            &nbsp;Remove
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row mb-3 mt-2">
                            <div class="d-flex flex-row">
                                <div class="d-flex flex-row bd-highlight">
                                    <button type="button" id="add-addon-data-btn"
                                        class="btn btn-orange action-button"><img
                                            src="{{ asset('assets/images/icons/add.png') }}" alt="add.png"> Add
                                        Add-on
                                    </button>
                                </div>
                            </div>
                        </div>


                        <div class="row">
                            <div class="d-flex justify-content-between">
                                <button type="button" class="btn btn-outline-secondary">Save for Later</button>
                                <button type="submit" class="btn btn-warning text-white">Publish</button>
                            </div>
                        </div>

                    </div>
                    <!--./End Available packages and payment plan -->
                </div>
            </form>

        </div>
    </div>
</div>
@endsection

@section('content_javascript')
<script type="text/javascript">
    $(document).ready(function () {

        $('.pricing_type').on('click', function () {
            var checkboxes = $('.pricing_type');
            checkboxes.not(this).prop('checked', false);
        });

        $('.special_request').on('click', function () {
            var checkboxes = $('.special_request');
            checkboxes.not(this).prop('checked', false);
        });

        $('#price-not-applicable').on('click', function () {
            var field = $('.price_per_hour');
            field.prop('disabled', !field.prop('disabled'));
        })

        $('#allowed_guests').on('click', function () {
            var field = $('.guests_field');
            field.prop('disabled', !field.prop('disabled'));
        })

        $('#add-feature-data-btn').on('click', function() {
            var newField = `
                <div class="d-flex mb-2 form-field">
                    <input class="form-control" type="text" id="feature" name="feature[]" placeholder="Enter service conditions" value="">
                    <button type="button" class="btn remove-btn">
                        <img src="{{ asset('assets/images/icons/remove-circle.png') }}" alt="remove-feature" />
                    </button>
                </div>
            `
            $('#feature-fields').append(newField);
        })

        $('#add-condition-data-btn').on('click', function() {
            var newField = `
                <div class="d-flex mb-2 form-field">
                    <input class="form-control" type="text" id="condition" name="condition[]" placeholder="Condition" value="">
                    <button type="button" class="btn remove-btn">
                        <img src="{{ asset('assets/images/icons/remove-circle.png') }}" alt="remove-condition" />
                    </button>
                </div>
            `
            $('#condition-fields').append(newField);
        })

        $(document).on('click', '.remove-btn', function () {
      $(this).closest('.form-field').remove();
    });

    });
</script>
@endsection