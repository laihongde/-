<?php

include 'db_conn.php';
session_start();

if(isset($_POST['submit'])){

   $tel = mysqli_real_escape_string($conn, $_POST['tel']);
   $pass = mysqli_real_escape_string($conn, md5($_POST['password']));

   $select = mysqli_query($conn, "SELECT * FROM `user_info` WHERE tel = '$tel' AND password = '$pass'") or die('query failed');

   if(mysqli_num_rows($select) > 0){
      $row = mysqli_fetch_assoc($select);
      $_SESSION['user_id'] = $row['id'];
      header('location:C-index.php');
   }else{
      $message[] = 'incorrect password or tel!';
   }

}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <!-- 清理緩存 -->
   <meta http-equiv="cache-control" content="no-cache">
   <meta http-equiv="pragma" content="no-cache">
   <meta http-equiv="expires" content="0">
   
   <title>登入介面</title>

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/style-1.css">

</head>
<body style="background: url('img/bg2.jpg') 
    center center fixed no-repeat;
    background-size: cover;
    height: 100%;
    width: 100%;
    ">

<?php
if(isset($message)){
   foreach($message as $message){
      echo '<div class="message" onclick="this.remove();">'.$message.'</div>';
   }
}
?>
   
<div class="form-container">

   <form action="" method="post">
      <h3>登入介面</h3>
      <input type="tel" name="tel" required placeholder="輸入電話" class="box">
      <input type="password" name="password" required placeholder="輸入密碼" class="box">
      <input type="submit" name="submit" class="btn" value="登入">
      <p>新增帳戶<a href="C-register.php">註冊</a></p>
   </form>

</div>

</body>
</html>