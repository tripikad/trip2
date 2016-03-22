$('.js-flag').stop(true, true).click(function (e){

    e.preventDefault();

    var element = $(this),
        textContainer = element.find('.js-flag-text'),
        icon = element.find('.js-icon'),
        iconFilled = element.find('.js-icon-filled'),
        url = element.attr('href');

    if(url) {

        $.get(url, function(data) {

            if (icon.hasClass('m-active')) {

                icon.removeClass('m-active');
                iconFilled.addClass('m-active');
                element.addClass('m-active');

            } else {

                icon.addClass('m-active');
                iconFilled.removeClass('m-active');
                element.removeClass('m-active');
            }

            textContainer.text(data);
        });
    }
});
