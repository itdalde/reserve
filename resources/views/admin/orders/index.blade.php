@extends('layouts.admin')
@section('content')
    <div class="container">

        <div class="row">
            <div class="col-9">
                <h3>Order List</h3>

                <div class="card mb-2">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table">
                                <thead class="thead-light">
                                <tr>
                                    <th scope="col" style="border-top-left-radius: 11px;background: #F2F1F0;">Name</th>
                                    <th scope="col" style=" background: #F2F1F0;">Order No.</th>
                                    <th scope="col" style=" background: #F2F1F0;">Type</th>
                                    <th scope="col" style=" background: #F2F1F0;">Guests</th>
                                    <th scope="col" style=" background: #F2F1F0;">Date</th>
                                    <th scope="col" style="background: #F2F1F0;">Status</th>
                                    <th scope="col" style="border-top-right-radius: 11px;background: #F2F1F0;">Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($orders as $order)
                                    <tr>
                                        <td>{{$order['order'] && $order['order']['user'] ? $order['order']['user']['first_name'] . ' ' . $order['order']['user']['last_name'] : ''}}</td>
                                        <td>{{$order['order'] ? $order['order']['reference_no'] : ''}}</td>
                                        <td>{{$order['service'] && $order['service']['price'] && $order['service']['price']['plan_type'] ? $order['service']['price']['plan_type']['name'] : ''}}</td>
                                        <td>{{$order['guests']}}</td>
                                        <td>{{Carbon\Carbon::parse($order['created_at'])->format('F d, Y H:m')}}</td>
                                        <td>
                                            @switch($order['status'])
                                                @case('pending')
                                                <span
                                                    class="w-100 badge bg-warning text-dark text-capitalize">{{$order['status']}}</span>
                                                @break
                                                @case('accepted')
                                                <span
                                                    class="w-100 badge bg-secondary text-capitalize">{{$order['status']}}</span>
                                                @break
                                                @case('declined')
                                                <span
                                                    class="w-100 badge bg-danger text-capitalize">{{$order['status']}}</span>
                                                @break
                                                @case('completed')
                                                <span
                                                    class="w-100 badge bg-success text-capitalize">{{$order['status']}}</span>
                                                @break
                                                @case('cancelled')
                                                <span
                                                    class="w-100 badge bg-danger text-capitalize">{{$order['status']}}</span>
                                                @break
                                                @default
                                                <span
                                                    class="w-100 badge bg-primary text-capitalize">{{$order['status']}}</span
                                            @endswitch

                                        </td>
                                        <td>
                                            <div class="d-flex justify-content-center w-100">
                                                <div class="px-2 {{$order['status'] == 'pending' ? '' : 'd-none'}}">
                                                    <button type="button"
                                                            class="btn btn-action btn-warning btn-accept-order "
                                                            data-id="{{$order['order']['id']}}" data-action="accept">
                                                        Accept
                                                    </button>
                                                </div>
                                                <div class="px-2 {{$order['status'] == 'pending' ? '' : 'd-none'}} ">
                                                    <button type="button"
                                                            class="btn btn-secondary btn-action btn-decline-order "
                                                            data-id="{{$order['order']['id']}}" data-action="decline">
                                                        Decline
                                                    </button>
                                                </div>
                                                <div
                                                    class="px-2 {{$order['status'] == 'pending' || $order['status'] == 'cancelled' || $order['status'] == 'declined' ? 'd-none' : ''}}">
                                                    <button type="button"
                                                            class="btn btn-action btn-warning btn-complete-order  "
                                                            data-id="{{$order['order']['id']}}" data-action="complete">
                                                        Complete
                                                    </button>
                                                </div>
                                                <div class="px-2">
                                                    <a href="orders/{{$order['order']['id']}}" class="btn btn-outline-info">View</a>
                                                </div>
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
            <div class="col-3 p-0">
                <h3>Upcoming orders</h3>
                <div class="d-flex justify-content-around">
                    <div class="px-2"><span class=" pending-dot"></span> Pending
                    </div>
                    <div class="px-2 "><span class=" accepted-dot"></span> Accepted
                    </div>
                </div>
                @foreach($futureOrders as $order)
                    <div
                        class="card mb-2 {{$order['status'] == 'pending' ? 'border-card-pending' : 'border-card-accepted'}}">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-2">
                                    <div class="avatar avatar-md avatar-indicators avatar-online">
                                        @if($order['order'] && $order['order']['user'] && $order['order']['user']['profile_picture'] )
                                            <img class="rounded-circle"
                                                 src="{{ asset( $order['order']['user']['profile_picture']) }}"
                                                 alt="...."/>
                                        @else
                                            <img class="rounded-circle"
                                                 src="https://ui-avatars.com/api/?name={{$order['order'] && $order['order']['user'] ? $order['order']['user']['first_name']. ' ' . $order['order']['user']['last_name'] : 'R'}}"
                                                 alt="...">
                                        @endif
                                    </div>
                                </div>
                                <div class="col-5">
                                    <div>{{$order['order']['reference_no']}}</div>
                                    <div>{{$order['order'] && $order['order']['user'] ? $order['order']['user']['first_name'] . ' ' . $order['order']['user']['last_name'] : ''}}</div>
                                </div>
                                <div class="col-5" style="border-left: 2px solid #a69382;">
                                    <div>{{Carbon\Carbon::parse($order['created_at'])->format('H:m A')}}</div>
                                    <div>{{Carbon\Carbon::parse($order['created_at'])->format('Y/d/m')}}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
@endsection

@section('content_javascript')
    <script type="text/javascript">
        $(document).ready(function () {

            $('body').on('click', '.btn-action', function () {
                let action = $(this).attr('data-action');
                let id = $(this).attr('data-id');
                let that = this;
                $.ajax({
                    url: "{{route('settings.update-status-order')}}",
                    method: "POST",
                    data: {action, id},
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    beforeSend: function () {
                        $('#loader').show();
                    },
                }).done(function (response) {
                    $('#loader').hide();
                    switch (action) {
                        case 'accept':
                            $('.btn-complete-order, .btn-cancel-order').closest('div').removeClass('d-none');
                            $('.btn-accept-order, .btn-decline-order').closest('div').addClass('d-none');
                            break;
                        case 'decline':
                            $(' .btn-cancel-order').closest('div').removeClass('d-none');
                            $('.btn-complete-order, .btn-accept-order, .btn-decline-order').closest('div').addClass('d-none');
                            break;
                        case 'complete':
                            $('.btn-complete-order').closest('div').removeClass('d-none');
                            $('.btn-accept-order, .btn-decline-order, .btn-cancel-order').closest('div').addClass('d-none');
                            break;
                        case 'cancel':
                            $('.btn-cancel-order').closest('div').removeClass('d-none');
                            $('.btn-complete-order, .btn-accept-order, .btn-decline-order').closest('div').addClass('d-none');
                            break;
                    }
                })
            });
            $('body').on('click', '.edit-featured-service-image-holder', function () {
                $('#edit-featured-service-image-file').click();
            });
            $('body').on('change', '#add-images-data-file', function () {
                $('.new-added-mg-temp').remove();
                for (let i = 0; i < this.files.length; ++i) {
                    let filereader = new FileReader();
                    let $img = jQuery.parseHTML("<img class='new-added-mg-temp figure-img img-fluid img-thumbnail image-gallery' src=''>");
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
