@extends('layouts.admin')
@section('content')
    <h3>Customer Orders</h3>
    <div class="card" >
        <div class="card-body">
            <table class="table" id="user-table">
                <thead>
                <tr>
                    <th scope="col">Customer name</th>
                    <th scope="col">Contact Details</th>
                    <th scope="col">Reference No.</th>
                    <th scope="col">Status</th>
                    <th scope="col">Timeline</th>
                    <th scope="col">Amount</th>
                    <th scope="col">Quantity</th>
                    <th scope="col">Action</th>
                </tr>
                </thead>
                <tbody>

                @foreach($orders as $order)

                    <tr>
                        <td>{{$order['user'] ? $order['user']['first_name'] .' ' .$order['user']['last_name'] : ''}}</td>
                        <td>{{$order['contact_details'] }}</td>
                        <td>{{$order['reference_no'] }}</td>
                        <td>{{$order['status']}}</td>
                        <td>{{$order['timeline']}}</td>
                        <td>QAD {{ number_format($order['total_amount'],2)}}</td>
                        <td>{{$order['total_items']}}</td>
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
                                <div class="px-2">
                                    <a href="{{route('orders.admin.view',['id'=> $order['id']])}}" class="btn btn-outline-info">View</a>
                                </div>
                            </div> </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection

@section('content_javascript')
    <script type="text/javascript">
        $(document).ready( function () {
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
            $.fn.dataTable.ext.errMode = 'none';
            let datatable = $('#user-table').DataTable({
                "pageLength": 10,
            });
            $('#user-table').on('error.dt', function(e, settings, techNote, message) {
                console.log( 'An error has been reported by DataTables: ', message);
            })
            $('#user-table_length').remove();
        } );
    </script>
@endsection
