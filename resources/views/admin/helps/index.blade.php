@extends('layouts.admin')
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-4">
                <h3>Support</h3>
                <div class="card mb-2" >
                    <div class="card-body">
                        <ul class="nav nav-tabs" id="myTab" role="tablist">
                            <li class="nav-item" role="presentation">
                                <button class="nav-link active" id="activeInquiries-tab" data-bs-toggle="tab" data-bs-target="#activeInquiries" type="button" role="tab" aria-controls="activeInquiries" aria-selected="true">Active ({{count($activeInquiries)}})</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="inActiveInquiries-tab" data-bs-toggle="tab" data-bs-target="#inActiveInquiries" type="button" role="tab" aria-controls="inActiveInquiries" aria-selected="false">Closed ({{count($inActiveInquiries)}})</button>
                            </li>
                        </ul>
                        <div class="tab-content" id="myTabContent">
                            <div class="tab-pane fade show active" id="activeInquiries" role="tabpanel" aria-labelledby="activeInquiries-tab" style="min-height: 140px;">
                                @foreach($activeInquiries as $inquiry)
                                    <a class="link-inquiry-c"
                                       data-id="{{$inquiry->id}}"
                                       data-title="{{$inquiry->title}}"
                                       data-description="{{$inquiry->description}}"
                                       data-issue-id="{{$inquiry->reference}}"
                                       data-issue-date="{{$inquiry->created_at->format('d/m/Y h:i A')}}"
                                       data-user-id="{{$inquiry->user->id}}"
                                       data-user-image="{{$inquiry->user->profile_picture}}"
                                       data-user-name="{{$inquiry->user->first_name .' '. $inquiry->user->last_name }}"
                                       href="#">
                                        <div class="card mb-3 border border-secondary card-border-orange" >
                                            <div class="card-body  text-dark">
                                                <h5 class="card-title">#{{$inquiry->id}} {{$inquiry->title}}</h5>
                                                <p class="card-text">{{ substr_replace($inquiry->description, "...", 150)}}</p>
                                                <small class="card-text">{{$inquiry->created_at->format('d/m/Y h:i A')}}</small><br>
                                                <span>Issue ID</span> <span class="bg-light-blue">{{$inquiry->reference}}</span>
                                            </div>
                                        </div>
                                    </a>
                                @endforeach
                            </div>
                            <div class="tab-pane fade" id="inActiveInquiries" role="tabpanel" aria-labelledby="inActiveInquiries-tab" style="min-height: 140px;">
                                @foreach($inActiveInquiries as $inquiry)
                                    <a class="link-inquiry-c" href="#"
                                       data-id="{{$inquiry->id}}"
                                       data-title="{{$inquiry->title}}"
                                       data-description="{{$inquiry->description}}"
                                       data-issue-id="{{$inquiry->reference}}"
                                       data-issue-date="{{$inquiry->created_at->format('d/m/Y h:i A')}}"
                                       data-user-id="{{$inquiry->user->id}}"
                                       data-user-image="{{$inquiry->user->profile_picture}}"
                                       data-user-name="{{$inquiry->user->first_name .' '. $inquiry->user->last_name }}">
                                        <div class="card mb-3 border border-secondary card-border-orange" >
                                            <div class="card-body  text-dark">
                                                <h5 class="card-title">#{{$inquiry->id}} {{$inquiry->title}}</h5>
                                                <p class="card-text">{{ substr_replace($inquiry->description, "...", 150)}}</p>
                                                <small class="card-text">{{$inquiry->created_at->format('d/m/Y h:i A')}}</small><br>
                                                <span>Issue ID</span> <span class="bg-light-blue">{{$inquiry->reference}}</span>
                                            </div>
                                        </div>
                                    </a>
                                @endforeach
                            </div>
                        </div>
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
                        <div class="d-flex bd-highlight mb-3">
                            <div class="p-2 bd-highlight"><h3 class="issue-title"></h3></div>
                            <div class="ms-auto p-2 bd-highlight">Active support agent <span class="issue-support-user"></span></div>
                        </div>

                        <div class="d-flex bd-highlight mb-3">
                            <div class="p-2 bd-highlight">Issue ID <span class="issue-reference-id bg-light-blue"></span></div>
                            <div class="ms-auto p-2 bd-highlight"><span class="issue-date"></span></div>
                        </div>

                        <div class="card mt-7 mb-2" >
                            <div class="card-body">
                                <div class="d-flex bd-highlight mb-3">
                                    <div class="p-2 bd-highlight"><img width="50" class="img-circle issue-user-image" src="" alt="..."></div>
                                    <div class="p-2 bd-highlight"><span class="issue-user-name"></span></div>
                                    <div class="ms-auto p-2 bd-highlight"><span class="issue-date"></span></div>
                                </div>
                                <div class="d-flex flex-column bd-highlight mb-3">
                                    <div class="p-2 bd-highlight issue-description"></div>
                                </div>
                            </div>
                        </div>
                        <div class="replies-holder mb-2">
                        </div>
                        <form class="d-inline-flex w-100" id="reply-form" enctype="multipart/form-data" action="{{route('issues-reply')}}" method="post">
                            @csrf
                            <div class="input-group">
                                <input type="hidden" name="issue_id" id="issue_id" value="">
                                <input type="hidden" name="owner_id" id="owner_id" value="">
                                <input multiple name="images[]" type="file" class="d-none" id="issue-attachment-replies">
                                <input name="reply" id="issue-reply-input" style="border-left: 1px solid #7e7b7b6b; border-right: none;" type="text" class="form-control" aria-label="Type your reply" placeholder="Type your message">
                                <span class="input-group-text"><img id="issue-attachment-replies-preview" src="{{asset('assets/images/icons/attachments.png')}}" alt=""></span>
                                <span style="border-right: 1px solid #7e7b7b6b;" class="input-group-text"><button id="issue-reply-btn" type="submit" class="btn btn-warning">Send</button></span>
                            </div>
                        </form>
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
            $('#issue-attachment-replies-preview').click(function() {
                $('#issue-attachment-replies').click();
            });

            function fetchReplies() {

                $.ajax({
                    method: "GET",
                    data: {
                        inquiries_id: $('#issue_id').val()
                    },
                    url: "{{route('issues-replies')}}",
                    beforeSend: function() {
                        $('#db-wrapper').addClass('blur-bg');
                        $('#loader').show();
                    },
                    success:function(data){
                        $('#db-wrapper').removeClass('blur-bg');
                        $('#loader').hide();
                        $('.replies-holder').html('');
                        $('.replies-holder').append(data)
                    },
                    error: function(data){
                        console.log("error");
                        console.log(data);
                    }
                });
            }
            $('#reply-form').on('submit',(function(e) {
                e.preventDefault();
                let formData = new FormData(this);

                $.ajax({
                    type:'POST',
                    url: $(this).attr('action'),
                    data:formData,
                    cache:false,
                    contentType: false,
                    processData: false,
                    beforeSend: function() {
                        $('#db-wrapper').addClass('blur-bg');
                        $('#loader').show();
                    },
                    success:function(data){
                        $('#db-wrapper').removeClass('blur-bg');
                        $('#loader').hide();
                        fetchReplies()
                    },
                    error: function(data){
                        console.log("error");
                        console.log(data);
                    }
                });
            }));
            setTimeout(function () {
                $('#activeInquiries > a:nth-child(1)').click();
            }, 1000);
            $('#activeInquiries > a').click();
            $('body').on('click','.link-inquiry-c', function() {
                let id =  $(this).attr('data-id');
                let title =  $(this).attr('data-title');
                let issueId =  $(this).attr('data-issue-id');
                let issueDate =  $(this).attr('data-issue-date');
                let userId =  $(this).attr('data-user-id');
                let userName =  $(this).attr('data-user-name');
                let description =  $(this).attr('data-description');
                let userImage =  $(this).attr('data-user-image');
                $('.issue-title').text('#' +id+ ' ' +title)
                $('.issue-reference-id').text(issueId)
                let image = '{{asset('images/blank-profile-picture.png')}}';
                if(userImage) {
                    image = userImage;
                }
                $('#owner_id').val(userId);
                $('#issue_id').val(id);
                $('.issue-user-image').attr('src',image)
                $('.issue-date').text(issueDate)
                $('.issue-user-name').text(userName)
                $('.issue-description').text(description)
                fetchReplies();
            });
        });
    </script>
@endsection
