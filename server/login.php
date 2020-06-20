<?php
    session_start();
?>


<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title></title>
  </head>
  <body>

    <?php

        // Receive inputs from client side
        $name = $_POST['name'];
        $password = $_POST['password'];


        // Check if the input matched the txt file
        $match = 0;

        // read the file line by line
        $file = fopen("../database/database.txt", "r");

        // read each line
        // assign values after seperation using ","
        // compare both password and user name
        while (!feof($file)){
          $line = trim(fgets($file));
          list($a, $b) = explode(",", "$line");

          if($name == $a && $password == $b){
            $match = 1;
            break;
          }
        }
        fclose($file);

        if($match == 1){
          $_SESSION['login']="YES";
          $_SESSION['user'] = $name;
          header('Location:../client/shoppingcart.php');
          echo "Log In Succeed!<br>
                Now you can access to the <a href='../client/shoppingcart.php'>shopping cart</a>";
        }else{
          echo "The password or the username were incorrect<br>
                Go back to <a href='../client/login.html'>Log in</a> or <a href='../client/registration.html'> Register";
        }


     ?>

  </body>
</html>
