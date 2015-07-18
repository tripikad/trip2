$('input[name=file]').hide();
$('input[name=submit_image]').hide();

$('#image_link').click(function(e) {
    e.preventDefault();
    $('input[name=file]').click();

});

$('input[name=file]').change(function(){
    $('input[name=submit_image]').click();
});