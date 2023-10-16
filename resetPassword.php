<?php
require "connection.php";

$email = $_POST["em"];
$code = $_POST["code"];
$n_pw = $_POST["npw"];
$c_pw = $_POST["cpw"];

if(empty($code)){
    echo ("Please enter Verification code");
}else if(strlen($code) != 6){
    echo ("Invalid Verification code");
}else if(empty($n_pw)){
    echo ("Please enter new Password");
}else if(strlen($n_pw) > 20 || strlen($n_pw) < 5){
    echo ("Password must have 5 - 20 characters");
}else if($n_pw != $c_pw){
    echo ("Password does't match");
}else{
    
    $rs = Database::search("SELECT * FROM `user` WHERE `email`='".$email."'");
    $n = $rs->num_rows;

    if($n == 1){
        $data = $rs->fetch_assoc();
        if($code = $data["verification_code"]){
            Database::iud("UPDATE `user` SET `password`='".$n_pw."' WHERE `email`='".$email."'");
            echo ("success");
        }
    }else{
        echo ("No Account with this Email. Please Sign In");
    }
}

?>