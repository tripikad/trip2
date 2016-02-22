$('.js-add-destination-row').on('click', function(){

    $(this).before(
        $('<div />')
        .addClass('c-form__group m-small-margin').append(
            $('<div />')
            .addClass('c-columns m-2-cols m-space')
            .html('<div class="c-columns__item"><div class="c-form__input-wrap"><input type="text" class="c-form__input" placeholder="Alguskoht"></div></div><div class="c-columns__item"><div class="c-form__input-wrap"><input type="text" class="c-form__input" placeholder="Sihtkoht"></div></div>')
        )
    );

    return false;
});
