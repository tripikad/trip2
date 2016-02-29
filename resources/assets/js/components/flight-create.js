$('.js-add-flight-dates').on('click', function(){

    $('.js-flight-dates .js-flight-dates-row')
    .clone()
    .append()
    .appendTo('.js-flight-dates-container');

    return false;
});

$(document).on('click', '.js-flight-dates-remove', function() {

    $(this).parents('.js-flight-dates-row').remove();

    return false;
});


$('.js-add-flight-route').on('click', function(){

    $('.js-flight-route .js-flight-route-row')
    .clone()
    .append()
    .appendTo('.js-flight-route-container');

    return false;
});

$(document).on('click', '.js-flight-route-remove', function() {

    $(this).parents('.js-flight-route-row').remove();

    return false;
});
