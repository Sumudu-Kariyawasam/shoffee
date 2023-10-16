<?php
session_start();
require "connection.php";

$id = $_GET["id"];
if(isset($_SESSION["user"])){
    $user = $_SESSION["user"];
    $email = $user["email"];

    Database::iud("UPDATE `product` SET `status`='3' WHERE `product_id`='".$id."' AND `user_email`='".$email."'");
    echo ("success");

}else if(isset($_SESSION["admin"])){

    Database::iud("UPDATE `product` SET `status`='3' WHERE `product_id`='".$id."'");
    echo ("success");

}
?>