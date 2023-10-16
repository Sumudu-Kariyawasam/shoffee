<?php

session_start();
require "connection.php";

if(isset($_SESSION["admin"])){

    $id = $_GET["id"];
    $count = 0;

    $cat_rs = Database::search("SELECT * FROM `category_has_sub_category` WHERE `sub_category_id` = '".$id."'");
    $cat_num = $cat_rs->num_rows;

    if($cat_num > 0){
        for($x = 0; $x < $cat_num; $x++){
            $cat_data = $cat_rs->fetch_assoc();
    
            $product_rs = Database::search("SELECT * FROM `product` WHERE `categories_id`='".$cat_data["2_category_id"]."'");
            $product_num = $product_rs->num_rows;
    
            $count = ($count + $product_num);
        }

    }
    
    echo $count;

}

?>