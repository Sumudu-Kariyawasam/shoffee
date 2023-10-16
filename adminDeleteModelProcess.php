<?php

session_start();
require "connection.php";

if(isset($_SESSION["admin"])){

    $id = $_GET["id"];
    $count = 0;

    $model_rs = Database::search("SELECT * FROM `brand_has_model` WHERE `model_id` = '".$id."'");
    $model_num = $model_rs->num_rows;

    if($model_num > 0){
        for($x = 0; $x < $model_num; $x++){
            $model_data = $model_rs->fetch_assoc();
    
            $product_rs = Database::search("SELECT * FROM `product` WHERE `categories_id`='".$model_data["brand_has_model_id"]."'");
            $product_num = $product_rs->num_rows;
    
            $count = ($count + $product_num);
        }

    }
    
    echo $count;

}

?>