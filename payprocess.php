<?php

session_start();
require "connection.php";

if(isset($_SESSION["user"])){
    $user = $_SESSION["user"];
}

if(isset($_POST["order_id"])){
    $oid = $_POST["order_id"];

    Database::search("UPDATE `invoice` SET `invoice_status`='2' WHERE `order_id`='".$oid."' AND `user_email`='".$user["email"]."'");
    echo ("success");

}

?>