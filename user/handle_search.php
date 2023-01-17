<?php

session_start();
include_once "../elements/db.php";

$user_query = $conn->real_escape_string($_POST['search']);
$query_db = $conn->query("SELECT * FROM accounts WHERE username LIKE '".$user_query."%' limit 0,20");

if(mysqli_num_rows($query_db) != 0) {
  while ($user_account = $query_db->fetch_assoc()) {
    echo '<li>
            <a class="user_search" href="'."profile?user=".$user_account["username"].'">
             <div class="z556c">
                <div class="RR-M-  g9vPa" role="button" tabindex="0">
                  <img class="search_profile_img" src="/img/brand/user_icon.png">
                </div>
                <div class="_2_M76">
                   <div class="uyeeR">
                      <span class="Ap253">'.$user_account["username"].'</span>
                   </div>
                   <span class="Fy4o8"></span>
                </div>
             </div>
            </a>
          </li>';

        }
}
else {
  echo 'No results';
}



?>
