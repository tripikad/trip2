// $('.c-search__form-input').on('keydown, function() {
//     $.ajax({
//         url: 'search/ajaxsearch',
//         type: 'get',
//         data: {name: $('.c-search__form-input').val()},
//         success: function(response) {
//             $('#search_results_div').html(response);
//         }
//     });
// });

$( "#global_search_form").submit(function( event ) {
  var search_val = $('#global_search_input').val();
  if(search_val && search_val.length >=2)
  	return true;
  else return false
});

