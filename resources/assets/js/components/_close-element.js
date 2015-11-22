$('.js-close-element').on('click', function() {

    $(this).hide(function() {

        $(this).parent().remove();

    });

});
