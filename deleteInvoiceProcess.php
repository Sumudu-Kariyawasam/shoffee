<?php
session_start();
require "connection.php";

if(isset($_SESSION["user"])){
    $email = $_SESSION["user"]["email"];

    if(isset($_GET["id"])){
        $id = $_GET["id"];

        Database::iud("UPDATE `invoice` SET `status`='3' WHERE `order_id`='".$id."' AND `user_email`='".$email."'");
        echo "success";

    }else{
        echo "Oops.. Something is missing";
    }
}else{
    echo "Something went wrong! Please try again later";
}
