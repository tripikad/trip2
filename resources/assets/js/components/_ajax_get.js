$('.js-ajax_get').click(function (e)
{
    e.preventDefault();

    var element = $(this),
        url = element.attr('href'),
        parent = element.parent();

    element.removeAttr('href');

    if($('.js-visibility', parent).length > 0) {
        $('.js-visibility', parent).hide();
    } else {
        element.hide();
    }

    $.get(url, function() {

        element.parent().remove();
    });
});
