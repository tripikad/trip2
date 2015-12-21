/*jslint browser: true*/

window.CKEDITOR_BASEPATH = '/plugins/ckeditor/';

var selector = $('.js-ckeditor'),
    script = window.CKEDITOR_BASEPATH + 'ckeditor.js',
    adapter = window.CKEDITOR_BASEPATH + 'adapters/jquery.js';

if (selector.length > 0) {
    $.getScript(script, function() {

        $.getScript(adapter, function() {

            $.each(selector, function () {

                $(this).ckeditor();
            });
        });
    });
}
