@extends('layouts.admin')
@section('content')
<div class="container">
    <div class="row">
        <div class="card w-100">

            <div class="card-body">
                <div class="">
                    <h3 class="text-secondary fs-3 mb-0">Schedule</h3>
                    <p class="fs-6">Click the dates multiple to set your availability on different days</p>
                    <div id="company-id" data-company-id="{{ auth()->user()->company->id }}"></div>
                </div>
                {{-- Buttons --}}
                <div class="d-flex gap-3 justify-content-between">
                    <div class="d-flex gap-3">
                        <button type="button" class="btn btn-light border border-1 text-secondary block-calendar"
                            data-type="1" id="block-weekends">Block
                            Weekends</button>
                        <button type="button" class="btn btn-light border border-1 text-secondary block-calendar"
                            data-type="2" id="block-all-days">Set all days as
                            available</button>
                        <button type="button" class="btn btn-light border border-1 text-secondary block-calendar"
                            data-type="3" id="unblock-all-days">Set all days an
                            unavailable</button>
                        <button type="button" class="btn btn-light border border-1 text-secondary block-calendar"
                            data-type="4" id="clear-block">Clear all</button>
                    </div>
                </div>
                <div class="mt-4 mb-6 d-flex">
                    <label class="d-flex" style="margin: auto 0;"><i class="bg-success rounded-circle me-1 m-auto"
                            style="display: inline-block; width: 16px; height: 16px;"
                            aria-hidden="true"></i>Available</label>
                    <label class="d-flex ms-3" style="margin: auto 0;"><i class="bg-danger rounded-circle me-1 m-auto"
                            style="display: inline-block; width: 16px; height: 16px;"
                            aria-hidden="true"></i>Unavailable</label>
                    <i class="bi bi-info-circle icon-info" style="margin-left: 14px; margin-top: -9px;"
                        data-bs-toggle="tooltip" data-bs-placement="bottom"
                        title="Dates without availability set are considered as available days"></i>
                </div>
                <div id='calendar'></div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('content_javascript')
<script>
    $(document).ready(function () {

        let SITEURL = "{{ url('/') }}";

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        var selectedRange = null;
        var buttonClicked = false;
        var calendar = $('#calendar').fullCalendar({
            events: SITEURL + "/calendar",
            displayEventTime: false,
            editable: true,
            selectable: true,
            selectHelper: true,
            eventRender: function (event, element, view) {
                event.allDay = event.allDay === 'true';
            },
            dayRender: function (date, cell) {
                // console.log('date', date);
                // console.log('cell', cell);
                // cell.css("background-color", "red");
            },
            dayClick: function (date) {
                var selectedDate = $.fullCalendar.formatDate(date, "DD/MM/YYYY");
                $.ajax({
                    type: "POST",
                    url: SITEURL + '/update-schedule',
                    data: {
                        date: selectedDate,
                        service_id: $('#set-schedule :selected').val()
                    },
                    success: function (response) {
                        $('#calendar').fullCalendar(
                            'removeEvents');
                        $('#calendar').fullCalendar('addEventSource', response);
                        displayMessage(
                            "Event Updated Successfully");
                    }

                })
            },
            header: {
                left: 'prev,next today',
                center: 'title',
                right: 'add_event'
            },
            eventAfterAllRender: function (events) {
                console.log('called', events);
                if (buttonClicked == false) {
                    buttonClicked = true
                    $('.block-calendar').on(
                        'click',
                        function (event) {
                            var type = $(this).attr('data-type');
                            var service_id = $('#set-schedule :selected').val();
                            $.ajax({
                                type: "POST",
                                url: SITEURL + '/update-schedule',
                                data: {
                                    type: type,
                                    service_id: service_id
                                },
                                success: function (response) {

                                    console.log('response', response);
                                    $('#calendar').fullCalendar(
                                        'removeEvents');
                                    $('#calendar').fullCalendar('addEventSource', response);
                                    displayMessage(
                                        "Event Updated Successfully");
                                }
                            });
                        })

                    // Dropdown Service
                    let selectHTML = document.createElement('select');
                    selectHTML.id = 'set-schedule';
                    selectHTML.className = "form-select";
                    let optionHTML = document.createElement('option');

                    var company_id = $('#company-id').attr('data-company-id');
                    $.ajax({
                        type: 'GET',
                        url: SITEURL + `/api/v1/occasion-events/company/${company_id}/occasions`,
                        success: function (response) {
                            for (let i = 0; i < response.data.length; i++) {
                                optionHTML += `<option value=${response.data[i].id}>${response.data[i].name}</option>`
                            }
                            $(selectHTML).append(optionHTML);
                        }
                    });
                    $(selectHTML).appendTo('.fc-right');

                    $('#set-schedule').on('change', function () {
                        var service_id = this.value;
                        var start = $.fullCalendar.formatDate(events.start, "Y-MM-DD");
                        var end = $.fullCalendar.formatDate(events.end, "Y-MM-DD");
                        $('#calendar').fullCalendar('removeEvents');
                        $.ajax({
                            type: 'GET',
                            url: SITEURL + '/calendar',
                            data: {
                                start: start,
                                end: end,
                                service_id: service_id,
                            },
                            success: function (response) {
                                console.log('response', response);
                                $('#calendar').fullCalendar('addEventSource', response);
                            }
                        })
                    })

                }


                //     $("#set-schedule").on('change', function() {
                //         let type = $(this).val();
                //         console.log('type', type);
                //         $.ajax({
                //             type: "POST",
                //             url: SITEURL + '/update-schedule',
                //             data: {
                //                 type: type,
                //             },
                //             success: function(response) {
                //                 $('#calendar').fullCalendar(
                //                     'removeEvents');
                //                 $('#calendar').fullCalendar(
                //                     'refetchEvents');
                //                 displayMessage(
                //                     "Event Updated Successfully");
                //             }
                //         });
                //     });
                // }
            },
            // select: function (start, end, allDay) {
            //     var title = prompt('Event Title:');
            //     if (title) {
            //         var start = $.fullCalendar.formatDate(start, "Y-MM-DD");
            //         var end = $.fullCalendar.formatDate(end, "Y-MM-DD");
            //         $.ajax({
            //             url: SITEURL + "/add-schedule",
            //             data: {
            //                 title: title,
            //                 start: start,
            //                 end: end,
            //                 type: 'add'
            //             },
            //             type: "POST",
            //             success: function (data) {
            //                 displayMessage("Event Created Successfully");
            //;
            //             }
            //         });
            //     }
            // },
            // eventDrop: function (event, delta) {
            //     var start = $.fullCalendar.formatDate(event.start, "Y-MM-DD");
            //     var end = $.fullCalendar.formatDate(event.end, "Y-MM-DD");
            //
            //     $.ajax({
            //         url: SITEURL + '/update-schedule',
            //         data: {
            //             title: event.title,
            //             start: start,
            //             end: end,
            //             id: event.id,
            //             type: 'update'
            //         },
            //         type: "POST",
            //         success: function (response) {
            //             displayMessage("Event Updated Successfully");
            //         }
            //     });
            // },
            // eventClick: function (event) {
            //     var deleteMsg = confirm("Do you really want to delete?");
            //     console.log(event)
            // if (deleteMsg) {
            //     $.ajax({
            //         type: "POST",
            //         url: SITEURL + '/remove-schedule',
            //         data: {
            //             id: event.id,
            //             type: 'delete'
            //         },
            //         success: function (response) {
            //             calendar.fullCalendar('removeEvents', event.id);
            //             displayMessage("Event Deleted Successfully");
            //         }
            //     });
            // }
            // }

        });
    });

    function displayMessage(message) {
        toastr.success(message, 'Event');
    }
</script>
@endsection
