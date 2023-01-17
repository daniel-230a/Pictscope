<?php
  session_start();

  //redirect if user already logged in
  if (isset($_SESSION['username'])) {
    header("/user/profile?user=daniel.k_18");
    exit;
  } else {
    //enable login or signup script depending on form
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
      if (isset($_POST['login'])) {

            require 'login.php';

      } else if (isset($_POST['sign_up'])) {

          require 'signup.php';

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
    <link href="/css/index_style.css" rel="stylesheet" >
    <!-- JS -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="/JS/access_form.js" type="text/javascript"></script>
  </head>
  <body>
    <?php include('elements/header.php'); ?>
    <section>
      <form class="access_form" action="/elements/login.php" method="POST" id="sign_up">
        <div class="logo">
          <img src="/img/brand/logo.png" alt="logo" class="brand">
        </div>
          <div class="form">
            <div class="input_container">
              <input type="text" placeholder="Username" name="username" id="username">
              <input type="password" placeholder="Password" name="password">
              <button type="submit" name="login" id="submit">Login</button>
              <div class="alert"></div>
              <h5 class="linked_text_forgot"><a class="linked_text_forgot" href="javascript:">Forgot your password?</a></h5>
            </div>
            <div class="small_container">
                <h5 class="linked_text_signup">Click here to <a class="linked_text_signup" href="" onclick="return switch_form('sign_up');">Sign up</a></h5>
            </div>
        </div>
      </form>
    </section>
    <?php include('elements/footer.php'); ?>
  </body>
</html>
