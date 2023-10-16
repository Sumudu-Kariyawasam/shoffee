<?php

require "connection.php";
session_start();

if(isset($_SESSION["user"])){
    $user = $_SESSION["user"];
    $email = $_SESSION["user"]["email"];

    if(isset($_POST["id"])){
        $pid = $_POST["id"];
        $product_rs = Database::search("SELECT * FROM `product` WHERE `product_id`='".$pid."'");
        $product_data = $product_rs->fetch_assoc();

        if($email == $product_data["user_email"]){
            $feedback = $_POST["face"];
            $stars = $_POST["star"];
            $comment = $_POST["comm"];
        
            Database::iud("INSERT INTO `feedback` (`feedback`,`stars`,`comment`,`product_id`,`user_email`) 
            VALUES ('".$feedback."','".$stars."','".$comment."','".$pid."','".$email."')");
    
            echo ("success");
        }else{
            echo ("Error! You can't sent feedback to your own products");
        }
    }else{
        echo ("Something is missing!");
    }

}else{
    echo ("Something went wrong! Please try again later.");
}

?>