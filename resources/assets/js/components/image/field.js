$('input[name=file]').hide();
$('input[name=image_submit]').hide();

$('#image_link').on('click touchstart', function(e) {

    e.preventDefault();
    
    $(this).text($(this).data('selected-title')).attr('style', 'opacity: 0.5;')
    $('input[name=file]').click();

});

$('input[name=file]').change(function(){
    
    $('input[name=image_submit]').click();

});