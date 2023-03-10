@extends('layouts.admin')
@section('content')
    <div class="container">

        <div class="row">
            <div class="col-12">
                <h3>Manage Order</h3>
                <div class="card mb-2">
                    <div class="card-body">

                        <div class="d-flex justify-content-end mb-3">

                            <div class="p2 ">
                                <div class="input-group mb-3">
                                    <input type="text" class="form-control input-group-search" placeholder="Search"
                                           aria-label="Search" aria-describedby="button-addon2">
                                    <button class="btn btn-outline-secondary btn-search-input-group " type="button"
                                            id="button-addon2"><i class="bi bi-search"></i></button>
                                </div>
                            </div>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-hover" id="table-manage-orders" aria-label="Table Order">
                                <thead class="thead-light">
                                <tr>
                                    <th scope="col" style="border-top-left-radius: 11px;background: #F2F1F0;">Name</th>
                                    <th scope="col" style=" background: #F2F1F0;">Reference No.</th>
                                    <th scope="col" style=" background: #F2F1F0;">Type</th>
                                    <th scope="col" style=" background: #F2F1F0;">Volume</th>
                                    <th scope="col" style=" background: #F2F1F0;">Date</th>
                                    <th scope="col" style=" background: #F2F1F0;">Status</th>
                                    <th scope="col" style="border-top-right-radius: 11px;background: #F2F1F0;">Actions</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($orders as $order)
                                    @if($order['order']['user'])
                                        <tr>
                                            <td>
                                                <div class="py-2">
                                                    {{$order['order']['user']['first_name'] . ' ' . $order['order']['user']['last_name']}}

                                                </div>
                                            </td>
                                            <td>
                                                <div class="py-2">
                                                    {{$order['order']['reference_no']}}
                                                </div>
                                            </td>
                                            <td>
                                                <div class="py-2">{{$order['service']['price']['plan_type']['name']}}</td>
                                            <td>
                                                <div class="py-2">1 Service
                                                </div>
                                            </td>
                                            <td>
                                                <div
                                                    class="py-2">{{Carbon\Carbon::parse($order['created_at'])->format('F d, Y')}}

                                                </div>
                                            </td>

                                            <td>
                                                <div class="py-2">
                                                    @switch($order['status'])
                                                        @case('pending')
                                                        <span
                                                            class="status-field w-100 badge bg-warning text-dark text-capitalize">{{$order['status']}}</span>
                                                        @break
                                                        @case('accepted')
                                                        <span
                                                            class="status-field w-100 badge bg-secondary text-capitalize">{{$order['status']}}</span>
                                                        @break
                                                        @case('declined')
                                                        <span
                                                            class="status-field w-100 badge bg-danger text-capitalize">{{$order['status']}}</span>
                                                        @break
                                                        @case('completed')
                                                        <span
                                                            class="status-field w-100 badge bg-success text-capitalize">{{$order['status']}}</span>
                                                        @break
                                                        @case('cancelled')
                                                        <span
                                                            class="status-field w-100 badge bg-danger text-capitalize">{{$order['status']}}</span>
                                                        @break
                                                        @default
                                                        <span
                                                            class="status-field w-100 badge bg-primary text-capitalize">{{$order['status']}}</span
                                                    @endswitch
                                                </div>

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
                                                        class="px-2 {{$order['status'] == 'pending' || $order['status'] == 'cancelled' || $order['status'] == 'declined' ? 'd-none' : ''}}">
                                                        <button type="button"
                                                                class="btn btn-action btn-warning btn-complete-order  "
                                                                data-id="{{$order['id']}}" data-action="complete">
                                                            Complete
                                                        </button>
                                                    </div>
                                                    <div class="px-2  {{$order['status'] == 'accepted' ? '' : 'd-none'}}">
                                                        <button type="button"
                                                                class="btn btn-action btn-danger btn-cancel-order "
                                                                data-id="{{$order['id']}}" data-action="cancel">
                                                            Cancel
                                                        </button>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                    @endif
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
            let datatable = $('#table-manage-orders').DataTable({
                "pageLength": 10,
                "columnDefs": [{"orderable": false, "targets": 6}]
            }).on('error.dt', function (e, settings, techNote, message) {
                console.log('An error has been reported by DataTables: ', message);
            })
            $('#table-manage-orders_length, #table-manage-orders_filter').remove();

            $(document).on('click', '.btn-search-input-group', function () {
                datatable.search(this.value).draw();
            });

            $(document).on('focus', '.input-group-search', function () {
                $(this).unbind().bind('keyup', function (e) {
                    if (e.keyCode === 13) {
                        datatable.search(this.value).draw();
                    }
                });
            });
        });
    </script>
@endsection

