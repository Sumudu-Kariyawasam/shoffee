<?php

session_start();
require "connection.php";

if(isset($_SESSION["admin"])){
    $admin = $_SESSION["admin"];

    $category = $_POST["cg"];
    $password = $_POST["pw"];

    if(empty($category)){
        echo "Please enter a category name!";
    }else if(empty($password)){
        echo "Please enter your password!";
    }else if($password != $admin["password"]){
        echo "Invalid password!";
    }else{
        $cate_rs = Database::search("SELECT * FROM `category` WHERE `category`='".$category."'");
        $cate_num = $cate_rs->num_rows;

        if($cate_num > 0) {
            echo "This category already exists!";
        }else {

            Database::iud("INSERT INTO category (`category`) VALUES ('".$category."')");
            echo "success";

        }
    }

}else{
    header("location:adminSignin.php");
}

?>