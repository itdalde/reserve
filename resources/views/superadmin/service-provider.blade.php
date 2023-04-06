@extends('layouts.admin')
@section('content')
    <h3>Service Providers</h3>
    <div class="card" >
        <div class="card-body">
            <table class="table" id="service-provider-table">
                <thead>
                <tr>
                    <th scope="col">Customer name</th>
                    <th scope="col">Company</th>
                    <th scope="col">Sale</th>
                    <th scope="col">Location</th>
                    <th scope="col">Actions</th>
                </tr>
                </thead>
                <tbody>

                @foreach($users as $user)
                    @if((!$user->hasRole('superadmin')))
                        <tr>
                            <td>{{$user->first_name ? $user->first_name . ' ' . $user->last_name : $user->email}}</td>
                            <td>{{$user->company->name }}</td>
                            <td>QAD {{number_format($user->total,2)}}</td>
                            <td>{{$user->location }}</td>
                            <td>
                                <div class="d-flex justify-content-between">
                                    <div style="    padding-top: 6px!important;">

                                        @if($user->confirmed != 1)
                                            <a href="{{route('users.approve-user',['id' => $user->id])}}" onclick="return confirm('Are you sure want to confirm this user?')">
                                                <i class="bi bi-check-circle"></i>
                                            </a>
                                        @endif
                                    </div>
                                    <div class="p-1">

                                        <a href="{{route('users.view-user',['id' => $user->id])}}">
                                            <img src="{{asset('assets/images/icons/preview.png')}}" alt="..">
                                        </a>
                                    </div>
                                    <div class="p-1">

                                        <a href="{{route('users.delete-user',['id' => $user->id])}}"  onclick="return confirm('Are you sure want to delete this user?')">
                                            <img src="{{asset('assets/images/icons/remove.png')}}" alt="..">
                                        </a>
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
@endsection


@section('content_javascript')
    <script type="text/javascript">
        $(document).ready( function () {
            $.fn.dataTable.ext.errMode = 'none';
            let datatable = $('#service-provider-table').DataTable({
                "pageLength": 10,
            });
            $('#service-provider-table').on('error.dt', function(e, settings, techNote, message) {
                console.log( 'An error has been reported by DataTables: ', message);
            })
            $('#service-provider-table_length').remove();
        } );
    </script>
@endsection
