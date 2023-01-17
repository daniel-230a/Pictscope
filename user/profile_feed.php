<?php

session_start();
include_once "../elements/db.php";

$current_user = $conn->real_escape_string($_POST['user']);
$account = $conn->query("SELECT account_ID FROM accounts WHERE username='$current_user'");
$account_ID = $account->fetch_assoc();


$user_uplds = $conn->query("SELECT * FROM tbl_images WHERE account_ID='".$account_ID['account_ID']."' ORDER BY img_ID DESC");

if (mysqli_num_rows($user_uplds) != 0) {
  while ($user_posts = $user_uplds->fetch_assoc()) {
    $img_title = $conn->query("SELECT img_title FROM tbl_images WHERE img_ID='".$user_posts['img_ID']."' ORDER BY img_ID DESC")->fetch_assoc();
    if ($img_title['img_title'] == "") {
      $title = "No title..";
    }
    else {
      $title = $img_title['img_title'];
    }
    echo  '<div class="post">' .
            '<img class="post_img" src="'.$user_posts['img_URL'].'" alt="'.$title.'">' .
          '</div>';

  }
}
else {
  echo "No posts";
}



?>
