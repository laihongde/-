<?php
session_start();
include"db_conn.php";

if(isset($_POST['password']) && isset($_POST['name']) && 
isset($_POST['re_password']) && isset($_POST['bir'])){

    function validate($data){
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }

    $name = validate($_POST['name']);
    $bir = validate($_POST['bir']);
    $gen = validate($_POST['gen']);
    $pass = validate($_POST['password']);
    $re_pass = validate($_POST['re_password']);


    $user_data = '&name='. $name . '&bir=' . $bir . 'gen=' . $gen;

    If(empty($name)){
        header("Location:signup.php?error=Name is required&$user_data");
        exit();
    }elseif(empty($bir)){
        header("Location:signup.php?error=Birthday is required&$user_data");
        exit();
    }elseif(empty($gen)){
        header("Location:signup.php?error=Gender is required&$user_data");
        exit();
    }elseif(empty($pass)){
        header("Location:signup.php?error=Password is required&$user_data");
        exit();
    }elseif(empty($re_pass)){
        header("Location:signup.php?error=Re Password is required&$user_data");
        exit();
    }
    else if($pass !== $re_pass){
        header("Location:signup.php?error=The confirmation password does not match&$user_data");
        exit();
    }
    else{
        //hashing the password
        $pass = md5($pass);

        $sql = "SELECT * FROM users WHERE name='$name'";
        $result = mysqli_query($conn,$sql);

        if(mysqli_num_rows($result) > 0){
            header("Location:signup.php?error=The name is taken try another&$user_data");
            exit();
        }else{
            $sql2 = "INSERT INTO users(gen,bir,password,name) VALUES('$gen','$bir','$pass','$name')";
            $result2 = mysqli_query($conn,$sql2);
            $name2=$name;
            if($result2){
                header("Location:signup.php?success=Your account has been created successfully&name2='$name2'");
                
                exit();
            }else{
                header("Location:signup.php?error=unknown error occurred&$user_data");
                exit();
            }
        }
    }
}else{
    header("Location:signup.php");
    exit();
}