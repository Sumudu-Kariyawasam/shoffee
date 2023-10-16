<?php

session_start();
require "connection.php";

if(isset($_SESSION["admin"])){

    $id = $_GET["id"];

    $cns_rs = Database::search("SELECT * FROM `category_has_sub_category` WHERE `category_id`='".$id."'");
    $cns_num = $cns_rs->num_rows;

    $dltd_subs = 0;

    for($x = 0; $x < $cns_num; $x++){
        $cns_data = $cns_rs->fetch_assoc();

        Database::iud("DELETE FROM `category_has_sub_category` WHERE `sub_category_id`='".$cns_data["sub_category_id"]."'");

        Database::iud("DELETE FROM `sub_category` WHERE `sub_category_id`='".$cns_data["sub_category_id"]."'");
        $dltd_subs = $dltd_subs + 1;
    }

    Database::iud("DELETE FROM `category` WHERE `category_id`='".$id."'");
    
    $result = array(
        "subs" => $dltd_subs,
        "cats" => "success",
    );

    echo json_encode($result);

}

?>