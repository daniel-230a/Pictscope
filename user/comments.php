<?php
$account_ID = $conn->query("SELECT account_ID FROM accounts WHERE username='".$_SESSION['username']."'")->fetch_assoc();

$preferences = $conn->query("SELECT * FROM tbl_preferences WHERE account_ID='".$account_ID['account_ID']."'");

if (mysqli_num_rows($preferences) != 0) {
  $get_preference = $preferences->fetch_assoc();
  $profile_img = $get_preference['profile_img'];
}
else {
  $profile_img = "/img/brand/user_icon.png";
}

?>

<ul class="comments">
  <li id="comment_container">
    <?php echo '<span class="comment_profile_container"><img class="comment_profile" src="'.$profile_img.'"></span></a>'; ?>
    <textarea id="comment_box" placeholder="Write a comment..."></textarea>
    <button id="post_comment_btn">Post</button>
  </li>
</ul>
