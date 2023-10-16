<?php
require "connection.php";

$email = $_GET["em"];

if(empty($email)){
    echo ("Please enter your Email");
}else if(strlen($email) > 100){
    echo ("Email must have less than 100 characters");
}else if(!filter_var($email,FILTER_VALIDATE_EMAIL)){
    echo ("Invalid Email!");
}else{

    $rs = Database::search("SELECT * FROM `user` WHERE `email`='".$email."'");
    $n = $rs->num_rows;

    if($n == 1){
        $code = rand(100000, 999999);
        Database::iud("UPDATE `user` SET `verification_code`='".$code."' WHERE `email`='".$email."'");
        echo ("success");
    }else{
        echo ("No Account with this Email");
    }
}

?>