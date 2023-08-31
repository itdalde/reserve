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
                <div class="image-event-deleted"></div>
                <div class="d-flex justify-content-between flex-wrap w-100">
                    <h5 class="card-title page-title label-color">Edit service </h5>
                    <div class="d-flex flex-wrap">
                        <p>en&nbsp;&nbsp;</p>
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" id="translation-toggle" {{ $service->locale == 'ar' ? 'checked' : '' }}>
                        </div>
                        <p>ar</p>
                    </div>
                </div>
            </div>
            <form action="{{ route('services.update', $service->id) }}" method="post" enctype="multipart/form-data" class="edit-service-form"
                style="margin-top: -20px;">
                @csrf
                @method('put')
                <input name="_method" type="hidden" value="PUT">
                <input type="hidden" id="service-locale" name="locale" value="{{$service->locale}}" />

                <div class="container">
                    <div class="row">
                        <div class="mb-3">
                            <label for="service_name" class="form-label field-label label-color w-full">Service
                                Name</label>
                            <input type="text" class="form-control" name="service_name" id="service-name"
                                placeholder="Service name" value="{{$service->name}}" required>

                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="mb-3">
                            <label for="cover_image" class="form-label field-label label-color">Cover Image
                                &nbsp;&nbsp;<span class="text-danger">*</span></label>
                            <div class="d-flex justify-content-between flex-wrap">
                                <a href="#" class="service-image-holder rounded-3">
                                    <img width="180" id="service-image-view"
                                        src="{{ $service->image ? asset($service->image) : asset('assets/images/icons/image-select.png') }}" alt="image-select"
                                        style="border-radius: 10px;">
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
                    </div>
                    <hr>
                    <div class="row">
                        <div class="mb-3">
                            <label for="description"
                                class="form-label field-label label-color">Description&nbsp;&nbsp;<span
                                    class="text-danger">*</span></label>
                            <textarea name="service_description" class="form-control"
                                placeholder="Description" id="service-description" style="height: 100px"
                                required>{{ $service->description }}</textarea>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="mb-3">
                            <label for="service_images" class="form-label field-label label-color">Service
                                Images&nbsp;&nbsp;<span class="text-danger">*</span></label>
                            <div class="d-flex">
                                
                                <div id="service-image-gallery-holder1"
                                    class="d-flex justify-content-between service-image-gallery-holder1 flex-row gallery">
                                    @foreach($service->images as $key => $image)
                                    <div class="image-container" style="position: relative;">
                                        <img src="{{ asset($image->image) }}" alt="service-gallery-{{$image->id}}" class="gallery-image" data-preview="{{ asset($image->image) }}" style="width: 250px; height: 180px; object-fit: contain;"/>
                                        <div style="position: absolute; top: 68px; left: 88px;">
                                            <button type="button" class="view-img-button" style="border: 0px; background: transparent; filter: brightness(2); scale: 2; padding-right: 17px;">
                                                <img src="http://localhost:8000/assets/images/icons/preview.png" alt="delete-img">
                                            </button>
                                            <button type="button" data-id="{{ $image->id }}" class="remove-img-button" style="border: 0px; background: transparent;">
                                                <img src="http://localhost:8000/assets/images/icons/trash.png" alt="delete-img">
                                            </button>
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                                <div class="image-preview">
                                    <img src="" alt="Preview" id="preview-image">
                                </div>
                                <button type="button" id="add-gallery-data-btn"
                                    class="btn btn-orange action-button"><img
                                        src="{{ asset('assets/images/icons/add.png') }}" alt="add.png"> Add
                                </button>
                                <input name="service_gallery[]" id="add-gallery-data-file"
                                    accept="image/png, image/gif, image/jpeg" type="file" multiple="multiple"
                                    class="d-none">
                            </div>
                        </div>

                    </div>
                    <hr>
                    <div class="pt-4">
                        <h5 class="page-title label-color available_available_plans">Available packages and payment
                            plans</h5>
                        <div class="row pt-4">
                            <label for="pricing_type" class="form-label field-label label-color">Pricing
                                Type&nbsp;&nbsp;<span class="text-danger">*</span></label>
                            <div class="mb-3">
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input pricing_type" name="plan_id" type="checkbox"
                                        id="per_guest" value="1" {{ $service->paymentPlan->plan_id == 1 ? 'checked' : '' }}>
                                    <label class="form-check-label" for="per_guest">Per Guest</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input pricing_type" name="plan_id" type="checkbox"
                                        id="per_package" value="2" {{ $service->paymentPlan->plan_id == 2 ? 'checked' : '' }}>
                                    <label class="form-check-label" for="per_package">Per Package</label>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <label for="service_price" class="form-label field-label label-color">How
                                much?&nbsp;&nbsp;<span class="text-danger">*</span></label>
                            <div class="col-3">
                                <div class="d-flex">
                                    <div class="input-group mb-3">
                                        <span class="input-group-text currency_curr" id="price">QAR</span>
                                        <input type="number" name="service_price" class="form-control mr-4"
                                            placeholder="Price" aria-label="price" aria-describedby="price" value="{{ $service->price }}">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <label for="timed_service" class="form-label field-label label-color">Is the service timed?
                                If yes, how
                                long?</label>
                            <div class="row col-5">
                                <div class="d-flex">
                                    <div>
                                        <div class="input-group mb-3 mr-3">
                                            <span class="input-group-text hours_label" id="hours">Hours</span>
                                            <input type="number" class="form-control price_per_hour"
                                                name="price_per_hour" placeholder="Hours" aria-label="hours"
                                                aria-describedby="hours" value="{{ $service->duration != 0 ? $service->duration : 24 }}" disabled="{{ $service->duration == 0}}" required>
                                        </div>
                                        <span class="badge_hour" style="border: 1px solid #e7e7e7;
                                        padding: 0 4px;
                                        border-radius: 5px;
                                        position: relative;
                                        top: -18px;
                                        font-weight: 500;
                                        color: #dc3545;
                                        font-size: .75rem;">Maximum of 24</span>
                                    </div>
                                    &nbsp;&nbsp;
                                    <div class="form-check form-check-inline w-100 pl-5 mt-2">
                                        <div class="">
                                            <input class="form-check-input" type="checkbox" id="price-not-applicable"
                                                name="not_applicable" value="not-applicable" checked="{{ $service->duration == 0}}">
                                            <label class="form-check-label" for="price_not_applicable">Not
                                                Applicable</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-2">
                                <div class="mb-3">
                                    <label for="minimum_guests" class="form-label">Minimum guests</label>
                                    <input type="number" min="0" value="{{ $service->min_capacity }}" class="form-control guests_field float-end"
                                        id="minimum-guest" name="min_capacity" placeholder="0.00" disabled="{{ $service->max_capacity == 0 || $service->min_capacity == 0}}" required>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="mb-3">
                                    <label for="maximum_guests" class="form-label">Maximum guests</label>
                                    <input type="number" min="0" value="{{ $service->max_capacity }}" class="form-control guests_field float-start"
                                        id="maximum-guests" name="max_capacity" placeholder="0.00" disabled="{{ $service->max_capacity == 0 || $service->min_capacity == 0}}" required>
                                </div>
                            </div>
                            <div class="form-check form-check-inline" style="margin-left: 16px;">
                                <input class="form-check-input" type="checkbox" id="allowed_guests"
                                    name="not_allowed_guests" value="not-applicable" checked="{{ $service->max_capacity == 0 || $service->min_capacity == 0}}">
                                <label class="form-check-label" for="allowed_guests">Not Applicable</label>
                            </div>
                        </div>

                        <!-- Features -->
                        <div class="row mt-2">
                            <label for="feature" class="form-label label-color field-label">Features</label>
                            <div class="col-5 mb-3" id="feature-fields">
                            @if (count($service->features) > 0)
                            @foreach($service->features as $key => $feature)
                                <div class="d-flex mb-2 form-field">
                                    <input class="form-control" type="text" id="feature" name="feature[]"
                                        placeholder="Enter service features" value="{{ $feature->name }}">
                                    @if ($key == 0)
                                    <button type="button" id="add-feature-data-btn" class="btn btn-orange action-button"
                                        style="width: 30%;">
                                        <img src="{{ asset('assets/images/icons/add.png') }}"
                                            alt="add-feature" />&nbsp;Add
                                    </button>
                                    @else
                                    <button type="button" class="btn remove-btn">
                                        <img src="{{ asset('assets/images/icons/remove-circle.png') }}" alt="remove-feature" />
                                    </button>
                                    @endif

                                </div>
                            @endforeach
                            @else
                            <div class="d-flex mb-2 form-field">
                                <input class="form-control" type="text" id="feature" name="feature[]"
                                    placeholder="Enter service features" value="">
                                <button type="button" id="add-feature-data-btn" class="btn btn-orange action-button"
                                    style="width: 30%;">
                                    <img src="{{ asset('assets/images/icons/add.png') }}"
                                        alt="add-feature" />&nbsp;Add
                                </button>
                            </div>
                            @endif

                            </div>

                        </div>

                        <!-- Conditions -->
                        <div class="row mt-2">
                            <label for="condition" class="form-label label-color field-label">Conditions</label>
                            <div class="col-5 mb-3" id="condition-fields">
                                @if(count($service->conditions) > 0)
                                @foreach($service->conditions as $key => $condition)
                                <div class="d-flex mb-2 form-field">
                                    <input class="form-control form-control-sm" type="text" name="condition[]"
                                        id="condition" placeholder="Enter service conditions" value="{{ $condition->name }}">
                                    @if ($key == 0)
                                    <button type="button" id="add-condition-data-btn"
                                        class="btn btn-orange action-button" style="width: 30%;">
                                        <img src="{{ asset('assets/images/icons/add.png') }}"
                                            alt="add-condition" />&nbsp;Add
                                    </button>
                                    @else
                                    <button type="button" class="btn remove-btn">
                                        <img src="{{ asset('assets/images/icons/remove-circle.png') }}" alt="remove-condition" />
                                    </button>
                                    @endif
                                </div>
                                @endforeach
                                @else
                                <div class="d-flex mb-2 form-field">
                                    <input class="form-control form-control-sm" type="text" name="condition[]"
                                        id="condition" placeholder="Enter service conditions" value="">
                                    <button type="button" id="add-condition-data-btn"
                                        class="btn btn-orange action-button" style="width: 30%;">
                                        <img src="{{ asset('assets/images/icons/add.png') }}"
                                            alt="add-condition" />&nbsp;Add
                                    </button>
                                </div>
                                @endif
                            </div>
                        </div>


                        <hr>
                        @foreach($service->adOns as $key => $adOn)
                        <div class="add-on-name add-on-div">
                            <div class="row">
                                <div class="mb-3">
                                    <label for="location-name" class="form-label field-label label-color">What is the
                                        title of the addon?</label>
                                    <input dir="auto" type="text" id="add-ons" class="form-control add_on_name border border-danger"
                                        name="add_on_name[]" placeholder="Add-on name" value="{{ $adOn->name }}">
                                </div>
                            </div>
                            <div class="row">
                                <label for="description" class="form-label field-label label-color">What is the price of
                                    the add-on?</label>
                                <div class="col-3">
                                    <div class="input-group mb-3">
                                        <span class="input-group-text" id="price">QAR</span>
                                        <input type="number" placeholder="0" class="form-control" required
                                            name="add_on_price[]" min="0" value="{{ $adOn->price }}" step="0.01" title="Amount"
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
                                                alt="remove-circle.png" /></button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach

                        <!-- Add On Fields -->
                        <div class="add-on-name add-on-div cloneable d-none">
                            <div class="row">
                                <div class="mb-3">
                                    <label for="location-name" class="form-label field-label label-color">What is the
                                        title of the addon?</label>
                                    <input dir="auto" type="text" id="add-ons" class="form-control add_on_name border border-danger"
                                        name="add_on_name[]" placeholder="Add-on name">
                                </div>
                            </div>
                            <div class="row">
                                <label for="description" class="form-label field-label label-color">What is the price of
                                    the add-on?</label>
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
                                                alt="remove-circle.png" /></button>
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
                            <div class="d-flex">
                                <button type="submit"
                                    class="btn btn-warning text-white publish-service" style="width: 175px;">Update Service</button>
                                <a href="/services" class="btn btn-outline-secondary ms-2" style="width: 175px;">Back</a>
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


        const galleryImages = document.querySelectorAll('.gallery-image');
        const previewImage = document.getElementById('preview-image');
        const imagePreviewContainer = document.querySelector('.image-preview');

        galleryImages.forEach((image) => {
            image.addEventListener('click', () => {
                const imageUrl = image.getAttribute('data-preview');
                previewImage.src = imageUrl;
                imagePreviewContainer.style.display = 'block';
            });
        });

        imagePreviewContainer.addEventListener('click', () => {
            imagePreviewContainer.style.display = 'none';
        });

        var translation = {
            en: {
                service_name: 'Service Name *',
                cover_image: 'Cover Image *',
                description: 'Description *',
                service_images: 'Service Images',
                available_package_plans: 'Available packages and payment plans',
                pricing_type: 'Pricing Type',
                per_guest: 'Per Guest',
                per_package: 'Per Package',
                service_price: 'How Much?',
                price: 'Price',
                timed_service: 'Is the servie timed? if yes, how long?',
                price_not_applicable: 'Not Applicable',
                minimum_guest: 'Minimum Guest',
                maximum_guest: 'Maximum Guest',
                feature: 'Features',
                feature_placeholder: 'Enter service features',
                condition: 'Conditions',
                condition_placeholder: 'Enter service conditions',
                add: 'Add',
                add_addon: 'Add Add-on',
                save_for_later: 'Save for Later',
                publish: 'Publish'
            },
            ar: {
                service_name: 'عنوان الخدمة',
                cover_image: 'صورة العرض',
                description: 'الوصف',
                service_images: 'صور الخدمة ',
                available_package_plans: 'طرق احتساب سعر الخدمة',
                pricing_type: 'طريقة الحساب',
                per_guest: 'للفرد ',
                per_package: 'للباقة',
                service_price: 'التكلفة؟',
                price: 'السعر ',
                timed_service: 'هل الخدمة مرتبطة بوقت معين؟ كم المدة؟',
                price_not_applicable: 'لا ينطبق',
                minimum_guest: 'اقل عدد ضيوف',
                maximum_guest: 'اكبر عدد ضيوف',
                feature: 'المميزات',
                feature_placeholder: 'ادخل تفاصيل الخدمة',
                condition: 'الشروط',
                condition_placeholder: 'ادخل شروط الخدمة ',
                add: 'إضافة ',
                add_addon: 'إضافة خدمات إضافية',
                save_for_later: 'حفظ',
                publish: 'نشر'
            }
        }

        $('.pricing_type').on('click', function () {
            var checkboxes = $('.pricing_type');
            checkboxes.not(this).prop('checked', false);
            checkboxes.prop('required', false);
        });

        $('.special_request').on('click', function () {
            var checkboxes = $('.special_request');
            checkboxes.not(this).prop('checked', false);
        });

        $('#price-not-applicable').on('click', function () {
            var field = $('.price_per_hour');
            field.prop('disabled', !field.prop('disabled'));
            field.prop('required', false);
        })

        $('#allowed_guests').on('click', function () {
            var field = $('.guests_field');
            field.prop('disabled', !field.prop('disabled'));
            field.prop('required', false);
        })

        $('#add-gallery-data-btn').on('click', function () {
            $('#add-gallery-data-file').click()
        })


        let currentLocale = $('#service-locale').val();
        $('#translation-toggle').click(function () {
            currentLocale = currentLocale === 'en' ? 'ar' : 'en';
            $('.edit-service-form').attr('dir', currentLocale === 'ar' ? 'rtl' : 'ltr');
            $('#service-locale').val(currentLocale);
            updateFieldTranslation(currentLocale);
        });

        @if ($locale)
            var locale = $('#service-locale').val();
            if (locale == 'ar') {
                $('.edit-service-form').attr('dir', 'rtl');
                updateFieldTranslation(locale);
            }
        @endif

        function updateFieldTranslation(lang) {
            var serviceNameLabel = document.querySelector('label[for="service_name"]');
            var coverImageLabel = document.querySelector('label[for="cover_image"]');
            var descriptionLabel = document.querySelector('label[for="description"]');
            var serviceImagesLabel = document.querySelector('label[for="service_images"]');
            var availablePackagesLabel = document.querySelector('.available_available_plans');
            var addBtnLabel = document.querySelector('#add-gallery-data-btn');
            var pricingTypeLabel = document.querySelector('label[for="pricing_type"]');
            var perGuestLabel = document.querySelector('label[for="per_guest"]');
            var perPackageLabel = document.querySelector('label[for="per_package"]');
            var servicePriceLabel = document.querySelector('label[for="service_price"]');
            var timedServiceLabel = document.querySelector('label[for="timed_service"]');
            var priceNotApplicableLabel = document.querySelector('label[for="price_not_applicable"]');
            var minimumGuestLabel = document.querySelector('label[for="minimum_guests"]');
            var maximumGuestLabel = document.querySelector('label[for="maximum_guests"]');
            var allowedGuestLabel = document.querySelector('label[for="allowed_guests"]');
            var featureLabel = document.querySelector('label[for="feature"]');
            var conditionLabel = document.querySelector('label[for="condition"]');
            var featureBtnLabel = document.querySelector('#add-feature-data-btn');
            var conditionBtnLabel = document.querySelector('#add-condition-data-btn');
            var addOnBtnLabel = document.querySelector('#add-addon-data-btn');
            var publishButnLabel = document.querySelector('.publish-service');

            serviceNameLabel.textContent = translation[lang].service_name ?? serviceNameLabel
            coverImageLabel.textContent = translation[lang].cover_image ?? coverImageLabel
            descriptionLabel.textContent = translation[lang].description ?? descriptionLabel
            serviceImagesLabel.textContent = translation[lang].service_images ?? serviceImagesLabel
            availablePackagesLabel.textContent = translation[lang].available_package_plans ?? availablePackagesLabel
            addBtnLabel.textContent = translation[lang].add ?? addBtnLabel
            pricingTypeLabel.textContent = translation[lang].pricing_type ?? pricingTypeLabel
            perGuestLabel.textContent = translation[lang].per_guest ?? perGuestLabel
            perPackageLabel.textContent = translation[lang].per_package ?? perPackageLabel
            servicePriceLabel.textContent = translation[lang].service_price ?? servicePriceLabel
            timedServiceLabel.textContent = translation[lang].timed_service ?? timedServiceLabel
            priceNotApplicableLabel.textContent = translation[lang].price_not_applicable ?? priceNotApplicableLabel
            minimumGuestLabel.textContent = translation[lang].minimum_guest ?? minimumGuestLabel
            maximumGuestLabel.textContent = translation[lang].maximum_guest ?? maximumGuestLabel
            allowedGuestLabel.textContent = translation[lang].price_not_applicable ?? allowedGuestLabel
            featureLabel.textContent = translation[lang].feature ?? featureLabel
            conditionLabel.textContent = translation[lang].condition ?? conditionLabel
            featureBtnLabel.textContent = translation[lang].add ?? featureBtnLabel
            conditionBtnLabel.textContent = translation[lang].add ?? conditionBtnLabel
            addOnBtnLabel.textContent = translation[lang].add_addon ?? addOnBtnLabel
            publishButnLabel.textContent = translation[lang].publish ?? publishButnLabel

            $('#service-name').attr('placeholder', translation[lang].service_name);
            $('#service-description').attr('placeholder', translation[lang].description);

            $('#feature').attr('placeholder', translation[lang].feature_placeholder);
            $('.add-feature').attr('placeholder', translation[lang].feature_placeholder);
            $('#condition').attr('placeholder', translation[lang].condition_placeholder);
            $('.add-condition').attr('placeholder', translation[lang].condition_placeholder);
            $('#add-ons').attr('placeholder', translation[lang].add_addon);
        }

        $('.remove-img-button').click(function() {
            $(this).closest('.image-container').remove();
            let eventImageId = $(this).attr('data-id');
            
            $.ajax({
                url: "{{ route('delete-event-image') }}",
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: {
                    id: eventImageId
                },
                beforeSend: function () {
                    window.VIEW_LOADING();
                }

            }).done(function(response) {
                window.HIDE_LOADING();
                $('.image-event-deleted').addClass('alert alert-success').text(response.replace(/['"]+/g, ''));
            })
            
        });

        const imageContainer = document.getElementById("service-image-gallery-holder1");
        $('body').on('change', '#add-gallery-data-file', function () {
            // $('.new-added-mg-temp').remove();
            var files = this.files;
            for (let i = 0; i < files.length; i++) {
                renderImage(files[i]);
            }
        })
        function renderImage(file) {
            const reader = new FileReader();
            reader.onload = function (event) {

              // In-progress
              const imgContainer = document.createElement("div");
                imgContainer.classList.add("image-container");
                imgContainer.style.position = "relative";

                const img = document.createElement("img");
                img.src = event.target.result;
                img.classList.add("new-added-mg-temp", "figure-img", "img-fluid", "img-thumbnail", "service-image-gallery");
                img.style.filter = "blur(1.5px)"
                imgContainer.appendChild(img);

                let btnContainer = document.createElement("div");
                btnContainer.style.position = "absolute";
                btnContainer.style.top = "50px";
                btnContainer.style.left = "55px";
                // remove button
                const removeButton = document.createElement("button");
                removeButton.type = "button";
                removeButton.innerHTML = "<img src='{{ asset('/assets/images/icons/trash.png') }}' alt='delete-img' />";
                removeButton.classList.add("remove-img-button");
                removeButton.style.border = 0;
                removeButton.style.background = "transparent";
                removeButton.addEventListener("click", function() {
                    imgContainer.remove();
                    alert("REMOVED IMAGE");
                });

                const viewImage = document.createElement("button");
                viewImage.innerHTML = "<img src='{{ asset('/assets/images/icons/preview.png') }}' alt='delete-img' />";
                viewImage.classList.add("view-img-button");
                viewImage.style.border = 0;
                viewImage.style.background = "transparent";
                viewImage.style.filter = "brightness(2)";
                viewImage.style.scale = 2;
                viewImage.style.paddingRight = "17px";
                viewImage.addEventListener("click", function() {
                    // imgContainer.remove();
                    // review image
                });


                btnContainer.appendChild(viewImage)
                btnContainer.appendChild(removeButton)
                imgContainer.appendChild(btnContainer);
                imageContainer.appendChild(imgContainer);
            };
            reader.readAsDataURL(file);
        }

        $('#add-feature-data-btn').on('click', function () {
            var newField = `
                <div class="d-flex mb-2 form-field">
                    <input class="form-control form-control-sm add-feature" type="text" id="feature" name="feature[]" placeholder="${currentLocale === 'en' ? translation['en'].feature_placeholder : translation['ar'].feature_placeholder}" value="">
                    <button type="button" class="btn remove-btn">
                        <img src="{{ asset('assets/images/icons/remove-circle.png') }}" alt="remove-feature" />
                    </button>
                </div>
            `
            $('#feature-fields').append(newField);
        })

        $('#add-condition-data-btn').on('click', function () {
            var newField = `
                <div class="d-flex mb-2 form-field">
                    <input class="form-control form-control-sm add-condition" type="text" id="condition" name="condition[]" placeholder="${currentLocale === 'en' ? translation['en'].condition_placeholder : translation['ar'].condition_placeholder}" value="">
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
