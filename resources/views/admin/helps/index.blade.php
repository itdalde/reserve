@extends('layouts.admin')
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-4">
                <h3>Support</h3>
                <div class="card mb-2" >
                    <div class="card-body">

                        <hr>
                        <div class="alert alert-warning mt-2" role="alert">
                            <p>WhatsApp us:</p>
                            <p>+974-74477814</p>
                            <p> Do not share number with customers this is only for vendors.</p>
                        </div>
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
            $('#new-support-modal').on('hidden.bs.modal', function () {
                $('#list-uploaded-data-help').text('')
            })
            let fileToRead = document.getElementById("support-attachments");
            fileToRead.addEventListener("change", function(event) {
                let numberOfFiles = event.target.files.length;
                for (let i = 0; i < numberOfFiles; i++) {
                    let file = event.target.files[i];
                    const url = window.URL.createObjectURL(file);
                    const a = document.createElement('a');
                    a.href = url;
                    a.text = file.name;
                    a.download = file.name;
                    let element = document.getElementById("list-uploaded-data-help");
                    element.appendChild(a);
                }
            }, false);
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
