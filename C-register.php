<?php

include 'db_conn.php';

if(isset($_POST['submit'])){

   $name = mysqli_real_escape_string($conn, $_POST['name']);
   $tel = mysqli_real_escape_string($conn, $_POST['tel']);
   $pass = mysqli_real_escape_string($conn, md5($_POST['password']));
   $cpass = mysqli_real_escape_string($conn, md5($_POST['cpassword']));

   $select = mysqli_query($conn, "SELECT * FROM `user_info` WHERE tel = '$tel' AND password = '$pass'") or die('query failed');

   if(mysqli_num_rows($select) > 0){
      $message[] = 'user already exist!';
   }else{
      mysqli_query($conn, "INSERT INTO `user_info`(name, tel, password) VALUES('$name', '$tel', '$pass')") or die('query failed');
      $message[] = 'registered successfully!';
      header('location:C-login.php');
   }

}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>建立帳號</title>

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/style-1.css">

</head>
<body style="background: url('img/bg2.jpg') 
    center center fixed no-repeat;
    background-size: cover;
    height: 100%;
    width: 100%;"
    >

<?php
if(isset($message)){
   foreach($message as $message){
      echo '<div class="message" onclick="this.remove();">'.$message.'</div>';
   }
}
?>
   
<div class="form-container">

   <form action="" method="post">
      <h3>蔬菜農場的新用戶</h3>
      <input type="text" name="name" required placeholder="輸入名稱" class="box">
      <input type="tel" name="tel" required placeholder="輸入電話" class="box">
      <input type="password" name="password" required placeholder="輸入密碼" class="box">
      <input type="password" name="cpassword" required placeholder="再次輸入密碼" class="box">
      <input type="submit" name="submit" class="btn" value="創建">
      <p>有註冊了嗎? <a href="C-login.php">馬上登入</a></p>
   </form>

</div>

</body>
</html>