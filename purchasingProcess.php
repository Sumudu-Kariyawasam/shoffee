<?php

session_start();
require "connection.php";

if (isset($_POST["id"]) && isset($_POST["qty"])) {
    $id = $_POST["id"];
    $qty = $_POST["qty"];

    if(empty($_POST["l1"])){
        $error["error"] = ("Address line 1 cannot be empty");
        echo json_encode($error);
    }else if(strlen($_POST["l1"]) > 50){
        $error["error"] = ("Address line 1 must be less than 50 charactors");
        echo json_encode($error);
    }else if(empty($_POST["l1"])){
        $error["error"] = ("Address line 1 cannot be empty");
        echo json_encode($error);
    }else if(strlen($_POST["l1"]) > 50){
        $error["error"] = ("Address line 1 must be less than 50 charactors");
        echo json_encode($error);
    }else if(!empty($_POST["l2"]) && strlen($_POST["l2"]) > 50){
        $error["error"] = ("Address line 2 must be less than 50 charactors");
        echo json_encode($error);
    }else if($_POST["dt"] == 0){
        $error["error"] = ("Please select the district");
        echo json_encode($error);
    }else if($_POST["ct"] == 0){
        $error["error"] = ("Please select the city");
        echo json_encode($error);
    }else if(empty($_POST["pc"])){
        $error["error"] = ("Postal code cannot be empty");
        echo json_encode($error);
    }else if(strlen($_POST["pc"]) != 5){
        $error["error"] = ("Postal code must be 5 charactors");
        echo json_encode($error);
    }elseif(!is_numeric($_POST["pc"])){
        $error["error"] = ("Invalid postal code");
        echo json_encode($error);
    }else{

        $no = $_POST["no"];
        $line1 = $_POST["l1"];
        $line2 = $_POST["l2"];
        $city = $_POST["ct"];
        $district = $_POST["dt"];
        $postal = $_POST["pc"];

        $user = $_SESSION["user"];

        $ids = explode("_", $id);
        $qtys = explode("_", $qty);

        $num = 0;
        if(count($ids) == 1){
            $num = 1;
        }else if(count($ids) > 1){
            $num = count($qtys) - 1;
        }

        $d = new DateTime();
        $tz = new DateTimeZone("Asia/Colombo");
        $d->setTimezone($tz);
        $date = $d->format("y-m-d h-i-s");

        $order_id = "ORD-" . rand(1000, 9999)."Er".rand(1000, 9999);
        $total = 0;

        for ($x = 0; $x < $num; $x++) {
            $product_rs = Database::search("SELECT * FROM `product` WHERE `product_id`='" . $ids[$x] . "'");
            $product_data = $product_rs->fetch_assoc();

            $total = $total + $product_data["price"] * $qtys[$x];
        }
        
        $email = $_SESSION["user"]["email"];

        $city_rs = Database::search("SELECT * FROM `city` WHERE `city_id`='".$city."'");
        $city_data = $city_rs->fetch_assoc();
        $city_name = $city_data["city_name"];
        $address = $no.",".$line1.",".$line2.",".$city_name;

        $details = array(
            "order_id" => $order_id,
            "items" => $num,
            "total" => $total,
            "fname" => $user["fname"],
            "lname" => $user["lname"],
            "email" => $user["email"],
            "mobile" => $user["mobile"],
            "address" => $address,
            "city" => $city
        );
        
        echo json_encode($details);

        for($y = 0; $y < $num; $y++){
            Database::iud("INSERT INTO `invoice` (`product_id`,`total`,`order_id`,`user_email`,`invoice_status`,`delivery_address`,`date_time`,`invoice_qty`,`status`) 
            VALUES ('".$ids[$y]."','".$total."','".$order_id."','".$email."','1','".$address."','".$date."','".$qtys[$y]."','1')");
        }
    }
    
} else {
    echo ("Something is missing");
}
