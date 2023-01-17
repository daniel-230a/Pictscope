<?php

session_start();
include_once "../elements/db.php";


$file = $_FILES['choose_img'];
$file_final =  $_POST['choose_img_final'];
$img_title_inp =  $conn->real_escape_string($_POST['img_title_inp']);
$img_desc_inp =  $conn->real_escape_string($_POST['img_desc_inp']);
$unique_id = hash('sha256', $file['name'] . strval(time()));
$location    = "../uplds/" . $unique_id . "/";
$temp = explode(".", $file["name"]);
$newfilename = hash('sha256', time()) . '.' . end($temp);
$target_file = $location . $newfilename;

$account = $conn->query("SELECT account_ID FROM accounts WHERE username='".$_SESSION['username']."'");
$account_ID = $account->fetch_assoc();
$upld_date = date("Y/m/d");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

  if (isset($file)) {
    if (isset($file_final)) {

      mkdir($location , 0777, true);

      if(move_uploaded_file($file["tmp_name"], $target_file)) {
        $conn->query("INSERT INTO tbl_images (account_ID, img_URL, img_title, img_desc, upld_date) VALUES ('".$account_ID['account_ID']."', '$target_file', '$img_title_inp', '$img_desc_inp', '$upld_date')");
        echo "The file " . $file["name"] . " has been uploaded.";
      }

    }
    else {
      // validate if upload is an image or not
      $valid_img = check_img_mime($file['tmp_name']);
      if ($valid_img != false) {
        echo "valid";
      }
      else {
        echo "That is not an image / Image type isn't supported";
      }
    }
  }
  else {
    echo "Something went wrong, image couldn't be uploaded.";
  }
}

function check_img_mime($tmpname){
  $finfo = finfo_open( FILEINFO_MIME_TYPE );
  $mtype = finfo_file( $finfo, $tmpname );
  $tmpname->mtype = $mtype;
  $alwd_type =  array(
                      'jpg' => 'image/jpeg',
                      'png' => 'image/png',
                      'gif' => 'image/gif',
                    );
  if(strpos($mtype, 'image/') === 0){
    if(array_search($mtype, $alwd_type,true)){
      return true;
    }
    else {
      return false;
    }
  }
  else {
    return false;
  }
  finfo_close($finfo);
}


?>
