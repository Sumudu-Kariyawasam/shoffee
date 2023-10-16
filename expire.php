<?php
require "connection.php";
sleep(30);

$ex = $_POST["ex"];
$email = $_POST["em"];

if($ex == "ex"){
    $code = rand(100001, 900001);
    Database::iud("UPDATE `user` SET `verification_code`='".$code."' WHERE `email`='".$email."'");
}else if($ex = "ax"){
    $code = rand(100001, 900001);
    Database::iud("UPDATE `admin` SET `verification_code`='".$code."' WHERE `admin_email`='".$email."'");
}

?>