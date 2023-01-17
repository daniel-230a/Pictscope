<?php
include_once "../elements/db.php";
$current_user = $conn->real_escape_string($_GET['user']);
$user_info = $conn->query("SELECT * FROM accounts WHERE username='$current_user'");
$display_info = $user_info->fetch_assoc();

$account_ID = $conn->query("SELECT account_ID FROM accounts WHERE username='".$_SESSION['username']."'")->fetch_assoc();
$follow_status =  $conn->query("SELECT * FROM tbl_relationship WHERE following_ID='".$display_info['account_ID']."' AND account_ID='".$account_ID['account_ID']."'");

if ($_POST['following'] == "testing") {
  $conn->query("INSERT INTO tbl_relationship (account_ID, following_ID) VALUES ('".$account_ID['account_ID']."', '".$display_info['account_ID']."')");
}

echo $account_ID['account_ID'];

?>
