
var galleryModal = $('.js-gallery-modal'),
    galleryNext = $('.js-gallery-modal-next'),
    galleryPrevious = $('.js-gallery-modal-previous'),
    galleryClose = $('.js-gallery-modal-close'),
    galleryImageContainer = $('.js-gallery-modal-images'),
    galleryThumbContainer = $('.js-gallery-modal-thumbs'),
    galleryTrigger = $('.js-gallery-modal-trigger');

// Open gallery and fill it with content

galleryTrigger.on('click', function() {

    var images = galleryModal.data('images');
    var count;

    $.each(images , function(index, value){
        if(index === 0) {
            galleryImageContainer.append('<img src="'+ value +'" class="m-active">');
            galleryThumbContainer.append('<div class="c-gallery__modal-thumb m-active" style="background-image:url('+value+');"></div>');
        } else {
            galleryImageContainer.append('<img src="'+ value +'">');
            galleryThumbContainer.append('<div class="c-gallery__modal-thumb" style="background-image:url('+value+');"></div>');
        }
    });

    galleryModal.addClass('m-active');

    return false;
});

// Close gallery

galleryClose.on('click', function(){

    galleryModal.removeClass('m-active');
    galleryImageContainer.find('img').remove();
    galleryThumbContainer.find('div').remove();

    return false;
});

// Next image

galleryNext.on('click', function(){

    var currentSlide;
    var currentSlideIndex;
    var nextSlideIndex;
    var item = galleryImageContainer.find('img');
    var thumb = galleryThumbContainer.find('div');

    // Change main image

    currentSlide = item.filter('.m-active');
    currentSlideIndex = item.index(currentSlide);

    if (currentSlideIndex + 1 >= item.length) {

        nextSlideIndex = 0;

    } else {

        nextSlideIndex = currentSlideIndex + 1;
    }

    console.log(nextSlideIndex);

    if (nextSlideIndex > 7) {

        // Shows max 8 thumbs, if thumb is for example 11
        // then thumb container moves to the left -37.5% (11-8 => 3*12.5)

        var percentage = (nextSlideIndex - 7) * 156;

        galleryThumbContainer.css({
            'left' : '-'+ percentage +'px'
        });
    } else if (nextSlideIndex === 0) {

        galleryThumbContainer.css({
            'left' : '0'
        });
    }

    item.removeClass('m-active');
    item.eq(nextSlideIndex).addClass('m-active');

    // Change thumb image

    thumb.removeClass('m-active');
    thumb.eq(nextSlideIndex).addClass('m-active');

    return false;
});

// Previous image

galleryPrevious.on('click', function(){

    var currentSlide;
    var currentSlideIndex;
    var nextSlideIndex;
    var item = galleryImageContainer.find('img');
    var thumb = galleryThumbContainer.find('div');

    // Change main image

    currentSlide = item.filter('.m-active');
    currentSlideIndex = item.index(currentSlide);

    if (currentSlideIndex - 1 < 0) {

        nextSlideIndex = item.length - 1;

    } else {

        nextSlideIndex = currentSlideIndex - 1;
    }

    item.removeClass('m-active');
    item.eq(nextSlideIndex).addClass('m-active');

    // Change thumb image

    var left = galleryThumbContainer.css('left');
    console.log(left);

    thumb.removeClass('m-active');
    thumb.eq(nextSlideIndex).addClass('m-active');

    return false;
});
