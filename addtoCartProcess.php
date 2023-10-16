<?php
require "connection.php";
session_start();

if(isset($_GET["id"])){
    $id = $_GET["id"];
    
    if(isset($_GET["qt"])){
        $qty = $_GET["qt"];
    }else{
        $qty = 1;
    }

    if(isset($_SESSION["user"])){
        $email = $_SESSION["user"]["email"];

        $recent_rs = Database::search("SELECT * FROM `recent` WHERE `product_id`='".$id."' && `user_email`='".$email."'");
        $recent_num = $recent_rs->num_rows;
        $recent_data = $recent_rs->fetch_assoc();

        $d = new DateTime();
        $tz = new DateTimeZone("Asia/colombo");
        $d->setTimezone($tz);
        $date = $d->format("Y-m-d");

        if($recent_num > 0){
            if($recent_data["type"] == 1){
                echo ("This product already exist in your cart");
            }else if($recent_data["type"] == 3){
                Database::iud("UPDATE `recent` SET `type`='1',`added_date`='".$date."' WHERE `recent_id`='".$recent_data["recent_id"]."'");
            }
        }else{

            Database::iud("INSERT INTO `recent` (`product_id`,`user_email`,`type`,`added_date`,`qty`) 
            VALUES ('".$id."','".$email."','1','".$date."','".$qty."')");
            echo ("Product added to cart");
        }
    }else{
        echo ("You're not logged in! Please login first");
    }

}else{
    echo ("Product is missing!");
}

?>