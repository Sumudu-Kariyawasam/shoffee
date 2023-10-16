<?php

session_start();
require "connection.php";

if(isset($_SESSION["admin"])){
    $admin = $_SESSION["admin"];

    $brand = $_POST["br"];
    $sub_cate = $_POST["sc"];
    $password = $_POST["pw"];

    if(empty($brand)){
        echo "Please enter a brand name!";
    }else if($sub_cate == 0){
        echo "Please select the parent sub category!";
    }else if(empty($password)){
        echo "Please enter your password!";
    }else if($password != $admin["password"]){
        echo "Invalid password!";
    }else{
        $brand_rs = Database::search("SELECT * FROM `brand` WHERE `brand`='".$brand."'");
        $brand_num = $brand_rs->num_rows;

        if($brand_num > 0) {
            $brand_data = $brand_rs->fetch_assoc();

            $sub_rs = Database::search("SELECT * FROM `brand_has_sub_category` WHERE `brand_id`='".$brand_data["brand_id"]."' AND `sub_category_id`='".$sub_cate."'");
            $sub_num = $sub_rs->num_rows;

            if($sub_num > 0) {
                echo "This brand already exists!";
            }else{

                Database::iud("INSERT INTO `brand` (`brand`) VALUES ('".$brand."')");
                $brand_id = Database::$connection->insert_id;

                Database::iud("INSERT INTO `brand_has_sub_category` (`brand_id`,`sub_category_id`) VALUES ('".$brand_id."','".$sub_cate."')");
                echo "success";
                    
            }
        }else {

            Database::iud("INSERT INTO `brand` (`brand`) VALUES ('".$brand."')");
            $brand_id = Database::$connection->insert_id;

            Database::iud("INSERT INTO `brand_has_sub_category` (`brand_id`,`sub_category_id`) VALUES ('".$brand_id."','".$sub_cate."')");
            echo "success";

        }
    }

}else{
    header("location:adminSignin.php");
}
