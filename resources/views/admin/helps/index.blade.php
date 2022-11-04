@extends('layouts.admin')
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-4">
                <h3>Support</h3>
                <div class="card mb-2" >
                    <div class="card-body">
                        @foreach($inquiries as $inquiry)
                            <a href="#">
                                <div class="card mb-3 border border-secondary" >
                                    <div class="card-body  text-dark">
                                        <h5 class="card-title">{{$inquiry->title}}</h5>
                                        <p class="card-text">{{$inquiry->description}}</p>
                                        <small class="card-text">{{$inquiry->created_at->format('d/m/Y h:i A')}}</small><br>
                                        <span>Issue ID</span> <span class="bg-light-blue">{{$inquiry->reference}}</span>
                                    </div>
                                </div>
                            </a>
                        @endforeach
                        <div class="d-flex justify-content-center">
                            <button type="button" class="btn btn-warning text-white text-center mx-auto"  data-bs-toggle="modal" data-bs-target="#new-support-modal">
                                <img src="{{asset('assets/images/icons/add-white.png')}}" alt="...">  &nbsp; &nbsp; &nbsp; &nbsp;Create new case
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-8">
                <div class="card mt-7 mb-2" >
                    <div class="card-body">
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('content_javascript')
    <script>
        $( document ).ready(function() {
            $('#add-attachment-btn').click(function() {
                $('#support-attachments').click();
            });
        });
    </script>
@endsection
