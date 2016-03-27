$('.js-radio').on('click', function(){

    var parent = $(this).parent('.js-radio-wrap');

    if(!parent.hasClass('m-active')) {

        $('.js-radio-wrap').removeClass('m-active');
        parent.addClass('m-active');
    }
});