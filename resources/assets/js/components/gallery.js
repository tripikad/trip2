
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
    offset;

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

// Open gallery and fill it with content

galleryTrigger.on('click', function() {

    var images = galleryModal.data('images');

    var currentSlide;
    var currentSlideIndex;

    // Show image based on click

    currentSlide = galleryTrigger.filter($(this));
    currentSlideIndex = galleryTrigger.index(currentSlide);

    $.each(images , function(index, value){

        // Add images and thumbs

        if(index === currentSlideIndex) {
            galleryImageContainer.append('<div class="c-gallery__modal-image m-active js-gallery-modal-image"><img src="'+ value.image +'">');
            galleryThumbContainer.append('<div class="c-gallery__modal-thumb m-active js-gallery-modal-thumb" style="background-image:url('+value.image+');"></div>');
        } else {
            galleryImageContainer.append('<div class="c-gallery__modal-image js-gallery-modal-image"><img src="'+ value.image +'">');
            galleryThumbContainer.append('<div class="c-gallery__modal-thumb js-gallery-modal-thumb" style="background-image:url('+value.image+');"></div>');
        }

        // Add title if available

        if(typeof value.title !== 'undefined' && value.title.length > 0) {

            $('.c-gallery__modal-image').eq(index).append('<div class="c-gallery__modal-title">'+ value.title +'</div>');
        }

        // Add tags if available

        if(typeof value.tags !== 'undefined' && value.tags.length > 0) {

            $('.c-gallery__modal-image').eq(index).append('<div class="c-gallery__modal-tags"><ul class="c-tags m-small"></ul></div>');

            $.each(value.tags , function(tagindex, tag){

                $('.c-gallery__modal-image').eq(index).find('.c-tags').append('<li class="c-tags__item '+ tag.modifiers +'"><a href="'+ tag.route +'" class="c-tags__item-link">'+ tag.name +'</a></li>');
            });
        }
    });

    // If clicked image does not fit in the container 8, then nudge the container

    if (currentSlideIndex > 7) {

        tripGallery.nudgeNegative(currentSlideIndex);
    }

    // Show modal

    galleryModal.addClass('m-active');

    // Assign variables

    galleryImageItem = $('.js-gallery-modal-image');
    galleryThumbItem = $('.js-gallery-modal-thumb');

    return false;
});

// Close gallery

galleryClose.on('click', function(){

    galleryModal.removeClass('m-active');
    galleryImageItem.remove();
    galleryThumbItem.remove();
    nudge = 0;

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

    tripGallery.nudgeNegative(nextSlideIndex);

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
        nextSlideIndex,
        currentNudge = galleryThumbContainer.css('left');

    // Get slide info

    currentSlide = galleryImageItem.filter('.m-active');
    currentSlideIndex = galleryImageItem.index(currentSlide);

    if (currentSlideIndex - 1 < 0) {

        nextSlideIndex = galleryImageItem.length - 1;

    } else {

        nextSlideIndex = currentSlideIndex - 1;
    }

    tripGallery.nudgePositive(nextSlideIndex);

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

// Functions

var tripGallery = {

    // Moves the thumb container to the left

    nudgeNegative: function(slideIndex) {

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
    },

    // Moves the thumb container to the right

    nudgePositive: function(slideIndex) {

        if (slideIndex < galleryImageItem.length - 8) {

            nudge = nudge - offset;

        } else if (slideIndex === galleryImageItem.length - 1) {

            nudge = (galleryImageItem.length - 8) * offset;
        }

        galleryThumbContainer.css({
            'left' : '-'+ nudge +'px'
        });
    }
};
