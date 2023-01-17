$( document ).ready(function() {

  $('#search_box').keydown(function(event) {
    if (event.keyCode == '13') {
       event.preventDefault();
    }
  });

  $('#search_box').keyup(function() {
    var user_query = $(this).val();
    if(user_query != '') {
      $.ajax({
          url: "../user/handle_search.php",
          method: "POST",
          data: {search: user_query},
          dataType: "text",
          success: function(result){
            $('#search_result').html(result);

          }
      });
    }
    else {
      $('#search_result').html('');
    }
  });
});
