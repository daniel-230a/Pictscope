var viewing_user;
var weekly_user_score;

$( document ).ready(function() {
  viewing_user = $('.user_name').text();

  $.ajax({
          url: "../user/img_rating.php",
          type: 'POST',
          dataType: "json",
          data: {rank_user: viewing_user},
          success: function (user_rank) {
            alert(user_rank[1]);
            $('#rate_ranking').html("★ Rating " + user_rank[0]);
            var graphData = [{
                    // weekly ratings
                    label:"rating",
                    data: user_rank[1],
                    color: '#71c73e'}];

            $.plot($('#graph-lines'), graphData, {
                		series: {
                			points: {
                				show: true,
                				radius: 5
                			},
                			lines: {
                				show: true
                			},
                			shadowSize: 0
                		},
                		grid: {
                			color: '#646464',
                			borderColor: 'transparent',
                			borderWidth: 10,
                			hoverable: true
                		},
                		xaxis: {
                			tickColor: 'transparent',
                			tickDecimals: 0
                		},
                		yaxis: {
                			tickSize: 20
                		}
                	});
          }
        });

  //Graphs rating
  function showTooltip(x, y, contents) {
      $('<div id="tooltip">' + contents + '</div>').css({
          top: y - 16,
          left: x + 20
      }).appendTo('body').fadeIn();
  }

  var previousPoint = null;

  $('#graph-lines, #graph-bars').bind('plothover', function (event, pos, item) {
      if (item) {
          if (previousPoint != item.dataIndex) {
              previousPoint = item.dataIndex;
              $('#tooltip').remove();
              var x = item.datapoint[0],
                  y = item.datapoint[1];
                  showTooltip(item.pageX, item.pageY, 'ranked #'+ y + ' on week ' + x);
          }
      } else {
          $('#tooltip').remove();
          previousPoint = null;
      }
  });

  if ($('#relationship').text() == "own") {
      $("#relationship").css('display','none');
  }
  else {
    $("#relationship").css('display','block');
  }

  display_posts();
});

function display_posts(){
  $( ".user_posts" ).val('');
    $.ajax({
      method: 'POST',
      url: "../user/profile_feed.php",
      data: {user: viewing_user},
      success: function(img){
        if(img == "No posts"){
          $( ".user_posts" ).css({'display':'block', 'padding':'50px', 'color': 'lightgray', 'font-size': '20px'});
          $( ".user_posts" ).append("<b>" +img+"</b>");
        }
        else {
          $( ".user_posts" ).append(img);
        }
      }
  });
}

var posts_index = 1;

$( document ).on('click','.post', function(){
  posts_index = $(this).index() + 1;
  openViewer();

  $('#post_comment_btn').hide();
  $('#comment_box').on('keyup', function() {
      if (this.value.trim().length) {
          $('#post_comment_btn').fadeIn(600);
      }else{
          $('#post_comment_btn').fadeOut(600);
      }
  });

});


function openViewer() {
  $("#img_viewer").css('display','block');

  show_img(posts_index);
}

function closeViewer() {
  $("#img_viewer").css('display','none');
}




// go to next image or previous img
function plusSlides(n) {
  show_img(posts_index += n);
  $( ".comment" ).replaceWith('');
  $( ".sub_comments" ).replaceWith('');
  $('#comment_box').val('');
  show_comments();
  img_src =  $("#displayed_img").attr('src');
  ini_rating();
}


// current img number
function current_img(n) {
  show_img(posts_index = n);
}



function show_img(n) {
  var posts = document.getElementsByClassName("post");
  var post_img = document.getElementsByClassName("post_img");
  var img_title = document.getElementById("img_title");
  var displayed_img = document.getElementById("displayed_img");

  if (n > posts.length) {
    posts_index = 1;
   }

  if (n < 1) {

    posts_index = posts.length;
  }

  img_title.innerHTML = post_img[posts_index-1].alt;
  displayed_img.src = post_img[posts_index-1].getAttribute('src');
}

$(window).click(function(event){
    if (event.target == document.getElementById("img_viewer")) {
        closeViewer();
    }
});

$( document ).on('click','.stats', function(){
	open_stats($('.stats').attr('id'));
});

function open_stats(stats_name) {
  $('#main_content').replacewith(stats_name);
}

//relationship button
$( document ).on('click','#relationship', function(){
  var current_status = $(this).html();
  if (current_status == "follow") {
    $(this).html("following");
    $(this).css('background-color','#1c4d34');
  }
  else if (current_status == "following") {
    $(this).html("follow");
    $(this).css('background-color','#02a652');
  }
  $.ajax({
      method: 'POST',
      url: "../user/user_relationship.php",
      data: {'following': current_status},
      success: function(data){
        alert(data)
      }
  });
});
