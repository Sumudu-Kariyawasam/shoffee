<?php
require "connection.php";
session_start();

$email = $_SESSION["user"]["email"];

$id = $_POST["id"];

$cate = $_POST["ct"];
$sub_cate = $_POST["sc"];
$brand = $_POST["br"];
$model = $_POST["md"];
$title = $_POST["tt"];
$condi = $_POST["cn"];
$color = $_POST["cl"];
$price = $_POST["pr"];
$dilc = $_POST["dc"];
$dilo = $_POST["do"];
$desc = $_POST["de"];
$sdes = $_POST["sd"];


if($cate == 0){
    echo ("Please Select A Category!");
}else if($cate == 0){
    echo ("Please Select A Category!");
}else if($brand == 0){
    echo ("Please Select A Brand!");
}else if($model == 0){
    echo ("Please Select A Model!");
}else if(empty($title)){
    echo ("Please Enter The Title!");
}else if(strlen($title < 100)){
    echo ("Title Should have less than 100 Charactors!");
}else if($color == 0 & empty($clr_input)){
    echo ("Please Select A Colour!");
}else if(empty($price)){
    echo ("Please Enter The Price!");
}else if(!is_numeric($price)){
    echo ("Invalid Input For Price!");
}else if(empty($dilc)){
    echo ("Please Enter The Delivery Fee Inside!");
}else if(!is_numeric($dilc)){
    echo ("Invalid Input For Delivery Fee Inside!");
}else if(empty($dilo)){
    echo ("Please Enter The Delivery Fee Outside!");
}else if(!is_numeric($dilo)){
    echo ("Invalid Input For Delivery Fee Outside!");
}else if(empty($desc)){
    echo ("Please Enter The Description!");
}elseif(empty($sdes)){
    echo ("Please Enter The Short Description!");
}else{

    $bhm_rs = Database::search("SELECT * FROM `brand_has_model` WHERE `brand_id`='".$brand."' AND `model_id`='".$model."'");
    $bhm_num = $bhm_rs->num_rows;

    if($bhm_num == 1){
        $bhm_data = $bhm_rs->fetch_assoc();
        $bhm = $bhm_data["brand_has_model_id"];
    }else{
        Database::iud("INSERT INTO `brand_has_model` (`brand_id`,`model_id`) VALUES ('".$brand."','".$model."')");
        $bhm = Database::$connection->insert_id;
    }

    $categories_rs = Database::search("SELECT * FROM `category_has_sub_category` WHERE `category_id`='".$cate."' AND `sub_category_id`='".$sub_cate."'");
    $categories_data = $categories_rs->fetch_assoc();

    $categories = $categories_data["2_category_id"];

    Database::iud("UPDATE `product` SET `price`='".$price."',`title`='".$title."',`short_desc`='".$sdes."',
    `description`='".$desc."',`delivery_fee_inside`='".$dilc."',`delivery_fee_outside`='".$dilo."',
    `categories_id`='".$categories."',`brand_has_model_id`='".$bhm."',`color_id`='".$color."',`condition_id`='".$condi."' 
    WHERE `user_email`='".$email."' AND `product_id`='".$id."'");

    $prod_id = Database::$connection->insert_id;

    $length = sizeof($_FILES);
    $allowed_extentions = array("image/jpg","image/jpeg","image/png","image/svg+xml");

    if($length != 0){

        Database::iud("DELETE FROM `product_image` WHERE `product_id`='".$id."'");

        for($x = 0; $x < $length; $x++){
            if(isset($_FILES["image".$x])){
                $image_file = $_FILES["image".$x];
                $extention = $image_file["type"];

                if(in_array($extention,$allowed_extentions)){
                    $new_extenstion;

                    if($extention == "image/jpg"){
                        $new_extenstion = ".jpg";
                    }else if($extention == "image/jpeg"){
                        $new_extenstion = ".jpeg";
                    }else if($extention == "image/png"){
                        $new_extenstion = ".png";
                    }else if($extention == "image/svg+xml"){
                        $new_extenstion = ".svg";
                    }

                    $img_name = uniqid();
                    $new_img_name = "resources//product-images//".$title."_".$x."_".$img_name.$new_extenstion;

                    move_uploaded_file($image_file["tmp_name"],$new_img_name);

                    Database::iud("INSERT INTO `product_image` (`product_id`,`product_image_path`) VALUES ('".$id."','".$new_img_name."')");
                }
            }
        }

    }

    echo ("success");

}

// echo ("HELLO");
