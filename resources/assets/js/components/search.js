$(document).on('click', function (e) {
    if (!$('.js-search').is(e.target) &&
        $('.js-search').has(e.target).length === 0) {
        $('.js-search').removeClass('m-active');
   }
});

/*
var searchInput = '.c-search__form-input',
    searchRequest = null;

$(searchInput).on('keypress keyup keydown click change', function() {

    if($(searchInput).val()) {
        var searchObject = this,
            jsSearchElement = $(searchObject).closest('.js-search'),
            searchType = '#js-search-type';

        if (searchRequest) {
            searchRequest.abort();
        }

        if (!jsSearchElement.hasClass('.m-active')) {
            jsSearchElement.addClass('m-active');
        }

        if ($(searchType).length && $(searchType).val()) {
            searchType = {types: $(searchType).val()};
        } else {
            searchType = {};
        }

        var headerSearch = ($(this).attr('id') && $(this).attr('id') == 'search_small')?1:0;
        searchRequest = $.ajax({
            url: '/search/ajaxsearch',
            type: 'get',
            data: $.extend({q: $('.c-search__form-input').val(), 'header_search': headerSearch}, searchType),
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
});*/
