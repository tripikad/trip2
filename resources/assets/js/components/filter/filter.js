// $('input[type=submit]').hide();

$('select[name=destination]').selectize({
    onChange: function(value) {
        $('input[type=submit]').click();
    }
});

$('select[name=topic]').selectize({
    onChange: function(value) {
        $('input[type=submit]').click();
    }
});

$('select[name=destinations]').selectize();
$('select[name=topics]').selectize();