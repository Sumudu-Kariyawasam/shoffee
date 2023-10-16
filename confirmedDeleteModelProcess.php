<?php

session_start();
require "connection.php";

if(isset($_SESSION["admin"])){

    $id = $_GET["id"];

    Database::iud("DELETE FROM `brand_has_model` WHERE `model_id` = '".$id."'");
    Database::iud("DELETE FROM `model` WHERE `model_id` = '".$id."'");

    echo "success";

}

?>