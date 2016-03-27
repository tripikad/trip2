/* Header search */

$(document).on('click', function (e) {
    if (!$('.js-search').is(e.target) &&
        $('.js-search').has(e.target).length === 0) {
        $('.js-search').removeClass('m-active');
   }
});

/* Search tabs */

// $('.js-search-tab').on('click', function(){

//     var data = $(this).data('tab');

//     $('.js-search-tab').removeClass('m-active');
//     $('.js-search-container').removeClass('m-active');

//     $(this).addClass('m-active');
//     $('.js-search-container[data-container='+ data +']').addClass('m-active');

//     return false;
// });


$('.c-search__form-input').on('keyup', function() {
    if($('.c-search__form-input').val()) {
        $(this).closest('.js-search').addClass('m-active');
        $.ajax({
            url: '/search/ajaxsearch',
            type: 'get',
            data: {q: $('.c-search__form-input').val()},
            success: function(response) {
                $('#search_results_div').html(response);
            }
        });
    }
    else $(this).closest('.js-search').removeClass('m-active');
   
});