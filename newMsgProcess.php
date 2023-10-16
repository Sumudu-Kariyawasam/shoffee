<?php

session_start();
require "connection.php";
$receiver = $_POST["rem"];

if(isset($_SESSION["user"])){
    $email = $_SESSION["user"]["email"];

    if(empty($receiver)){
        echo ("Please enter Email to start Chat");
    }else if(strlen($receiver) > 100){
        echo ("Email must have less than 100 characters!");
    }else if(!filter_var($receiver,FILTER_VALIDATE_EMAIL)){
        echo ("Invalid Email!");
    }else{

        $receiver_rs = Database::search("SELECT * FROM `user` WHERE `email`='".$receiver."'");
        $receiver_num = $receiver_rs->num_rows;

        if($receiver_num > 0){
            if(!empty($_POST["txt"])){
                
                $text = $_POST["txt"];

                $d = new DateTime();
                $tz = new DateTimeZone("Asia/colombo");
                $d->setTimezone($tz);
                $date = $d->format("Y-m-d H:i:s");

                Database::iud("INSERT INTO `chat` (`content`,`sent_date_time`,`from`,`to`,`msg_status`) 
                VALUES ('".$text."','".$date."','".$email."','".$receiver."','1')");

                echo ("success");
            }else{
                echo ("Please Enter Your Message!");
            }
        }else{
            echo ("No user with this Email. Please check Email again!");
        }
    }
}else{
    echo "You're not logged in! Please login first";
}

?>