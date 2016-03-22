var alertBox = $('.js-alert'),
    alertTrigger = $('.js-alert__close');

alertTrigger.on('click', function(){

    var $this = $(this),
        parent = $this.parent(alertBox);

    parent.slideUp('slow', function(){

        $(this).remove();
    });

    return false;
});