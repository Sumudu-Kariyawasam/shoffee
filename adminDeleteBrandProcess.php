<?php

session_start();
require "connection.php";

if(isset($_SESSION["admin"])){

    $id = $_GET["id"];
    $count = 0;

    $brand_rs = Database::search("SELECT * FROM `brand_has_model` WHERE `brand_id` = '".$id."'");
    $brand_num = $brand_rs->num_rows;

    if($brand_num > 0){
        for($x = 0; $x < $brand_num; $x++){
            $brand_data = $brand_rs->fetch_assoc();
    
            $product_rs = Database::search("SELECT * FROM `product` WHERE `categories_id`='".$brand_data["brand_has_model_id"]."'");
            $product_num = $product_rs->num_rows;
    
            $count = ($count + $product_num);
        }

    }
    
    echo $count;

}

?>