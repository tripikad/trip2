$('input[name=image_file]').hide();
$('input[name=image_submit]').hide();

$('#image_link').on('click touchstart', function(e) {
    e.preventDefault();
    $('input[name=image_file]').click();

});

$('input[name=image_file]').change(function(){
    $('input[name=image_submit]').click();
});