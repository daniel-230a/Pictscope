<?php
  session_start();
  //if user isn't logged in redirect to login page
  if (!isset($_SESSION['username'])) {
    header("Location: /");
  }
  else {
    include_once "../elements/db.php";
    $current_user = $conn->real_escape_string($_GET['user']);
    $user_info = $conn->query("SELECT * FROM accounts WHERE username='$current_user'");
    $display_info = $user_info->fetch_assoc();

    $account_ID = $conn->query("SELECT account_ID FROM accounts WHERE username='".$_SESSION['username']."'")->fetch_assoc();
    $preferences = $conn->query("SELECT * FROM tbl_preferences WHERE account_ID='".$display_info['account_ID']."'");
    $follow_status =  $conn->query("SELECT * FROM tbl_relationship WHERE following_ID='".$display_info['account_ID']."' AND account_ID='".$account_ID['account_ID']."'");
    $display_status = "";

    if (mysqli_num_rows($user_info) == 0) {
      header("Location: /error404.php");
    }
    else{
      if ($display_info["username"] == $_SESSION['username']) {
        $display_status =  "own";
      } else {
          if(mysqli_num_rows($follow_status) != 0) {
            $display_status = "following";
          }
          else{
            $display_status = "follow";
          }
      }
    }
  }

?>

<!DOCTYPE html>
<html>
  <head>
    <!-- Title -->
    <title>Pictscope</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- CSS -->
    <link href="/css/profile.css" rel="stylesheet" >
    <!-- JS -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
    <script src="/JS/jquery.flot.min.js" type="text/javascript"></script>
    <script src="/JS/upload.js" type="text/javascript"></script>
    <script src="/JS/profile.js" type="text/javascript"></script>
    <script src="/JS/rating.js" type="text/javascript"></script>
    <script src="/JS/comments.js" type="text/javascript"></script>
  </head>
  <body>
    <?php include('../elements/header.php'); ?>
    <section class="content">
      <div class="user">
        <div class="user_profile_img">
          <?php
            if (mysqli_num_rows($preferences) != 0) {
              $get_preference = $preferences->fetch_assoc();
              $profile_img = $get_preference['profile_img'];
            }
            else {
              $profile_img = "/img/brand/user_icon.png";
            }
            echo '<img class="user_profile_img" src="'.$profile_img.'">'; ?>
        </div>
        <h1 class="user_fullname">
          <?php echo $display_info["fullname"]; ?>
        </h1>
        <span class="user_name"><?php echo $display_info["username"]; ?></span>
        <button id="relationship"><?php echo $display_status; ?></button>
      </div>
      <div class="user_stats">
        <b>
          <span class="stats" id="photos"><a>Photos</a></span>
          <span class="stats" id="followers"><a>followers</a></span>
          <span class="stats" style="color: #e5b830;" id="rate_ranking"><a>★ Rating --</a></span>
        </b>
      </div>
      <div id="main_content">
        <div class="user_posts"></div>
         <div id="img_viewer" >
          <span class="close cursor" onclick="closeViewer()">&times;</span>
            <div class="img_viewer_content ">
                <div class="img_container">
                  <img id="displayed_img" src="" style="width:100%">
                </div>

                <a class="prev" onclick="plusSlides(-1)">&#10094;</a>
                <a class="next" onclick="plusSlides(1)">&#10095;</a>

                <div class="img_title_box">
                  <p id="img_title"></p>
                </div>
              </div>
            <div class="user_interaction">
              <div class="rating">
                <span class="star">★</span>
                <span class="star">★</span>
                <span class="star">★</span>
                <span class="star">★</span>
                <span class="star">★</span>
              </div>
              <div class="votes"></div>
              <?php include('../user/comments.php'); ?>
          </div>
        </div>
       </div>
       <div id="graph-wrapper">
          <div class="graph-info">
              <a href="javascript:void(0)" class="visitors">Weekly rating analytics</a>
          </div>
          <div class="graph-container">
              <div id="graph-lines"></div>
          </div>
          <p>Week</p>
	  </div>
      <?php include('../user/upload.php'); ?>
    </section>
    <?php include('../elements/footer.php'); ?>
  </body>
</html>
