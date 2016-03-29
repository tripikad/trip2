$(document).on('click', function (e) {
    if (!$('.js-search').is(e.target) &&
        $('.js-search').has(e.target).length === 0) {
        $('.js-search').removeClass('m-active');
   }
});

$('.c-search__form-input').on('keyup', function() {
    if($('.c-search__form-input').val()) {
        $(this).closest('.js-search').addClass('m-active');
        var header_search = ($(this).attr("id") && $(this).attr("id") == 'search_small')?true:false;
        $.ajax({
            url: '/search/ajaxsearch',
            type: 'get',
            data: {q: $('.c-search__form-input').val(), 'header_search': header_search},
            success: function(response) {
                if(response)
                    $('#search_results_div').html(response);
                else {
                    $('.js-search').removeClass('m-active');
                    $('#search_results_div').html('');
                }
            }
        });
    }
    else $(this).closest('.js-search').removeClass('m-active');
});