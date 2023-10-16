<?php

session_start();
require "connection.php";

if(isset($_SESSION["admin"])){
    $admin = $_SESSION["admin"];

    $sub_cate = $_POST["sb"];
    $category = $_POST["cg"];
    $password = $_POST["pw"];

    if(empty($sub_cate)){
        echo "Please enter a sub category name!";
    }else if($category == 0){
        echo "Please select the parent category!";
    }else if(empty($password)){
        echo "Please enter your password!";
    }else if($password != $admin["password"]){
        echo "Invalid password!";
    }else{
        $cate_rs = Database::search("SELECT * FROM `sub_category` WHERE `sub_category_name`='".$category."'");
        $cate_num = $cate_rs->num_rows;

        if($cate_num > 0) {
            $cate_data = $cate_rs->fetch_assoc();
            $sub_rs = Database::search("SELECT * FROM `category_has_sub_category` WHERE `sub_category_id`='".$cate_data["sub_category_id"]."' AND `category_id`='".$category."'");
            $sub_num = $sub_rs->num_rows;

            if($sub_num > 0){
                echo "This category already exists!";
            }else {

                Database::iud("INSERT INTO `sub_category` (`sub_category_name`) VALUES ('".$sub_cate."')");
                $sub_cate_id = Database::$connection->insert_id();

                Database::iud("INSERT INTO `category_has_sub_category` (`sub_category_id`,`category_id`) VALUES ('".$sub_cate_id."','".$category."')");
                echo "success";
    
            }
        }else {

            Database::iud("INSERT INTO `sub_category` (`sub_category_name`) VALUES ('".$sub_cate."')");
            $sub_cate_id = Database::$connection->insert_id;

            Database::iud("INSERT INTO `category_has_sub_category` (`sub_category_id`,`category_id`) VALUES ('".$sub_cate_id."','".$category."')");
            echo "success";

        }
    }

}else{
    header("location:adminSignin.php");
}

?>