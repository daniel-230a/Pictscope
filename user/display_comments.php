<?php
session_start();
include_once "../elements/db.php";

$img_URL = $conn->real_escape_string($_POST['img_url']);

$img_ID = $conn->query("SELECT img_ID FROM tbl_images WHERE img_URL='$img_URL'")->fetch_assoc();

$comments = $conn->query("SELECT * FROM tbl_comments WHERE img_ID='".$img_ID['img_ID']."'");

$sub_comment="";

$delete_btn = "";

if(mysqli_num_rows($comments) != 0){
  while ($comment = $comments->fetch_assoc()) {
    $account = $conn->query("SELECT username FROM accounts WHERE account_ID='".$comment['account_ID']."'")->fetch_assoc();

    $preferences = $conn->query("SELECT * FROM tbl_preferences WHERE account_ID='".$comment['account_ID']."'");

    $sub_comments = $conn->query("SELECT * FROM tbl_comments WHERE parent_comment_ID='".$comment['comment_ID']."'");

    if($account['username'] != $_SESSION['username']){
      $delete_btn = "";
    }
    else {
      $delete_btn = '<button class="delete_comment" data-id="'.$comment['comment_ID'].'">delete</button>';
    }

    if (mysqli_num_rows($preferences) != 0) {
      $get_preference = $preferences->fetch_assoc();
      $profile_img = $get_preference['profile_img'];
    }
    else {
      $profile_img = "/img/brand/user_icon.png";
    }

    if($comment['parent_comment_ID'] == 0) {
      while($sub = $sub_comments->fetch_assoc()) {
        $sub_account = $conn->query("SELECT username FROM accounts WHERE account_ID='".$sub['account_ID']."'")->fetch_assoc();

        if($sub_account['username'] != $_SESSION['username']){
          $delete_btn = "";
        }
        else {
          $delete_btn = '<button class="delete_comment" data-id="'.$comment['comment_ID'].'">delete</button>';
        }

        if ($sub['parent_comment_ID'] == $comment['comment_ID']) {
          $sub_comment .= '<li class="comment" data-id="'.$sub['parent_comment_ID'].'">'.
                            '<a class="user_search" href="'."profile?user=".$sub_account['username'].'"><span class="comment_user">'.$sub_account['username'].'</span>'.
                            '<span class="comment_profile_container"><img class="comment_profile" src="'.$profile_img.'"></span></a>'.
                            '<span class="comment_time">'.$sub['comment_time'].'</span>'.
                            '<p class="comment_text">'.$sub['comment'].'</p>'.
  						  '<button class="reply_comment" data-id="'.$sub['comment_ID'].'">reply</button>'.
  			              $delete_btn.
                          '</li>';
        }
      }
      echo '<li class="comment" data-id="'.$comment['parent_comment_ID'].'">'.
              '<a class="user_search" href="'."profile?user=".$account['username'].'"><span class="comment_user">'.$account['username'].'</span>'.
              '<span class="comment_profile_container"><img class="comment_profile" src="'.$profile_img.'"></span></a>'.
              '<span class="comment_time">'.$comment['comment_time'].'</span>'.
              '<p class="comment_text">'.$comment['comment'].'</p>'.
  			'<button class="reply_comment" data-id="'.$comment['comment_ID'].'">reply</button>'.
  			$delete_btn.
            '</li>'.
            '<ul class="sub_comments" data-id="'.$comment['comment_ID'].'">'.$sub_comment.'</ul>';
    }
    $sub_comment = "";
  }
}
else {
  echo '<p id="no_comments" style="padding: 10px;text-align: center;color: #b1b1b1;">No comments...</p>';
}

?>

</a>
