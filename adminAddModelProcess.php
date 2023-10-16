<?php

session_start();
require "connection.php";

if(isset($_SESSION["admin"])){
    $admin = $_SESSION["admin"];

    $model = $_POST["md"];
    $brand = $_POST["br"];
    $sub_cate = $_POST["sc"];
    $password = $_POST["pw"];

    if(empty($model)){
        echo "Please enter a model name!";
    }else if($brand == 0){
        echo "Please select the parent brand!";
    }else if($sub_cate == 0){
        echo "Please select the parent sub category!";
    }else if(empty($password)){
        echo "Please enter your password!";
    }else if($password != $admin["password"]){
        echo "Invalid password!";
    }else{
        $model_rs = Database::search("SELECT * FROM `model` WHERE `model`='".$model."'");
        $model_num = $model_rs->num_rows;

        if($model_num > 0) {
            $model_data = $model_rs->fetch_assoc();
            $brand_rs = Database::search("SELECT * FROM `brand_has_model` 
            WHERE `model_id`='".$model_data["model_id"]."' AND `brand_id`='".$brand."' AND `sub_category_id`='".$sub_cate."'");
            $brand_num = $brand_rs->num_rows;

            if($brand_num > 0){
                echo "This Model already exists!";
            }else {

                Database::iud("INSERT INTO `model` (`model`) VALUES ('".$model."')");
                $model_id = Database::$connection->insert_id;

                Database::iud("INSERT INTO `brand_has_model` (`sub_category_id`,`model_id`,`brand_id`) VALUES ('".$sub_cate."','".$model_id."','".$brand."')");
                echo "success";
    
            }
        }else {

            Database::iud("INSERT INTO `model` (`model`) VALUES ('".$model."')");
            $model_id = Database::$connection->insert_id;

            Database::iud("INSERT INTO `brand_has_model` (`sub_category_id`,`model_id`,`brand_id`) VALUES ('".$sub_cate."','".$model_id."','".$brand."')");
            echo "success";

        }
    }

}else{
    header("location:adminSignin.php");
}
