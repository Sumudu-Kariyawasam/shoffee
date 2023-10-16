<?php

session_start();
require "connection.php";

if(isset($_SESSION["admin"])){

    $id = $_GET["id"];

    $models = 0;
    $brands = 0;

    $bns_rs = Database::search("SELECT * FROM `brand_has_sub_category` WHERE `sub_category_id`='".$id."'");
    $bns_num = $bns_rs->num_rows;

    $bhm_rs = Database::search("SELECT * FROM `brand_has_model` WHERE `sub_category_id`='".$id."'");
    $bhm_num = $bhm_rs->num_rows;

    Database::iud("DELETE FROM `brand_has_model` WHERE `sub_category_id`='".$id."'");
    Database::iud("DELETE FROM `brand_has_sub_category` WHERE `sub_category_id`='".$id."'");

    for($z = 0; $z < $bhm_num; $z++){
        $bhm_data = $bhm_rs->fetch_assoc();
        Database::iud("DELETE FROM `model` WHERE `model_id`='".$bhm_data["model_id"]."'");
        $models = $models + 1;
    }

    Database::iud("DELETE FROM `category_has_sub_category` WHERE `sub_category_id`='".$id."'");
    Database::iud("DELETE FROM `sub_category` WHERE `sub_category_id`='".$id."'");

    for($x = 0; $x < $bns_num; $x++){
        $bns_data = $bns_rs->fetch_assoc();

        $brand_rs = Database::search("SELECT * FROM `brand_has_sub_category` WHERE `brand_id`='".$bns_data["brand_id"]."'");
        $brand_num = $brand_rs->num_rows;

        if($brand_num == 0){
            Database::iud("DELETE FROM brand WHERE brand_id = '".$bns_data["brand_id"]."'");
            $brands = $brands + 1;
        }
    }
    
    $result = array(
        "brd" => $bns_num,
        "mdl" => $bhm_num,
        "sub" => "success",
    );

    echo json_encode($result);


}
