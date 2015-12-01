/*jslint browser: true*/

window.CKEDITOR_BASEPATH = '/plugins/ckeditor/';

var selector = $('.js-ckeditor'),
    ckeditor_script = window.CKEDITOR_BASEPATH + 'ckeditor.js',
    ckeditor_adapter = window.CKEDITOR_BASEPATH + 'adapters/jquery.js';

if (selector.length > 0) {
    $.getScript(ckeditor_script, function() {

        $.getScript(ckeditor_adapter, function() {

            $.each(selector, function () {

                $(this).ckeditor();
            });
        });
    });
}
