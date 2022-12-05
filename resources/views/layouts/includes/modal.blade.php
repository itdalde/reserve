@if(!Auth::user()->hasRole('superadmin'))
    <div class="modal fade" id="new-service-modal" tabindex="-1" aria-labelledby="new-service-modalLabel"
         aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="new-service-modalLabel">Add new service</h5>
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal" aria-label="Close">close
                    </button>
                </div>
                <form id="create-service" action="{{route('services.store')}}" method="post"
                      enctype="multipart/form-data">
                    @csrf

                    <div class="modal-body">
                        <div class="container fist-step-c">
                            <div class="d-flex flex-row bd-highlight">
                                <div class="bd-highlight w-25">
                                    <img class="float-end" src="{{asset('assets/images/icons/circle-orange.png')}}"
                                         alt="circle-orange">
                                </div>
                                <div class="bd-highlight w-75">
                                    <hr style="margin-top: 10px;">
                                </div>
                                <div class="bd-highlight w-25">
                                    <img class="float-start" src="{{asset('assets/images/icons/circle.png')}}"
                                         alt="circle-orange">
                                </div>

                            </div>
                            <div class="d-flex flex-row bd-highlight mb-3">
                                <div class="bd-highlight w-50">
                                    <span class="ms-5">Service type</span>
                                </div>
                                <div class="bd-highlight w-50"></div>
                                <div class="bd-highlight w-50">
                                    <span>Features and plans</span>
                                </div>
                            </div>
                            <hr>
                            <div class="mb-3 row">
                                <label for="service-name" class="col-sm-2 col-form-label">Service name</label>
                                <div class="col-sm-10">
                                    <input dir="auto" name="service_name" type="text" class="form-control"
                                           placeholder="Enter Service Name"
                                           id="service-name" value="">
                                    <div class="service-name-error alert alert-danger d-none  mt-2" role="alert">
                                        Please add service name
                                    </div>
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label for="service-type" class="col-sm-2 col-form-label">Service type</label>
                                <div class="col-sm-5">
                                    <input type="hidden" name="service_type"
                                           value="{{Auth::user() &&  Auth::user()->company &&  Auth::user()->company->service_type_id ?  Auth::user()->company->service_type_id : 1}}">
                                    <input type="text" class="form-control" readonly
                                           value="{{Auth::user() &&  Auth::user()->company &&  Auth::user()->company->serviceType ? Auth::user()->company->serviceType->name : 'Serrvice'}}">
                                </div>
                                <div class="col-sm-5">
                                    <div class="input-group flex-nowrap">
                                    <span class="input-group-text" id="addon-wrapping">
                                        <img class="float-end" src="{{asset('assets/images/icons/location.png')}}"
                                             alt="location">
                                    </span>
                                        <input dir="auto" name="location" type="text" class="form-control"
                                               placeholder="Enter Location"
                                               aria-label="" aria-describedby="addon-wrapping">
                                    </div>
                                </div>
                            </div>
                            <div class="mb-3 row d-none">
                                <label for="staticEmail" class="col-sm-2 col-form-label">Occasion Type</label>
                                <div class="col-sm-10">
                                    <select name="occasion_type" class="form-select" aria-label="Select Occasion Type">
                                        @if(isset($occasionTypes))
                                            @foreach($occasionTypes as $occasionType)
                                                <option
                                                    value="{{$occasionType['id']}}">{{$occasionType['name']}}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label class="col-sm-2 col-form-label">Description</label>
                                <div class="col-sm-10 ">

                                    <ul class="nav nav-tabs" role="tablist">
                                        <li class="nav-item" role="presentation">
                                            <button class="nav-link active" id="english-tab" data-bs-toggle="tab"
                                                    data-bs-target="#english" type="button" role="tab"
                                                    aria-controls="english" aria-selected="true">English Description
                                            </button>
                                        </li>
                                        <li class="nav-item" role="presentation">
                                            <button class="nav-link" id="arabic-tab" data-bs-toggle="tab"
                                                    data-bs-target="#arabic" type="button" role="tab"
                                                    aria-controls="arabic" aria-selected="false">Arabic Description
                                            </button>
                                        </li>
                                    </ul>
                                    <div class="tab-content">
                                        <div class="tab-pane fade show active" id="english" role="tabpanel"
                                             aria-labelledby="english-tab" style="min-height: 140px;">

                                            <div class="form-floating">
                                    <textarea dir="auto" name="service_description" class="form-control"
                                              placeholder="Description"
                                              id="floatingTextarea2" style="height: 100px"></textarea>
                                                <label for="floatingTextarea2">Enter Service description</label>
                                            </div>
                                        </div>
                                        <div class="tab-pane fade" id="arabic" role="tabpanel"
                                             aria-labelledby="arabic-tab" style="min-height: 140px;">

                                            <div class="form-floating">
                                    <textarea dir="rtl" name="service_description_arabic" class="form-control"
                                              placeholder="أدخل وصف الخدمة"
                                              id="arabic-description" style="height: 100px"></textarea>
                                                <label style="margin-left: 78%;" dir="rtl" for="arabic-description">أدخل وصف الخدمة</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label class="col-sm-2 col-form-label">Featured Image</label>
                                <div class="col-sm-10 mb-2">
                                    <div class="d-flex justify-content-between flex-wrap">
                                        <a href="#" class="service-image-holder">
                                            <img width="200" id="service-image-view"
                                                 src="{{asset('assets/images/icons/image-select.png')}}"
                                                 alt="image-select">
                                        </a>
                                    </div>
                                    <input
                                        onchange="document.getElementById('service-image-view').src = window.URL.createObjectURL(this.files[0])"
                                        id="service-image-file" accept="image/png, image/gif, image/jpeg" type="file"
                                        class="d-none" name="featured_image">

                                    <div class="service-image-error alert alert-danger d-none mt-2" role="alert">
                                        Please add image first
                                    </div>
                                </div>
                                <label class="col-sm-2 col-form-label">Image Gallery</label>
                                <div class="col-sm-10">

                                    <div
                                        class="d-flex justify-content-between service-image-gallery-holder  flex-wrap"></div>
                                    <input
                                        id="service-image-gallery-file" accept="image/png, image/gif, image/jpeg"
                                        type="file"
                                        class="" name="images[]" multiple>

                                </div>
                            </div>
                        </div>

                        <div class="container last-step-c d-none">
                            <div class="d-flex flex-row bd-highlight">
                                <div class="bd-highlight w-25">
                                    <img class="float-end" src="{{asset('assets/images/icons/check mark.png')}}"
                                         alt="circle-orange">
                                </div>
                                <div class="bd-highlight w-75">
                                    <hr style="margin-top: 10px;background: #D97C37;height: 2px;">
                                </div>
                                <div class="bd-highlight w-25">
                                    <img class="float-start" src="{{asset('assets/images/icons/circle-orange.png')}}"
                                         alt="circle-orange">
                                </div>

                            </div>
                            <div class="d-flex flex-row bd-highlight mb-3">
                                <div class="bd-highlight w-50">
                                    <span class="ms-5">Service type</span>
                                </div>
                                <div class="bd-highlight w-50"></div>
                                <div class="bd-highlight w-50">
                                    <span>Features and plans</span>
                                </div>
                            </div>
                            <hr>
                            <div class=" row">
                                <label for="service-name" class="col-sm-2 col-form-label">Details</label>
                                <div class="col-sm-10">
                                    <div class="mb-3">
                                        <label class="form-label">Capacity</label>
                                        <div class="d-flex flex-row bd-highlight mb-3">
                                            <div class="bd-highlight w-50">
                                                <input min="0" value="0" placeholder="Minimum" name="min_capacity"
                                                       class="float-end form-control" type="number">
                                            </div>
                                            <div class="bd-highlight w-15">
                                                <hr>
                                            </div>
                                            <div class="bd-highlight w-50">
                                                <input min="0" value="0" placeholder="Maximum" name="max_capacity"
                                                       class="float-start form-control" type="number">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="d-flex flex-row bd-highlight mb-3">
                                        <div class="col-sm-6 pe-2 d-none">
                                            <div class="mb-3">
                                                <label class="form-label">Available time</label>
                                                <div class="d-flex flex-row bd-highlight mb-3">
                                                    <div class="bd-highlight">
                                                        <input value="07:00:00" name="start_available_time"
                                                               class="float-end form-control" type="time">
                                                    </div>
                                                    <div class="bd-highlight w-15">
                                                        <hr>
                                                    </div>
                                                    <div class="bd-highlight">
                                                        <input value="20:00:00" name="end_available_time"
                                                               class="float-start form-control" type="time">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-7 pe-2 ">
                                            <div class="row">
                                                <label class="form-label">Available Date</label>
                                                <div class="col-sm-6 ">
                                                    <input value="<?php echo date('Y-m-d'); ?>"
                                                           name="start_available_date" class="float-end form-control"
                                                           type="date">
                                                </div>
                                                <div class="col-sm-6 ">
                                                    <input value="<?php echo date('Y-m-d'); ?>"
                                                           name="end_available_date" class="float-start form-control"
                                                           type="date">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="ms-3 col-sm-5 ">
                                            <label class="form-label">Available Slot</label>
                                            <div class="bd-highlight">
                                                <input value="2" name="available_slot" class="float-end form-control"
                                                       type="number">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class=" row">
                                <label for="service-type" class="col-sm-2 col-form-label">Payment plans</label>

                                <div class="col-sm-10">
                                    <div class="mb-3">
                                        <div class="d-flex flex-row bd-highlight mb-3">
                                            <div class="pe-2 bd-highlight w-100">
                                                <label class="form-label">Plan Type</label>
                                                <div class="bd-highlight w-100">
                                                    <select id="plan_id" name="plan_id" class="form-select"
                                                            aria-label="Select Plan Type">
                                                        @if(isset($plan))
                                                            @foreach($plan as $p)
                                                                <option value="{{$p['id']}}">{{$p['name']}}</option>
                                                            @endforeach
                                                        @endif
                                                    </select>
                                                </div>
                                            </div>
                                            <div class=" bd-highlight w-100">
                                                <label class="form-label">Price</label>
                                                <div class="bd-highlight w-100">
                                                    <div class="input-group mb-3">
                                                        <span class="input-group-text">QAR</span>
                                                        <input type="number" placeholder="0" class="form-control"
                                                               required name="service_price" min="0" value="0"
                                                               step="0.01" title="Amount" pattern="^\d+(?:\.\d{1,2})?$">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="d-none package-div">
                                        <div class="mb-3">
                                            <label class="form-label">Package name</label>
                                            <div class="bd-highlight w-100">
                                                <input dir="auto" name="package_name" class="float-end form-control"
                                                       type="text">
                                            </div>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Capacity</label>
                                            <div class="d-flex flex-row bd-highlight mb-3">
                                                <div class="bd-highlight w-50">
                                                    <input min="0" value="0" placeholder="Minimum"
                                                           name="package_min_capacity" class="float-end form-control"
                                                           type="number">
                                                </div>
                                                <div class="bd-highlight w-15">
                                                    <hr>
                                                </div>
                                                <div class="bd-highlight w-50">
                                                    <input min="0" value="0" placeholder="Maximum"
                                                           name="package_max_capacity" class="float-start form-control"
                                                           type="number">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="mb-3">
                                            <div class="d-flex flex-row bd-highlight mb-3">
                                                <div class="pe-2 bd-highlight w-100">
                                                    <labe class="form-label">Package details</labe>
                                                    <div class="bd-highlight w-100 mt-2">
                                                        <input dir="auto" name="package_details"
                                                               class="float-end form-control" type="text">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label for="service-type" class="col-sm-2 col-form-label">Add-ons</label>

                                <div class="col-sm-10">
                                    <div class="add-on-div cloneable d-none">
                                        <div class="d-flex flex-row bd-highlight">
                                            <div class="pe-2 bd-highlight w-100">
                                                <label class="form-label">Name</label>
                                                <div class="bd-highlight w-100">
                                                    <input dir="auto" type="text"
                                                           class="form-control add_on_name border border-danger"
                                                           name="add_on_name[]">

                                                </div>
                                            </div>
                                            <div class=" bd-highlight w-100">
                                                <label class="form-label">Price</label>
                                                <div class="bd-highlight w-100">
                                                    <div class="input-group">
                                                        <span class="input-group-text">QAR</span>
                                                        <input type="number" placeholder="0" class="form-control"
                                                               required name="add_on_price[]" min="0" value="0"
                                                               step="0.01" title="Amount" pattern="^\d+(?:\.\d{1,2})?$">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="d-flex flex-row bd-highlight">
                                            <div class="bd-highlight w-100">
                                                <label class="form-label">Description</label>
                                                <div class="bd-highlight w-100">
                                                    <input dir="auto" type="text" class="form-control"
                                                           name="add_on_description[]">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="d-flex bd-highlight mb-3 remove-btn-div d-none">
                                            <div class="p-2 bd-highlight w-75">
                                                <hr>
                                            </div>
                                            <div class="ms-auto p-2 bd-highlight">
                                                <button type="button" class="btn btn-orange remove-addon-data-btn"><img
                                                        src="{{asset('assets/images/icons/remove-circle.png')}}"
                                                        alt="remove-circle.png">&nbsp; &nbsp;&nbsp;remove
                                                </button>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="d-flex flex-row bd-highlight">
                                        <button type="button" id="add-addon-data-btn" class="btn btn-orange"><img
                                                src="{{asset('assets/images/icons/add.png')}}" alt="add.png"> Add-ons
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="d-flex bd-highlight mb-3">
                            <div class="p-2 bd-highlight">
                                <button type="button" id="service-close-btn" class="btn btn-light"
                                        data-bs-dismiss="modal">
                                    Close
                                </button>
                                <button type="button" id="service-back-btn" class="btn btn-light d-none">Back</button>
                            </div>

                            <div class="ms-auto p-2 bd-highlight">
                                <button type="button" id="service-next-btn" class="btn btn-warning">Next</button>
                                <button  type="submit" id="service-submit-btn" class="btn btn-warning d-none">Save
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="modal fade" id="new-support-modal" tabindex="-1" aria-labelledby="new-support-modalLabel"
         aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="new-support-modalLabel">New support ticket</h5>
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal" aria-label="Close">close
                    </button>
                </div>
                <form method="post" action="{{route('helps.store')}}" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <div class="row g-3 align-items-center mb-3">
                            <div class="col-auto" style="width: 29%;">
                                <label for="ticket-modal-title-field" class="col-form-label">Enter ticket title</label>
                            </div>
                            <div class="col-auto" style="width: 70%;">
                                <input dir="auto" name="title" type="text" id="ticket-modal-title-field"
                                       class="form-control"
                                       placeholder="Enter service name">
                            </div>
                        </div>
                        <div class="row g-3 align-items-center mb-3">
                            <div class="col-auto" style="width: 29%; margin-top: -157px;">
                                <label for="ticket-modal-description-field" class="col-form-label">Issue
                                    description</label>
                            </div>
                            <div class="col-auto" style="width: 70%;">
                        <textarea dir="auto" rows="8" name="description" type="text" id="ticket-modal-description-field"
                                  class="form-control"
                                  placeholder="Enter service description"> </textarea>
                            </div>
                        </div>

                        <div class="row g-3 align-items-center mb-3">
                            <div class="col-auto" style="margin-left: 9em;">
                                <button type="button" id="add-attachment-btn"
                                        class="btn btn-warning text-white text-center mx-auto">
                                    <img src="{{asset('assets/images/icons/attachment.png')}}" alt="..."> &nbsp; &nbsp;
                                    &nbsp; &nbsp;Attach supporting document
                                </button>
                                <input name="attachments[]" id="support-attachments" type="file" multiple="multiple"
                                       class="d-none">
                            </div>
                        </div>
                        <div class="d-flex bd-highlight mb-3">
                            <div class="p-2 bd-highlight">
                                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                            </div>

                            <div class="ms-auto p-2 bd-highlight">
                                <button type="submit" class="btn btn-warning">Save changes</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endif
