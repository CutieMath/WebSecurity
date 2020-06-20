<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title></title>
  </head>
  <body>

    <?php

      // Receive input from client side
      $name = $_POST['name'];
      $password = $_POST['password'];

      // Check if the user name exist
      $exist = 0;

      // Read the file line by line
      $file = fopen("../database/database.txt", "r");

      // read each line and seperate values using ","
      // assign values after seperation
      // compare user name
      while (!feof($file)){
        $line = trim(fgets($file));
        list($a, $b) = explode(",", "$line,", 2);
        if($a == $name){
          $exist = 1;
          break;
        }
      }
      fclose($file);

      if($exist == 1){
        // Ask user for another input
        echo "The input exist! <br>
              Please enter another one via <a href = '../client/registration.html'>Registration Page</a>";
      }else{
        // Add information into database
        $file = fopen("../database/database.txt", "a");
        fwrite($file, $name.",".$password."\n");
        fclose($file);
        echo "The input has been added to the database named as database.txt <br>
              You can view <a href='../database/database.txt'>here</a>.<br>
              You can log in <a href='../client/login.html'>here</a>.";
      }


     ?>

  </body>
</html>
