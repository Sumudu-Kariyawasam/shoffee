<?php
require "connection.php";
session_start();

if(isset($_SESSION["user"])){

    $email = $_SESSION["user"]["email"];
    if(isset($_POST["ar"])){
        $arr = $_POST["ar"];
        $array = explode(",",$arr);
        $size = count($array);

        for($x = 0; $x < $size; $x++){
            $prosuct_rs = Database::search("SELECT * FROM `recent` WHERE `user_email`='".$email."' && 
            `product_id`='".$array[$x]."' && `type`='1'");
            $prosuct_num = $prosuct_rs->num_rows;

            if($prosuct_num == 0){
                Database::iud("UPDATE `recent` SET `type`='1' WHERE `user_email`='".$email."' && 
                `product_id`='".$array[$x]."' && `type`='2'");
            }else{
                Database::iud("DELETE FROM `recent` WHERE `user_email`='".$email."' && 
                `product_id`='".$array[$x]."' && `type`='1'");
            }
        }
        echo "success";
    }else{
        echo "Something went wrong";
    }

}else{
    echo ("You're not logged in! Please login first");
}

?>