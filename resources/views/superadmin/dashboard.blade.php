@extends('layouts.admin')
@section('content')
    <h3>Customers</h3>
    <div class="card" >
        <div class="card-body">
            <table class="table" id="user-table">
                <thead>
                <tr>
                    <th scope="col">Customer name</th>
                    <th scope="col">Last purchase</th>
                    <th scope="col">Location</th>
                    <th scope="col">Total orders</th>
                    <th scope="col">Actions</th>
                </tr>
                </thead>
                <tbody>

                @foreach($users as $user)

                    @if(!$user->hasRole('superadmin'))
                        <tr>
                            <td>{{$user->first_name ? $user->first_name . ' ' . $user->last_name : $user->email}}</td>
                            <td>QAD {{$user->customer_orders && $user->customer_orders->last() ? number_format($user->customer_orders->last()->total_amount,2) : 0.00}}</td>
                            <td>{{$user->location }}</td>
                            <td>{{count($user->customer_orders) }}</td>
                            <td>
                                <a  href="{{route('users.view-user',['id' => $user->id])}}">
                                    <img src="{{asset('assets/images/icons/preview.png')}}" alt="..">
                                </a>
                                <a href="{{route('users.delete-user',['id' => $user->id])}}"  onclick="return confirm('Are you sure want to delete this user?')">
                                    <img src="{{asset('assets/images/icons/remove.png')}}" alt="..">
                                </a>
                            </td>
                        </tr>
                    @endif
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
