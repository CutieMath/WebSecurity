<?php
  session_start();
  include('PHP_API/rsa.php');
  include('PHP_API/des.php');
 ?>


<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Order confirmation</title>

  <style media="screen">

    table{
      width:400px;
      font-family: arial, sans-serif;
      border-collapse: collapse;
    }

    th{
      background-color: pink;
      color:white;
    }

    td, th{
      height: 55px;
      width: 100px;
      text-align: center;
      padding: 8px;
      font-size: 15px;
    }
  </style>
</head>

  <body>


    <!-- Section 1 -->
    <!-- Encryption and decryption information -->


    <!-- php code for retriving DES key and decryption -->

    <?php
    // Step 1: get the ciphertext (the encrypted DES key)
    $encrypted = $_POST['desKey'];
    // Step 2: get the private key from rsa.php
    $privateKey = get_rsa_privateKey('RSA_keys/private.key');
    // Step 3: compute the decrytped value
    $decrypted = rsa_decryption($encrypted, $privateKey);

    // Step 4: get the credit card number
    $cardNum = $_POST["cardNum"];
    // Step 5: use PHP DES for decryption (use recovered DES key)
    $recoveredCardNum = php_des_decryption($decrypted, $cardNum);


    // Step 6: decrypt shopping cart information
    $aSubtotal = php_des_decryption($decrypted, $_POST["aSubtotal"]);
    $bSubtotal = php_des_decryption($decrypted, $_POST["bSubtotal"]);
    $cSubtotal = php_des_decryption($decrypted, $_POST["cSubtotal"]);

    $totalQty = php_des_decryption($decrypted, $_POST["totalQty"]);
    $totalPrice = php_des_decryption($decrypted, $_POST["totalPrice"]);

     ?>



    <!-- Display on screen -->


    <h2>Confirmation of your order:</h2>
    <br><br>

    <table>
      <tr>
        <th>Products</th>
        <th>Price</th>
        <th>Quantity</th>
        <th>Subtotal</th>
      </tr>

      <tr>
        <td><?php echo $_POST['aProduct']; ?></td>
        <td><?php echo $_POST['aPrice']; ?></td>
        <td><?php echo $_POST['aQty']?></td>
        <td><?php echo $aSubtotal ?></td>
      </tr>

      <tr>
        <td><?php echo $_POST['bProduct']; ?></td>
        <td><?php echo $_POST['bPrice']; ?></td>
        <td><?php echo $_POST['bQty'] ?></td>
        <td><?php echo $bSubtotal ?></td>
      </tr>

      <tr>
        <td><?php echo $_POST['cProduct']; ?></td>
        <td><?php echo $_POST['cPrice']; ?></td>
        <td><?php echo $_POST['cQty'] ?></td>
        <td><?php echo $cSubtotal ?></td>
      </tr>

      <tr>
        <th></th>
        <th>Total</th>
        <th><?php echo $totalQty ?></th>
        <th><?php echo $totalPrice ?></th>
      </tr>

    </table>

    <br><br>



    Received encrypted DES key:<br>
    <textarea rows="7" cols="80"><?php echo $encrypted; ?></textarea>
    <br><br>
    Recovered DES key: <?php echo $decrypted; ?>
    <br><br>
    Recovered credit card number: <?php echo $recoveredCardNum; ?>
    <br><br>



     <!-- Add shopping cart information and credit card number into order.txt -->
     <?php

     // open the file which named as order.txt
     $file = fopen("../database/order.txt", "a");
     $divide = "---------------------------------------------"."\n";
     $client = "Client: ".$_SESSION['user']."\n"."Ordered quantity information:"."\n";
     $pa = "Product A: ".$_POST['aQty']." ($30 each)"."\n";
     $pb = "Product B: ".$_POST['bQty']." ($40 each)"."\n";
     $pc = "Product C: ".$_POST['cQty']." ($10 each)"."\n";
     $total = "Total Price: ".$totalPrice."\n";
     $card = "Credit card number: ".$recoveredCardNum."\n\n";

     // write into file
     fwrite($file, $divide);
     fwrite($file, $client);
     fwrite($file, $pa);
     fwrite($file, $pb);
     fwrite($file, $pc);
     fwrite($file, $total);
     fwrite($file, $card);
     // clost the file
     fclose($file);

     echo "You can go to <a href='../database/order.txt'>order.txt</a> to check if this order information has been added to the file";
     ?>

  </body>
</html>
