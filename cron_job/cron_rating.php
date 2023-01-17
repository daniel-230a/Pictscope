<?php
include_once "../elements/db.php";

$current_user = $conn->real_escape_string($_GET['user']);
$user_info = $conn->query("SELECT * FROM accounts WHERE username='$current_user'");
$display_info = $user_info->fetch_assoc();

$account_ID = $conn->query("SELECT user_score FROM accounts WHERE username='".$display_info['account_ID']."'")->fetch_assoc();
date("Y-m-d")

$conn->query("INSERT INTO tbl_comments (parent_comment_ID, account_ID, img_ID, comment, comment_time) VALUES ('$parent_comment_ID', '".$account_ID['account_ID']."', '".$img_ID['img_ID']."', '$comment', '$comment_time')");  

?>