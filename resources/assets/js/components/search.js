$(document).on('click', function (e) {
    if (!$('.js-search').is(e.target) &&
        $('.js-search').has(e.target).length === 0) {
        $('.js-search').removeClass('m-active');
   }
});

var searchInput = '.c-search__form-input',
    searchRequest = null;
$(searchInput).on('keypress keyup keydown click change', function() {
    if($(searchInput).val()) {
        if (searchRequest) {
            searchRequest.abort();
        }

        $(this).closest('.js-search').addClass('m-active');
        var headerSearch = ($(this).attr('id') && $(this).attr('id') == 'search_small')?1:0;
        searchRequest = $.ajax({
            url: '/search/ajaxsearch',
            type: 'get',
            data: {q: $('.c-search__form-input').val(), 'header_search': headerSearch},
            success: function(response) {
                if (response) {
                    $('#search_results_div').html(response);
                } else {
                    $('#search_results_div').hide();
                }
            }
        });
    }
    else {
        $(this).closest('.js-search').removeClass('m-active');
    }
});