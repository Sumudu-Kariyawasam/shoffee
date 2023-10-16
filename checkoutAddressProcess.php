<?php

session_start();
require "connection.php";

if(isset($_SESSION["user"])){
    $user = $_SESSION["user"];

    $add_rs = Database::search("SELECT * FROM `user_has_user_address` WHERE `user_email`='".$user["email"]."'");
    $add_data = $add_rs->fetch_assoc();

    $address_rs = Database::search("SELECT * FROM `user_address` INNER JOIN `city` ON 
    city.city_id=user_address.city_id INNER JOIN `district` ON 
    city.district_id=district.district_id WHERE `address_id`='".$add_data["user_address_id"]."'");
    $address_data = $address_rs->fetch_assoc();

    $array = array(
        "line1" => $address_data["line_1"],
        "line2" => $address_data["line_2"],
        "city" => $address_data["city_name"],
        "city_id" => $address_data["city_id"],
        "district" => $address_data["district_name"],
        "district_id" => $address_data["district_id"],
        "postal" => $address_data["postal_code"]
    );

    echo json_encode($array);

}else{
    echo "You are not logged in! Please login first";
}

?>