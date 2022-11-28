@extends('layouts.admin')
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-12 mb-4">
                <div class="d-flex justify-content-between">
                    <h3>Settings -> Status</h3>
                    <button type="button" class="btn btn-warning text-white text-center"  data-bs-toggle="modal" data-bs-target="#new-service-modal">
                        <img src="{{asset('assets/images/icons/add-white.png')}}" alt="...">  &nbsp; &nbsp; &nbsp; &nbsp;Create new service
                    </button>
                </div>
            </div>
            <div class="card w-100">
                <div class="card-body">

                    <div class="table-responsive">
                        <table class="table table-striped" id="service-table">
                            <thead>
                            <tr>
                                <th scope="col">Name</th>
                                <th scope="col">Status</th>
                                <th scope="col"></th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($services as $service)
                                <tr>
                                    <td>{{$service->name}}</td>
                                    <td><span
                                            class="badge rounded-pill {{$service->active == 1 ? 'bg-success' : 'bg-secondary'}}">{{$service->active == 1 ? 'Active' : 'Inactive'}}</span>
                                    </td>
                                    <td>
                                        <div class="d-flex justify-content-center">
                                            <div class="p-1">
                                                <button class="btn btn-info update-service-btn"
                                                        data-bs-toggle="modal" data-bs-target="#update-service-modal"
                                                        data-id="{{$service->id}}"
                                                        data-name="{{$service->name}}"
                                                        data-active="{{$service->active}}"
                                                >Edit</button>

                                            </div>
                                            <div class="p-1">

                                                <a class="btn btn-danger" href="{{route('services.delete',['id' => $service->id])}}"  onclick="return confirm('Are you sure want to delete this service?')">
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

    <div class="modal fade" id="new-service-modal" tabindex="-1" aria-labelledby="new-service-modalLabel"
         aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="new-support-modalLabel">New Service</h5>
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal" aria-label="Close">close</button>
                </div>
                <form method="post" action="{{route('service-store')}}" enctype="multipart/form-data">
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
                        <div class="row g-3 align-items-center mb-3">
                            <div class="col-auto" style="margin-left: 9em;">
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" role="switch" id="flexSwitchCheckChecked" checked>
                                    <label class="form-check-label" for="flexSwitchCheckChecked">Is Active</label>
                                </div>
                            </div>
                        </div>
                        <div class="d-flex bd-highlight mb-3">
                            <div class="p-2 bd-highlight">
                                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                            </div>

                            <div class="ms-auto p-2 bd-highlight">
                                <button type="submit" class="btn btn-warning">Save changes</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="modal fade" id="update-service-modal" tabindex="-1" aria-labelledby="update-service-modalLabel"
         aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="new-support-modalLabel">Update Service</h5>
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal" aria-label="Close">close</button>
                </div>
                <form method="post" action="{{route('service-update')}}" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="id" id="service-id">
                    <div class="modal-body">
                        <div class="row g-3 align-items-center mb-3">
                            <div class="col-auto" style="width: 29%;">
                                <label for="service-name-field" class="col-form-label"> Name</label>
                            </div>
                            <div class="col-auto" style="width: 70%;">
                                <input dir="auto" name="name" type="text" id="service-name-field" class="form-control"
                                       placeholder="Enter name">
                            </div>
                        </div>
                        <div class="row g-3 align-items-center mb-3">
                            <div class="col-auto" style="margin-left: 9em;">
                                <div class="form-check form-switch">
                                    <input name="active" class="form-check-input" type="checkbox" role="switch" id="is-active-field" checked>
                                    <label class="form-check-label" for="is-active-field">Is Active</label>
                                </div>
                            </div>
                        </div>
                        <div class="d-flex bd-highlight mb-3">
                            <div class="p-2 bd-highlight">
                                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                            </div>

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
            let datatable = $('#service-table').DataTable({
                "pageLength": 10,
            });
            $('#service-table').on('error.dt', function (e, settings, techNote, message) {
                console.log('An error has been reported by DataTables: ', message);
            })
            $('#service-table_length').remove();
            $('body').on('click','.update-service-btn',function (e) {
                let id = $(this).attr('data-id');
                let name = $(this).attr('data-name');
                let active = $(this).attr('data-active') == 1 ? true : false;
                $('#service-id').val(id)
                $('#service-name-field').val(name)
                $('#is-active-field').attr('checked',active)
            });
        });
    </script>
@endsection
