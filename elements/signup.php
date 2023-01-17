<?php
  session_start();
  include_once "db.php";

  $fullname = ucwords(strtolower($conn->real_escape_string($_POST['fullname'])));
  $email    = $conn->real_escape_string($_POST['email']);
  $username = strtolower($conn->real_escape_string($_POST['username']));
  $password = $conn->real_escape_string($_POST['password']);
  $re_password = $conn->real_escape_string($_POST['re_password']);
  $hash = password_hash($password,  PASSWORD_BCRYPT);

  $uid_exist = $conn->query("SELECT * FROM accounts WHERE username='$username'");
  $email_exist = $conn->query("SELECT * FROM accounts WHERE email='$email'");

  if (mysqli_num_rows($uid_exist) != 0) {

    echo "This username already exists";

  } else if (mysqli_num_rows($email_exist) != 0) {

    echo "This email is already linked to another account";

  } else if (empty($fullname) || empty($email) || empty($username) || empty($password)) {

      echo "All fields are mandatory!";

  } else if ($re_password != $password) {

      echo "Your password doesn't match. Try again";

  } else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {

      echo "The email you have entered is invalid";

  } else {
      $signup_date = date("Y/m/d");
      $insert = $conn->query("INSERT INTO accounts (fullname, email, username, password, signup_date) VALUES ('$fullname', '$email', '$username', '$hash', '$signup_date')");

      $_SESSION["fullname"] = $fullname;
      $_SESSION['username'] = $username;

      echo "success";

      $recipient = $email;
      $headers .= "Reply-To: Pictscope <pictscope@danielsweb.co.uk>\r\n";
      $headers .= "Return-Path: Pictscope <<pictscope@danielsweb.co.uk>\r\n";
      $headers .= "From: Pictscope <<pictscope@danielsweb.co.uk>\r\n";
      $subject = "Pictscope - Thanks for creating an account";
      $msg =
      "Hello " . $fullname . ",

      You have succesfully made an account on Pictscope

      ";

      mail($recipient, $subject, $msg, $headers);
  }
?>
