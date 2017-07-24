var CKEDITOR_BASEPATH = '/vendor/ckeditor/',
    selector = $('.js-ckeditor'),
    script = CKEDITOR_BASEPATH + 'ckeditor.js?t_=13072017221300',
    adapter = CKEDITOR_BASEPATH + 'adapters/jquery.js?t_=13072017221300',
    k = 0;

if (selector.length > 0) {
    $.cachedScript(script).done(function() {
        $.cachedScript(adapter).done(function() {
            $.each(selector, function () {
                ++k;
                if ($(this).attr('id')) {
                    CKEDITOR.replace($(this).attr('id'));
                } else {
                    $(this).attr('id', 'js-ckeditor-' + k);
                    CKEDITOR.replace('js-ckeditor-' + k);
                }
            });
        });
    });
}
