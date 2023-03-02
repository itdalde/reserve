@extends('layouts.admin')
@section('content')
    <div class="container">

        <div class="row">
            <div class="col-12">
                <h3>Order List</h3>

                <div class="card mb-2">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table w-100" id="myTable">
                                <thead class="thead-light">
                                <tr>
                                    <th scope="col" style="border-top-left-radius: 11px;background: #F2F1F0;">Name</th>
                                    <th scope="col" style=" background: #F2F1F0;">Order No.</th>
                                    <th scope="col" style=" background: #F2F1F0;">Type</th>
                                    <th scope="col" style=" background: #F2F1F0;">Guests</th>
                                    <th scope="col" style=" background: #F2F1F0;">Date</th>
                                    <th scope="col" style="background: #F2F1F0;">Status</th>
                                    <th scope="col" style="border-top-right-radius: 11px;background: #F2F1F0;">Action
                                    </th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($orders as $order)
                                    <tr data-class="{{$order['status'] == 'pending' ? 'border-card-pending' : 'border-card-accepted'}}">
                                        <td>{{$order['order'] && $order['order']['user'] ? $order['order']['user']['first_name'] . ' ' . $order['order']['user']['last_name'] : ''}}</td>
                                        <td>{{$order['order'] ? $order['order']['reference_no'] : ''}}</td>
                                        <td>{{$order['service'] && $order['service']['price'] && $order['service']['price']['plan_type'] ? $order['service']['price']['plan_type']['name'] : ''}}</td>
                                        <td>{{$order['guests']}}</td>
                                        <td>{{Carbon\Carbon::parse($order['schedule_start_datetime'])->format('F d, Y H:m')}}</td>
                                        <td>
                                            @switch($order['status'])
                                                @case('pending')
                                                <span
                                                    class="status-field w-100 badge bg-warning text-dark text-capitalize">{{$order['status']}}</span>
                                                @break
                                                @case('processing')
                                                <span
                                                    class="status-field w-100 badge bg-secondary text-capitalize">
                                                    {{$order['status']}}
                                                </span>
                                                <br> |-> <small>{{$order['balance'] == 0 ? 'Final Payment received' : ($order['balance'] == $order['total_paid'] ? 'First payment received' : 'No First payment received') }} </small>
                                                @break
                                                @case('declined')
                                                <span
                                                    class="status-field w-100 badge bg-danger text-capitalize">
                                                    {{$order['status']}}
                                                </span>
                                                <br> |-> <small>{{$order['balance'] == 0 ? 'Final Payment received' : ($order['balance'] == $order['total_paid'] ? 'First payment received' : 'No First payment received') }} </small>
                                                @break
                                                @case('completed')
                                                <span
                                                    class="status-field w-100 badge bg-success text-capitalize">{{$order['status']}}</span>
                                                <br> |-> <small>{{$order['balance'] == 0 ? 'Final Payment received' : ($order['balance'] == $order['total_paid'] ? 'First payment received' : 'No First payment received') }} </small>
                                                @break
                                                @case('cancelled')
                                                <span
                                                    class="status-field w-100 badge bg-danger text-capitalize">{{$order['status']}}</span>
                                                <br> |-> <small>{{$order['reason']}}</small>
                                                <br> |-> <small>{{$order['balance'] == 0 ? 'Final Payment received' : ($order['balance'] == $order['total_paid'] ? 'First payment received' : 'No First payment received') }} </small>
                                                @break
                                                @default
                                                <span
                                                    class="status-field w-100 badge bg-primary text-capitalize">{{$order['status']}}</span>
                                                <br> |-> <small>{{$order['balance'] == 0 ? 'Final Payment received' : ($order['balance'] == $order['total_paid'] ? 'First payment received' : 'No First payment received') }} </small>
                                            @endswitch

                                        </td>
                                        <td>
                                            <div class="d-flex justify-content-center w-100">
                                                <div class="px-2 {{$order['status'] == 'pending' ? '' : 'd-none'}}">
                                                    <button type="button"
                                                            class="btn btn-action btn-warning btn-accept-order "
                                                            data-id="{{$order['id']}}" data-action="accept">
                                                        Accept
                                                    </button>
                                                </div>
                                                <div class="px-2 {{$order['status'] == 'pending' ? '' : 'd-none'}} ">
                                                    <button type="button"
                                                            class="btn btn-secondary btn-action btn-decline-order "
                                                            data-id="{{$order['id']}}" data-action="decline">
                                                        Decline
                                                    </button>
                                                </div>
                                                <div
                                                    class="px-2 {{$order['status'] == 'pending' || $order['status'] == 'cancelled' ||$order['status'] == 'completed' || $order['status'] == 'declined' ? 'd-none' : ''}}">
                                                    <button type="button"
                                                            class="btn btn-action btn-warning btn-complete-order  "
                                                            data-id="{{$order['id']}}" data-action="complete">
                                                        Complete
                                                    </button>
                                                </div>
                                                <div class="px-2">
                                                    <a href="orders/{{$order['id']}}"
                                                       class="btn btn-outline-info">View</a>
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
                    let tr = $(that).closest('tr');
                    let status = tr.find('.status-field');
                    switch (action) {
                        case 'accept':
                            status.removeClass('bg-warning bg-danger bg-success').addClass('bg-secondary').text('processing')
                            tr.find('.btn-complete-order, .btn-cancel-order').closest('div').removeClass('d-none');
                            tr.find('.btn-accept-order, .btn-decline-order').closest('div').addClass('d-none');
                            break;
                        case 'decline':
                            status.removeClass('bg-warning bg-secondary bg-success ').addClass('bg-danger').text('declined')
                            tr.find(' .btn-cancel-order').closest('div').removeClass('d-none');
                            tr.find('.btn-complete-order, .btn-accept-order, .btn-decline-order').closest('div').addClass('d-none');
                            break;
                        case 'complete':
                            status.removeClass('bg-warning bg-secondary bg-danger ').addClass('bg-success').text('completed')
                            tr.find('.btn-complete-order, .btn-accept-order, .btn-decline-order, .btn-cancel-order').closest('div').addClass('d-none');
                            break;
                    }
                })
            });

            $.fn.dataTable.ext.errMode = 'none';
            let datatable = $('#myTable').DataTable({
                "pageLength": 10,
                columnDefs: [{type: 'date', 'targets': [4]}],
                order: [[4, 'desc']],
                createdRow: function (row, data, dataIndex) {
                    let classData = $(row).attr('data-class');
                    $(row).addClass(classData);
                },
            });
            $('#myTable').on('error.dt', function (e, settings, techNote, message) {
                console.log('An error has been reported by DataTables: ', message);
            })
            $('#myTable_length').remove();


        });
    </script>
@endsection
