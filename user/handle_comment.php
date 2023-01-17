<?php
session_start();
include_once "../elements/db.php";

$comment = $conn->real_escape_string($_POST['comment']);

$img_URL = $conn->real_escape_string($_POST['img_url']);

$parent_ID = $conn->real_escape_string($_POST['parent_ID']);

$img_ID = $conn->query("SELECT img_ID FROM tbl_images WHERE img_URL='$img_URL'")->fetch_assoc();

$account_ID = $conn->query("SELECT account_ID FROM accounts WHERE username='".$_SESSION['username']."'")->fetch_assoc();

$comment_time = date("Y-m-d h:i:sa");

$parent_comment_ID = 0;

$conn->query("INSERT INTO tbl_comments (parent_comment_ID, account_ID, img_ID, comment, comment_time) VALUES ('$parent_comment_ID', '".$account_ID['account_ID']."', '".$img_ID['img_ID']."', '$comment', '$comment_time')");

if ($parent_ID) {

  $conn->query("DELETE FROM tbl_comments WHERE comment_ID='".$parent_ID."' AND account_ID='".$account_ID['account_ID']."'");

}/* */
?>
