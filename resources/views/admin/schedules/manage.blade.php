@extends('layouts.admin')
@section('content')
    <div class="container">
        <div class="row">
            <div class="col mb-4">
                <h3>Schedules</h3>
            </div>
            <div class="card w-100">
                <div class="card-body">
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

            var calendar = $('#calendar').fullCalendar({
                events: SITEURL + "/calendar",
                displayEventTime: false,
                editable: true,
                eventRender: function (event, element, view) {
                    event.allDay = event.allDay === 'true';
                },
                selectable: true,
                selectHelper: true,
                header: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'add_event'
                } ,
                eventAfterAllRender: function(events) {
                    if($("select[id=set-schedule]").length < 1) {
                        let selectHTML = "<select id=\"set-schedule\" class=\"form-select\">" +
                            "<option selected>Setup Availability</option>"+
                            "<option value='1'>Mark all days as available</option>" +
                            "<option value='2'>Mark all days as available except weekends</option>" +
                            "</select>";


                        $(selectHTML).appendTo('.fc-right');
                        $("#set-schedule").on('change', function() {
                            let type = $(this).val();
                            $.ajax({
                                type: "POST",
                                url: SITEURL + '/update-schedule',
                                data: {
                                    type: type,
                                },
                                success: function (response) {
                                    $('#calendar').fullCalendar('removeEvents');
                                    $('#calendar').fullCalendar('refetchEvents');
                                    displayMessage("Event Updated Successfully");
                                }
                            });
                        });
                    }
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
