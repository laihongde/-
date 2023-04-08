<?php
session_start();
include"db_conn.php";

if(isset($_POST['s_id'])&&isset($_POST['password'])){

    function validate($data){
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }
    
    $s_id = validate($_POST['s_id']);
    $pass = validate($_POST['password']);

    if(empty($s_id)){
        header("Location:index.php?error=Staff ID is required");
        exit();
    }elseif(empty($pass)){
        header("Location:index.php?error=Password is required");
        exit();
    }else{
        //hashing the password
        $pass = md5($pass);
        
        $sql = "SELECT * FROM users WHERE id='$s_id' AND password='$pass'";

        $result = mysqli_query($conn,$sql);

        if(mysqli_num_rows($result) === 1){
            $row = mysqli_fetch_assoc($result);
            if($row['id'] === $s_id && $row['password'] === $pass){
                $_SESSION['id'] = $row['id'];
                $_SESSION['name'] = $row['name'];
                $_SESSION['id'] = $row['id'];
                header("Location:block.php");
                exit();
            }else{
                header("Location:index.php?error=Incorect Staff ID or password");
                exit();
            }
        }else{
            header("Location:index.php?error=Incorect Staff ID or password");
            exit();
        }
    }
}else{
    header("Location:index.php");
    exit();
    
}