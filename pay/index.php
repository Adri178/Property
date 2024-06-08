<?php
session_start();
// var_dump($_SESSION);

include("../config.php");
$error="";
$msg="";

if (isset($_POST['submit'])) {
    if(isset($_SESSION['name'], $_SESSION['email'], $_SESSION['phone'], $_SESSION['pass'], $_SESSION['utype'])){
      $name=$_SESSION['name'];
      $email=$_SESSION['email'];
      $phone=$_SESSION['phone'];
      $pass=$_SESSION['pass'];
      $utype=$_SESSION['utype'];

      $uimage=$_SESSION['uimage'];
      // $temp_name1 = $_SESSION['temp_name1'];
      $pass= sha1($pass);
      
      $query = "SELECT * FROM user where uemail='$email'";
      $res=mysqli_query($con, $query);
      $num=mysqli_num_rows($res);
      
      if($num != 1)
      {
          
          if(!empty($name) && !empty($email) && !empty($phone) && !empty($pass))
          {
              
              $sql="INSERT INTO user (uname,uemail,uphone,upass,utype,uimage) VALUES ('$name','$email','$phone','$pass','$utype', 'admin/user/$uimage')";
              $result=mysqli_query($con, $sql);
              // move_uploaded_file($temp_name1,"admin/user/$uimage");
                if($result){
                    echo "<script> alert('Register Successfully Silahkan Login kembali :)') </script>";
                    echo "<script> window.location.href='../login.php'; </script>";
                    session_destroy();
                }
                else{
                    $error = "<p class='alert alert-warning'>Register Not Successfully</p> ";
                }
          }else{
              $error = "<p class='alert alert-warning'>Please Fill all the fields</p>";
          }
      }
      
 }
}
?>


<!DOCTYPE html>
<html ng-app="">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>FORM PAY</title>
  <style>
    body {
      background: #F0F0F0;
      margin: 0;
      color: gray;
      font-family: calibri;
    }

    input:invalid {
      background: pink;
    }

    .container {
      background: white;
      width: 40%;
      height: auto;
      padding: 15px;
      position: absolute;
      left: 30%;
      top: 1%;
      border-radius: 5px;
    }

    .input-form {
      width: 95%;
      background: #F9F9F9;
      margin: 0.9%;
      padding: 10px;
      border: none;
      border-radius: 5px;
    }

    .input-form-number {
      width: 12%;
      background: #F9F9F9;
      margin: 1%;
      padding: 10px;
      border: none;
      border-radius: 5px;
    }

    .input-form-value {
      width: 57.5%;
      background: #F9F9F9;
      margin: 1%;
      padding: 10px;
      border: none;
      border-radius: 5px;
    }

    .btn-form-change {
      color: white;
      background: #ff6868;
      font-weight: bold;
      border: none;
      border-radius: 50px;
      padding: 15px;
      margin: 10px;
      width: 35%;
      float: left;
      margin-left: 20px;
      cursor: pointer;
    }

    .btn-form-pay {
      color: white;
      background: #68a2ff;
      font-weight: bold;
      border: none;
      border-radius: 50px;
      padding: 15px;
      margin: 10px;
      width: 35%;
      float: right;
      cursor: pointer;
    }

    .btn-form-pay:hover {
      background: #66bef9;
    }

    .btn-form-change:hover {
      background: #fc7979;
    }

    table {
      margin-top: 5px;
      border-collapse: collapse;
      width: 100%;
      border: 1px solid #ddd;
    }

    th,
    td {
      background: white;
    }

    th img {
      cursor: pointer;
    }

    th:hover {
      box-shadow: 2px 0px 10px 0px #F4F4F4;
      border: 1px solid #68a2ff;
    }

    th {
      border: 1px solid #F4F4F4;
    }

    @media only screen and (max-width: 700px) {
      .container {
        width: 80%;
        left: 6%;
      }

      .input-form-value {
        width: 49%;
      }
    }

    footer {
      background: white;
      width: 100%;
      height: 40px;
      position: absolute;
      bottom: 0;
    }
  </style>
  <script>
    function showAccountNumber() {
      var images = document.querySelectorAll('th img');
      images.forEach((image) => {
        image.addEventListener('click', function () {
          images.forEach((img) => {
            img.classList.remove('selected');
          });
          this.classList.add('selected');
          var accountNumber = "";
          switch (this.alt) {
            case "BNI":
              accountNumber = "1234567890 (BNI)";
              break;
            case "BCA":
              accountNumber = "1234567891 (BCA)";
              break;
            case "BRI":
              accountNumber = "0987654321 (BRI)";
              break;
            case "BJB":
              accountNumber = "1234567892 (BJB)";
              break;
            case "BankDKI":
              accountNumber = "1234567893 (Bank DKI)";
              break;
            case "BankBB":
              accountNumber = "1234567894 (Bank BB)";
              break;
            case "Visa":
              accountNumber = "1234567895 (Visa)";
              break;
            case "MasterCard":
              accountNumber = "1234567896 (MasterCard)";
              break;
            case "PayPal":
              accountNumber = "1234567897 (PayPal)";
              break;
            case "Alfamart":
              accountNumber = "1234567898 (Alfamart)";
              break;
            case "Indomaret":
              accountNumber = "1234567899 (Indomaret)";
              break;
            case "GoPay":
              accountNumber = "12345678910 (GoPay)";
              break;
          }
          document.getElementById("accountNumber").innerText = accountNumber;
        });
      });
    }
    document.addEventListener('DOMContentLoaded', showAccountNumber);
  </script>
</head>

<body>
  <div class="container">
    <h1 style="margin:10px;">PAYMENT</h1>
    <form method="post">
      <input required  class="input-form laf" type="text" name="nama" value="" placeholder="Nama Rekening">
      <input required class="input-form laf" type="number" name="id" value="" placeholder="Nomor Rekening Anda">
      <textarea required class="input-form" cols="5" rows="5" name="catatan" placeholder="Catatan"></textarea>
      <div style="overflow-x:auto;">
        <label>Pilih Metode Pembayaran</label>
        <table border="0" cellpadding="10">
          <tr>
            <th><img src="img/bni.png" width="60px" height="20px" alt="BNI"></th>
            <th><img src="img/logo-bca.png" width="60px" height="20px" alt="BCA"></th>
            <th><img src="img/bri.png" width="60px" height="25px" alt="BRI"></th>
            <th><img src="img/bjb.png" width="60px" height="30px" alt="BJB"></th>
            <th><img src="img/bankdki.png" width="60px" height="25px" alt="BankDKI"></th>
            <th><img src="img/bankbb.png" width="60px" height="20px" alt="BankBB"></th>
          </tr>
          <tr>
            <th><img src="img/visa.png" width="60px" height="30px" alt="Visa"></th>
            <th><img src="img/masterc.png" width="60px" height="30px" alt="MasterCard"></th>
            <th><img src="img/paypal.png" width="60px" height="20px" alt="PayPal"></th>
            <th><img src="img/alfa.jpg" width="70px" height="50px" alt="Alfamart"></th>
            <th><img src="img/indomaret.png" width="60px" height="20px" alt="Indomaret"></th>
            <th><img src="img/gopay.jpg" width="65px" height="40px" alt="GoPay"></th>
          </tr>
        </table>
      </div>
      <div class="form-group">
        <label for="accountNumber">Account Number</label>
        <p id="accountNumber" class="account-number"></p>
      </div>
      <div class="form-group">
        <label required for="paymentProof">Upload Bukti Pembayaran</label>
        <input type="file" id="paymentProof" name="paymentProof">
      </div>
      <a href="../index.php"><button type="submit" class="btn-form-pay" name="submit">SUBMIT</button></a>
      <button class="btn-form-change" id="myBtn">Batal</button>
    </form>
  </div>
</body>

</html>
