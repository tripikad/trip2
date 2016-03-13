/*jslint browser: true*/

window.CKEDITOR_BASEPATH = '/plugins/ckeditor/';

var selector = $('.js-ckeditor'),
    script = window.CKEDITOR_BASEPATH + 'ckeditor.js',
    adapter = window.CKEDITOR_BASEPATH + 'adapters/jquery.js',
    k = 0;

if (selector.length > 0) {
    $.cachedScript(script).done(function() {

        $.cachedScript(adapter).done(function() {
            $.each(selector, function () {
                ++k;
                if ($(this).attr('id')) {
                    $(this).ckeditor();
                } else {
                    $(this).attr('id', 'js-ckeditor-' + k);
                    $(this).ckeditor();
                }
            });
        });
    });
}
