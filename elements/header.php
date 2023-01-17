<?php

  if (isset($_SESSION['username'])) {

    echo <<<EOD
    <head>
      <!-- JS -->
      <script src="/JS/search.js" type="text/javascript"></script>
      <!-- CSS -->
      <link href="/css/header.css" rel="stylesheet" >
      <link rel="shortcut icon" href="/favicon.png" />
    </head>
    <header>
      <a href="/user/main_feed.php">
        <img class="header_logo" src="/img/brand/logo_transparent.png">
      </a>
      <div class="user_logout">
        <span id="user">
          <a href="/user/profile?user={$_SESSION['username']}">
            {$_SESSION['username']}
          </a>
        </span>
        <a id="logout_btn" href="logout.php">
          <button id="logout">Logout</button>
        </a>
      </div>
    </header>
EOD;
  } else {
    echo <<<EOD
    <head>
      <!-- CSS -->
      <link href="/css/header.css" rel="stylesheet" >
      <link rel="shortcut icon" href="/favicon.png" />
    </head>
    <header>
      <a href="/user/main_feed.php">
        <img class="header_logo" src="/img/brand/logo_transparent.png">
      </a>
    </header>
EOD;
  }
?>
