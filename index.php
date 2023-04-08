<!DOCTYPE html>
<html>
<head>
    <title>LOGIN</title>
    <link rel="stylesheet" type="text/css" href="css/style.css">
</head>
<body>

    <form action="login.php" method="post">
        <h2>登入</h2>
        
        <?php if(isset($_GET['error'])){?>
            <p class="error"><?php echo $_GET['error'];?></p>
        <?php } ?>
        <label>員工ID</label>
        <input type="text" name="s_id" placeholder="Staff ID"><br>

        <label>使用者密碼</label>
        <input type="password" name="password" placeholder="Password"><br>

        <button type="submit">登入</button>
        <a href="signup.php" class="ca">註冊新帳號</a>
    </form>
</body>
</html>