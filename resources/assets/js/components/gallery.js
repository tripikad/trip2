
var galleryModal = $('.js-gallery-modal'),
    galleryNext = $('.js-gallery-modal-next'),
    galleryPrevious = $('.js-gallery-modal-previous'),
    galleryClose = $('.js-gallery-modal-close'),
    galleryImageContainer = $('.js-gallery-modal-images'),
    galleryThumbContainer = $('.js-gallery-modal-thumbs'),
    galleryTrigger = $('.js-gallery-modal-trigger'),
    galleryImageItem,
    galleryThumbItem,
    galleryDesktopLarge = 1520,
    galleryDesktopMedium = 1440,
    winWidth = $(window).width(),
    nudge,
    offset,
    galleryInstalled = null;

$(window).on('resize', function(){

    winWidth = $(window).width();
});


if (winWidth >= galleryDesktopLarge) {

    offset = 168;

} else if (winWidth >= galleryDesktopMedium) {

    offset = 156;

} else {

    offset = 144;
}

// Functions

// Moves the thumb container to the left

var nudgeNegative = function(slideIndex) {

    if (slideIndex > 7) {

        nudge =  (slideIndex - 7) * offset;

        galleryThumbContainer.css({
            'left' : '-'+ nudge +'px'
        });

    } else if (slideIndex === 0) {

        nudge = 0;

        galleryThumbContainer.css({
            'left' : nudge
        });

    }
};

// Moves the thumb container to the right

var nudgePositive = function(slideIndex) {

    if (slideIndex < galleryImageItem.length - 8) {

        nudge = nudge - offset;

    } else if (slideIndex === galleryImageItem.length - 1) {

        nudge = (galleryImageItem.length - 8) * offset;
    }

    galleryThumbContainer.css({
        'left' : '-'+ nudge +'px'
    });
};

// Open gallery and fill it with content

galleryTrigger.find('a').on('click', function(event) {
    event.preventDefault();
    event.stopPropagation();
    galleryTrigger.trigger('click');
});

galleryTrigger.stop(true, true).on('click', function() {

    if (!galleryInstalled) {
        var images = galleryModal.data('images');

        var currentSlide;
        var currentSlideIndex;

        // Show image based on click

        currentSlide = galleryTrigger.filter($(this));
        currentSlideIndex = galleryTrigger.index(currentSlide);

        $.each(images , function(index, value){

            // Add images and thumbs

            if(index === currentSlideIndex) {

                galleryImageContainer.append(
                    $('<div>')
                        .addClass('c-gallery__modal-image')
                        .addClass('m-active')
                        .addClass('js-gallery-modal-image')
                        .append('<img src="'+ value.image +'">')
                );

                galleryThumbContainer.append(
                    $('<div>')
                        .addClass('c-gallery__modal-thumb')
                        .addClass('m-active')
                        .addClass('js-gallery-modal-thumb')
                        .css({
                            'background-image': 'url('+value.image+')'
                        })
                );
            } else {

                galleryImageContainer.append(
                    $('<div>')
                        .addClass('c-gallery__modal-image')
                        .addClass('js-gallery-modal-image')
                        .append('<img src="'+ value.image +'">')
                );

                galleryThumbContainer.append(
                    $('<div>')
                        .addClass('c-gallery__modal-thumb')
                        .addClass('js-gallery-modal-thumb')
                        .css({
                            'background-image': 'url('+value.image+')'
                        })
                );
            }

            // Add title if available

            if(typeof value.title !== 'undefined' && value.title.length > 0) {

                $('.c-gallery__modal-image')
                    .eq(index)
                    .append(
                    $('<div>')
                        .addClass('c-gallery__modal-title')
                        .text(value.title)
                        .append(
                            $('<br>'),
                            $('<a>')
                                .attr("href", value.userRoute.length > 0 ? value.userRoute : '#')
                                .text(value.userName.length > 0 ? "Lisas: " + value.userName: '')
                        )
                );
            }

            // Add tags if available

            if(typeof value.tags !== 'undefined' && value.tags.length > 0) {

                $('.c-gallery__modal-image').eq(index)
                    .append(
                    $('<div>')
                        .addClass('c-gallery__modal-tags')
                        .append(
                        $('<ul>')
                            .addClass('c-tags m-small')
                    )
                );

                $.each(value.tags , function(tagindex, tag){

                    $('.c-gallery__modal-image').eq(index).find('.c-tags')
                        .append(
                        $('<li>')
                            .addClass('c-tags__item '+ tag.modifiers)
                            .append(
                            $('<a>')
                                .attr('href', tag.route)
                                .addClass('c-tags__item-link')
                                .text(tag.name)
                        )
                    );
                });
            }
        });

        // If clicked image does not fit in the container of 8
        // then nudge the container

        if (currentSlideIndex > 7) {

            nudgeNegative(currentSlideIndex);
        }

        // Show modal

        galleryModal.addClass('m-active');

        // Assign variables

        galleryImageItem = $('.js-gallery-modal-image');
        galleryThumbItem = $('.js-gallery-modal-thumb');
        galleryInstalled = true;
    }

    return false;
});

// Close gallery

galleryClose.on('click', function(){

    galleryModal.removeClass('m-active');
    galleryImageItem.remove();
    galleryThumbItem.remove();
    nudge = 0;
    galleryInstalled = null;

    return false;
});

// Next image

galleryNext.on('click', function(){

    var currentSlide,
        currentSlideIndex,
        nextSlideIndex;

    // Get slide info

    currentSlide = galleryImageItem.filter('.m-active');
    currentSlideIndex = galleryImageItem.index(currentSlide);

    if (currentSlideIndex + 1 >= galleryImageItem.length) {

        nextSlideIndex = 0;

    } else {

        nextSlideIndex = currentSlideIndex + 1;
    }

    // Nudge container left if necessary

    nudgeNegative(nextSlideIndex);

    // Change main image

    galleryImageItem.removeClass('m-active');
    galleryImageItem.eq(nextSlideIndex).addClass('m-active');

    // Change thumb image

    galleryThumbItem.removeClass('m-active');
    galleryThumbItem.eq(nextSlideIndex).addClass('m-active');

    return false;
});

// Previous image

galleryPrevious.on('click', function(){

    var currentSlide,
        currentSlideIndex,
        nextSlideIndex;

    // Get slide info

    currentSlide = galleryImageItem.filter('.m-active');
    currentSlideIndex = galleryImageItem.index(currentSlide);

    if (currentSlideIndex - 1 < 0) {

        nextSlideIndex = galleryImageItem.length - 1;

    } else {

        nextSlideIndex = currentSlideIndex - 1;
    }

    nudgePositive(nextSlideIndex);

    // Change main image

    galleryImageItem.removeClass('m-active');
    galleryImageItem.eq(nextSlideIndex).addClass('m-active');

    // Change thumb image

    galleryThumbItem.removeClass('m-active');
    galleryThumbItem.eq(nextSlideIndex).addClass('m-active');

    return false;
});

// On thumb click

galleryThumbContainer.on('click', 'div', function() {

    var currentSlideIndex;

    // Get slide info

    currentSlideIndex = $(this).index();

    // Change main image

    galleryImageItem.removeClass('m-active');
    galleryImageItem.eq(currentSlideIndex).addClass('m-active');

    // Change thumb image

    galleryThumbItem.removeClass('m-active');
    galleryThumbItem.eq(currentSlideIndex).addClass('m-active');


});
