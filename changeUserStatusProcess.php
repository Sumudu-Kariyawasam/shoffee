<?php
require "connection.php";

if(isset($_GET["em"])){
    $email = $_GET["em"];

    $user_rs = Database::search("SELECT * FROM `user` WHERE `email`='".$email."'");
    $user_num = $user_rs->num_rows;

    if($user_num == 1){
        $user_data = $user_rs->fetch_assoc();
        $status = $user_data["status"];
        if($status == 1){
            Database::iud("UPDATE `user` SET `status`='2' WHERE `email`='".$email."'");
            echo "2";
        }else if($status == 2){
            Database::iud("UPDATE `user` SET `status`='1' WHERE `email`='".$email."'");
            echo "1";
        }
    }else{
        echo "Something went wrong";
    }
}else{
    echo "Oops.! Something is missing";
}

?>