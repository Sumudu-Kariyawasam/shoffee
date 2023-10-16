<?php

require "connection.php";

session_start();

$email = $_POST["em"];
$password = $_POST["pw"];
$remember = $_POST["rm"];

if(empty($email)){
    echo ("Please enter your Email");
}else if(strlen($email) > 100){
    echo ("Email must have less than 100 characters");
}else if(!filter_var($email,FILTER_VALIDATE_EMAIL)){
    echo ("Invalid Email!");
}else if(empty($password)){
    echo ("Please enter your Password");
}else if(strlen($password) > 20 || strlen($password) < 5){
    echo ("Password must have 5 - 20 characters");
}else{
    $rs = Database::search("SELECT * FROM `user` WHERE `email`='".$email."' AND `password`='".$password."'");
    $n = $rs->num_rows;

    if($n == 1){
        $data = $rs->fetch_assoc();
        $_SESSION["user"] = $data;
        echo ("success");

        if($remember == "true"){
            setcookie("USem-rEbme", $email, time() + (60 * 60 * 24 * 365));
            setcookie("USpd-rEbme", $password, time() + (60 * 60 * 24 * 365));
        }else{
            setcookie("USEM-rEbme", $email, time() + 0);
            setcookie("USpd-rEbme", $password, time() + 0);
        }
    }else{
        echo ("Invalid Email or Password!");
    }
}

?>