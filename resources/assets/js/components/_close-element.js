$('.js-close-element').on('click', function() {

    $(this).parent().slideUp('fast', function() {

        $(this).remove();

    });

});
