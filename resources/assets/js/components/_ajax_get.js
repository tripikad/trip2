$('.js-ajax_get').stop(true, true).click(function (e)
{
    e.preventDefault();

    var element = $(this),
        url = element.attr('href'),
        parent = element.parent(),
        remove = 0;

    if(url) {
        if($('.js-visibility', parent).length > 0) {
            $('.js-visibility', parent).hide();
            element.removeAttr('href');
            remove = 1;
        } else {
            element.hide();
        }

        $.get(url, function(data) {

            if(remove === 1) {
                element.parent().remove();
            } else {
                element.html(data).show();
            }
        });
    }
});
