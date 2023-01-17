var rate_img = true;
var current_rate = 0;
var img_index;
var img_src;

function ini_rating() {
  $(".star").css("color", "#c5c5c5");
  $.ajax({
          url: "../user/img_rating.php",
          type: 'POST',
          data: {img_url: img_src, current_rating: "ini"},
          success: function (rating) {
            $(".star").css("color", "#c5c5c5");
            if (rating != 0) {
              for (i = 0; i <= rating; i++) {
                $(".star:nth-child("+ i +")").css("color", "#ffb100");
              }
              $(".star").unbind('mouseenter mouseleave');
            }
            else{
              hover_stars();
              rate_img = true;
            }
          }
        });
}


$( document ).on('click','.post', function(){
  img_index = $(this).index() +1;
  img_src = $(".post:nth-child("+ img_index +")").find(".post_img").attr('src');
  ini_rating();

  if (rate_img == true) {
      hover_stars();
  }
});

function handle_rating(n) {
  count_stars();
  $.ajax({
          url: "../user/img_rating.php",
          type: 'POST',
          data: {img_url: img_src, current_rating: current_rate}
        });
}

function hover_stars() {
  $(".star").hover(function(){
        colour_star($(this));
      },function(){
          $(".star").css("color", "#c5c5c5");
    });
}

function colour_star(star){
  var selected_star = star.index() + 1;
  for (i = 0; i <= selected_star; i++) {
    $(".star:nth-child("+ i +")").css("color", "#ffb100");
  }
}

function count_stars(){
  current_rate = 0;
  for (i = 0; i <= 5; i++) {
    if($(".star:nth-child("+ i +")").css("color") == "rgb(255, 177, 0)"){
      current_rate += 1;
    }
  }
}

$( document ).on('click','.star', function() {
  if ($(this).css("color") == "rgb(197, 197, 197)" || rate_img == true) {
    colour_star($(this));
    $(".star").unbind('mouseenter mouseleave');
    rate_img = false;
  }
  else {
    $(".star").css("color", "#c5c5c5");
    hover_stars();
    rate_img = true;
  }
  handle_rating(img_index);
});
