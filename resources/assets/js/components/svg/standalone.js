var selector = $('.js-standalone');

$.each(selector, function () {

    var element = $(this),
        file_name = element.data('name');

    $.get(file_name, function (data) {

        element.after(new XMLSerializer().serializeToString(data.documentElement));
        element.remove();
    });
});
