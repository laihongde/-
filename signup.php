<?php
include "db_conn.php";
?>
<!DOCTYPE html>
<html>

<head>
    <title>SIGN UP</title>
    <link rel="stylesheet" type="text/css" href="css/style.css">
</head>

<body>
    <?php
    if (isset($_GET['name2']) ) {
        require("db_conn.php");
        function s_ID($name, $conn)
        {
            $sql = "SELECT `id` FROM users WHERE name = $name";
            $result = mysqli_query($conn, $sql);
            $row = mysqli_fetch_array($result);
            $id = $row['id'];
            echo "<script>alert('員工ID為:$id')</script>";
        }
        s_ID($_GET['name2'], $conn);
    }?>
    <form action="signup-check.php" method="post">
        <h2>註冊</h2>
        <?php if (isset($_GET['error'])) { ?>
            <p class="error"><?php echo $_GET['error']; ?></p>
        <?php } ?>

        <?php if (isset($_GET['success'])) { ?>
            <p class="success"><?php echo $_GET['success']; ?></p>
        <?php } ?>

        <label>名稱</label>
        <?php if (isset($_GET['name'])) { ?>
            <input type="text" name="name" placeholder="Name" value="<?php echo $_GET['name']; ?>"><br>
        <?php } else { ?>
            <input type="text" name="name" placeholder="Name"><br>
        <?php } ?>

        <label>生日</label>
        <?php if (isset($_GET['bir'])) { ?>
            <input type="date" name="bir" placeholder="Birthday" value="<?php echo $_GET['bir']; ?>"><br>
        <?php } else { ?>
            <input type="date" name="bir" placeholder="Birthday"><br>
        <?php } ?>

        <label>性別</label><br>
        <?php if (isset($_GET['gen'])) { ?>
            <input class="ingender" type="radio" name="gen" placeholder="Gender" value="male">男
            <input class="ingender" type="radio" name="gen" placeholder="Gender" value="female">女
            <br>
        <?php } else { ?>
            <input class="ingender" type="radio" name="gen" placeholder="Gender" value="male">男
            <input class="ingender" type="radio" name="gen" placeholder="Gender" value="female">女<br>
        <?php } ?>

        <label>使用者密碼</label>
        <input type="password" name="password" placeholder="Password" id="pass"><br>
        <label>確認密碼</label>
        <input type="password" name="re_password" placeholder="Re_Password" id="re_pass"><br>

        <button type="submit">完成</button>
        <a href="index.php" class="ca">已經有帳號了嗎?</a>
    </form>
</html>