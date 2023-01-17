function show_comments() {
  $.ajax({
      method: 'POST',
      url: "../user/display_comments.php",
      data: {img_url: $("#displayed_img").attr('src')},
      success: function(comment){
        $( ".comment" ).replaceWith('');
        $( ".sub_comments" ).replaceWith('');
        $( "#no_comments" ).replaceWith('');
        $( ".comments" ).append(comment);
      }
  });
}


$( document ).on('click','.post', function(){
  $('#comment_box').val('')
  show_comments()
});

$( document ).on('click','#post_comment_btn', function(event){
  event.preventDefault();

  $.ajax({
      method: 'POST',
      url: "../user/handle_comment.php",
      data: {comment: $('#comment_box').val(), img_url: $("#displayed_img").attr('src')},
      success: function(msg){
      }
  });

  $('#comment_box').val('')
  show_comments()

});

$( document ).on('click','.reply_comment', function(){

  $(".sub_comments[data-id*='"+$(this).attr("data-id")+"']").append($( "#comment_container" ).get(0).outerHTML);

  $.ajax({
      method: 'POST',
      url: "../user/handle_comment.php",
      data: {parent_ID: $('.reply_comment').val()},
      success: function(msg){
      }
  });

  $('#comment_box').val('')

});

$( document ).on('click','.delete_comment', function(){

  $.ajax({
      method: 'POST',
      url: "../user/handle_comment.php",
      data: {parent_ID: $(this).attr("data-id")},
      success: function(msg){
      }
  });

  show_comments()

});
