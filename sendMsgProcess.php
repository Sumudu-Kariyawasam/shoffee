<?php

session_start();
require "connection.php";

if(isset($_SESSION["user"])){
    $email = $_SESSION["user"]["email"];

    if(isset($_POST["em"])){
        if(isset($_POST["txt"])){
            $receiver = $_POST["em"];
            $text = $_POST["txt"];

            $d = new DateTime();
            $tz = new DateTimeZone("Asia/colombo");
            $d->setTimezone($tz);
            $date = $d->format("Y-m-d H:i:s");

            Database::iud("INSERT INTO `chat` (`content`,`sent_date_time`,`from`,`to`,`msg_status`) 
            VALUES ('".$text."','".$date."','".$email."','".$receiver."','1')");

            echo ("success");
        }
    }else{
        echo ("Something is missing!");
    }
}else{
    echo "You're not logged in! Please login first";
}

?>