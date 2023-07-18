@extends('layouts.admin')
@section('content')
    <style>
        .bg-success {
            background-color: #14DA4B !important;
        }
    </style>
    <div class="container">
        <div class="row">
            <div class="col">
                <div class="card mb-2">
                    <div class="card-body">
                        <div class="d-flex flex-row bd-highlight mb-3">
                            <div class="p-1">
                                <h3>Occassions</h3>
                            </div>
                            <div class="p-1">
                                <div class="input-group mb-3">
                                      <span class="input-group-text">
                                        <i class="bi bi-search"></i>
                                      </span>
                                    <input id="occassions-search-input" type="text" class="form-control"
                                           placeholder="Search">
                                </div>
                            </div>
                        </div>
                        <table class="table w-100 service-table" id="occassions-table">
                            <thead>
                            <tr class="d-none">
                                <th scope="col">Name</th>
                                <th scope="col">Status</th>
                                <th scope="col">Services</th>
                                <th scope="col"></th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($occasions as $occasion)
                                <tr>
                                    <td>{{$occasion['name']}}</td>
                                    <td>
                                        <div class="d-flex justify-content-center">
                                            <span
                                                class="badge py-3 w-75 rounded-0 {{$occasion['active'] == 1 ? 'bg-success' : 'bg-secondary'}}">
                                                {{$occasion['active'] == 1 ? 'Active' : 'Inactive'}}
                                            </span>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="d-flex justify-content-center">
                                            <span class="badge py-3 w-75 rounded-0 bg-secondary">
                                                {{count($occasion['service_types'])}}  {{count($occasion['service_types']) > 1 ? 'Services' : 'Service' }}
                                            </span>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="d-flex justify-content-center">
                                            <div class="p-0 w-50">
                                                <a href="{{ route('occasions-services.edit',['id' => $occasion['id']]) }}" type="button" class="rounded-0 w-100 btn btn-info">
                                                    Edit
                                                </a>

                                            </div>
                                            <div class="p-0">
                                                &nbsp; &nbsp;
                                            </div>
                                            <div class="p-0 w-50">

                                                <a class="rounded-0 w-100 btn btn-danger"
                                                   href="{{route('occasions-services.remove',['id' => $occasion['id']])}}"
                                                   onclick="return confirm('Are you sure want to delete this occassion?')">
                                                    Delete
                                                </a>

                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                        <div class="row mt-3">
                            <div class="col">
                                <button data-bs-toggle="modal" data-bs-target="#new-occassion-modal"
                                        class="btn btn-warning text-white text-center w-100" type="button">
                                    Add new Occassion
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <input type="hidden" id="occassion-names" value="{{$occasionNames}}">
    </div>

    <div class="modal fade" id="new-occassion-modal" tabindex="-1" aria-labelledby="new-occassion-modalLabel"
         aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="new-occassion-modalLabel">Add new Occassion</h5>
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal" aria-label="Close">close
                    </button>
                </div>
                <form method="post" action="{{route('occasions-services.store')}}">
                    @csrf
                    <div class="modal-body">
                        <div class="row g-3 align-items-center mb-3">
                            <div class="col-auto" style="width: 29%;">
                                <label for="occassion-modal-name-field" class="col-form-label">Enter name</label>
                            </div>
                            <div class="col-auto" style="width: 70%;">
                                <input dir="auto" name="name" type="text" id="occassion-modal-name-field"
                                       class="form-control"
                                       placeholder="Enter occassion name">
                            </div>
                        </div>

                        <div class="row g-3 align-items-center mb-3">
                            <div class="col-auto" style="width: 29%;">
                                <label for="occassion-modal-services-field" class="col-form-label">
                                    Add services to occassion
                                </label>
                            </div>
                            <div class="col-auto" style="width: 70%;">
                                <select multiple class="form-control selectpicker" name="services[]" id="occassion-modal-services-field">
                                    @foreach($serviceTypes as $serviceType)
                                        <option value="{{$serviceType->id}}">{{$serviceType->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="d-flex bd-highlight mb-3">
                            <div class="p-2 bd-highlight">
                                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
                            </div>

                            <div class="ms-auto p-2 bd-highlight">
                                <button  id="occassion-modal-brn-save" type="submit" class="btn btn-warning">Save</button>
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
            $('body').on('keyup','#occassion-modal-name-field',function (e) {
                let names = $('#occassion-names').val();
                names = JSON.parse(names);
                if(names.includes($(this).val().trim())) {
                    toastr.error('Duplicate name found ' + $(this).val() )
                    $('#occassion-modal-brn-save').attr('disabled',true);
                } else {
                    $('#occassion-modal-brn-save').removeAttr('disabled');
                }
            });
            $.fn.dataTable.ext.errMode = 'none';
            let datatable = $('#occassions-table').DataTable({
                "pageLength": 10000,
            }).on('error.dt', function (e, settings, techNote, message) {
                console.log('An error has been reported by DataTables: ', message);
            })
            $('#occassions-table_length, #occassions-table_filter,.dataTables_info,.dataTables_paginate').remove();


            $(document).on('focus', '#occassions-search-input', function () {
                $(this).unbind().bind('keyup', function (e) {
                    datatable.search(this.value).draw();
                });
            });
            $('.selectpicker').selectpicker();
        });
    </script>
@endsection
