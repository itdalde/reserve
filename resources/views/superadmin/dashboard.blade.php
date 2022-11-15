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
                    <th scope="col">CS Cases</th>
                    <th scope="col">Total orders</th>
                    <th scope="col">Actions</th>
                </tr>
                </thead>
                <tbody>

                @foreach($users as $user)
                    <tr>
                        <td>{{$user->first_name . ' ' . $user->last_name}}</td>
                        <td>0</td>
                        <td>{{$user->location }}</td>
                        <td><span class="badge bg-secondary w-100">0 unresolved</span></td>
                        <td>0</td>
                        <td>
                            <a href="">
                                <img src="{{asset('assets/images/icons/preview.png')}}" alt="..">
                            </a>
                            <a href="">
                                <img src="{{asset('assets/images/icons/remove.png')}}" alt="..">
                            </a>
                        </td>
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
            $('#service-provider-table').on('error.dt', function(e, settings, techNote, message) {
                console.log( 'An error has been reported by DataTables: ', message);
            })
            $('#service-provider-table_length').remove();
        } );
    </script>
@endsection
