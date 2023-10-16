<?php

require "connection.php";
session_start();

if(isset($_SESSION["admin"])){
    $admin = $_SESSION["admin"];

    if(isset($_GET["iid"]) && isset($_GET["stt"])){

        $iid = $_GET["iid"];
        $status = $_GET["stt"];

        Database::iud("UPDATE `invoice` SET `invoice_status`='".$status."' WHERE `invoice_id`='".$iid."'");
        echo "Order Status Updated";

    }else{
        echo "Something is missing!";
    }

}else{
    echo "Error.! - Unauthorized Action";
}

?>