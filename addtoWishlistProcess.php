<?php

require "connection.php";
session_start();

if(isset($_GET["id"])){
    $id = $_GET["id"];

    if(isset($_SESSION["user"])){
        $email = $_SESSION["user"]["email"];

        $recent_rs = Database::search("SELECT * FROM `recent` WHERE `product_id`='".$id."' && `user_email`='".$email."' && `type`='2'");
        $recent_num = $recent_rs->num_rows;
        $recent_data = $recent_rs->fetch_assoc();

        $d = new DateTime();
        $tz = new DateTimeZone("Asia/colombo");
        $d->setTimezone($tz);
        $date = $d->format("Y-m-d");

        if($recent_num > 0){
            if($recent_data["type"] == 2){
                echo ("This product already exist in your wishlist");
            }else if($recent_data["type"] == 3){
                Database::iud("UPDATE `recent` SET `type`='2' WHERE `recent_id`='".$recent_data["recent_id"]."'");
            }
        }else{

            Database::iud("INSERT INTO `recent` (`product_id`,`user_email`,`type`,`added_date`,`qty`) 
            VALUES ('".$id."','".$email."','2','".$date."','1')");
            echo ("success");
        }
    }else{
        echo ("You're not logged in! Please login first");
    }

}else{
    echo ("Product is missing!");
}

?>