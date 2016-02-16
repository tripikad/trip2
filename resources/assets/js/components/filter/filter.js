var filter = $('.js-filter'),
    submit = $('.js-submit');

if (submit.length > 0) {

    filter.selectize({

        onChange: function() {
            submit.click();
        }
    });
} else {

    filter.selectize({

        plugins: ['remove_button'],
    });
}

