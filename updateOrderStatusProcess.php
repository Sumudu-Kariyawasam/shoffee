<?php

session_start();
require "connection.php";

if(isset($_SESSION["user"])){
    $email = $_SESSION["user"]["email"];

    if($_POST["oid"]){

        $oid = $_POST["oid"];
        $pid = $_POST["pid"];
        $status = $_POST["sts"];
    
        if($status != "0"){
            if($pid == "no"){
                $product_rs = Database::search("SELECT * FROM `invoice` INNER JOIN `product` ON 
                invoice.product_id=product.product_id WHERE `order_id`='" . $oid . "' AND  product.user_email='" . $email . "'");
                $product_num = $product_rs->num_rows;

                for($x = 0; $x < $product_num; $x++){
                    $product_data = $product_rs->fetch_assoc();

                    Database::iud("UPDATE `invoice` SET `invoice_status`='".$status."' WHERE `order_id`='".$oid."' AND `product_id`='".$product_data["product_id"]."'");
                }
                echo ("success");
            }else{
                Database::iud("UPDATE `invoice` SET `invoice_status`='".$status."' WHERE `order_id`='".$oid."' AND `product_id`='".$pid."'");
                echo ("success");
            }
        }else{
            echo ("Please select a status to update");
        }
    }else{
        echo ("Something went wrong! Please try again later");
    }
}else{
    echo ("You're not logged in! Please login first");
}

?>