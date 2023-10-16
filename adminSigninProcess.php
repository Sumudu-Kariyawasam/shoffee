<?php

require "connection.php";
session_start();

$email = $_POST["em"];
$v_code = $_POST["vc"];
$password = $_POST["ap"];

if(empty($v_code)){
    echo ("Please enter the Verification Code!");
}else if(strlen($v_code) != 6){
    echo ("Invalid Verification Code!");
}else if(empty($password)){
    echo ("Please enter your Password!");
}else if(strlen($password) > 20 || strlen($password) < 5){
    echo ("Password must have been 5 - 20 characters!");
}else{

    $admin_rs = Database::search("SELECT * FROM `admin` WHERE `admin_email`='".$email."' 
    AND `verification_code`='".$v_code."' AND `password`='".$password."'");
    $admin_num = $admin_rs->num_rows;

    if($admin_num > 0){
        $admin_data = $admin_rs->fetch_assoc();
        $_SESSION["admin"] = $admin_data;

        echo ("success");

    }else{
        echo ("Incorrect Verification Code or Password!");
    }
}
