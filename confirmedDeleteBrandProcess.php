<?php

session_start();
require "connection.php";

if(isset($_SESSION["admin"])){

    $id = $_GET["id"];
    $count = 0;

    $brand_rs = Database::search("SELECT * FROM `brand_has_model` WHERE `brand_id` = '".$id."'");
    $brand_num = $brand_rs->num_rows;

    Database::iud("DELETE FROM `brand_has_sub_category` WHERE `brand_id` = '".$id."'");
    Database::iud("DELETE FROM `brand_has_model` WHERE `brand_id` = '".$id."'");
    Database::iud("DELETE FROM `brand` WHERE `brand_id` = '".$id."'");

    if($brand_num > 0){
        for($x = 0; $x < $brand_num; $x++){
            $brand_data = $brand_rs->fetch_assoc();
    
            Database::iud("DELETE FROM `model` WHERE `model_id`='".$brand_data["model_id"]."'");
            $count = ($count + 1);

        }
    }
    
    $result = array(
        "brd" => "success",
        "mdl" => $count
    );

    echo json_encode($result);

}

?>