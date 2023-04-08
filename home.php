<?php
session_start();

if(isset($_SESSION['id']) && isset($_SESSION['name'])){
    
?>
<!DOCTYPE html>
<html>
<head>
   
    <title>HOME</title>
    <link rel="stylesheet" type="text/css" href="css/style.css">
</head>
<body>
    <h1>Hello, <?php echo $_SESSION['name']; ?></h1>
    <a href="logout.php" class="lo">Logout</a>
</body>
</html>

<?php
}else{
    header("Location:index.php");
    exit();
}
?>