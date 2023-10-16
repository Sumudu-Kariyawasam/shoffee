<?php
require "connection.php";
session_start();

if(isset($_GET["id"])){
    $id = $_GET["id"];

    if(isset($_SESSION["user"])){
        $email = $_SESSION["user"]["email"];

        $recent_rs = Database::search("SELECT * FROM `recent` WHERE `product_id`='".$id."' && `user_email`='".$email."'");
        $recent_num = $recent_rs->num_rows;

        if($recent_num == 1){
            $recent_data = $recent_rs->fetch_assoc();
            if($recent_data["type"] == 1){
                echo ("This product already exist in your cart");
            }else if($recent_data["type"] == 2){
                Database::iud("UPDATE `recent` SET `type`='1' WHERE `recent_id`='".$recent_data["recent_id"]."'");
                echo "success";
            }
        }else if($recent_num > 1){
            for($x = 0; $x < $recent_num; $x++){
                $recent_data = $recent_rs->fetch_assoc();

                if($recent_data["type"] == 1){
                    echo ("This product already exist in your cart");
                }else if($recent_data["type"] == 2){
                    Database::iud("UPDATE `recent` SET `type`='1' WHERE `recent_id`='".$recent_data["recent_id"]."'");
                }else if($recent_data["type"] == 3){
                    Database::iud("DELETE FROM `recent` WHERE `recent_id`='".$recent_data["recent_id"]."'");
                }
            }
            echo "success";
        }

        // echo ($recent_num);
    }else{
        echo ("You're not logged in! Please login first");
    }

}else{
    echo ("Product is missing!");
}

?>