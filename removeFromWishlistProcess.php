<?php

require "connection.php";
session_start();

if(isset($_GET["id"])){
    $id = $_GET["id"];

    if(isset($_SESSION["user"])){
        $email = $_SESSION["user"]["email"];

        $recent_rs = Database::search("SELECT * FROM `recent` WHERE `product_id`='".$id."' AND `user_email`='".$email."' AND `type`='2'");
        $recent_data = $recent_rs->fetch_assoc();

        $rec_exist_rs = Database::search("SELECT * FROM `recent` WHERE `product_id`='".$id."' AND `user_email`='".$email."' AND `type`='3'");
        $rec_exist_num = $rec_exist_rs->num_rows;

        if($rec_exist_num > 0){
            Database::iud("DELETE FROM `recent` WHERE `recent_id`='".$recent_data["recent_id"]."'");
        }else{
            Database::iud("UPDATE `recent` SET `type`='3' WHERE `recent_id`='".$recent_data["recent_id"]."'");
        }

        echo ("success");
    }else{
        echo ("You're not logged in! Please login first");
    }

}else{
    echo ("Product is missing!");
}

?>