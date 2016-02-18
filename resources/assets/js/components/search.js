$('.js-search__form-input').on('focus', function(){
    $(this).closest('.js-search').addClass('m-active');
});

$('.js-search__form-icon').on('click', function(){
    $(this).next($('.js-search__form-input')).focus();
    $(this).closest('.js-search').addClass('m-active');
});

$(document).on('click', function (e) {
    if (!$('.js-search').is(e.target) &&
        $('.js-search').has(e.target).length === 0) {
        $('.js-search').removeClass('m-active');
   }
});
