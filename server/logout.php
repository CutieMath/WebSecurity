<?php

  session_start();
  unset($_SESSION['login']);
  echo "You have logged out, you cannot access to the <a href= '../client/shoppingcart.php'>shopping cart </a> right now";
  echo "<br><br>If you try to access to the shopping cart page without login successful, you will be redirect to <a hreg='../client/lognin.html'>login.html</a> page";


 ?>
