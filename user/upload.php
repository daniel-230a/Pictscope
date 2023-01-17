<?php

header("Location: /");

?>

<head>
      <link href="/css/upload.css" rel="stylesheet" >
</head>
<section id="upload_view">
  <form action="/user/handle_upload.php" method="post" enctype="multipart/form-data" id="img_uploader">
    <div class="rounded_box">
      <h1 class="title">Upload to Pictscope</h1>
      <input class="btn" type="button" value="Upload" id="upload_img_btn">
    </div>
    <input type="file" name="choose_img" id="choose_img">
    <div class="alert"></div>
  </form>
</section>
