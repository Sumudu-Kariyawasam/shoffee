<?php
require "connection.php";

if(isset($_GET["id"])){
    $id = $_GET["id"];

    $product_rs = Database::search("SELECT * FROM `product` WHERE `product_id`='".$id."'");
    $product_num = $product_rs->num_rows;

    if($product_num == 1){
        $product_data = $product_rs->fetch_assoc();
        $status = $product_data["status"];
        if($status == 1){
            Database::iud("UPDATE `product` SET `status`='2' WHERE `product_id`='".$id."'");
            echo "2";
        }else if($status == 2){
            Database::iud("UPDATE `product` SET `status`='1' WHERE `product_id`='".$id."'");
            echo "1";
        }
    }else{
        echo "Something went wrong";
    }
}else{
    echo "Oops.! Something is missing";
}

?>