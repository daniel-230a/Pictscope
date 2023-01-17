<?php
session_start();
include_once "../elements/db.php";

$img_URL = $conn->real_escape_string($_POST['img_url']);

$current_rating = $conn->real_escape_string($_POST['current_rating']);

$rank_user = $conn->real_escape_string($_POST['rank_user']);

$img_ID = $conn->query("SELECT img_ID FROM tbl_images WHERE img_URL='$img_URL'")->fetch_assoc();

$account_ID = $conn->query("SELECT account_ID FROM accounts WHERE username='".$_SESSION['username']."'")->fetch_assoc();

$img_rating = $conn->query("SELECT img_rating FROM tbl_rating WHERE img_ID='".$img_ID['img_ID']."' AND account_ID='".$account_ID['account_ID']."'");

$initial_rating = $img_rating->fetch_assoc();


if (isset($current_rating) and $current_rating != "ini"){
  if (mysqli_num_rows($img_rating) != 0) {
    if ($current_rating == 0) {
      $conn->query("DELETE FROM tbl_rating WHERE img_ID='".$img_ID['img_ID']."' AND account_ID='".$account_ID['account_ID']."'");
      $conn->query("UPDATE tbl_images SET rating_votes= rating_votes - 1 WHERE img_ID='".$img_ID['img_ID']."'");

    }
    else{
      $conn->query("UPDATE tbl_rating SET img_rating='$current_rating' WHERE img_ID='".$img_ID['img_ID']."' AND account_ID='".$account_ID['account_ID']."'");
    }
  }
  else {
      if ($current_rating != 0) {
        $conn->query("INSERT INTO tbl_rating (account_ID, img_ID, img_rating) VALUES ('".$account_ID['account_ID']."', '".$img_ID['img_ID']."', '$current_rating')");
        $conn->query("UPDATE tbl_images SET rating_votes= rating_votes + 1 WHERE img_ID='".$img_ID['img_ID']."'");
      }
  }
}
else {
    echo $initial_rating['img_rating'];
}

if(isset($rank_user) and $current_rating != "ini") {
  $sum_img_ratings = 0;
  $avg_img_rating= 0;
  $num_img = 0;

  $user_ID = $conn->query("SELECT account_ID FROM accounts WHERE username='$rank_user'")->fetch_assoc();
  $global_rank = $conn->query("SELECT global_rank FROM accounts WHERE username='$rank_user'")->fetch_assoc();
  $img_info = $conn->query("SELECT * FROM tbl_images WHERE account_ID='".$user_ID['account_ID']."'");
  $weekly_user_score = $conn->query("SELECT * FROM accounts WHERE account_ID='".$user_ID['account_ID']."'")->fetch_assoc();

  if (mysqli_num_rows($img_info) != 0) {
    while ($img_ID_select = $img_info->fetch_assoc()) {
      $img_ratings = $conn->query("SELECT img_rating FROM tbl_rating WHERE img_ID='".$img_ID_select['img_ID']."'");
      while ($rating = $img_ratings->fetch_assoc()) {
        $sum_img_ratings += $rating['img_rating'];
      }
      if ($img_ID_select['rating_votes'] != 0) {
        $avg_img_rating += $sum_img_ratings / $img_ID_select['rating_votes'];
      }
      $num_img += 1;
    }
    $user_score = round($avg_img_rating / $num_img, 3);
    $conn->query("UPDATE accounts SET user_score='$user_score' WHERE username='$rank_user'");

    //echo $global_rank['global_rank'];
    if ($user_score > 0) {
   	  $current_score = $user_score;
    }
    else {
      $current_score = "N/A";
   }
   echo json_encode(array($current_score, $weekly_user_score['weekly_user_score'],$user_ID['account_ID']));
  }
}

?>
