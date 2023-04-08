<?php

$sname = "localhost";
$uname = "B11056047";
$password = "B11056047";
$db_name = "veg_mgmt_db";

$conn = mysqli_connect($sname,$uname,$password,$db_name);

if(!$conn){
    echo "Connection failed!";
}