/*exported createDropzone */

$('.js-dropzoneClick').click(function(e) {
    e.preventDefault();
    e.stopPropagation();
    $('#dropzoneImage').trigger('click');
});

function createDropzone(
    selector,
    url,
    method,
    paramName,
    maxFileSize,
    uploadMultiple,
    maxFiles,
    autoProcessQueue,
    token,
    translations,
    formSelector,
    submitSelector
) {

    if (maxFileSize.length === 0) {
        maxFileSize = 256;
    }

    if (uploadMultiple === 'false') {
        uploadMultiple = false;
    } else {
        uploadMultiple = true;
    }

    if (maxFiles.length === 0) {
        maxFiles = null;
    }

    if (autoProcessQueue === 'false') {
        autoProcessQueue = false;
    } else {
        autoProcessQueue = true;
    }

    if (
        token.length === 0 &&
        $('input[name="_token"]', formSelector).length > 0
    ) {
        token = $('input[name="_token"]', formSelector).val();
    }

    var hiddenFieldSelector = '#dz-hidden-field';

    $(selector).dropzone({
        url: url,
        method: method,
        paramName: paramName,
        maxFilesize: maxFileSize,
        uploadMultiple: uploadMultiple,
        maxFiles: maxFiles,
        autoProcessQueue: autoProcessQueue,
        headers: {
            'X-CSRF-Token': token
        },
        dictDefaultMessage: translations[0],
        dictFallbackMessage: translations[1],
        dictFallbackText: translations[2],
        dictMaxFilesExceeded: translations[3],
        dictFileTooBig: translations[4],
        dictRemoveFile: translations[5],

        sending: function(file, xhr, formData) {

            $('input, textarea, select', formSelector).each(function() {

                formData.append($(this).attr('name'), $(this).val());

            });

        },


        init: function() {
            var myDropzone = this;
            var hiddenFile = $(myDropzone.hiddenFileInput);

            if (autoProcessQueue === true) {
                if (uploadMultiple === true) {
                    myDropzone.on('successmultiple', function() {
                        location.reload();
                    });
                } else {
                    myDropzone.on('success', function() {
                        location.reload();
                    });
                }
            } else {
                this.on('addedfile', function() {

                    if (parseInt(maxFiles) == 1) {
                        if (
                            typeof this.files[1] !== 'undefined' &&
                            this.files[1] !== null
                        ) {
                            this.removeFile(this.files[0]);
                        }

                    }

                    hiddenFile = $(myDropzone.hiddenFileInput);
                });

                $(submitSelector).click(function(e) {
                    e.preventDefault();
                    e.stopPropagation();

                    if($(hiddenFieldSelector).length > 0) {
                        $(hiddenFieldSelector).remove();
                    }

                    hiddenFile.appendTo($(formSelector)).attr({
                        'name' : paramName,
                        'id' : hiddenFieldSelector
                    });

                    $(formSelector).submit();
                });
            }
        }
    });
}
