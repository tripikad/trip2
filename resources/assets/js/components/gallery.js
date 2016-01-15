
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
    galleryDesktop = 1200,
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

    // Change main image

    currentSlide = galleryTrigger.filter($(this));
    currentSlideIndex = galleryTrigger.index(currentSlide);

    $.each(images , function(index, value){
        if(index === currentSlideIndex) {
            galleryImageContainer.append('<div class="c-gallery__modal-image m-active js-gallery-modal-image"><img src="'+ value +'">');
            galleryThumbContainer.append('<div class="c-gallery__modal-thumb m-active js-gallery-modal-thumb" style="background-image:url('+value+');"></div>');
        } else {
            galleryImageContainer.append('<div class="c-gallery__modal-image js-gallery-modal-image"><img src="'+ value +'">');
            galleryThumbContainer.append('<div class="c-gallery__modal-thumb js-gallery-modal-thumb" style="background-image:url('+value+');"></div>');
        }
    });

    if (currentSlideIndex > 7) {

        tripGallery.nudgeNegative(currentSlideIndex);
    }

    galleryModal.addClass('m-active');

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

// Functions

tripGallery = {

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

        console.log('nudgeNegative: ' + nudge);
    },

    nudgePositive: function(slideIndex) {

        if (slideIndex < galleryImageItem.length - 8) {

            nudge = nudge - offset;

        } else if (slideIndex === galleryImageItem.length - 1) {

            console.log(galleryImageItem.length );

            nudge = (galleryImageItem.length - 8) * offset;
        }

        galleryThumbContainer.css({
            'left' : '-'+ nudge +'px'
        });

        console.log('nudgePositive: ' + nudge);
    }
};

