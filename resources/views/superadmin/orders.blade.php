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
                        <td>QAD {{ number_format($order['total_amount'])}}</td>
                        <td>{{$order['total_items']}}</td>
                        <td> <a href="{{route('orders.admin.view',['id'=> $order['id']])}}" class="btn btn-outline-info">View</a></td>
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
