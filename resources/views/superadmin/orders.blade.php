@extends('layouts.admin')
@section('content')
    <h3>Customers</h3>
    <div class="card" >
        <div class="card-body">
            <table class="table" id="user-table">
                <thead>
                <tr>
                    <th scope="col">Customer name</th>
                    <th scope="col">Vendor</th>
                    <th scope="col">Reference No.</th>
                    <th scope="col">Status</th>
                    <th scope="col">Timeline</th>
                    <th scope="col">Amount</th>
                </tr>
                </thead>
                <tbody>

                @foreach($orders as $order)

                    <tr>
                        <td>{{$order['order'] && $order['order']['user'] ? $order['order']['user']['first_name'] .' ' .$order['order']['user']['last_name'] : ''}}</td>
                        <td>{{$order['service'] ? $order ['service']['name'] : ''}}</td>
                        <td>{{$order['order']  ? $order['order']['reference_no'] : ''}}</td>
                        <td>{{$order['status']}}</td>
                        <td>{{$order['timeline']}}</td>
                        <td>QAD {{$order['order']  ? number_format($order['order']['total_amount']) : '0.00'}}</td>
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
