var slider = $('.c-range-filter__slider'),
    firstStep,
    firstInitialStep,
    lastStep,
    lastInitialStep,
    steps = [
        'November 2015',
        'Detsember 2015',
        'Jaanuar 2016',
        'Veebruar 2016',
        'Märts 2016',
        'Aprill 2016',
        'Mai 2016',
        'Juuni 2016',
        'Juuli 2016',
        'August 2016',
    ];

    slider.slider({
    range: true,
    min: 0,
    max: 9,
    values: [0, 9],
    step: 1,
    slide: function(event, ui) {
        firstStep = steps[ui.values[0]];
        lastStep = steps[ui.values[1]];
        $('.ui-slider-handle')
            .eq(0)
            .html('<span>' + firstStep + '</span>');
        $('.ui-slider-handle')
            .eq(1)
            .html('<span>' + lastStep + '</span>');
    }
});

firstInitialStep = slider.slider('values', 0 );
lastInitialStep = slider.slider('values', 1 );

$('.ui-slider-handle')
    .eq(0)
    .html('<span>' + steps[firstInitialStep] + '</span>');
$('.ui-slider-handle')
    .eq(1)
    .html('<span>' + steps[lastInitialStep] + '</span>');
