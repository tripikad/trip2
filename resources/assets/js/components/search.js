$('.js-search__form-input').on('focus', function(){

    $(this).closest('.js-search').addClass('m-active');
});

$('.js-search__form-input').on('blur', function(){

    $(this).closest('.js-search').removeClass('m-active');
});
