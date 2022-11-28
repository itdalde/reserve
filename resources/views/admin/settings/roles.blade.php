@extends('layouts.admin')
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-12 mb-4">
                <div class="d-flex justify-content-between">
                    <h3>Settings -> Role</h3>
                    <button type="button" class="btn btn-warning text-white text-center"  data-bs-toggle="modal" data-bs-target="#new-role-modal">
                        <img src="{{asset('assets/images/icons/add-white.png')}}" alt="...">  &nbsp; &nbsp; &nbsp; &nbsp;Create new role
                    </button>
                </div>
            </div>
            <div class="card w-100">
                <div class="card-body">

                    <div class="table-responsive">
                        <table class="table table-striped" id="roles-table">
                            <thead>
                            <tr>
                                <th scope="col">Role</th>
                                <th scope="col"></th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($roles as $role)
                                <tr>
                                    <td>{{$role->name}}</td>
                                    <td>
                                        <div class="d-flex justify-content-center">
                                            <div class="p-1">
                                                <button class="btn btn-info update-role-btn"
                                                        data-bs-toggle="modal" data-bs-target="#update-role-modal"
                                                        data-id="{{$role->id}}"
                                                        data-name="{{$role->name}}"
                                                >Edit</button>

                                            </div>
                                            <div class="p-1">

                                                <a class="btn btn-danger" href="{{route('roles.delete',['id' => $role->id])}}"  onclick="return confirm('Are you sure want to delete this role?')">
                                                    Delete
                                                </a>

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

    <div class="modal fade" id="new-role-modal" tabindex="-1" aria-labelledby="new-role-modalLabel"
         aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="new-support-modalLabel">New Role</h5>
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal" aria-label="Close">close</button>
                </div>
                <form method="post" action="{{route('role-store')}}" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <div class="row g-3 align-items-center mb-3">
                            <div class="col-auto" style="width: 29%;">
                                <label for="ticket-modal-title-field" class="col-form-label"> Name</label>
                            </div>
                            <div class="col-auto" style="width: 70%;">
                                <input dir="auto" name="name" type="text" id="ticket-modal-title-field" class="form-control"
                                       placeholder="Enter name">
                            </div>
                        </div>
                        <div class="d-flex bd-highlight mb-3">

                            <div class="ms-auto p-2 bd-highlight">
                                <button type="submit" class="btn btn-warning">Save changes</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="modal fade" id="update-role-modal" tabindex="-1" aria-labelledby="update-role-modalLabel"
         aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="new-support-modalLabel">Update Role</h5>
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal" aria-label="Close">close</button>
                </div>
                <form method="post" action="{{route('role-update')}}" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="id" id="role-id">
                    <div class="modal-body">
                        <div class="row g-3 align-items-center mb-3">
                            <div class="col-auto" style="width: 29%;">
                                <label for="role-name-field" class="col-form-label"> Name</label>
                            </div>
                            <div class="col-auto" style="width: 70%;">
                                <input dir="auto" name="name" type="text" id="role-name-field" class="form-control"
                                       placeholder="Enter name">
                            </div>
                        </div>
                        <div class="d-flex bd-highlight mb-3">
                            <div class="ms-auto p-2 bd-highlight">
                                <button type="submit" class="btn btn-warning">Save changes</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
@section('content_javascript')
    <script>
        $(document).ready(function () {

            $.fn.dataTable.ext.errMode = 'none';
            let datatable = $('#role-table').DataTable({
                "pageLength": 10,
            });
            $('#role-table').on('error.dt', function (e, settings, techNote, message) {
                console.log('An error has been reported by DataTables: ', message);
            })
            $('#role-table_length').remove();
            $('body').on('click','.update-role-btn',function (e) {
                let id = $(this).attr('data-id');
                let name = $(this).attr('data-name');
                $('#role-id').val(id)
                $('#role-name-field').val(name)
            });
        });
    </script>
@endsection
