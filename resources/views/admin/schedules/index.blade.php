@extends('layouts.admin')
@section('content')
    <div class="container">
        <div class="row">
            <div class="col mb-4">
                <h3>My Bookings</h3>
            </div>
            <div class="card w-100" >
                <div class="card-body">

                    <ul class="nav nav-tabs" id="myTab" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="userProfile-tab" data-bs-toggle="tab" data-bs-target="#userProfile" type="button" role="tab" aria-controls="userProfile" aria-selected="true">Schedules</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="companyProfile-tab" data-bs-toggle="tab" data-bs-target="#companyProfile" type="button" role="tab" aria-controls="companyProfile" aria-selected="false">Opted Days</button>
                        </li>
                    </ul>
                    <div class="tab-content" id="myTabContent">
                        <div class="tab-pane fade show active" id="userProfile" role="tabpanel" aria-labelledby="userProfile-tab" style="min-height: 140px;">

                            <div class="d-flex flex-column bd-highlight table-responsive">
                                <table class="table table-hover" id="service-table">
                                    <thead>
                                    <tr>
                                        <th scope="col">Service Name</th>
                                        <th scope="col">Scheduled Start Date</th>
                                        <th scope="col">Scheduled End Date</th>
                                    </tr>
                                    </thead>
                                    @foreach($services as $service)
                                    <tr>
                                        <td >{{$service->name}}</td>
                                        <td >{{Carbon\Carbon::parse($service->availability_start_date)->format('Y-m-d')}}
                                        </td>
                                        <td >{{Carbon\Carbon::parse($service->availability_end_date)->format('Y-m-d')}}
                                            <input type="hidden" class="dates-sched"  data-start_date="{{Carbon\Carbon::parse($service->availability_start_date)->format('Y-m-d')}}" data-end_date="{{Carbon\Carbon::parse($service->availability_end_date)->format('Y-m-d')}}">
                                        </td>
                                    </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="companyProfile" role="tabpanel" aria-labelledby="inActiveInquiries-tab" style="min-height: 140px;">

                            <div class="d-flex justify-content-end">
                                <div class="p-2 ">

                                    <button type="button" class="btn btn-warning text-white text-center mx-auto"  data-bs-toggle="modal" data-bs-target="#new-schedule-modal">
                                        <img src="{{asset('assets/images/icons/add-white.png')}}" alt="...">  &nbsp; &nbsp; &nbsp; &nbsp;Create schedule
                                    </button>
                                </div>
                            </div>
                            <div class="d-flex flex-column bd-highlight">
                                <table class="table" id="opted-table">
                                    <thead>
                                    <tr>
                                        <th scope="col">Name</th>
                                        <th scope="col">Opted Date</th>
                                        <th scope="col">Action</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($schedules as $schedule)
                                        <tr>
                                            <td >{{$schedule->name}}</td>
                                            <td >{{Carbon\Carbon::parse($schedule->date)->format('Y-m-d')}}</td>
                                            <td>
                                                <a class="btn btn-outline-danger" href="{{route('schedules.delete-schedule',['id' => $schedule->id])}}"  onclick="return confirm('Are you sure want to delete this schedule?')">
                                                    <img src="{{asset('assets/images/icons/remove.png')}}" alt="..">
                                                </a>
                                            </td>
                                          </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('content_javascript')
    <script type="text/javascript">
        $(document).ready(function () {


            $.fn.dataTable.ext.errMode = 'none';
            let datatable = $('#service-table').DataTable({
                "pageLength": 10,
            });
            let optedeDatatable = $('#opted-table').DataTable({
                "pageLength": 10,
            });
            $('#service-table,#opted-table').on('error.dt', function (e, settings, techNote, message) {
                console.log('An error has been reported by DataTables: ', message);
            })
            $('#service-table_length, #opted-table_filter,#opted-table_length, #service-table_filter').remove();

            function datesArray(start, end) {
                let result = [], current = new Date(start);
                while (current <= end)
                    result.push(current) && (current = new Date(current)) && current.setDate(current.getDate() + 1);
                return result;
            }
            $('body').on('change','#schedule-modal-date-field',function (e) {
                let myDate = $(this).val();
                $('.dates-sched').each(function (e,d) {
                    let start_date = $(d).attr('data-start_date');
                    let end_date = $(d).attr('data-end_date');
                    if(start_date == myDate || end_date == myDate) {
                        alert('You have an event scheduled on this day.')
                        return false;
                    }
                    if(start_date != end_date) {
                        const test = datesArray(
                            new Date(start_date),
                            new Date(end_date)
                        );

                        for (let i = 0; i < test.length; i ++ ) {
                            if(test[i].toISOString().slice(0,10) == myDate  ) {
                                alert('You have an event scheduled on this day.')
                                return false;
                            }
                        }
                    }
                });

            });
        });
    </script>
@endsection
