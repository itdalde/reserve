$(document).ready(function () {
    HTMLFormElement.prototype._submit = HTMLFormElement.prototype.submit;
    HTMLFormElement.prototype.submit = function () {
        window.VIEW_LOADING();
        $(this).submit(); // trigger jq submit handler
    }

    $(document).on('submit', 'form', function (e) {
        if(!$(this).hasClass('is-ajax')) {
            e.preventDefault();
            window.VIEW_LOADING();
            this._submit();
        }
    });

    window.VIEW_LOADING = function () {
        document.getElementById("overlay").style.display = "block";
        $('#loader').show();
        setTimeout(function () {
            window.HIDE_LOADING();
        }, 30000);
    }

    window.HIDE_LOADING = function () {
        document.getElementById("overlay").style.display = "none";
        $('#loader').hide();
    }

    $(document).ajaxStart(function() {
        window.VIEW_LOADING();
    });

    $(document).ajaxStop(function() {
        window.HIDE_LOADING();
    });
    $('body').on('change', '#service-image-gallery-file', function () {
        $(".service-image-gallery-holder").empty();//you can remove this code if you want previous user input
        for(let i=0;i<this.files.length;++i){
            let filereader = new FileReader();
            let $img=jQuery.parseHTML("<img class='figure-img img-fluid img-thumbnail image-gallery' src=''>");
            filereader.onload = function(){
                $img[0].src=this.result;
            };
            filereader.readAsDataURL(this.files[i]);
            $(".service-image-gallery-holder").append($img);
        }

    });

    $('body').on('click', '.profile-image-holder', function () {

        $('#profile-image-file').click();
    });

    $('body').on('click', '.company-image-holder', function () {
        $('#company-image-file').click();
    });

    $('body').on('click', '.service-image-holder', function () {
        $(this).closest('.modal').find('#service-image-file').click();
    });
    $('body').on('change', '#service-image-file', function () {
        $('.service-image-error').addClass('d-none');
    });
    $('body').on('keyup', '#service-name', function () {
        $('.service-name-error').addClass('d-none');
    });
    $('body').on('click', '#service-next-btn', function () {
        if($('#service-name').val() == '') {
            $('.service-name-error').removeClass('d-none');
        }
        if ($('#service-image-file').get(0).files.length === 0) {
            $('.service-image-error').removeClass('d-none');
        }
        if($('#service-name').val() == '' || $('#service-image-file').get(0).files.length === 0) {
            return;
        }
        $('.last-step-c, #service-submit-btn, #service-back-btn').removeClass('d-none');
        $('.fist-step-c, #service-next-btn, #service-close-btn').addClass('d-none');
    });
    $('body').on('click', '#service-back-btn', function () {
        $('.last-step-c, #service-submit-btn, #service-back-btn').addClass('d-none')
        $('.fist-step-c, #service-next-btn, #service-close-btn').removeClass('d-none')
    });

    $('body').on('click', '#plan_id', function () {
        if($(this).val() == 1) {
            $('.package-div').addClass('d-none');
        } else {
            $('.package-div').removeClass('d-none');
        }
    });

    $('body').on('click', '#add-addon-data-btn', function () {
        let cloneElem = $('.add-on-div.cloneable').clone().removeClass("cloneable d-none");
        $( '.add-on-div.cloneable' ).after(cloneElem );
        cloneElem.find('.remove-btn-div').removeClass('d-none');
        $('#service-submit-btn').attr('disabled','disabled');
    });
    $('body').on('click', '.remove-addon-data-btn', function () {
        $(this).closest('.add-on-div').remove();
        if($('.add-on-div:visible').length == 0) {
            $('#service-submit-btn').removeAttr('disabled')
        }
    });

    $('body').on('keyup', '.add_on_name', function () {
        if($(this).val() == '') {
            $(this).addClass('border border-danger');
            $('#service-submit-btn').attr('disabled','disabled')
        } else {
            $(this).removeClass('border border-danger');
            $('#service-submit-btn').removeAttr('disabled')
        }
    });

    // $("#create-service").submit(function(e) {
    //     e.preventDefault();
    //     let form = $(this);
    //     let actionUrl = form.attr('action');
    //     $.ajax({
    //         type: "POST",
    //         url: actionUrl,
    //         data: form.serialize(),
    //         beforeSend: function() {
    //             window.VIEW_LOADING();
    //         },
    //         success: function(data) {
    //             window.HIDE_LOADING();
    //             $('#new-service-modal').modal('hide');
    //         }
    //     });
    //
    // });
});
