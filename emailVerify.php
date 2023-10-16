<?php
require "connection.php";

$email = $_POST["em"];
$v_code = $_POST["vc"];

$rs = Database::search("SELECT * FROM `user` WHERE `email`='".$email."'");
$n = $rs->num_rows;

    if($n == 1){
        $data = $rs->fetch_assoc();
        if($data["verification_code"] == $v_code){
            Database::iud("UPDATE `user` SET `status`='1' WHERE `email`='".$email."'");
            echo ("success");
        }else{
            echo ("Invalid Verification code!");
        }
    }else{
        echo ("Something went wrong!");
    }


?>