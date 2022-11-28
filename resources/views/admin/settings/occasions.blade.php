@extends('layouts.admin')
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-12 mb-4">
                <div class="d-flex justify-content-between">
                    <h3>Settings -> Occasions</h3>
                    <button type="button" class="btn btn-warning text-white text-center"  data-bs-toggle="modal" data-bs-target="#new-occasion-modal">
                        <img src="{{asset('assets/images/icons/add-white.png')}}" alt="...">  &nbsp; &nbsp; &nbsp; &nbsp;Create new occasion
                    </button>
                </div>
            </div>
            <div class="card w-100">
                <div class="card-body">

                    <div class="table-responsive">
                        <table class="table table-striped" id="occasions-table">
                            <thead>
                                <tr>
                                    <th scope="col">Occasion</th>
                                    <th scope="col">Image</th>
                                    <th scope="col">Status</th>
                                    <th scope="col"></th>
                                </tr>
                            </thead>
                            <tbody>
                            @foreach($occasions as $occasion)
                                <tr>
                                    <td>{{$occasion->name}}</td>
                                    <td><img src="{{asset($occasion->logo)}}" alt="...">
                                    </td>
                                    <td><span
                                            class="badge rounded-pill {{$occasion->active == 1 ? 'bg-success' : 'bg-secondary'}}">{{$occasion->active == 1 ? 'Active' : 'Inactive'}}</span>
                                    </td>
                                    <td>
                                        <div class="d-flex justify-content-center">
                                            <div class="p-1">
                                                <button class="btn btn-info update-occasion-btn"
                                                        data-bs-toggle="modal" data-bs-target="#update-occasion-modal"
                                                        data-id="{{$occasion->id}}"
                                                        data-name="{{$occasion->name}}"
                                                        data-logo="{{asset($occasion->logo)}}"
                                                        data-active="{{$occasion->active}}"
                                                >Edit</button>

                                            </div>
                                            <div class="p-1">

                                                <a class="btn {{$occasion->active == 1 ? 'btn-danger' : 'btn-warning'}}" href="{{route('occasions.delete-occasion',['id' => $occasion->id,'active' => $occasion->active])}}"  onclick="return confirm('Are you sure want to update its status?')">
                                                    {{$occasion->active == 1 ? 'Deactivate' : 'Activate'}}
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

    <div class="modal fade" id="new-occasion-modal" tabindex="-1" aria-labelledby="new-occasion-modalLabel"
         aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="new-support-modalLabel">New Occasion</h5>
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal" aria-label="Close">close</button>
                </div>
                <form method="post" action="{{route('occasion-store')}}" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <div class="row g-3 align-items-center mb-3">
                            <div class="col-auto" style="width: 29%;">
                                <label for="ticket-modal-title-field" class="col-form-label">Enter Name</label>
                            </div>
                            <div class="col-auto" style="width: 70%;">
                                <input dir="auto" name="title" type="text" id="ticket-modal-title-field" class="form-control"
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
                        <div class="row g-3 align-items-center mb-3">
                            <div class="col-auto" style="margin-left: 9em;">

                                <div class="d-flex justify-content-between flex-wrap">
                                    <a href="#" class="service-image-holder">
                                        <img width="200" id="service-new-image-view"
                                             src="{{asset('assets/images/icons/image-select.png')}}" alt="image-select">
                                    </a>
                                </div>
                                <input
                                    onchange="document.getElementById('service-new-image-view').src = window.URL.createObjectURL(this.files[0])"
                                    id="service-image-file" accept="image/png, image/gif, image/jpeg" type="file"
                                    class="d-none" name="featured_image" >

                                <div class="service-image-error alert alert-danger d-none mt-2" role="alert">
                                    Please add image first
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
    <div class="modal fade" id="update-occasion-modal" tabindex="-1" aria-labelledby="update-occasion-modalLabel"
         aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="new-support-modalLabel">Update Occasion</h5>
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal" aria-label="Close">close</button>
                </div>
                <form method="post" action="{{route('occasion-update')}}" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="id" id="occasion-id">
                    <div class="modal-body">
                        <div class="row g-3 align-items-center mb-3">
                            <div class="col-auto" style="width: 29%;">
                                <label for="occasion-name-field" class="col-form-label">Occasion Name</label>
                            </div>
                            <div class="col-auto" style="width: 70%;">
                                <input dir="auto" name="title" type="text" id="occasion-name-field" class="form-control"
                                       placeholder="Enter Occasion name">
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
                        <div class="row g-3 align-items-center mb-3">
                            <div class="col-auto" style="margin-left: 9em;">

                                <div class="d-flex justify-content-between flex-wrap">
                                    <a href="#" class="service-image-holder">
                                        <img width="200" id="service-image-view"
                                             src="{{asset('assets/images/icons/image-select.png')}}" alt="image-select">
                                    </a>
                                </div>
                                <input
                                    onchange="document.getElementById('service-image-view').src = window.URL.createObjectURL(this.files[0])"
                                    id="service-image-file" accept="image/png, image/gif, image/jpeg" type="file"
                                    class="d-none" name="image" >

                                <div class="service-image-error alert alert-danger d-none mt-2" role="alert">
                                    Please add image first
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
            let datatable = $('#occasions-table').DataTable({
                "pageLength": 10,
            });
            $('#occasions-table').on('error.dt', function (e, settings, techNote, message) {
                console.log('An error has been reported by DataTables: ', message);
            })
            $('#occasions-table_length').remove();
            $('body').on('click','.update-occasion-btn',function (e) {
                let id = $(this).attr('data-id');
                let name = $(this).attr('data-name');
                let logo = $(this).attr('data-logo');
                let active = $(this).attr('data-active') == 1 ? true : false;
                $('#occasion-id').val(id)
                $('#service-image-view').attr('src',logo)
                $('#occasion-name-field').val(name)
                $('#is-active-field').attr('checked',active)
            });
        });
    </script>
@endsection
