var selector = $('.js-standalone');

$.each(selector, function () {

    var element = $(this),
        fileName = element.data('name');

    $.get(fileName, function (data) {

        element.after(
            new XMLSerializer().
                serializeToString(data.documentElement)
        );
        element.remove();
    });
});
