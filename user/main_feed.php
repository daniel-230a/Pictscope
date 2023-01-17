<?php
  session_start();
  //if user isn't logged in redirect to login page
  if (!isset($_SESSION['username'])) {
    header("Location: /");
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
    <link href="/css/main_feed.css" rel="stylesheet" >
    <!-- JS -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  </head>
  <body>
    <?php include('../elements/header.php'); ?>
    <section class="main_feed">
      <div class="img_view"></div>
    </section>
    <?php include('../elements/footer.php'); ?>
  </body>
</html>
