$(document).ready(function () {
    $('body').on('click', '.service-image-holder', function () {
        $('#service-image-file').click();
    });
    $('body').on('click', '#service-next-btn', function () {
        $('.last-step-c, #service-submit-btn, #service-back-btn').removeClass('d-none');
        $('.fist-step-c, #service-next-btn, #service-close-btn').addClass('d-none');
    });
    $('body').on('click', '#service-back-btn', function () {
        $('.last-step-c, #service-submit-btn, #service-back-btn').addClass('d-none')
        $('.fist-step-c, #service-next-btn, #service-close-btn').removeClass('d-none')
    });
});
