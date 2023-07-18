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
                        <div class="d-flex flex-column mb-3">
                            <div class="p-1">
                                <h3>{{$occasion['name']}}</h3>
                            </div>
                            <div class="p-1">
                                <span class="badge py-3   rounded-1  bg-secondary">
                                &nbsp;&nbsp;&nbsp;{{count($occasion['service_types'])}} active services &nbsp;&nbsp;&nbsp;
                                </span>
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
                            @foreach($occasion['service_types'] as $serviceType)
                                <tr>
                                    <td>{{$serviceType['service_type']['name']}}</td>
                                    <td>
                                        <div class="d-flex justify-content-center">
                                            <span class="badge py-3  rounded-1 bg-secondary">
                                               &nbsp;&nbsp;&nbsp; {{count($serviceType['vendors'])}} Vendor(s) &nbsp;&nbsp;&nbsp;
                                            </span>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="d-flex justify-content-center">
                                            <div class="p-0 w-50">

                                                <a class="rounded-1 w-100 btn btn-danger"
                                                   href="{{route('occasions-services-type.remove',['id' => $serviceType['service_type_id']])}}"
                                                   onclick="return confirm('Are you sure want to delete this service?')">
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
                            <div class="col-sm-6">
                                <button data-bs-toggle="modal" data-bs-target="#new-service-modal"
                                        class="btn btn-warning text-white text-center w-100" type="button">
                                    Add new Service
                                </button>
                            </div>
                            <div class="col-sm-6">
                                <button data-bs-toggle="modal" data-bs-target="#assign-service-modal"
                                        class="btn btn-success text-white text-center w-100" type="button">
                                    Assign Service
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="assign-service-modal" tabindex="-1" aria-labelledby="assign-service-modalLabel"
         aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="assign-service-modalLabel">Assign Service</h5>
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal" aria-label="Close">close
                    </button>
                </div>
                <form method="post" action="{{route('occasions-services-type.assign')}}">
                    @csrf
                    <input type="hidden" name="occasion_id" value="{{$occasion['id']}}">
                    <div class="modal-body">
                        <div class="row g-3 align-items-center mb-3">
                            <div class="col-auto" style="width: 29%;">
                                <label for="occassion-modal-services-field" class="col-form-label">
                                    Add services to occassion
                                </label>
                            </div>
                            <div class="col-auto" style="width: 70%;">
                                <select multiple class="form-control selectpicker" name="services[]" id="occassion-modal-services-field">
                                   @php
                                   @endphp
                                    @foreach($serviceTypes as $serviceType)
                                        @if(!in_array( $serviceType->id,$typesAssigned))
                                        <option value="{{$serviceType->id}}">{{$serviceType->name}}</option>
                                        @endif
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="d-flex bd-highlight mb-3">
                            <div class="p-2 bd-highlight">
                                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
                            </div>

                            <div class="ms-auto p-2 bd-highlight">
                                <button type="submit" class="btn btn-warning">Save</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="modal fade" id="new-service-modal" tabindex="-1" aria-labelledby="new-service-modalLabel"
         aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="new-service-modalLabel">Add new Service</h5>
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal" aria-label="Close">close
                    </button>
                </div>
                <form method="post" action="{{route('occasions-services-type.store')}}">
                    @csrf
                    <input type="hidden" name="occasion_id" value="{{$occasion['id']}}">
                    <div class="modal-body">
                        <div class="row g-3 align-items-center mb-3">
                            <div class="col-auto" style="width: 29%;">
                                <label for="service-modal-name-field" class="col-form-label">Enter name</label>
                            </div>
                            <div class="col-auto" style="width: 70%;">
                                <input dir="auto" name="name" type="text" id="service-modal-name-field"
                                       class="form-control"
                                       placeholder="Enter service name">
                            </div>
                        </div>

                        <div class="d-flex bd-highlight mb-3">
                            <div class="p-2 bd-highlight">
                                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
                            </div>

                            <div class="ms-auto p-2 bd-highlight">
                                <button type="submit" class="btn btn-warning">Save</button>
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
