<?php
  session_start();
  if(!isset($_SESSION['login'])){
    header('Location:login.html');
  }
 ?>


<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>SEC Shopping Cart</title>
  <style media="screen">


      .box{
          background-color: rgba(255, 229, 236, 0.5);
          width: 500px;
          height: 700px;
          padding: 80px;
          border: 100px;
          margin: 20px auto;
          position: center;
          font-family: sans-serif, arial;
      }

      table{
        width: 500px;
        border-collapse: collapse;
      }

      td, th{
        height: 55px;
        width: 100px;
        text-align: center;
        padding: 8px;
        font-size: 15px;
      }

      .spans{
        text-align: right;
      }

      .userGreeting{
        font-size: 10px;
        font-color: grey;
      }

      td{
        color: grey;
      }

      th{
        color: white;
        background-color: pink;
      }

      .btn{
        padding: 6px;
        background-color: grey;
        font-family:  sans-serif;
        font-size: 14px;
        color: white;
        cursor: pointer;
        border-radius: 4px;
        border: white 1px solid;
        text-align: center;
        -webkit-transition-duration: 0.4s;
        transition-duration: 0.4s;
      }

      .btn:hover{
        background-color: pink;
      }

      .btn2{
        padding: 6px;
        background-color: white;
        font-family:  sans-serif;
        font-size: 14px;
        color: grey;
        cursor: pointer;
        border-radius: 4px;
        border: white 1px solid;
        text-align: center;
        -webkit-transition-duration: 0.4s;
        transition-duration: 0.4s;
      }

      .btn2:hover{
        background-color: pink;
      }


  </style>
</head>

  <body>

    <div class="box">
    <center>

      <div class="userGreeting">

        <h2>Hi! <?php echo $_SESSION['user']; ?>.</h2>
        <br>

        <form action="../server/logout.php" method="post">
        <button type="submit" name="logout" class="btn2">Logout</button>
        <br><br><br>
        </form>

        <p>This is your personal shopping cart, only successful login user can access.</p>
        <br>

      </div>


    <form action="../server/order.php" method="post">
      <table>
        <tr>
          <th>Products</th>
          <th>Price</th>
          <th>Quantity</th>
          <th>Subtotal</th>
        </tr>

        <tr>
          <td>Model S <input type="hidden" name="aProduct" value="Product A" id="aProduct"></td>
          <td>$30 <input type="hidden" name="aPrice" value="$30" id="aPrice"></td>
          <td><input step="1" min = "0" type="number" name="aQty" value="0" id="aQty" onchange="calc();"></td>
          <td><p id="aSub">0</p><input type="hidden" name="aSubtotal" id="aSubtotal"></td>
        </tr>

        <tr>
          <td>Model X <input type="hidden" name="bProduct" value="Product B" id="bProduct"></td>
          <td>$40 <input type="hidden" name="bPrice" value="$40" id="bPrice"></td>
          <td><input step="1" min = "0" type="number" name="bQty" value="0" id="bQty" onchange="calc();"></td>
          <td><p id="bSub">0</p><input type="hidden" name="bSubtotal" id="bSubtotal"></td>
        </tr>

        <tr>
          <td>Model 3<input type="hidden" name="cProduct" value="Product C" id="cProduct"></td>
          <td>$10 <input type="hidden" name="cPrice" value="$10" id="cPrice"></td>
          <td><input step="1" min = "0" type="number" name="cQty" value="0" id="cQty" onchange="calc();"></td>
          <td><p id="cSub">0</p><input type="hidden" name="cSubtotal" id = "cSubtotal"></td>
        </tr>

        <tr>
          <th></th>
          <th>Total</th>
          <th><p id="total">0</p><input type="hidden" name="totalQty" id="totalQty"></th>
          <th><p id="price">0</p><input type="hidden" name="totalPrice" id="totalPrice"></th>
        </tr>

        <tr>
          <td colspan="2" class="spans"> <p>Your DES key:</p></td>
          <td colspan="2"><input type="text" name="desKey" id="desKey"></td>
        </tr>


        <tr>
          <td colspan="2" class="spans"> <p> Credit Card Number: </p></td>
          <td colspan="2"><input type="text" name="cardNum" id="cardNum" maxlength="16"></td>
        </tr>

        <tr>
          <th></th>
          <th></th>
          <th></th>
          <th><button type="submit" class="btn" onclick="Encryption();">Submit</button></th>
        </tr>

      </table>
    </form>
    </center>
    </div>

    <script src="js/des.js"></script>
    <script src="js/rsa.js"></script>
    <script type="text/javascript">

      function Encryption(){

        // Encrypt the card number using DES key entered by user
        var cardNum = document.getElementById("cardNum").value;
        var key = document.getElementById("desKey").value;
        var encryptednum = javascript_des_encryption(key, cardNum);
        document.getElementById("cardNum").value = encryptednum;

        // Encrypt the shopping cart information using DES key entered by user
        var aSubtotal = document.getElementById("aSubtotal").value;
        var bSubtotal = document.getElementById("bSubtotal").value;
        var cSubtotal = document.getElementById("cSubtotal").value;
        var totalQty = document.getElementById("totalQty").value;
        var totalPrice = document.getElementById("totalPrice").value;

        var aSubtotalE = javascript_des_encryption(key, aSubtotal);
        var bSubtotalE = javascript_des_encryption(key, bSubtotal);
        var cSubtotalE = javascript_des_encryption(key, cSubtotal);
        var totalQtyE = javascript_des_encryption(key, totalQty);
        var totalPriceE = javascript_des_encryption(key, totalPrice);

        document.getElementById("aSubtotal").value = aSubtotalE;
        document.getElementById("bSubtotal").value = bSubtotalE;
        document.getElementById("cSubtotal").value = cSubtotalE;
        document.getElementById("totalQty").value = totalQtyE;
        document.getElementById("totalPrice").value = totalPriceE;


        // Encrypt the DES key using RSA algorithm
        var plaintext = document.getElementById('desKey').value;
        var public_key = "-----BEGIN PUBLIC KEY-----MIIBIjANBgkqhkiG9w0BAQEFAAOCAQ8AMIIBCgKCAQEAzdxaei6bt/xIAhYsdFdW62CGTpRX+GXoZkzqvbf5oOxw4wKENjFX7LsqZXxdFfoRxEwH90zZHLHgsNFzXe3JqiRabIDcNZmKS2F0A7+Mwrx6K2fZ5b7E2fSLFbC7FsvL22mN0KNAp35tdADpl4lKqNFuF7NT22ZBp/X3ncod8cDvMb9tl0hiQ1hJv0H8My/31w+F+Cdat/9Ja5d1ztOOYIx1mZ2FD2m2M33/BgGY/BusUKqSk9W91Eh99+tHS5oTvE8CI8g7pvhQteqmVgBbJOa73eQhZfOQJ0aWQ5m2i0NUPcmwvGDzURXTKW+72UKDz671bE7YAch2H+U7UQeawwIDAQAB-----END PUBLIC KEY-----";

        // Encrypt with the public key
        var encrypt = new JSEncrypt();
        encrypt.setPublicKey(public_key);
        var encryptedkey = encrypt.encrypt(plaintext);
        // assign encrypted value to the plaintext
        document.getElementById('desKey').value = encryptedkey;
      }


      // Calculates the value within shopping cart
      function calc(){

        const A_PRICE = 30;
        const B_PRICE = 40;
        const C_PRICE = 10;

        // get user inputs on quantity
        var Aqty = parseInt(document.getElementById('aQty').value);
        var Bqty = parseInt(document.getElementById('bQty').value);
        var Cqty = parseInt(document.getElementById('cQty').value);

        // calculate subtotals
        var Asubtotal = Aqty * A_PRICE;
        var Bsubtotal = Bqty * B_PRICE;
        var Csubtotal = Cqty * C_PRICE;

        // calculate total quantity and total price
        var total = Aqty + Bqty + Cqty;
        var priceTotal = Asubtotal + Bsubtotal + Csubtotal;

        // display results
        document.getElementById("aSub").innerHTML = Asubtotal;
        document.getElementById("bSub").innerHTML = Bsubtotal;
        document.getElementById("cSub").innerHTML = Csubtotal;

        document.getElementById("total").innerHTML = total;
        document.getElementById("price").innerHTML = priceTotal;

        // Assign results for posting purpose
        document.getElementById("aSubtotal").value = Asubtotal;
        document.getElementById("bSubtotal").value = Bsubtotal;
        document.getElementById("cSubtotal").value = Csubtotal;

        document.getElementById("totalQty").value = total;
        document.getElementById("totalPrice").value = priceTotal;
      }

    </script>



  </body>
</html>
