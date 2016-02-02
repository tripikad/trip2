$( "#global_search_form").submit(function( event ) {
  var search_val = $('#global_search_input').val();
  if(search_val && search_val.length >= 2)
  	return true;
  else return false
});

